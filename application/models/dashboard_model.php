<?php 
/*
|--------------------------------------------------------------------------
| BASE URL Exception
|--------------------------------------------------------------------------
|
| 
|Prevent From Direct Script Access     
|
|
*/ 

if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| SITE MODEL CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Campaign Model Class 
| 
| 
*/ 

class Dashboard_model extends CI_Model                   
{ 
 
 
 private $campaign_table      = 'campaign'; 
 private $user_table          = 'users';
 private $group_table         = 'groups'; 
 private $user_profiles_table = 'user_profiles'; 
 private $page_view_log_table = 'page_view_log';
 private $campaign_payment_table = 'payment';  

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get page hit       
|--------------------------------------------------------------------------
|
| 
|
*/ 
 
  function count_page_hit() 
  {
     $sql   = "SELECT id FROM $this->page_view_log_table ";
     $query = $this->db->query($sql);  
	 $count = $query->num_rows(); 
	 return $count; 
  }  

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get total amount donated       
|--------------------------------------------------------------------------
|
| 
|
*/  
  
  function total_amount_donated() 
  {
	$pie_c           = $this->piechart();
    $t_donate_per    = $pie_c['total_donate_per'];
    $t_total_raised  = $pie_c['total_raised'];  
	
	  /* ----- Total donation till now ------- */
	  
	 $donate_amt_recent  = $t_total_raised * $t_donate_per/100;
	 return $donate_amt_recent;  
	
	 //$this->db->select_sum('amount');
     //$query = $this->db->get($this->campaign_payment_table);
	 //$result = $query->result_array(); 
	 //return $result[0]['amount'];   	 
  
  }

/*
|
|
|
|--------------------------------------------------------------------------
| Query to count total donors who paid for the campaign       
|--------------------------------------------------------------------------
|
| 
|
*/  
 
  function total_donors() 
  {
     $sql   = "SELECT DISTINCT payer_user_id FROM $this->campaign_payment_table ";
     $query = $this->db->query($sql);
     return $query->num_rows();  	 
  }

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get donation message of the selected campaign       
|--------------------------------------------------------------------------
|
| 
|
*/
  
  function donation_message()  
  {
     $sql   = "SELECT comment FROM $this->campaign_payment_table WHERE  payer_user_id = ? ";
     $query = $this->db->query($sql,array($this->tank_auth->get_user_id()));
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $data[] = $r;
	   }
	   return $data;  
     }	 
  }

  /*
|
|
|
|--------------------------------------------------------------------------
| Query to get campaign hit counter / campaign page viewers count       
|--------------------------------------------------------------------------
|
| 
|
*/
  
  function page_counter()   
  {
     $sql   = "SELECT date FROM $this->page_view_log_table WHERE campaign_id IN (SELECT id FROM $this->campaign_table WHERE user_id = ? ) "; 
     $query = $this->db->query($sql,array($this->tank_auth->get_user_id())); 
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $data[] = $r;
	   }
	   return $data;  
     }
  }
  
