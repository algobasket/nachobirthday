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
| ADMIN GROUP CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday admin group Class
| METHOD : index -> The default method when the page loads
|  
*/
 
class Admin_setting extends CI_Controller{     

/* 
|--------------------------------------------------------------------------
| Constructor
|--------------------------------------------------------------------------
|
| 
| METHOD : Initialise the method in it when a class is instantiated    
|
|
*/

   
  function __construct()
  {
     parent::__construct();
	 $this->load->model('admin_setting_model');  
     $this->session_exist();  
    	 
  }
  
  function maintainance()
  {
  
   if($this->input->post('submit')) 
   {
      $status = $this->input->post('maintainance'); 
	  $txt = $this->input->post('maintainance_message');  
      $data = array(
	      'maintainance'        => $status,
	      'maintainance_message' => $txt 
	);	
	  $result = $this->admin_setting_model->maintainance($data); 
      if($result==TRUE)
       { 
         $data['result'] = "Change Saved";   
       } 		  
	};
	$data['maintainance_detail'] = $this->_get_maintainance();  
	$this->load->view('admin/site-maintainance',$data);    
 }
  
 function _get_maintainance()
 {
   return $this->admin_setting_model->get_maintainance();    
 }
  
 function social_setting()
 {
   if($this->input->post('facebook_submit'))
   { 
      $facebook_app_id     = $this->input->post('fb_app_id'); 
	  $facebook_app_secret = $this->input->post('fb_app_secret');  
	  $data = array(
	    'fb_app_id'     => $facebook_app_id, 
		'fb_app_secret' => $facebook_app_secret
	  );
         $result = $this->admin_setting_model->save_social_setting($data);
      if($result==TRUE)
       {
         $data['result'] = "Change Saved";   
       }	   
   }
   $data['social_setting'] = $this->admin_setting_model->get_social_setting();  
   $this->load->view('admin/social-setting',$data);    
 } 
/* 
|
|
|
|--------------------------------------------------------------------------
| Session Existence 
|--------------------------------------------------------------------------
|
| 
| METHOD :This method check the session time out    
|
|
*/ 
       
  function session_exist()
  {
     if($this->session->userdata('admin_id')==NULL || $this->session->userdata('admin_id')==FALSE) 
	 {
	      redirect('admin');       
	  }	   
  }

  
}