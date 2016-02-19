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
| Nacho birthday Groupmodel Class
| 
| 
*/ 
 
class Admin_group_model extends CI_Model           
{
  
  private $group_table = 'groups';     
/* 
|--------------------------------------------------------------------------
| Create a new group by admin
|--------------------------------------------------------------------------
|
*/    
   
   function create_group($name,$visibility,$uid) 
   {
      $data = array(
	    'group_name' => substr($name,0,20),      
		'admin_id'   => $uid     
	  );   	  
	  $query = $this->db->query("SELECT id FROM $this->group_table WHERE group_name= ? ",array($name));  
	  if($query->num_rows()==0)
	  {
	     $this->db->insert('groups',$data);    
         return true;
	  }
	  else
     {
        return false; 
     } 	  
  
  }

/* 
|--------------------------------------------------------------------------
| Edit the selected group
|--------------------------------------------------------------------------
|
*/ 
  
  function edit_group($select_group_id,$editGroupName,$visibility,$campaignSelect)
  {
    
    $data = array(
	  'group_name' => $editGroupName,
	  'visibility' => $visibility,
      'campaigns'  => json_encode($campaignSelect,TRUE) 	  
	); 
	$this->db->where("id",$select_group_id);
	$this->db->update($this->group_table,$data);  
	
	return true; 
 }

/* 
|--------------------------------------------------------------------------
| Get all existing group
|--------------------------------------------------------------------------
|
*/ 
 
   function get_all_group()   
   {
      $this->db->select("id,group_name,visibility,campaigns"); 
	 
	 $query = $this->db->get($this->group_table);
	
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
| Get the selected group detail
|--------------------------------------------------------------------------
|
*/ 
 
  function get_group_by_id($id)  
  {
    $sql = "SELECT id,group_name,visibility,campaigns FROM $this->group_table WHERE id= ? "; 
	$query = $this->db->query($sql,array($id)); 
	 if($query->num_rows() ==1)
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
| Delete Selected  Group 
|--------------------------------------------------------------------------
|
*/ 
  
  function delete_group($id)   
  { 
    $this->db->where('id',$id);
    $this->db->delete($this->group_table);
	return true; 
  } 
  
  
}
