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

class Campaign_model extends CI_Model                   
{

 private $campaign_table           = 'campaign'; 
 private $user_table               = 'users';  
 private $group_table              = 'groups'; 
 private $user_profiles_table      = 'user_profiles';  
 private $page_view_log_table      = 'page_view_log';    
 private $campaign_sub_description = 'campaign_sub_description';
 private $payment                  = 'payment';
 
/* 
|--------------------------------------------------------------------------
| Get All Campaigns Method
|--------------------------------------------------------------------------
|
| 
| METHOD : createCampaign -> This method insert/create new row in the data model `new_campaign`   
|
|
*/ 

 function create_campaign($TableCampaign,$uid,$title,$content,$image,$link,$social,$setting,$pub_stat,$mybirthday,$donate,$donatePercentage,$donateTo,$keepPercentage,$keepPercentageLimit,$campaign_life_span )  
 {
    
	$data = array(    
	         'user_id'                => $uid,
             'title'                  => $title,
             'content'                => $content,   
			 'image'                  => $image,     
             'youtube_link'	          => $link,
			 'social'                 => $social,
			 'setting'                => $setting,
			 'show_pub_stat'          => $pub_stat,
			 'mybirthday'             => $mybirthday, 
			 'donate_outlets_percent' => $donatePercentage,  
			 'keep_percent'           => $keepPercentageLimit,
			 'created_date'           => date('Y-m-d'), 
             'campaign_life_span'     => $campaign_life_span      		 
	     ); 
		 
   $this->db->insert($this->campaign_table,$data); 
   $id = $this->db->insert_id();   
   return $id;   
  }  
  
  
/* 
|--------------------------------------------------------------------------
| Get All Campaigns Method
|--------------------------------------------------------------------------
|
| 
| METHOD : getAllCampaigns -> This method fetch all the campaign from the data model `new_campaign`   
|
|
*/	
    
  
	
  
  function get_all_campaigns($id)     
  {
     $sql   = "SELECT id,user_id,title,content,image,youtube_link,social,setting,show_pub_stat,mybirthday,donate_outlets_percent,keep_percent,suspend,created_date,campaign_life_span FROM $this->campaign_table WHERE id = ? ORDER BY id DESC";
     $query = $this->db->query($sql,array($id));
	 if($query->num_rows() > 0)
	 {
	   foreach($query->result_array() as $r) 
	   {
	      $data[] = $r; 
	   }
	   return $data; 
	 }
  }

  
  
  function carousel_campaign_display()     
  {
     $sql   = "SELECT id,user_id,title,content,image,youtube_link,social,setting,show_pub_stat,mybirthday,donate_outlets_percent,keep_percent,suspend FROM $this->campaign_table ORDER BY id DESC";
     $query = $this->db->query($sql);
	 if($query->num_rows() > 0)
	 {
	   foreach($query->result_array() as $r)
	   {
	       if($this->check_campaign_lift_span($r['id']) == 0) 
		   {
	            $data[] = $r; 
		   }
	   
	   }
	   return $data; 
	 }
  }
  
  function check_campaign_lift_span($cid) 
  {
     $sql   = "SELECT created_date,campaign_life_span FROM $this->campaign_table WHERE id = ? ORDER BY id DESC";
     $query = $this->db->query($sql,array($cid));
	 if($query->num_rows() > 0)
	 { 
	   foreach($query->result_array() as $r)
	   { 
          $stored_date     = strtotime($r['created_date']);   
          $word            = ($r['campaign_life_span'] == 1) ? ' day' : ' days';  												   
	      $expiry_date     =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));      
		  $datediff        =  time() - strtotime($expiry_date);       
          $no_of_days =  -floor($datediff/(60*60*24));   
          if($no_of_days < 0) 
		  {
		    return 1; // if expired
		  }
		  else
		  {
		   return 0; // if not expired
		  }
	                                			  
	   } 
	 } 
  }
  
