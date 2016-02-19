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
 
final class Admin_group extends CI_Controller{     

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
	 $this->load->model('admin_group_model');
     $this->session_exist();  
    	 
  }
   
   function index()  
   {   
     $this->_template($data=NULL,$templatename='group');      
   }    
    
/* 
|-------------------------------------------------------------------------- 
| New Group 
|--------------------------------------------------------------------------
|
| 
| METHOD : newgroup method to create new group / categories for campaign  
|
|
*/
  
  function new_group($uri=NULL) 
   { 
     if($uri=='create')  
	 {  
	    $name       = $this->input->post('new-group-name');
		$array      = $this->input->post('optionsRadios');
        $visibility  = $array[0];		
		if($name)  
		{ 
		   $result = $this->admin_group_model->create_group($name,$visibility,$this->session->userdata('admin_id'));   
		  if($result==true) 
		  {
		     $data['error'] = "New Group Created"; 
		  }
		  else
		  {
		     $data['error'] = "Already Exist";  
		  }
	   }
	 }
	  $data['admin_info'] = $this->admin_model->admin_profile_detail();  
     $this->load->view('admin/add-new-group',@$data);     
   } 
   
  /* 
|--------------------------------------------------------------------------
| Edit Group
|--------------------------------------------------------------------------
|
| 
| METHOD : editgroup to edit group  
|
|
*/   
   
   function edit_group($uri=NULL)   
   { 
     //$data['all_groups']        = $this->adminmodel->get_all_group();  
	  $data['get_group_by_id']    = $this->admin_group_model->get_group_by_id($uri);  
      $data['all_campaign']       = $this->admin_model->get_all_campaign();      
	 if($this->input->post('update')) 
	 {   
	    $select_group_id    = $this->uri->segment(3);   
		$editGroupName      = $this->input->post('editGroupName');
		$array              = $this->input->post('optionsRadios'); 
		$visibility         = $array[0];   		
        $campaignSelect     = $this->input->post('campaignSelect');       
		 
	      if($select_group_id && $editGroupName && $campaignSelect)    
          { 
		 
		     $result = $this->admin_group_model->edit_group($select_group_id,$editGroupName,$visibility,$campaignSelect);    
		     if($result==TRUE)
			 { 
			     $data['result'] = "Change Saved";  
			  } 
			 else
			 {
			     $data['result'] = "Error in saving";  
			 }
		  }  		
	  }	 
      $data['admin_info'] = $this->admin_model->admin_profile_detail();  	  
	 $this->load->view('admin/edit-group',$data);      
   }

    /* 
|--------------------------------------------------------------------------
| View All Group 
|--------------------------------------------------------------------------
|
| 
| METHOD : Viewallgroup the group 
|
|
*/   
   
   function view_all_group()  
   {    
     $data['all_groups']   = $this->admin_group_model->get_all_group();  
      $data['admin_info'] = $this->admin_model->admin_profile_detail();  	 
     $this->load->view('admin/view-all-group',$data);   
   } 

  /* 
|--------------------------------------------------------------------------
| Delete Group
|--------------------------------------------------------------------------
|
| 
| METHOD : delete selected group  
|
|
*/
   
   function delete_group($id)    
   {
     $this->admin_group_model->delete_group($id);    
	 redirect('admingroup/viewallgroup'); 
   }
   
     /* 
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