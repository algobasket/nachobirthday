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
| WELCOME CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday welcome Class
| METHOD : index -> The default method when the page loads
| 
*/


final class Welcome extends CI_Controller 
{


/*
|--------------------------------------------------------------------------
| CAMPAIGN CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Campaign Class
| METHOD : index -> The default method when the page loads
| 
*/

    /*
|--------------------------------------------------------------------------
| Constructor
|--------------------------------------------------------------------------
|
| 
| METHOD : __construct -> Initialise the method whenever the class is called   
|
|
*/

	function __construct()
	{
		parent::__construct();
     
	   // Initialise Methods    
        foreach($this->_get_maintainance() as $m) 
        {
          if($m['maintainance']==1)
		  {
		    die($m['maintainance_message']);
		  }
        } 
       
	 }

	
/*
|--------------------------------------------------------------------------
| INDEX
|--------------------------------------------------------------------------
|
| 
| METHOD : index -> The default method when the page loads   
|
|
*/	 
	
	
	function index()   
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('login'); 
		} else {
		 
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();  
			$this->_template($data,$templatename='welcome');
		}
	}
	
  /*
|
|
|  
|--------------------------------------------------------------------------
| FAQ
|--------------------------------------------------------------------------
| 
|
|
*/	
	
	
	function faq()
	{
	  $this->_template($data=NULL,$templatename='faq'); 
	}
	
  /*
|
|
|  
|--------------------------------------------------------------------------
| How it's Work
|--------------------------------------------------------------------------
| 
|
|
*/		
	
	function how_it_works() 
	{
	  $this->_template($data=NULL,$templatename='how-it-works');
	}

  /*
|
|
|  
|--------------------------------------------------------------------------
| Contact Us
|--------------------------------------------------------------------------
| 
|
|
*/	
	
	function contact_us()
	{
	   $this->_template($data=NULL,$templatename='contact-us'); 
	}

  /*
|
|
|  
|--------------------------------------------------------------------------
| FAQ
|--------------------------------------------------------------------------
| 
|
|
*/	
	
	function about_us()
	{
	   $this->_template($data=NULL,$templatename='about-us');  
	}
	

	function term_and_condition()
	{
	   $this->_template($data=NULL,$templatename='term-and-condition');  
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
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */