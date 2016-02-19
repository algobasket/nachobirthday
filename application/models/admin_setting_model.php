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

class Admin_setting_model extends CI_Model                     
{ 
   private $admin_setting_table  = 'admin_setting';      
 
  function maintainance($data)
  { 
	$this->db->update($this->admin_setting_table,$data); 
	return true;  
  }
 
  function get_maintainance() 
  {
    $query = $this->db->select('maintainance')->select('maintainance_message')->from($this->admin_setting_table)->get(); 
	if($query->num_rows > 0)
	{
	  foreach($query->result_array() as $r)   
	  {
	    $data[] = $r;
	  }
	  return $data;
	} 
  }
  
  
  function save_social_setting($data) 
  { 
    $this->db->update($this->admin_setting_table,$data);
	return true;  
  }
  
  function get_social_setting()
  {
    $query = $this->db->select('fb_app_id')->select('fb_app_secret')->from($this->admin_setting_table)->get();
	if($query->num_rows > 0)
	{
	   foreach($query->result_array() as $r)
	  {
	    $data[] = $r;
	  }
	  return $data; 
	}
  }
 
}