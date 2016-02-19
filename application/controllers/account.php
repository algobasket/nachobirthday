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

final class Account extends CI_Controller{     
   
  function __construct()
  {
     parent::__construct();
  }
  
  function billing() 
  {   
      if($this->uri->segment(4)=='redeem_request') 
	  {
	     $cid    = $this->uri->segment(5);
		 $amount = $this->uri->segment(6);
         $result = $this->campaign_model->user_redeem_request($cid,$amount); 
         if($result==true){ 		 
		      redirect('account/billing/redeem/');
          }
		 }
      $data['billing_detail']         = $this->billing_detail(); 
	  $data['redeem_campaign_amount'] = $this->redeem_campaign_amount();
      $this->_template($data,$templatename='account-billing');       	
  } 
   
  function billing_detail() 
  {   
      $this->load->model('admin_payment_model');   
      //return $this->admin_payment_model->payment_report_user($this->tank_auth->get_user_id());  
      return $this->admin_payment_model->account_overview($this->tank_auth->get_user_id());      	  
  }
 
  /* --------- Campaign Redeem  --------------- */
 
 
 function test() 
 {
     $this->load->model('admin_payment_model');  
     //print_r($this->admin_payment_model->test($this->tank_auth->get_user_id()));
     print_r($this->admin_payment_model->account_overview()); 	 	 
 }

  function redeem_campaign_amount()      
  {   
     $result = $this->campaign_model->user_campaign_info();
    if(is_array($result)){  	 
     foreach($result as $r) 
	 {  
	   $cid            = $r['id'];
	   $redeem_request = $r['redeem_request_to_admin'];
       $admin_approval = $r['redeem_admin_approval_status']; 	   
	   $cname          = $this->campaign_model->get_campaign_by_id($cid);
	   $make_array[]   = array(  
	     'cid'                          => $cid,
		 'campaign_name'                => $cname, 
		 'campaign_amount'              => $this->campaign_amount($cid), 
		 'campaign_donation_amount'     => $this->campaign_donation_amount($cid),
		 'redeem_request'               => $redeem_request,  
         'admin_approval'               => $admin_approval,  		 
         'is_redeem_available'		    => $this->is_redeem_available($cid),      
	   ); 
	 } 
	   return $make_array; 
     }	 
  }
  
  function is_redeem_available($cid)
  { 
     if($this->campaign_amount($cid) ==0 && $this->campaign_donation_amount($cid)==0){
	   return 0;
	 }else{
	    if($this->campaign_amount($cid) <= $this->campaign_donation_amount($cid)){
	  return 1;
	 }else{
	  return 0; 
	 }
	 }
     
  }
  
  /* --------- Campaign Amount --------------- */
  
  function campaign_amount($id) 
  {
     return $this->campaign_model->campaign_amount($id);
  }
   
  /* --------- Campaign Donation Amount --------------- */ 
  
  function campaign_donation_amount($id)
  {
     return $this->campaign_model->campaign_donation_amount($id); 
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