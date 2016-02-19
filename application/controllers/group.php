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

final class Group extends CI_Controller{    


   function __construct()
   {
    
	parent::__construct();
    foreach($this->_get_maintainance() as $m)
        {
          if($m['maintainance']==1)
		  {
		    die($m['maintainance_message']);
		  }
        }	
    if ($this->tank_auth->is_logged_in()==FALSE)   
     {
	   redirect('login');       
	 }
   } 
   
   function index()  
   {  
     $this->_template($data=NULL,$templatename='group');      
   }    
  
/*
|
|
|  
|--------------------------------------------------------------------------
| Check Maintainance Mode
|--------------------------------------------------------------------------
|
| 
| METHOD : _get_maintainance - Is to check maintainance whether site offline or online  
|
|
*/
   
   
   function _get_maintainance() 
   {  
      return $this->admin_setting_model->get_maintainance();
   } 
  
/*
|--------------------------------------------------------------------------
| Template Method
|--------------------------------------------------------------------------
|
| 
| METHOD : template -> This method dynamically load the template   
|
|
*/    
   
   function _template($data=NULL,$templatename=NULL)  
   {
     $header = ($this->tank_auth->get_user_id()) ? 'header-2':'header';
     $data['template'] = $templatename;
	 $data['header']   = 'includes/'.$header;
     $this->load->view('includes/template',$data); 
   }   
  
  
  
?>