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
class Admin_payment_model extends CI_Model                   
{ 
   private $campaign_table                 = 'campaign';  
   private $user_table                     = 'users';
   private $campaign_payment_table         = 'payment';
   private $campaign_payment_setting_table = 'admin_payment_setting';

// ---------------- Get all payment detail -------------- //   
 
  function get_all_payment($option,$id)   // $option -> all or $option -> single 
  {
       
	  if($option=='all' && $id==NULL)
	  {
	    $sql = "SELECT id,campaign_id,payer_user_id,transactionId,date,status,payment_type,amount,comment FROM $this->campaign_payment_table ORDER BY id DESC";
		$query = $this->db->query($sql);
	  }
	  if($option=='single' && $id)  // 
	  {
	    $sql = "SELECT id,campaign_id,payer_user_id,transactionId,date,status,payment_type,amount,comment FROM $this->campaign_payment_table WHERE id=?";
		$query = $this->db->query($sql,array($id));
	  }
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $data[] = array(
		   'id'            => $r['id'],
		   'campaign_name' => $this->_get_campaign_name($r['campaign_id']),
		   'user'          => $this->_get_user($r['payer_user_id']),  
		   'transactionId' => $r['transactionId'],
		   'date'          => $r['date'],
		   'status'        => $r['status'],
		   'payment_type'  => $r['payment_type'],
		   'amount'        => $r['amount'],
		   'comment'       => $r['comment']  
		 );
	   }
	   return $data;   
     }
  } 

// ---------------- Track any payment -------------- //  
  
  function track_payment($search)  
  {
     $sql = "SELECT id,campaign_id,payer_user_id,transactionId,date,status,payment_type,amount,comment FROM $this->campaign_payment_table".
	        " WHERE id LIKE '%$search%' OR campaign_id LIKE '%$search%' OR payer_user_id LIKE '%$search%' OR transactionId LIKE '%$search%' OR date LIKE '%$search%'".
			" OR status LIKE '%$search%' OR payment_type LIKE '%$search%' OR amount LIKE '%$search%'";
	 $query = $this->db->query($sql);  
	 if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $data[] = array(
		   'id'            => $r['id'],
		   'campaign_name' => $this->_get_campaign_name($r['campaign_id']),
		   'user'          => $this->_get_user($r['payer_user_id']),  
		   'transactionId' => $r['transactionId'],
		   'date'          => $r['date'],
		   'status'        => $r['status'],
		   'payment_type'  => $r['payment_type'], 
		   'amount'        => $r['amount'],
		   'comment'       => $r['comment']  
		 );
	   }
	   return $data;   
     }
  }

// ---------------- Get user's name -------------- //  
  
  function _get_user($id) 
  {
     $sql = "SELECT firstname,lastname FROM $this->user_table WHERE id = ?";
	  $query = $this->db->query($sql,array($id));    
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     
	     $name = ucfirst($r['firstname']).' '.ucfirst($r['lastname']);
	   }
	   return $name;   
     }
  }

  // ---------------- Get user's email -------------- //
  
  function _get_user_email($id)   
  {
     $sql = "SELECT email FROM $this->user_table WHERE id=?";
	  $query = $this->db->query($sql,array($id));    
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     
	     $email = $r['email'];
	   }
	   return $email;    
     }
  }

// ---------------- Get campaign name -------------- //  
  
  function _get_campaign_name($id) 
  {
     $sql = "SELECT title FROM $this->campaign_table WHERE id=?";
	  $query = $this->db->query($sql,array($id));    
     if($query->num_rows() > 0)
     {
       foreach($query->result_array() as $r)
	   {
	     $name = ucfirst($r['title']);
	   }
	   return $name;   
     }
  }

