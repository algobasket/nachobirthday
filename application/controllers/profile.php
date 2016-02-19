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

final class Profile extends CI_Controller{     
  
  
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
	   $this->load->library('form_validation'); 	
	    $this->load->model('profile_model');	
   }   
 
/*
|--------------------------------------------------------------------------
| Index / Default
|--------------------------------------------------------------------------
|
|  
*/
 
   function index()   
   {  
     $data['profile_info']   = $this->tank_auth->get_user_by_id($this->tank_auth->get_user_id(),TRUE);
     $data['profile_detail'] = $this->tank_auth->get_user_profile_detail($this->tank_auth->get_user_id());     	 
     $this->_template($data,$templatename='profile');     
   }


/*
|--------------------------------------------------------------------------
| Edit User Profile
|--------------------------------------------------------------------------
|
|  
*/ 
   
   function edit()   
   { 
     if($this->input->post('submit'))    
	 {
	   $this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[20]|xss_clean');
	   $this->form_validation->set_rules('firstname','First Name','trim|required|alpha|min_length[2]|max_length[20]|xss_clean');  
	   $this->form_validation->set_rules('lastname','Last Name','trim|required|alpha|min_length[2]|max_length[20]|xss_clean');     
	   $this->form_validation->set_rules('email','Email','trim|required|valid_email||xss_clean');    
	   $this->form_validation->set_rules('birthday','Birthday','trim|xss_clean');
	   $this->form_validation->set_rules('hobbies','Hobbies','trim|xss_clean');
	   
	   if($this->form_validation->run()==FALSE) 
	   { 
	     $data['message'] = "Error in update";  
	   }
	   else
	   {
	      $input_data = array( 
	       'username'  => $this->input->post('username'),
	       'firstname' => $this->input->post('firstname'),
		   'lastname'  => $this->input->post('lastname'),   
		   'email'     => $this->input->post('email')   
         );
		     if(@$_FILES['image']['name'])
                {
		           $allowed_images      = array('jpg','jpeg','png','gif');   //********* Allowed Extension ************//
		           list($filename,$ext) = explode('.',$_FILES['image']['name']);
		              if(in_array($ext,$allowed_images))
			             {
		                    $input_data2 = array( 
                              'avatar'       => (in_array($ext,$allowed_images)) ? $_FILES['image']['name']:NULL,          		 
		                      'user_id'      => $this->tank_auth->get_user_id(),   
		                      'website'      => $this->input->post('website'),
	                          'country'      => $this->input->post('country'),
		                      'description'  => $this->input->post('description'), 
		                      'facebook'     => $this->input->post('facebook'),
		                      'linkedin'     => $this->input->post('linkedin'),
		                      'twitter'      => $this->input->post('twitter'),
		                      'google'       => $this->input->post('google'),
                              'birthday'     => $this->input->post('birthday'),
                              'hobbies'	     => $this->input->post('hobbies')						  
		                     );
						   $result = $this->profile_model->update($input_data,$input_data2); 	 
		                 }
		               else
		                {
		                      $data['ext_error'] = "<a href='#'>Allow only jpg,jpeg,png or gif image type</a> ";
            					
		                }
		           }
	  	         else
                 {		 
		              $input_data2 = array(       		 
		                   'user_id'      => $this->tank_auth->get_user_id(), 
		                   'website'      => $this->input->post('website'),
	                       'country'      => $this->input->post('country'),
		                   'description'  => $this->input->post('description'), 
		                   'facebook'     => $this->input->post('facebook'),
		                   'linkedin'     => $this->input->post('linkedin'),
		                   'twitter'      => $this->input->post('twitter'),
		                   'google'       => $this->input->post('google'),
                           'birthday'     => $this->input->post('birthday'),
                           'hobbies'	  => $this->input->post('hobbies')						   
		                );
					  $result = $this->profile_model->update($input_data,$input_data2);    	
                 } 
		 
	  if(@$result==TRUE && @$_FILES['image']['name']) 
     { 
        $config['upload_path']   = './uploads/profile/';
		$config['allowed_types'] = 'gif|jpg|png';    
		$config['max_size']	     = '5000';
		$config['max_width']     = '1024';
		$config['max_height']    = '768';
		
		$this->load->library('upload',$config);  
        $this->upload->do_upload('image');  	
     } 	  
         
		 if(@$result==TRUE) 
		 {
		   $data['message'] = "Updated Profile Successfully";
		 }
	   } 
	              	 
	 }
     $data['profile_info']   = $this->tank_auth->get_user_by_id($this->tank_auth->get_user_id(),TRUE);
     $data['profile_detail'] = $this->tank_auth->get_user_profile_detail($this->tank_auth->get_user_id());       
     $this->_template($data,$templatename='profile');   
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
