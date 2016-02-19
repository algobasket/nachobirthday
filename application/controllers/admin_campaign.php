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
class Admin_campaign extends CI_Controller{  
 
   private $api_username = 'pradent_api1.pradent.com';                                  /* ----- Paypal Username -------- */
   
   private $api_password = '1400496288';                                                /* ----- Paypal Password -------- */
   
   private $signature   = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AnGg-lpat0-XKrvPXXmxXSv9kqmr';   /* ----- Paypal Signature -------- */
   
   private $test_mode   = true;        
   
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
	$this->load->model('admin_campaign_model');
	$this->_session_exist();
    
    /* -------- Load Paypal Library ------- */

    $this->load->library('merchant');                                   /* ----- Load Paypal Merchant -------- */
     $this->merchant->load('paypal_express'); 
     $settings = $this->merchant->default_settings();
	 $settings = array( 
                    'username'  => $this->api_username, 
                    'password'  => $this->api_password,
                    'signature' => $this->signature, 
                    'test_mode' => $this->test_mode 
			   ); 
     $this->merchant->initialize($settings);     
	
  }
 
  /* 
|--------------------------------------------------------------------------
| Index / Default Method
|--------------------------------------------------------------------------    
|
|
*/
 
  function index()
  {
    $this->view_all_campaign();
  }

 /* 
|--------------------------------------------------------------------------
| View all campaign 
|--------------------------------------------------------------------------   
|
*/
  
  function view_all_campaign()        
  { 
    $data['admin_info'] = $this->admin_model->admin_profile_detail();
    $data['campaign'] = $this->admin_campaign_model->all_campaign();       
	$this->load->view('admin/view-all-campaign',$data);             
  }  
  
  function campaign_redeem() 
  { 
     if($this->uri->segment(3) == 'redeem_for_user' && $this->uri->segment(4) && $this->uri->segment(5))
	 {
	    $c_id     = $this->uri->segment(4);
		$c_amount = $this->uri->segment(5);
		if($this->admin_campaign_model->redeem_for_user($c_id,$c_amount) == true)
         {
               redirect('admin_campaign/campaign_redeem/');
               //$this->campaign_redeem_pay($c_id);
		 } // END IF		 
	 }
     $data['campaign_redeem_list'] = $this->campaign_redeem_list();
     $this->load->view('admin/view-all-campaign-redeem',$data);         
  }
  
  function campaign_redeem_pay($c_id)
  {
      $campaign_detail = $this->campaign_model->get_all_campaigns($c_id);
              foreach($campaign_detail as $r)
              {
              $campaign_name = $r['title'];
              }			  
              $return_url      =  base_url().'admin_campaign/campaign_redeem';   
              $cancel_url      =  base_url().'admin_campaign/campaign_redeem/cancel';      
              
			  $params = array( 
              'item_name'   => "Redeem For Campaign ".$campaign_name,  
              'item_number' => $c_id,   			  
              'amount'      => $c_amount,    
              'currency'    => 'USD',  
              'return_url'  => $return_url,   
              'cancel_url'  => $cancel_url,    
              'items' => array( 
                             array(  
                             'name' => $campaign_name,    
                             'desc' => 'Hope you are doing well.We have send your redeem amount '.$c_amount.' for the campaign '.$campaign_name,   
                             'amt'  => $c_amount,  
                             'qty'  => 1      
                      ) 	
                  )	 				  
			  );    
            $response = $this->merchant->purchase($params); 
  }
  
 /* 
|--------------------------------------------------------------------------
| Edit Campaign Detail
|--------------------------------------------------------------------------   
|
*/
  
function edit()  
{ 
  $campaign_id  = $this->uri->segment(3);
  $action       = $this->uri->segment(4);
  if(isset($campaign_id) && $action=='save' )
  {
    $title   = $this->input->post('title');
    $images  = $this->input->post('images');
    $youtube = $this->input->post('youtube');
    $content = $this->input->post('content');  
    $data = array( 
	   'title'        => $title,
	   'image'       =>  json_encode($images,TRUE), 
	   'youtube_link' => $youtube,
	   'content'      => $content 
	);
	$this->admin_campaign_model->update_campaign($campaign_id,$data);
    redirect('admin_campaign/show/'.$campaign_id);  	
  }
  $campaign_id = $this->uri->segment(3);
   $data['admin_info'] = $this->admin_model->admin_profile_detail();    
  $data['campaign'] = $this->admin_campaign_model->view_selected_campaign($campaign_id); 
  $this->load->view('admin/edit-campaign',$data);     
}
  
 /* 
|--------------------------------------------------------------------------
| Show Selected Campaign Detail
|--------------------------------------------------------------------------   
|
*/  
  
  function show()   
  {
    $data['campaign'] = $this->admin_campaign_model->view_selected_campaign($this->uri->segment(3)); 
	$this->load->view('admin/campaign',$data);           
  }

/* 
|--------------------------------------------------------------------------
| Activate Pause or Suspend Campaign 
|--------------------------------------------------------------------------   
|
*/  
  
  function activate()
  {  
     if($this->uri->segment(3)=='pause')   
	 { 
       $this->admin_campaign_model->activate_pause_campaign($this->uri->segment(4));
       redirect('admin_campaign/view_all_campaign');	 
	 }
	 else if($this->uri->segment(3)=='suspend') 
	 {
       $this->admin_campaign_model->activate_suspend_campaign($this->uri->segment(4)); 
       redirect('admin_campaign/view_all_campaign');   
     }
  }
   
/* 
|--------------------------------------------------------------------------
| Pause selected campaign from donation
|--------------------------------------------------------------------------   
|
*/    
   
  function pause()
  {
     $this->admin_campaign_model->pause_campaign($this->uri->segment(3));
     redirect('admin_campaign/view_all_campaign');  	 
  }

/* 
|--------------------------------------------------------------------------
| suspend selected campaign from viewing
|--------------------------------------------------------------------------   
|
*/  
  
  function suspend() 
  { 
   $this->admin_campaign_model->suspend_campaign($this->uri->segment(3));
   redirect('admin_campaign/view_all_campaign');
  }
  
  
  function campaign_redeem_list() 
  {
    $result = $this->admin_campaign_model->campaign_redeem_list();  
    return $result;
  }
  
/* 
|--------------------------------------------------------------------------
| Delete selected campaign
|--------------------------------------------------------------------------   
|
*/  
  
  function delete_campaign() 
  {
    $this->admin_campaign_model->delete_campaign($this->uri->segment(3));  
	redirect('admin_campaign/view_all_campaign');    
  }
 
/* 
|--------------------------------------------------------------------------
| Check session existence
|--------------------------------------------------------------------------   
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

