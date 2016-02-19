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
| FACEBOOK MODEL CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Facebook Model Class 
| 
| 
*/
class Facebook_Model extends CI_Model{ 


/* 
|--------------------------------------------------------------------------
| List all table 
|--------------------------------------------------------------------------
|
*/ 

 private $user_table              = 'users';
 private $user_profile_table      = 'user_profiles';   
 private $admin_setting_table     = 'admin_setting';
/* 
|--------------------------------------------------------------------------
| Query to retrieve and check whether the current user has facebook credential or not  
|--------------------------------------------------------------------------
|
*/ 
 
  function facebook_user_check($email,$firstname,$lastname,$oauth_uid,$username)    
  { 
  
        $sql = "SELECT id,username,activated FROM $this->user_table WHERE email = ? and activated = ? and oauth_uid = ? ";        
	    $query = $this->db->query($sql,array($email,1,$oauth_uid));   
        
		if ($query->num_rows()==1)  
		{
		  foreach($query->result_array() as $r)
          {
             $stored_id         = $r['id'];
			 $stored_username   = $r['username'];
			 $stored_activation = $r['activated'];
          }
           $data = array(
			   'user_id'        => $stored_id,
			   'username'       => $stored_username, 
			   'status'	        => $stored_activation, 
               'oauth_provider'	=> 'facebook' 			   
			);
            return $data;  	  
        } 
        else  
        { 
          $user_data = array(
		    'username'       => $username,
			'firstname'      => $firstname,
			'lastname'       => $lastname,
			'email'          => $email,
			'activated'      => 1,
			'new_email_key'  => NULL,
			'last_ip'        => $this->input->ip_address(),
			'last_login'     => date("Y-m-d H:i:s"),
			'oauth_uid'      => $oauth_uid,
			'oauth_provider' => 'facebook'   
		  );
           //---------Insert User Credentials------------	
			
			$this->db->insert($this->user_table,$user_data);
            $current_id = $this->db->insert_id();
			
			//-------- Insert User Profile Data ----------
			
			$profile_data = array(
			  'user_id' => $current_id,
			);
			$this->db->insert($this->user_profile_table,$profile_data);
            $data = array(
			   'user_id'        => $current_id,
			   'username'       => $username, 
			   'status'	        => 1,
               'oauth_provider'	=> 'facebook'  		   
			);
            return $data;      			
        }   
  }
 
  function get_facebook_detail() 
  {
     $query = $this->db->query("SELECT fb_app_id,fb_app_secret FROM $this->admin_setting_table");
	 if($query->num_rows() > 0)
	 {
	    foreach($query->result_array() as $r)
		{
		  $data[] = $r;
		}
	   return $data;	
	 }
  }
 
 
}