// ------------------------ Save Paypal setting -------------- //  
  
  function save_paypal_setting($data)
  { 
     $query = $this->db->query("SELECT * FROM $this->campaign_payment_setting_table");
     if($query->num_rows()==0)
	 { 
	    
		$this->db->insert($this->campaign_payment_setting_table,$data);
	    return true; 
	
	}else{
	
	  $this->db->update($this->campaign_payment_setting_table,$data);
	  return true;
	
	}
    
  }

 // ------------------------ Get Paypal setting -------------- //  
  
   function get_paypal_setting() 
  { 
     $query = $this->db->query("SELECT paypal_api_username,paypal_api_password,paypal_api_signature,paypal_api_mode FROM $this->campaign_payment_setting_table");
     if($query->num_rows() > 0)  
     {
       foreach($query->result_array() as $r)
	   { 
         $data[] = $r; 
       }
       return $data; 	   
     }  		 
  }
 
   // ------------------------ Get Paypal setting -------------- //
 
  function get_firstgiving_setting()
  { 
     $query = $this->db->query("SELECT first_giving_app_key,first_giving_app_secret,first_giving_endpoint FROM $this->campaign_payment_setting_table");
     if($query->num_rows() > 0)  
     {
       foreach($query->result_array() as $r)
	   { 
         $data[] = $r; 
       }
       return $data; 	   
     }  		 
  }
  
// --------------------- Save credit card setting -------------- //
  
  function save_creditcard_setting($data)  
  { 
    $this->db->update($this->campaign_payment_setting_table,$data);
	return true;
  } 

  
  
