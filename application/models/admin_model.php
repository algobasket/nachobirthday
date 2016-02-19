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
| Nacho birthday SiteModel Class
| 
| 
*/

class Admin_model extends CI_Model             
{
   
  private $campaign_table         = 'campaign';
  private $users_table            = 'users';
  private $users_profile_table    = 'user_profiles';
  private $admin_table            = 'admin'; 
  private $admin_setting_table    = 'admin_setting';
/* 
|--------------------------------------------------------------------------
| Get all campaign
|--------------------------------------------------------------------------
|
*/ 
 
   function get_all_campaign()    
   {
     $this->db->select('id')->select('title')->from($this->campaign_table); 
     $query = $this->db->get();
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
|--------------------------------------------------------------------------
| Get all existing users 
|--------------------------------------------------------------------------
|
*/ 
  
  function get_all_user()    
  {
   $query = $this->db->query("SELECT a.id,a.firstname,a.lastname,a.email,a.activated,a.banned,b.avatar FROM $this->users_table a,$this->users_profile_table b WHERE a.id = b.user_id "); 
   if($query->num_rows() > 0)
   {
     foreach($query->result_array() as $r)
     {
	   $data[] = $r;
     }	 
   }
   return $data;  	
  }

  function get_all_user_count() 
  {
    $query = $this->db->query("SELECT id FROM $this->users_table");    
    $count = $query->num_rows(); 
	return $count;  
  }  
/* 
|--------------------------------------------------------------------------
| Get selected user detail Info 
|--------------------------------------------------------------------------
|
*/ 
  
  function user_info($id)   
  {
    $query = $this->db->query("SELECT a.id,a.firstname,a.lastname,a.username,a.email,a.activated,a.banned,a.created,b.avatar FROM $this->users_table a,$this->users_profile_table b WHERE a.id = b.user_id AND a.id = ?",array($id));        
   if($query->num_rows() > 0)
   {
     foreach($query->result_array() as $r) 
     {
	   $data[] = $r;
     }	 
   } 
   return $data;
  }
 
   /*
|--------------------------------------------------------------------------
| Query to delete user profile 
|--------------------------------------------------------------------------
|
*/
 
function deleteProfile($id)
{ 
  $this->db->where('id',$id);
  $this->db->delete($this->users);
  return true;
} 

  /*
|--------------------------------------------------------------------------
| Query to search users  
|--------------------------------------------------------------------------
|
*/
  
  function search_member($search)         
  { 
    $query = $this->db->query("SELECT a.id,a.firstname,a.lastname,a.username,a.email,a.activated,a.created,b.avatar FROM $this->users_table a,$this->users_profile_table b WHERE a.id = b.user_id AND (a.firstname LIKE '%$search%' OR a.lastname LIKE '%$search%')");    
    if($query->num_rows() > 0)
   { 
       foreach($query->result_array() as $r) 
       { 
	     $data[] = $r;
       }	 
   }   
    return @$data;  
  }
 
  /* 
|--------------------------------------------------------------------------
| Query to get all activated and not activated users 
|--------------------------------------------------------------------------
|
*/
 
  function member_activity($status)
  {
    $query = $this->db->query("SELECT a.id,a.firstname,a.lastname,a.username,a.email,a.activated,a.created,b.avatar FROM $this->users_table a,$this->users_profile_table b WHERE a.id = b.user_id AND activated = ?",array($status));  
    if($query->num_rows() > 0)
   {
     foreach($query->result_array() as $r) 
     {
	   $data[] = $r;
     }	 
   } 
   return @$data; 
  }

  /*
|--------------------------------------------------------------------------
| Query to get all members 
|--------------------------------------------------------------------------
|
*/  
  
  function all_member() 
  {
    $this->get_all_user();
  }  

  /*
|--------------------------------------------------------------------------
| Query to get admin profile detail 
|--------------------------------------------------------------------------
|
*/
  
  function admin_profile_detail()   
  {
     $query = $this->db->query("SELECT id,fullname,email,avatar FROM $this->admin_table WHERE id= ? ",array($this->session->userdata('admin_id')));  
    
	if($query->num_rows() > 0)
   {
     foreach($query->result_array() as $r) 
     {
	   $data[] = $r;
     }	 
   } 
   return @$data; 
  }

  /*
|--------------------------------------------------------------------------
| Query to get client page setting
|--------------------------------------------------------------------------
|
*/  
  
  function site_front_page_data()   
  {
    $query = $this->db->query("SELECT front_page_video_link,highlight_text_big,sub_highlight_text_small,campaign_goal_status FROM $this->admin_setting_table");
    if($query->num_rows() > 0)
   {
     foreach($query->result_array() as $r) 
     {
	   $data[] = $r; 
     }	 
   } 
   return @$data;   
	}
 
  /*
|--------------------------------------------------------------------------
| Query to update client page setting
|--------------------------------------------------------------------------
|
*/ 
 
   function update_client_page_info($data)
   { 
     $this->db->where('id',1);   
     $this->db->update('admin_setting',$data);
	 return true;
   }
   
  /*
|-------------------------------------------------------------------------- 
| Query to update admin profile detail  
|--------------------------------------------------------------------------
|
*/
  
  function admin_profile_edit($data)   
  {
    $this->db->where('id',$this->session->userdata('admin_id')); 
	$this->db->update($this->admin_table,$data);  
	return true; 
  }

  function activate_user($id)  
  {  
     $data = array(
	  'banned' => 0,
	);
     $this->db->where('id',$id);  
	 $this->db->update($this->users_table,$data);  
  }
  
  function ban_user($id)  
  {  
    $data = array(
	  'banned' => 1,
	);
     $this->db->where('id',$id);
	 $this->db->update($this->users_table,$data); 
  }
 
}