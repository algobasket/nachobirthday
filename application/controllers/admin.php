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
| Admin Class
|--------------------------------------------------------------------------
|
| Nacho birthday Admin Class 
| METHOD : index -> The default method when the page loads
|  
*/

final class Admin extends CI_Controller{      

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
     $this->_session_exist();  	 
  }

  
     
   function other_login()   
   {
      $data['admin_info'] = $this->admin_model->admin_profile_detail();  
      $this->load->view('admin/other-login',$data); 
   }
   
 
/* 
|--------------------------------------------------------------------------
| Create a new user by admin
|--------------------------------------------------------------------------
|
*/    
   
   function add_user()   
   {
    if($this->uri->segment(3)=='post')   
	{ 
	   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[5]|max_length[12]|xss_clean');
	   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[5]|max_length[12]|xss_clean');
       $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
       $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]|alpha_dash'); 
       $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|alpha_dash'); 
       $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');   
	   $email_activation = $this->config->item('email_activation', 'tank_auth');  
	   if ($this->form_validation->run() == FALSE) 
		{ 
			$data['result'] = "Failed to create";   
		}
		else
		{
		                $this->tank_auth->create_user(  
				        $this->form_validation->set_value('firstname'),
                        $this->form_validation->set_value('lastname'),  						
						$this->form_validation->set_value('username'), 
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'), 
						$email_activation);      
		                $data['result'] = "New User Created";   
		}
	}
	$data['admin_info'] = $this->admin_model->admin_profile_detail();  
	$this->load->view('admin/add-users',@$data);    
   }

/* 
|--------------------------------------------------------------------------
| Get all existing user members
|--------------------------------------------------------------------------
|
*/    
   
   function users()
   {
     $this->load->view('admin/users');  
   }
   
   function other_users()      
   { 
	 switch($this->uri->segment(3))
	 {
	 
	 case 'search':
	    $search = $this->input->post('search');    
	    $data['users'] = $this->admin_model->search_member($search); 
		break;
	 
	 case 'active':
	    $data['users'] = $this->admin_model->member_activity(1); 
	    break;
	 
	 case 'passive':
	    $data['users'] = $this->admin_model->member_activity(0);
	    break;
	
	 case 'all': 
	    $data['users'] = $this->admin_model->all_member();  
	
	 default:
         $data['users'] = $this->admin_model->get_all_user();  	
	 }  	   
     $data['admin_info'] = $this->admin_model->admin_profile_detail();  
	 $this->load->view('admin/other-user-listing',$data);    

	}
   
 /* 
|--------------------------------------------------------------------------
| Get selected  user's profile detail  
|--------------------------------------------------------------------------
|
*/   
   
   function profile()
   {
    $id  = $this->uri->segment(3);
	
    if($this->uri->segment(4)=='activate')
	{
	  //$result = $ci->tank_auth->users->get_activation_key($id);  
      $result = $this->admin_model->activate_user($id);  
	}
	if($this->uri->segment(4)=='ban')
	{
	   $result = $this->admin_model->ban_user($id);     
      //print_r($result);
	  //echo "sdddsdsd"; 
	}
	
     $data['admin_info'] = $this->admin_model->admin_profile_detail();   
	 $data['userinfo'] = $this->admin_model->user_info($id);    
	 $this->load->view('admin/profile',$data);    
   }

 /* 
|--------------------------------------------------------------------------
| Delete user profile   
|--------------------------------------------------------------------------
|
*/ 
   
   function delete_profile() 
   {
     if($this->admin_model->delete_profile((int) $this->uri->segment(3))==TRUE)
	     redirect("admin/other_users");   
   }
  
 /* 
|--------------------------------------------------------------------------
| Get Admin  user's profile detail  
|--------------------------------------------------------------------------
|
*/   
  
  
  function my_profile() 
  {
    $data['admin_info'] = $this->admin_model->admin_profile_detail();  
	if($this->uri->segment(3)=='edit')
	{ 
	    // -------- form data ---------//
           if($this->uri->segment(4)=='update') 
	        {
	         $this->form_validation->set_rules('fullname','First Name','required'); 
		     $this->form_validation->set_rules('email','Email','trim|required|valid_email');
		    if($this->form_validation->run()==FALSE) 
		       {
		         // Error Message
		       }
		     else  
		      {  
		            if($_FILES['avatar']['name']) 
		             {
		              $data = array(
				          'avatar'   => $_FILES['avatar']['name'],
		                  'email'    => $this->input->post('email'),
			              'fullname' => $this->input->post('fullname')
		                 ); 	 
		             }
					 else
					 {
					   $data = array( 
		                 'email'    => $this->input->post('email'),
			             'fullname' => $this->input->post('fullname')
		               ); 
			         }
		          $result = $this->admin_model->admin_profile_edit($data);    
		         if($result==TRUE)
		         {
		             $this->_uploadSetting();  
		         }
		   
		}
	  }
        // -------- form data end ---------//		
	    $this->_edit(); 
	}
	else
	{
	   $data['admin_info'] = $this->admin_model->admin_profile_detail();  
	  $this->load->view('admin/myprofile',$data);    
    }
  }
  
 /* 
|--------------------------------------------------------------------------
|  Edit Info 
|--------------------------------------------------------------------------
|
|
*/   
  
  function _edit()
  { 
    $data['admin_info'] = $this->admin_model->admin_profile_detail(); 
	$this->load->view('admin/edit-profile',$data);   
  }
 
 
  function page_setting() 
  { 
    if($this->input->post('save_page_setting'))  
	{ 
	  $data = array(
	     'sub_highlight_text_small' => $this->input->post('description'),
		 'front_page_video_link'    => $this->input->post('videoLink'),
		 'campaign_goal_status'     => $this->input->post('show-donation-goal')  
	  );
      $result = $this->admin_model->update_client_page_info($data);  	  
	  if($result==TRUE) 
	  {
	    $data['error'] = "Changes Saved";  
	  }
	}
	 $data['admin_info'] = $this->admin_model->admin_profile_detail();  
	 $data['site_front_page_data'] = $this->admin_model->site_front_page_data();   
     $this->load->view('admin/page-setting',$data);       
  }
  
 /* 
|--------------------------------------------------------------------------
|  Upload Setting 
|--------------------------------------------------------------------------
|
|
*/ 
 
  function _uploadSetting()
  {
        $config['upload_path']   = './uploads/admin-profile/'; 
		$config['allowed_types'] = 'gif|jpg|png';   
		$config['max_size']	     = '100';
		$config['max_width']     = '1024';
		$config['max_height']    = '768';
		$this->load->library('upload',$config);  
        $this->upload->do_upload('avatar');
  }
   
  /* 
|--------------------------------------------------------------------------
| Session Timeout
|--------------------------------------------------------------------------
|
| 
| METHOD :This method check the session time out    
|
|
*/ 
       
  function _session_exist()  
  {
     if($this->session->userdata('admin_id')==NULL || $this->session->userdata('admin_id')==FALSE) 
	 {
	      redirect('admin');        
	  }	   
  }   
  


  
 } 