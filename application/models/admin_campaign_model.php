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

 class Admin_campaign_model extends CI_Model{    


 /*
|--------------------------------------------------------------------------
| List of tables 
|--------------------------------------------------------------------------
|
*/ 

 private $campaign_table = 'campaign';
 private $user_table     = 'users';  
 
  function __construct()
  {
    parent::__construct();     
   // ---- Some Methods ---- 	
  } 
 
 
  /*
|--------------------------------------------------------------------------
| Query to retrieve all campaign 
|--------------------------------------------------------------------------
|
*/ 
 
  function all_campaign()     
  {
     $sql   = "SELECT a.id,a.user_id,a.title,a.pause,a.suspend,b.firstname,".
	          "b.lastname FROM $this->campaign_table a,$this->user_table b WHERE".
			  " a.user_id=b.id  ORDER BY a.id DESC";
			  
     $query = $this->db->query($sql);  
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
| Query to add new campaign 
|--------------------------------------------------------------------------
|
*/ 
 
 function add_new_campaign($data) 
 {
   $this->db->insert($this->campaign_table,$data);
   return true; 
 }

  /*
|--------------------------------------------------------------------------
| Query to get campaign created user 
|--------------------------------------------------------------------------
|
*/
 
 function campaign_created_user($id)
 {
   $sql = "SELECT username FROM $this->user_table WHERE id = '$id'";  
   $query = $this->db->query($sql); 
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
| Query to retrieve campaign detail from id
|--------------------------------------------------------------------------
|
*/
 
  function view_selected_campaign($id)      
 {
   $sql = "SELECT a.id,a.user_id,a.title,a.content,a.image,a.youtube_link,".
          "a.social,a.setting,a.show_pub_stat,a.mybirthday,a.donate_outlets_percent,".
		  "a.keep_percent,a.created_date,a.campaign_life_span,b.firstname,b.lastname FROM $this->campaign_table a,$this->user_table b".
		  " WHERE a.user_id=b.id AND a.id='$id'  ORDER BY a.id DESC";  
		  
   $query = $this->db->query($sql); 
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
| Query to update selected campaign 
|--------------------------------------------------------------------------
|
*/
  
  function update_campaign($id,$data)  
  {
    $this->db->where('id',$id);
	$this->db->update($this->campaign_table,$data);
  }   

  /*
|--------------------------------------------------------------------------
| Query to activate pause campaign 
|--------------------------------------------------------------------------
|
*/
  
   function activate_pause_campaign($id)
	{  
	   $data = array(
	     'pause' => 0
	   );
	   $this->db->where('id',$id);
	   $this->db->update($this->campaign_table,$data);
	}

  /*
|--------------------------------------------------------------------------
| Query to update selected suspended campaign 
|--------------------------------------------------------------------------
|
*/
	
	function activate_suspend_campaign($id) 
    {
       $data = array(
	     'suspend' => 0   
	   );
	   $this->db->where('id',$id);
	   $this->db->update($this->campaign_table,$data);
    }

  /*
|--------------------------------------------------------------------------
| Query to pause selected campaign 
|--------------------------------------------------------------------------
|
*/
	
    function pause_campaign($id)
	{  
	   $data = array(
	     'pause' => 1
	   );
	   $this->db->where('id',$id);
	   $this->db->update($this->campaign_table,$data);
	}

  /*
|--------------------------------------------------------------------------
| Query to suspend selected campaign 
|--------------------------------------------------------------------------
|
*/
	
	function suspend_campaign($id)
    {
       $data = array(
	     'suspend' => 1   
	   );
	   $this->db->where('id',$id);
	   $this->db->update($this->campaign_table,$data);
    }	 

  /*
|--------------------------------------------------------------------------
| Query to delete selected campaign 
|--------------------------------------------------------------------------
|
*/ 
    
	function delete_campaign($id) 
	{
	   $this->db->where('id',$id);
	   $this->db->delete($this->campaign_table); 
	}
   
   function campaign_redeem_list() 
   { 
      $sql   = "SELECT id,title,user_id,redeem_admin_approval_status,redeem_amount FROM $this->campaign_table WHERE redeem_request_to_admin = ? ";  
      $query = $this->db->query($sql,array(1));
      if($query->num_rows() > 0)
      {
         foreach($query->result_array() as $r)
		 {
		     $array = $this->campaign_created_user($r['user_id']);
			 foreach($array as $r2)
			 {
			   $username = $r2['username']; 
			 }
			 $data[] = array(
			     'cid'                          => $r['id'], 
				 'ctitle'                       => $r['title'],
				 'uid'                          => $r['user_id'],
				 'username'                     => $username,
				 'redeem_amount'                => $r['redeem_amount'],
                 'redeem_admin_approval_status'	=> $r['redeem_admin_approval_status']			 
			 );
			   
		 }
		 return $data;  
      }	  
  }
  
  function redeem_for_user($cid,$amount)
  {
    $data = array(
	  'redeem_admin_approval_status' => 1
	);
    $this->db->where('id',$cid);  
    $this->db->update($this->campaign_table,$data);
	return true;   
  }
  
  
  
 } 
 