/* 
|--------------------------------------------------------------------------
| Active Group 
|--------------------------------------------------------------------------
|
| 
| METHOD : getActiveCampaignGroup -> Get all the active group campaign   
|
|
*/  
 
  function get_active_campaign_group()    
  { 
    $sql = "SELECT id,group_name,campaigns FROM $this->group_table WHERE visibility= ?"; 
	
	$query = $this->db->query($sql,array(1));
	
	if($query->num_rows() > 0)
	 {   
	   $array = array(); 
	   
	  foreach($query->result_array() as $r)
	   {  
	     
		 $data['group'] = $r['group_name'];      
	     
		 $campaigns     = json_decode($r['campaigns'],TRUE);     
		   
		   if(is_array($campaigns)){
			
			foreach($campaigns as $a)
             {     
			     $result = $this->get_all_campaigns($a);
                 
				 if(!empty($result)) 
				  { 
				  
				  foreach($result as $c)   
                   {     
                      foreach($this->campaign_raised_amount($a) as $d)
                       {			
                        $raised_amount = $d['SUM(amount)'];   
                       } 
					   
					   /* ---- Expected Campaign Amount ------ */
					   $goal_amount              = $c['setting'];
					   $expected_campaign_amount = ($goal_amount * $c['keep_percent']/100) - ($goal_amount * $c['keep_percent']/100) * 0.05;  
					   
					   
					   /* ----- Raised Calculation ------ */
					   $raised                  = $raised_amount * $c['keep_percent']/100;
					   $nacho_amount            = $raised * 0.05;
					   $campaign_raised_amount  = $raised - $nacho_amount;    
					   @$campaign_raised_percent = 100 * $campaign_raised_amount/$expected_campaign_amount;
					   //if($this->check_campaign_lift_span($c['id'])==0){   /* ----- Condition to Check  Campaign Expiry ------ */
                        
					   $data[] = array(
                           'id'                 => $c['id'],  
						   'title'              => $c['title'],
						   'content'            => $c['content'],
						   'image'              => $c['image'],
						   'setting'            => $c['setting'],
                           'suspend'            => $c['suspend'], 
                           'mybirthday'	        => $c['mybirthday'],  					   
                           'keep_percent'       => $c['keep_percent'],
                           'created_date'       => $c['created_date'], 
                           'campaign_life_span' => $c['campaign_life_span'],    						   
						   'raised_amount'      => $campaign_raised_amount,  
						   'raised_percent'     => ($campaign_raised_percent > 100) ? 100   :   @$campaign_raised_percent ,         						   
                         );  
                     
					 //}  END IF						 
			      
				  } 
		        }
                 
			  }
           }			 
		array_push($array,$data); 
	    unset($data); 
		}
	  return $array;      
	} 
 } 
 
 
 function user_campaign()    
 {   
     $user_id = $this->tank_auth->get_user_id(); 
     $sql   = "SELECT id FROM $this->campaign_table WHERE user_id = ? ";  
     $query = $this->db->query($sql,array($user_id));   
	 if($query->num_rows() > 0)
	 {
	   foreach($query->result_array() as $r)
	   {
	        //-------------- Get each campaign detail ---------------
			
			foreach($this->get_all_campaigns($r['id']) as $c)   
                  {
                       //$data[] = $c;
                        
                     foreach($this->campaign_raised_amount($r['id']) as $d)
                     {
					    			
                        $raised_amount = $d['SUM(amount)'];   
                     }
					  if($this->check_campaign_lift_span($c['id'])==0){ 
                       $data[] = array(
                           'id'            => $c['id'], 
						   'title'         => $c['title'],
						   'content'       => $c['content'],
						   'image'         => $c['image'],
						   'setting'       => $c['setting'],
                           'suspend'       => $c['suspend'],  						   
						   'raised_amount' => $raised_amount,   
						   'raised_percent' => ($raised_amount > $c['setting']) ? 100: @($raised_amount/$c['setting'])*100  
                         )	;
                      }						 
			      }  
	   
	   }
	  return $data;  
	 } 
  }
 
  function user_campaign_info()
  {
     $user_id = $this->tank_auth->get_user_id(); 
     $sql   = "SELECT id,setting,redeem_request_to_admin,redeem_admin_approval_status FROM $this->campaign_table WHERE user_id = ? ORDER BY id DESC";   
     $query = $this->db->query($sql,array($user_id));    
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
| Get Campaigns Detail Method
|--------------------------------------------------------------------------
|
| 
| METHOD : getCampaignDetail -> This method fetch all the campaign detail from the data model `new_campaign`   
|
|
*/	 
  
  function get_campaign_detail($id)  
  {   
     $sql   = "SELECT
           	        a.id,
			        a.user_id,
					a.title,
					a.content,
					a.image,
					a.youtube_link,
					a.social,setting,  
	                a.show_pub_stat,
					a.mybirthday,
					a.donate_outlets_percent,
					a.keep_percent,
					a.pause,
					a.suspend,
					a.created_date,
					a.campaign_life_span
					FROM 
					$this->campaign_table a 
					WHERE
					a.id = ? ";      
     $query = $this->db->query($sql,array($id));  
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
|--------------------------------------------------------------------------
| Campaign View By User Method
|--------------------------------------------------------------------------
|
| 
| METHOD : CampaignViewUser -> This method insert the user view record in data model  `view_campaign`   
|
|
*/	
  
  function campaign_view_user($id)    
  {
    $userid = $this->tank_auth->get_user_id();       
    $data = array(  
	   'campaign_id' => $id,   
	   'user_id'     => $userid    
	); 
	 $sql = "SELECT id FROM view_campaign WHERE user_id='$userid' AND campaign_id = ? ";    
     $query = $this->db->query($sql,array($id));       	
    if($query->num_rows()==0 && !$userid==0)  
	{   
	   $this->db->insert('view_campaign',$data);
	}  
  }

/* 
|--------------------------------------------------------------------------
| Get campaign title by id
|--------------------------------------------------------------------------   
|
|
*/ 
  
  function get_campaign_by_id($id)
  {
    $query = $this->db->query("SELECT title FROM $this->campaign_table WHERE id = ? ",array($id)); 
	  if($query->num_rows() == 1) 
	  {
	    foreach($query->result_array() as $r)
	       $title = $r['title'];
	  }  
	return $title;
  }
  
/* 
|--------------------------------------------------------------------------
| Get campaign availbility
|--------------------------------------------------------------------------
|
|
*/   
  
  function availability($id,$field) 
  {  
    $sql = "SELECT id FROM $this->campaign_table WHERE ".$field."='0' AND id='$id'";
    $query = $this->db->query($sql);
    return ($query->num_rows()==1) ? TRUE:FALSE;    	
  }

/* 
|--------------------------------------------------------------------------
| Get campaign selected user_id
|--------------------------------------------------------------------------
|
|
*/
  
  function get_campaign_user($id)
  {
    $query = $this->db->query("SELECT user_id FROM $this->campaign_table WHERE id = ? ",array($id));
	if($query->num_rows() == 1)
	{
	  foreach($query->result_array() as $r)  
	    $user_id = $r['user_id'];
	} 
	return $user_id; 
  }
 

 
  function get_session_user_fullname()    
  { 
    $query = $this->db->query("SELECT firstname,lastname FROM $this->user_table WHERE id = ? ",array($this->tank_auth->get_user_id()));
	if($query->num_rows() == 1)
	{
	  foreach($query->result_array() as $r)
	  { 
	     $fullname = ucfirst($r['firstname']).' '.ucfirst($r['lastname']); 
	  }
	  return $fullname; 
	}
  }
/* 
|--------------------------------------------------------------------------
| Get campaign selected user detail
|--------------------------------------------------------------------------
|
|
*/
  
  function get_campaign_user_detail($campid)          
  {  
    $userid = $this->get_campaign_user($campid);   
    $query = $this->db->query("SELECT a.avatar,a.description,a.facebook,a.linkedin,a.twitter,a.google,b.firstname,b.lastname FROM $this->user_profiles_table a,$this->user_table b WHERE b.id=a.user_id AND b.id = ? ",array($userid));  
	if($query->num_rows() > 0)  
	{
	  foreach($query->result_array() as $r)
	    $data[] = $r;
	} 
	return $data;
  }
/*
|--------------------------------------------------------------------------
| DonationOutletList Method
|--------------------------------------------------------------------------
|
| 
| METHOD : DonationOutletList -> Display the list of donation outlets  
|
|
*/
  
  
  function donation_outlet_list()    
  {
    $sql   = "SELECT id,name FROM donation_outlets ORDER BY name ASC";
	$query = $this->db->query($sql);
	if($query->num_rows()>0)
	{
	  foreach($query->result_array() as $r)  
	  {
	      $data[] = $r;
	  }
	}
	return $data;
  }
  
/*
|
| 
|--------------------------------------------------------------------------
| Campaign donation payment
|--------------------------------------------------------------------------
|
|
*/
  
  function payment_paypal($transaction_id)     
  {       
        $amount = $this->session->userdata('amount') - $this->session->userdata('processingFees');  
        $data  = array(
                'payer_name'       =>  $this->session->userdata('payer_name'),  
			    'payer_user_id'    =>  $this->session->userdata('payer_user_id'), 
			    'campaign_id'      =>  $this->session->userdata('campaign_id'),
				'amount'           =>  $amount, 
			    'comment'          =>  $this->session->userdata('comment'),
                'payment_type'     =>  $this->session->userdata('payment_type'), 
				'date'             =>  date('d/M/Y'), 
				'transactionId'    => $transaction_id,
                'processing_fees'  => $this->session->userdata('processingFees'),
 				'status'           => 1 
        );    
		$this->db->insert('payment',$data);  	
        return true; 		
 } 

/*
|
|
|
|--------------------------------------------------------------------------
| Query to insert user's payment detail after successful credit card payment       
|--------------------------------------------------------------------------
|
| 
|
*/
  
  function payment_creditcard()
  {   
     $amount = $this->session->userdata('amount') - $this->session->userdata('processingFees');
     $data = array(
                'payer_name'       =>  $this->session->userdata('payer_name'),  
			    'payer_user_id'    =>  $this->session->userdata('payer_user_id'), 
			    'campaign_id'      =>  $this->session->userdata('campaign_id'),
				'amount'           =>  $amount,  
			    'comment'          =>  $this->session->userdata('comment'), 
                'payment_type'     =>  $this->session->userdata('payment_type'),
				'transactionId'    =>  $this->session->userdata('transactionId'), 
                'status'           =>  $this->session->userdata('status'), 
                'date'             =>  date('d/M/Y'),
                'processing_fees'  => $this->session->userdata('processingFees')    				
        );    
		$this->db->insert('payment',$data); 	
        return true;	
  }

/*
|
|
|
|--------------------------------------------------------------------------
| Get total raised amount of the selected campaign       
|--------------------------------------------------------------------------
|
| 
|
*/
  
 function campaign_raised_amount($id) 
 {
   $sql = "SELECT SUM(amount),payer_user_id,payer_name,amount,comment FROM payment WHERE campaign_id = ?";  
   $query = $this->db->query($sql,array($id));
   foreach($query->result_array() as $r){
     $data[] = $r;  
   } 
   return $data;   
 }

function actual_campaign_raised_amount($id)  
{
      $result = $this->get_all_campaigns($id);
	  foreach($result as $r)
      {
        $amount         = $r['setting'];
		$keep_percent   = $r['keep_percent']; 
	  }
	$campaign_amount           =  $amount * $keep_percent/100;
	$till_now_campaign_amount  =  $this->campaign_raised_amount($id) *  $keep_percent/100;
	
	
	if($till_now_campaign_amount >= $campaign_amount) 
	{
	      return array(
	                  'raised_amount'          => $campaign_amount,
	                  'raised_percent'         => $till_now_campaign_amount 
	               );
	}else{
         return false;
     } 
}
 
/*
|
|
|
|--------------------------------------------------------------------------
| Query to get selected campaign donation detail        
|--------------------------------------------------------------------------
|
| 
|
*/
	
 function campaign_donations($id)   
 {
   $sql = "SELECT amount,payer_user_id,payer_name,amount,comment FROM payment WHERE campaign_id = ? ";  
   $query = $this->db->query($sql,array($id));
   foreach($query->result_array() as $r)
   {
     $payer_user_id = $r['payer_user_id'];
      
	 $query2 = $this->db->query('SELECT avatar from '.$this->user_profiles_table.' WHERE user_id= ? ',array($payer_user_id));	 
         foreach($query2->result_array() as $r2)
	      {
	         $image = $r2['avatar'];  
	      }  
	 $data[] = array(
        'avatar'    => (@$image) ? @$image:'',
        'amount'    => $r['amount'],
		'comment'   => $r['comment']
	 );
   }
   return @$data;   
 }     
 
 /*
|
|
|
|--------------------------------------------------------------------------
| Query to give permission whether the campaign goal is visible to the user
| during campaign creation       
|--------------------------------------------------------------------------
|
| 
|
*/

 function get_goal_visibility()       
 {
   $sql = "SELECT campaign_goal_status FROM admin_setting";   
   $query = $this->db->query($sql);
   foreach($query->result_array() as $r)
   {
     $data = $r['campaign_goal_status'];   
   } 
   return $data;  
 } 

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get page view      
|-------------------------------------------------------------------------- 
|
| 
|
*/
 
 function create_page_views($data)      
 {
   $sql   = "SELECT date FROM $this->page_view_log_table WHERE uid= ? "; 
   $query = $this->db->query($sql,array($this->tank_auth->get_user_id()));   
   $count = $query->num_rows(); 
   if($count==0)
   { 
      $this->db->insert($this->page_view_log_table,$data);
	  return true;   
   }
   else 
   {   
      $date = date('d/M/Y');     
	  list($d1,$m1,$y1) = explode('/',$date);
	  $query2 = $this->db->query("SELECT date FROM $this->page_view_log_table WHERE uid= ? AND campaign_id = ? ",array($this->tank_auth->get_user_id(),$data['campaign_id'])); 
	  foreach($query2->result_array() as $r)  
	  {
	     list($d2,$m2,$y2) = explode('/',$r['date']);   
	  }  
	  if(@$d1!== @$d2)    
	  {
	     $this->db->insert($this->page_view_log_table,$data);    
	     return true;   
	  }  
  }
    
}    

/*
|
|
|
|--------------------------------------------------------------------------
| Query to insert new sub description       
|--------------------------------------------------------------------------
|
| 
|
*/

function add_sub_description($data)  
{
   $this->db->insert($this->campaign_sub_description,$data);  
   return $this->get_owner_sub_description($data['campaign_id']);     
}

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get campaign sub description       
|--------------------------------------------------------------------------
|
| 
|
*/

function get_owner_sub_description($campaign_id)  
{  
   $data = array();
   $sql = "SELECT user_id,sub_description,date FROM $this->campaign_sub_description WHERE campaign_id=?";
   $query = $this->db->query($sql,array($campaign_id));   
   foreach($query->result_array() as $r)
   {
     $data[] = $r;   
   } 
   return $data;
}

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get all searched campaign via campaign name or title     
|--------------------------------------------------------------------------
|
| 
|
*/

function campaign_search($search)  
{  
   $data = array();
  
      $sql = "SELECT 
	              id,
				  title,
				  image,
				  content 
				  FROM 
				  campaign 
				  WHERE (title LIKE '%$search%')     
				  OR   
				  (user_id
				  IN 
				  (SELECT 
				        id
						FROM
						users
						WHERE
						firstname 
						LIKE
						'%$search%'   
						OR 
						lastname
						LIKE 
						'%$search%' 
						OR 
						CONCAT(firstname,' ',lastname) 
						LIKE 
						'%$search%')) 
				  ";   

   $query = $this->db->query($sql);  
   if($query->num_rows() > 0)
   {
      foreach($query->result_array() as $r) 
      {
         $result = $this->campaign_stats($r['id']);
	 
         $data[] = array(
	     'id'             => $r['id'],
		 'title'          => $r['title'],
		 'image'          => $r['image'],
         'content' 	      => $r['content'],
         'raised_percent' => $result['raised_percent'], 
         'raised_amount'  => $result['raised_amount']  		 
	 );	 
   } 
     return $data; 
   }
}

function campaign_stats($cid) 
{ 
   $donation_amount = array();
   $sql = "SELECT setting,keep_percent FROM $this->campaign_table WHERE id = ?";   
   $query = $this->db->query($sql,array($cid));
   if($query->num_rows() > 0)
   {
    foreach($query->result_array() as $r)
     {
      $goal_amt     = $r['setting']; 
	  $keep_percent = $r['keep_percent']; 
    }
   }
    $query2 = $this->db->query("SELECT amount FROM $this->payment WHERE campaign_id = ?",array($cid));
   if($query2->num_rows() > 0)
   {  
      
      foreach($query2->result_array() as $r2)
      {
         $donation_amount[] = $r2['amount'];  
      }
   } 	  
   
   $raised_amount   = array_sum($donation_amount); 
   
    /* ---- Expected Campaign Amount ------ */ 
					   $goal_amount              = $goal_amt; 
					   $expected_campaign_amount = ($goal_amount * $keep_percent/100) - ($goal_amount * $keep_percent/100) * 0.05;  
					   
					   
	 /* ----- Raised Calculation ------ */
					   $raised                  = $raised_amount * $keep_percent/100;
					   $nacho_amount            = $raised * 0.05;
					   $campaign_raised_amount  = $raised - $nacho_amount;    
					   $campaign_raised_percent = 100 * $campaign_raised_amount/$expected_campaign_amount;
   
   return array(
       'raised_amount'   => $campaign_raised_amount,
	   'raised_percent'  => $campaign_raised_percent 
   );   
}

/*
|
|
|
|--------------------------------------------------------------------------
| Query to get donation outlets name from it's id     
|--------------------------------------------------------------------------
|
| 
|
*/

 function get_donation_outlet_name($id)
 {
   $query = $this->db->select('name')->from('donation_outlets')->where('id',$id)->get();
   if($query->num_rows > 0)
   {
      foreach($query->result_array() as $r)
	  {
	    $data = $r['name'];
	  }
	  return $data;
   }
 }

/*
|
|
|
|--------------------------------------------------------------------------
| Query to campaign owner billing detail.     
|--------------------------------------------------------------------------
|
| 
|
*/ 
 
 function billing_detail()   
 {
   $sql = "SELECT id,campaign_id,payment_type,amount,transactionId,date FROM $this->payment WHERE payer_user_id= ? ORDER BY id DESC"; 
   $query = $this->db->query($sql,$this->tank_auth->get_user_id());
    if($query->num_rows > 0)
    {
        foreach($query->result_array() as $r) 
	    {  
		   $query2 = $this->db->query("SELECT * FROM campaign WHERE id = ?",array($r['campaign_id']));
		     if($query2->num_rows > 0)
			 {
               //$campaign_owner = $['user_id'];			 
			 } 
           $array = array( 
		     'campaign_name' => $this->get_campaign_by_id($r['campaign_id']), 
			 'campaign_id'   => $r['campaign_id'],
			 'payment_type'  => $r['payment_type'],
			 'amount'        => $r['amount'],
			 'transactionId' => $r['transactionId'],  
			 'date'          => $r['date'] 
		   ); 
	       $data[] = $array; 
	    } 
	   return $data;  
    } 
  }
  
  function campaign_amount($id)   
  {  
      $result = $this->get_all_campaigns($id);
	  foreach($result as $r)
      {
        $amount         = $r['setting'];
		$keep_percent   = $r['keep_percent']; 
        $remaining_amt  = $amount * $keep_percent/100;
	  }	
    return $remaining_amt; 	  
  }
  
  
  
  
  function campaign_donation_amount($id)
  {
     $result = $this->get_all_campaigns($id);  
     foreach($result as $r)
      {
        $amount         = $r['setting'];
		$keep_percent   = $r['keep_percent'];
	  }
	  
	  // ------ Recent Campaign Payment Amount ------- //
	  
	  $result2 = $this->campaign_raised_amount($id);
	  foreach($result2 as $r2)  
	  {
	    $amount2 = $r2['SUM(amount)'];  
	  } 
	  
	  $remaining_amt  = $amount2 * $keep_percent/100;
	  
	  return $remaining_amt; 
  } 
  
  function user_redeem_request($cid,$amount)
  { 
    $data = array(
	 'redeem_request_to_admin' => 1,
	 'redeem_amount'                  => $amount
	);
	$this->db->where('id',$cid);
    $this->db->update($this->campaign_table,$data);
	return true; 
  }
  
  //function is_nachobirthday()   
  //{
    // $sql =  "SELECT
	//		      id
	//		      FROM 
	//		      $this->campaign_table
	//		      WHERE 
	//			  mybirthday = ?   
	//			  AND 
	//			  user_id = ?  
	//			  ";
	//  $query = $this->db->query($sql,array(1,$this->tank_auth->get_user_id()));  
    //   if($query->num_rows() > 0)  
    //   { 
	//	  return $query->num_rows();    
    //   }	  
	          
   // }
  
  
  
  
  
  
}