// ---------------------- Get all payment report ------------------//  
  
  
  
  
  function payment_report() 
  {  
     $sql   = "SELECT id,campaign_id,payer_user_id,transactionId,date,amount FROM $this->campaign_payment_table ORDER BY id DESC";  
	 $query = $this->db->query($sql); 
     if($query->num_rows() > 0) 
     {
       foreach($query->result_array() as $r)
	   {    
	    
		$data[] = array(
		   'id'                     => $r['id'],
		   'transactionId'          => $r['transactionId'],
		   'campaign_name'          => $this->_get_campaign_name($r['campaign_id']),
           'campaign_id'		    => $r['campaign_id'], 
		   'donor_name'             => $this->_get_user($r['payer_user_id']),  
		   'donor_email'            => $this->_get_user_email($r['payer_user_id']),  
		   'donation_amount'        => $this->payment_amount($r['id']), 
           'total_donation_amount'  => $this->total_donation_amount($r['campaign_id']),  		   
		   'per_going_to_campaign'  => $this->keep_percentage($r['campaign_id']),   
		   'amt_going_to_campaign'  => $this->keep_amount($r['campaign_id'],$r['id']) - ($this->keep_amount($r['campaign_id'],$r['id'])) * 0.05,  
           'per_going_to_donated'	=> @array_sum($this->per_going_to_donated($r['campaign_id'])),
           'amt_going_to_donated'	=> $this->amt_going_to_donated($r['campaign_id'],$r['id']) - ($this->amt_going_to_donated($r['campaign_id'],$r['id'])) * 0.05,  
           'per_nb_share'		    => $this->per_nb_share(),    
		   'per_nb_share_amt'       => ($this->keep_amount($r['campaign_id'],$r['id'])) * 0.05  + ($this->amt_going_to_donated($r['campaign_id'],$r['id'])) * 0.05        
		 );    
		}  
	   return $data;    
     }
  }
  
  
  
   // ------------------ Export Payment Report of User ----------------------//
  
  
  
  function payment_report_user_export() 
  {
      $data = $this->payment_report();
      $this->load->dbutil();
      return $this->dbutil->csv_from_result($data);	  
  }   
  
  
 // ------------------- Get All Payment Report of User ---------------------
 
 

  function payment_report_user($user_id)    
  {  
     $sql   = "SELECT id,campaign_id,payer_user_id,transactionId,date,amount FROM $this->campaign_payment_table WHERE campaign_id IN (SELECT id FROM campaign WHERE user_id = ?) ORDER BY id DESC";  
	 $query = $this->db->query($sql,array($user_id));  
     if($query->num_rows() > 0) 
     {
       foreach($query->result_array() as $r)
	   {    
	    
		$data[] = array( 
		   'id'                     => $r['id'],
		   'campaign_name'          => $this->_get_campaign_name($r['campaign_id']),
           'campaign_id'		    => $r['campaign_id'], 
		   'donor_name'             => $this->_get_user($r['payer_user_id']),  
		   'transactionId'          => $r['transactionId'], 
		   'donor_email'            => $this->_get_user_email($r['payer_user_id']),   
		   'donation_amount'        => $this->payment_amount($r['id']), 
           'total_donation_amount'  => $this->total_donation_amount($r['campaign_id']),  		   
		   'per_going_to_campaign'  => $this->keep_percentage($r['campaign_id']),    
		   'amt_going_to_campaign'  => $this->keep_amount($r['campaign_id'],$r['id']),  
           'per_going_to_donated'	=> array_sum($this->per_going_to_donated($r['campaign_id'])),
           'amt_going_to_donated'	=> $this->amt_going_to_donated($r['campaign_id'],$r['id']),   
           'per_nb_share'		    => $this->per_nb_share(),     
		   'per_nb_share_amt'       => $this->per_nb_share_amt($this->payment_amount($r['id']),$this->keep_amount($r['campaign_id'],$r['id']),$this->amt_going_to_donated($r['campaign_id'],$r['id']))                
		 ); 
		}
	   return $data;    
     }
  }  
  function account_overview($uid) 
  { 
    $query = $this->db->query("SELECT id,keep_percent,donate_outlets_percent,created_date,campaign_life_span FROM $this->campaign_table WHERE user_id = ? ORDER BY id DESC",array($uid));   
	if($query->num_rows() > 0)
	{
	   foreach($query->result_array() as $r) 
	   {   
		    $outlets = json_decode($r['donate_outlets_percent'],TRUE);  
		    if(is_array($outlets))
			{   
			  foreach($outlets as $s) 
		      {  
			      $charity[] =  $s['donatePercent'];       				   
		      }      
		    }  
		          
		 		 
	     $stored_date     = strtotime($r['created_date']);   
         $word            = ($r['campaign_life_span'] == 1) ? ' day' : ' days';  												   
		 $expiry_date     =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));
         $query2          = $this->db->query("SELECT amount FROM $this->campaign_payment_table WHERE campaign_id = ? ",array($r['id'])); 	 
           if($query2->num_rows() > 0)
		   { 
		      foreach($query2->result_array() as $r2)
		      {   
			       $actual_donation[] = $r2['amount'];      
				   
		          /* ---- Amount Break Start Down ----- */
			        
					//$keep_percent    = $r['keep_percent'];
			        //$charity_percent = array_sum($charity);
					//$deduct_amount   = ($r2['amount'] * $keep_percent/100) + ($r2['amount'] * $charity_percent/100);  
			        //$donation        = $r2['amount'] - ($r2['amount'] * $keep_percent/100);  
				  /* ---- Amount Break Down End------- */
		          
				    
		     }
			 
          }else{
		     $actual_donation[] = 0; 
		  }
		  $array[] = array(
		   'campaign_name' => $this->_get_campaign_name($r['id']), 
		   'donation'      => (is_array($actual_donation)) ? array_sum($actual_donation) : 0,   
		   'expiry'        => $expiry_date, 
		  );
		 unset($charity); 
         unset($actual_donation);		  
	   }
	   return $array;    
	}
  }
  
  
 // -------------------- Percentage going to campaign  -------------------//
  
  function per_going_to_donated($campaign_id)  
  {
     $sql   = "SELECT donate_outlets_percent FROM $this->campaign_table WHERE id = ? "; 
	 $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     {
	          $outlets = json_decode($r['donate_outlets_percent'],TRUE); 
		      foreach($outlets as $s) 
		       {
		          $donatePercent[] = $s['donatePercent'];
		       } 
		      return $donatePercent;   
	     }
	  }
  }  
  
  

  
  
  function get_nonprofits($campaign_id)  
  {
    $sql   = "SELECT donate_outlets_percent FROM $this->campaign_table WHERE id = ? "; 
	 $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     {
	          $outlets = json_decode($r['donate_outlets_percent'],TRUE); 
		      foreach($outlets as $s) 
		       {  
			      $array[] = array( 
				   'charity_id'          => $s['donatePersonID'],  
				   'charity_percentage'  => $s['donatePercent'],
                   'each_charity_amount' => $this->each_charity_amount($campaign_id,$charity_percentage)				   
				  );
		       } 
		      return $array;   
	     }
	  }
  }
 



 
 // ---------------------- Each Charity Amount ---------------------- //

 
 
 
 
 function each_charity_amount($campaign_id,$charity_percentage)       
 {
   $amount = $this->total_donation_amount($campaign_id);   
   $each_charity_amount = ($amount * $charity_percentage/100) - ($amount * $charity_percentage/100) * 0.05; 
   return $each_charity_amount;     
 }  
 
 function _has_completed($cid) 
 {
      $query  = $this->db->query("SELECT created_date,campaign_life_span FROM $this->campaign_table WHERE id = ?",array($cid));
	  if($query->num_rows() == 1)
	  {
	    foreach($query->result_array() as $r)
		{
		    $stored_date     = strtotime($r['created_date']);   
            $word            = ($r['campaign_life_span'] == 1) ? ' day' : ' days';  												   
	        $expiry_date =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));      
		    $datediff = time() - strtotime($expiry_date);       
            $no_of_days =  -floor($datediff/(60*60*24));			
		}
		return $no_of_days;
	  }
 }
 
 
 // ---------------------- Amount going to donate  -------------------//   
  
  
  
  
  function amt_going_to_donated($campaign_id,$pay_id)  
  { 
    $per_going_to_donated    = $this->per_going_to_donated($campaign_id);
    $remaining  = $this->payment_amount($pay_id) - $this->keep_amount($campaign_id,$pay_id);  	
    return $remaining;  
  } 
  
  
  
  
  
  //  ----------------------- Charity ------------------------------- //
  
  
  
  
  
  function charity($campaign_id,$pay_id,$charity_number) 
  {    
      $charity_amount          = $this->payment_amount($pay_id) - $this->keep_amount($campaign_id,$pay_id); 
      $charity_percentage      = $this->per_going_to_donated($campaign_id);   
      @$each_charity_amount    = $charity_percentage[$charity_number]*$charity_amount/100;                
      return $each_charity_amount;       	 
  } 
 
 
 
 
 
 //  ----------------- Keep Percentage ------------------------------- //
  
  
  
  
 
  function keep_percentage($campaign_id)      
  {  
     $sql = "SELECT keep_percent FROM $this->campaign_table WHERE id = ? ";  
	 $query = $this->db->query($sql,$campaign_id); 
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     {
	        $keep = $r['keep_percent'];          
	     }
		 return $keep; 
	  }
  }



  
  //  ----------------- Keep Amount ------------------------------- //
  
 
 
 
 
   function keep_amount($campaign_id,$pay_id)  
   {
	   $donation_amount = $this->payment_amount($pay_id); 
	   $keep_percentage = $this->keep_percentage($campaign_id);  
	   $keep_amount = $keep_percentage*$donation_amount/100;    
	   return $keep_amount;    
    } 

	
	
	
  //  ----------------- Goal Amount / Target Amount ---------------- //
  
	
    function goal_amount($id)  
	{
	  $sql = "SELECT setting FROM $this->campaign_table WHERE id = ? "; 
	  $query = $this->db->query($sql,$id); 
	  if($query->num_rows())
	  { 
	     foreach($query->result_array() as $r)
	     {
	       $setting_goal = $r['setting'];  
	     }
		 return $setting_goal;      
	}
  }
  
  
  
  //  ----------------- Total Donation Amount in the campaign ----------------------- //  
  
  
  function total_donation_amount($campaign_id)     
  { 
      $sql   = "SELECT amount FROM payment WHERE campaign_id = ? "; 
	  $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  { 
	     foreach($query->result_array() as $r)  
	     {     
		  $amount[]      = $r['amount'];   
		 }
		 return array_sum($amount);       
	}
  }     

  
  
  //  ----------------- Payment Amount ------------------------------- //
  
  
  
  
  function payment_amount($pay_id) 
  { 
      $sql   = "SELECT amount FROM payment WHERE id = ? "; 
	  $query = $this->db->query($sql,$pay_id);   
	  if($query->num_rows())
	  { 
	     foreach($query->result_array() as $r)
	     {
	       $amount = $r['amount'];  
	     }  
		  $share_percent = $this->per_nb_share();
		  //$share_amount  =  $amount * $share_percent/100;
		  //$remaining  = $amount - $share_amount;   
		  return $amount;              
	} 
  }
 
  //  -------------------- Nacho birthday Share Percentage ----------------------- //
  
  function per_nb_share()  
  { 
     return $nachobirthday_share_percent = 5;   // ------ Nachobirthday share 5 % ------- 
  }
  
  //  -------------------- Nacho birthday Share Amount -------------------------- //
 
  function per_nb_share_amt($donation_amount,$keep_amt,$charity_amount)   
  {  
       
     //--- Say we Take Donation amount = 100$,Keep Amount = 60$,Charity Amount = 40$ --- // 	
	
     $nacho_share_percentage             =   5;  
	 
	 /* ------ Nacho's Share Percent on Campaign and Charity --------- */
	 
	 // ----This Gives 3% ----- //
	 $nacho_percent_on_campaign     =   (5 * $keep_amt) / 100;             /* ---- Nacho Percent * Keep_amount/Donation_amount ----*/
	 
	
     // ----This Gives 2% ----- //   
	$nacho_percent_on_charity       =   (5 * $charity_amount) / 100;       /* ---- Nacho Percent * Charity_amount/Donation_amount ----*/  

	  /* ------ Nacho's Share Amount on Campaign and Charity --------- */   
	 
	 $nacho_amount_on_campaign      =   ($nacho_percent_on_campaign/100) * $donation_amount;          //--- But here gives 1.8$ , well it should gives 3$ ----//
	 $nacho_amount_on_charity       =   ($nacho_percent_on_charity/100) * $donation_amount;    //--- But here gives 0.8$ , well it should gives 2$ ----//    
      
	 $nacho_amount =  $nacho_amount_on_campaign + $nacho_amount_on_charity;
	 return $nacho_amount; 
	 
	  
	 	 
  
  }
  
  /* ------ This function is used for testing only -------------- */  
  
  function test($user_id) 
  {
      $sql   = "SELECT id,campaign_id,payer_user_id,transactionId,date,amount FROM $this->campaign_payment_table WHERE campaign_id IN (SELECT id FROM campaign WHERE user_id = ?) ORDER BY id DESC";  
	 $query = $this->db->query($sql,array($user_id));  
     if($query->num_rows() > 0)  
     {
       foreach($query->result_array() as $r) 
	   {    
	    
		$data[] = array(
		   'id'                     => $r['id'],
		   'campaign_name'          => $this->_get_campaign_name($r['campaign_id']),
           'campaign_id'		    => $r['campaign_id'], 
		   'donor_name'             => $this->_get_user($r['payer_user_id']),  
		   'transactionId'          => $r['transactionId'], 
		   'donor_email'            => $this->_get_user_email($r['payer_user_id']),  
		   'donation_amount'        => $this->payment_amount($r['id']), 
           'total_donation_amount'  => $this->total_donation_amount($r['campaign_id']),  		   
		   'per_going_to_campaign'  => $this->keep_percentage($r['campaign_id']),    
		   'amt_going_to_campaign'  => $this->keep_amount($r['campaign_id'],$r['id']),  
           'per_going_to_donated'	=> array_sum($this->per_going_to_donated($r['campaign_id'])), 
           'amt_going_to_donated'	=> $this->amt_going_to_donated($r['campaign_id'],$r['id']),  
           'per_nb_share'		    => $this->per_nb_share(),  
		   'per_nb_share_amt'       => $this->per_nb_share_amt($this->payment_amount($r['id']),$this->keep_amount($r['campaign_id'],$r['id']),$this->amt_going_to_donated($r['campaign_id'],$r['id']))                
		 ); 
		} 
	   return $data;       
     } 
  }  
  
  /* ----- Get All Campaign Charity Names -------- */
  
  function get_campaign_charity_name($campaign_id)   
  {
     $sql   = "SELECT donate_outlets_percent FROM $this->campaign_table WHERE id = ? "; 
	 $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     {
	          $outlets = json_decode($r['donate_outlets_percent'],TRUE); 
		      foreach($outlets as $s) 
		       {  
			      $array[] = array( 
				   'charity_name' => $this->charity_name_id($s['donatePersonID'])  				   
				  );
		       } 
		      return $array;   
	     }
	  }
  }
  
  
  
  /* ----- Get Campaign Charity Percentage -------- */
  
  
  
  function get_campaign_charity_percent($campaign_id)
  {
    $sql   = "SELECT donate_outlets_percent FROM $this->campaign_table WHERE id = ? "; 
	 $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     {
	          $outlets = json_decode($r['donate_outlets_percent'],TRUE); 
		      foreach($outlets as $s) 
		       {  
			      $array[] = array( 
				   'charity_percentage' => $s['donatePercent'],				   
				  );
		       } 
		      return $array;    
	     }
	  }
  }
  
  
  /* ----- Get Campaign Charity Amount -------- */
  
  
  function get_campaign_charity_amount($campaign_id)   
  { 
    $sql   = "SELECT donate_outlets_percent FROM $this->campaign_table WHERE id = ? "; 
	 $query = $this->db->query($sql,$campaign_id);   
	  if($query->num_rows())
	  {
	     foreach($query->result_array() as $r)
	     { 
	          $outlets = json_decode($r['donate_outlets_percent'],TRUE); 
		      foreach($outlets as $s) 
		       {  
			      $array[] = array( 
				    'charity_id'          => $s['donatePersonID'],  
				    'charity_percentage'  => $s['donatePercent'],
                    'each_charity_amount' => $this->each_charity_amount($campaign_id,$s['donatePercent'])    				   
				  );
		       } 
		      return $array;   
	     }
	  }
  }
  
  
  /* ----- Get Charity Name From Id -------- */
  
  
  function charity_name_id($charity_id) 
  {
    $query = $this->db->select('name')
	              ->from('donation_outlets')
				  ->where('id',$charity_id)
				  ->get();
	if($query->num_rows > 0)
	{
	  foreach($query->result_array() as $r)
	  {
	    $name = $r['name']; 
	  }
	  return $name;
	}
  }
  
  
  /* ----- Get Campaign Name From Id -------- */
  
  
  function campaign_name_from_id($campaign_id)  
  {
    $query = $this->db->select('title')
	                  ->from($this->campaign_table)
					  ->where('id',$campaign_id)
					  ->get();
	if($query->num_rows() > 0)  
     {
       foreach($query->result_array() as $r)
	   { 
         $data = $r['title']; 
       }
       return $data; 	   
     }				  
  }

  
  
  
  /* ----- Payment Report Campaign -------- */
  
  
  
  
  function payment_report_campaign($campaign_id)
  {
      $sql   = "SELECT id,campaign_id,payer_user_id,date,amount,donated FROM $this->campaign_payment_table WHERE campaign_id = ? ORDER BY id DESC";  
	  $query = $this->db->query($sql,array($campaign_id));     
     if($query->num_rows() > 0)  
     {
       foreach($query->result_array() as $r)
	   { 
	     $keep_amount = $r['amount'] * $this->keep_percentage($r['campaign_id'])/100; //------------------Keep Amount ------------ //
		 $site_share  = $r['amount'] * 5/100;                                         // ---------------- Nacho Share ------------ //
	     $amount      = $r['amount'] - ($keep_amount+$site_share);     
	     $array  = array(
		   'name'   => $this->_get_user($r['payer_user_id']), 
		   'date'   => $r['date'],  
		   'amount' => $amount,
           'donated' => $r['donated']		   
		 );
         $data[] = $array;
       }
       return $data; 	   
     }		
  } 
  
  
  /* ----- Update Donation Status -------- */
  
  function update_donation_status($campaign_id,$status_flag)
  { 
    $data = array(
	   'donated' => 1   
	);
    $this->db->where('campaign_id',$campaign_id);
    $this->db->update($this->campaign_payment_table,$data);
    return true;
  }
  
}