/*
|
|
|
|--------------------------------------------------------------------------
| Query to get donation statistic / Summary       
|--------------------------------------------------------------------------
|
| 
|
*/
  
  function donation_stat() 
  {
     $sql   = "SELECT amount,date FROM $this->campaign_payment_table WHERE status= ? AND campaign_id IN (SELECT id FROM $this->campaign_table WHERE user_id = ? )";   
     $query = $this->db->query($sql,array(1,$this->tank_auth->get_user_id())); 
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $data[] = $r;
	   }
	   return $data;    
     }
  }
  
  function piechart()    
  {
     $sql   = "SELECT id,keep_percent,setting,donate_outlets_percent FROM $this->campaign_table WHERE user_id = ? "; 
	 $query = $this->db->query($sql,array($this->tank_auth->get_user_id())); 
	 $x_amount = array();
	 if($query->num_rows() > 0)
	 { 
     	 
	   foreach($query->result_array() as $r)
	   { 
        
         /*------ Raised Till now --------- */
		 //$x_amount = array();
	     $sql2   = "SELECT amount FROM $this->campaign_payment_table WHERE campaign_id = ? ";	 
         $query2 = $this->db->query($sql2,array($r['id']));   
		 if($query2->num_rows() > 0){
		 foreach($query2->result_array() as $x) 
         {
           $x_amount[] = $x['amount'];   
		 } 
           }  		 
		 /*------ Raised Till now end --------- */
		 
	     $keep_percent           = $r['keep_percent'];
	     $goal_amount            = $r['setting']; 
		 $keep_amount            = $goal_amount*$keep_percent/100; 
         $donate_outlets_percent = json_decode($r['donate_outlets_percent'],TRUE); 
		 if(is_array($donate_outlets_percent)){
		 foreach($donate_outlets_percent as $y)
		 {
		   $donate_percent[] = $y['donatePercent'];
           $donate_amount[]  = $goal_amount * $y['donatePercent']/100;
		 }
		 } 
		 $total_goal_amount_of_all_owned_campaign[]    = $goal_amount;
		 $total_keep_percent_of_all_owned_campaign[]   = $keep_percent;
         $total_keep_amount_of_all_owned_campaign[]    = $keep_amount;
         $total_donate_percent_of_all_owned_campaign   = @$donate_percent;   		 
	     $total_donate_amount_of_all_owned_campaign    = @$donate_amount; 
	  } // END FOREACH
	 
	 
	 }
	 
	 $total_goal             = array_sum($total_goal_amount_of_all_owned_campaign);  
     $total_keep_per         = array_sum($total_keep_percent_of_all_owned_campaign); 
     $total_keep_amt         = array_sum($total_keep_amount_of_all_owned_campaign);	 
     $total_donate_per       = array_sum($total_donate_percent_of_all_owned_campaign);    
  	 $total_donate_amt       = array_sum($total_donate_amount_of_all_owned_campaign); 
	 $total_raised_amt       = array_sum($x_amount);   
	  
     //-------------- Pie Chart Calc --------------  
      $data = array(
	    'total_goal'       => $total_goal,
		'total_keep_per'   => $total_keep_per,
		'total_keep_amt'   => $total_keep_amt,
		'total_donate_per' => $total_donate_per,
		'total_donate_amt' => $total_donate_amt,  
		'total_raised'     => $total_raised_amt 
	  ); 
	  return $data;         	  
  }  
  
  function birthday_percentage()
  {   
     $pie_c           = $this->piechart(); 
     $t_amount        = $pie_c['total_goal'];
     $t_keep_per      = $pie_c['total_keep_per']; 	 
	 $t_keep_amt      = $pie_c['total_keep_amt'];
	 $t_total_raised  = $pie_c['total_raised']; 
	   
     /* ----- Total amount raised till now ------- */
	 
     $keep_amt_recent = $t_total_raised * $t_keep_per/100;
	 $percentage      = 100 * $keep_amt_recent/$t_keep_amt;  
     return round($percentage);  
  }
  
  function charity_percentage() 
  {
    $pie_c           = $this->piechart();
	$t_amount        = $pie_c['total_goal'];
    $t_donate_per    = $pie_c['total_donate_per'];
	$t_donate_amt    = $pie_c['total_donate_amt'];  
    $t_total_raised  = $pie_c['total_raised'];  
	
	  /* ----- Total donation till now ------- */
	  
	$donate_amt_recent  = $t_total_raised * $t_donate_per/100;
	$percentage         = 100 * $donate_amt_recent/$t_donate_amt; 
    return round($percentage);   
  } 
  
  function campaign_amount_owner() 
  {
     $pie_c           = $this->piechart(); 	 
	 $t_keep_amt      = $pie_c['total_keep_amt'];
     return $t_keep_amt;  
  }
  
  function recent_campaign_payment()
  {
  
  }
  
  
 }