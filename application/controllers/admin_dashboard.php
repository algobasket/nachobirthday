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


class Admin_dashboard extends CI_Controller{    
 
 
 function index()
 {
   $this->welcome();
 } 
/* 
|--------------------------------------------------------------------------
| Welcome Method
|--------------------------------------------------------------------------
|
| 
| METHOD : Authenticated member redirect to this method 
|
| 
*/
  function welcome()    
  {  
     if($this->session->userdata('admin_id')==NULL || $this->session->userdata('admin_id')==FALSE) 
	  {
	    redirect('admin_login/login');       
	  } 
	  else
	  {
	    $data['admin_info'] = $this->admin_model->admin_profile_detail(); 
	    $this->load->view('admin/welcome',$data);  
	  }   	 
  }
  
  /* ----- Calculate Profit ------ */
  
  function calculate_profit()
  {
     
  }
  
   /* ----- Calculate Growth ------ */
  
  function calculate_growth()
  {
  
  }
  
  /*----- Count New Group ----- */ 
  
  function new_groups()
  {
  
  }
  

  
/* 
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
|
| 
| METHOD :Logout admin 
|
| 
*/  
  
 function logout() 
   {
     $this->session->sess_destroy();   
	 redirect('admin');     
   } 
}

?>