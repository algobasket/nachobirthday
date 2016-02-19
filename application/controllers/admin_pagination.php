<?php
  // WORKING ON IT

class Admin_pagination extends CI_Controller{

  function __construct()
  {
    parent::__construct();
	$this->load->library('pagination');    
  }
 
  function get_total_users()
  { 
    return $this->admin_model->getAllUserCount();
  }
   
  function per_page() 
  {
    return 5; 
  } 
  
  function pagination_setting()
  {
     
  }
  
  
  
  
}

