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
| CAMPAIGN CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Campaign Class
| METHOD : index -> The default method when the page loads
|  
*/

final class Admin_login extends CI_Controller{      



  protected $email;
  protected $password; 
  protected $data;  
  
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
     $this->load->library('form_validation'); 
	 $this->load->library('security');
	 $this->load->model('admin_login_model');   
     $this->session_exist();    	 
  }
  /* 
|--------------------------------------------------------------------------
| INDEX Method
|--------------------------------------------------------------------------
|
| 
| METHOD : index method default method    
|
|
*/	
  
  
   function index($val=NULL)  
   {  
     $data['error'] = $val;  
     $this->load->view('admin/index',$data);                      
   }   

  /* 
|--------------------------------------------------------------------------
| Login Method
|--------------------------------------------------------------------------
|
| 
| METHOD : Login method to authenticate admin members 
|
|
*/

   
   function login()
   {  
       $email    = $this->input->post('email'); 
	   $password = sha1($this->input->post('password'));   
	   $result   = $this->admin_login_model->authenticate($email,$password);         
	     
		if(is_array($result))
	    {
	      foreach($result as $r) 
	      {
	        $id       = $r['id'];
		    $email    = $r['email']; 
            $fullname = $r['fullname'];    		
	      }  
		$data = array( 
	           'email'     => $email, 
		       'admin_id'  => $id, 
		       'fullname'  => $fullname        
	       );     
		 $this->session->set_userdata($data);
		 redirect('admin_dashboard');       
	 }  	
	 else 
	 {
	     $val="Login Fail"; 
	     $this->index($val);    
	  }   
	 
	}
	    
 /* 
|--------------------------------------------------------------------------
| Session Existence
|--------------------------------------------------------------------------  
|
|
*/
   
  function session_exist()  
  {
     if($this->session->userdata('admin_id'))  
	 {
	    redirect('admin_dashboard');         
	 }
  } 
  
  
  
  
 }
  
