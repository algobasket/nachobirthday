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
| Nacho birthday Profile Model Class
| 
| 
*/

class Profile_model extends Users{
  
  
 /* 
|--------------------------------------------------------------------------
| List all table 
|--------------------------------------------------------------------------
|
*/  
  private $user_profiles_table = 'user_profiles'; 
  private $user_table = 'users';
/* 
|--------------------------------------------------------------------------
| Query to update user profile detail information   
|--------------------------------------------------------------------------
|
*/ 
  
  
  
  function update($data,$data2) 
  {
    $this->db->where('id',$this->tank_auth->get_user_id()); 
	$result = $this->db->update('users',$data);
	if($result) 
	{ 
	   $query = $this->db->query("SELECT id FROM $this->user_profiles_table WHERE user_id = ?",array($this->tank_auth->get_user_id()));
	   if($query->num_rows()==1)
	   {
	    $this->db->where('user_id',$this->tank_auth->get_user_id()); 
	    $this->db->update('user_profiles',$data2);
	   }
	   else
       {         
          $this->db->insert('user_profiles',$data2); 
       }	  
	}
	 return true;
  }
  
/* 
|--------------------------------------------------------------------------
| Query to get current user email    
|--------------------------------------------------------------------------
|
*/ 
  
  function get_current_user_email() 
  { 

    $query = $this->db
	              ->select('email')  
	              ->from($this->user_table)
	              ->where('id',$this->tank_auth->get_user_id())
	              ->get();
	 
	 
	if($query->num_rows() > 0)
	{
	
	  foreach($query->result_array() as $r)
	  {
	    $data = $r['email'];
	  }
	
	} 
	return $data; 
 
 } 

/* 
|--------------------------------------------------------------------------
| Query to check user profile completeness    
|--------------------------------------------------------------------------
|
*/ 
 
  
  function check_user_profile_complete()  
  {
    $sql   = "SELECT * FROM $this->user_profiles_table WHERE user_id = '".$this->tank_auth->get_user_id()."' "; 
    $query = $this->db->query($sql);    
   	if($query->num_rows() > 0)
	{
	   foreach($query->result_array() as $r)
	   {
	      $avatar      = $r['avatar'];
		  $country     = $r['country'];
		  $website     = $r['website'];
		  $description = $r['description'];
		  $facebook    = $r['facebook'];
		  $linkedin    = $r['linkedin'];
		  $twitter     = $r['twitter'];
		  $google      = $r['google'];  
		  
	      if($avatar=="" || $avatar == NULL)
		  {
		     return false;
		  }
		  else if($country=="" || $country==NULL)
		  {
		     return false;
		  }
		  else if($website=="" || $website==NULL)
		  {
		     return false;
		  }
		  else if($description=="" || $description==NULL)
		  {
		     return false;
		  }
		  else if($facebook=="" || $facebook==NULL)
		  {
		     return false;
		  }
		  else if($linkedin=="" || $linkedin==NULL)
		  {
		     return false;
		  }
		  else if($twitter=="" || $twitter==NULL)
		  {
		     return false;
		  }
		  else if($google=="" || $google==NULL)
		  {
		     return false; 
		  }
		  else
		  {
		     return true;  
		  }  
	   }
	}	
  } 

  function get_user_firstname()
  {
    $sql = "SELECT firstname FROM $this->user_table WHERE id = ? ";
	$query = $this->db->query($sql,array($this->tank_auth->get_user_id()));
	if($query->num_rows() > 0)
	{
	
	  foreach($query->result_array() as $r)
	  {
	    $data = $r['firstname'];
	  }
	
	} 
	return $data; 
  } 


 function _reset_password_user($uid,$new_password_key,$new_password)
 {
    $query = $this->db->query("SELECT id FROM $this->user_table WHERE id = ? AND new_password_key = ? ",array($uid,$new_password_key));
	if($query->num_rows() == 1)
	{
	  $data = array(  
	    'new_password_key' => NULL,
		'password'         => $new_password
	  ); 
	  $this->db->where('id',$uid); 
	  $this->db->update($this->user_table,$data);  
      return true;	  
	}
 }

  
    
}
