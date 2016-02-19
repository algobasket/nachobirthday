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
| DASHBOARD CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday dashboard Class
| METHOD : index -> The default method when the page loads
| 
*/

final class Dashboard extends CI_Controller     
{
	
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
		$this->lang->load('tank_auth');
        $this->load->model('dashboard_model');
        $this->load->model('profile_model');  		
	    $this->_session_exist(); 
        $this->_create_page_hits();	 	
	}
	
	function index()  
	{    
	    $data['campaign']                   = $this->campaign_model->get_active_campaign_group();   
        $data['dashboard_stats']            = $this->_dashboard_stats();    	
	    $data['get_goal_visibility']        = $this->campaign_model->get_goal_visibility(); 	   
	    $data['my_campaign']                = $this->campaign_model->user_campaign(); 
        $data['profile_completeness']       = $this->profile_model->check_user_profile_complete();       		
        $this->_template($data,$templatename='dashboard');   		
	}   

/*
|--------------------------------------------------------------------------
| Insert the page viewing users 
|--------------------------------------------------------------------------
|
*/
	 
	function _create_page_hits()  
    { 
	  $user_id = $this->tank_auth->get_user_id();
      $ip      = $this->input->ip_address();
	  $date    = date('d/M/Y'); 
	  $data = array(
	     'uid'         => $user_id,
		 'date'        => $date,
		 'campaign_id' => NULL, 
		 'ip_address'  => $ip 
	  );  
	  return $this->campaign_model->create_page_views($data); 
    }	

/*
|--------------------------------------------------------------------------
| Count Page Hit
|--------------------------------------------------------------------------
|
*/	
	 
	function _count_page_hit() 
    {
      return $this->dashboard_model->count_page_hit();   
    } 
	 
/*
|--------------------------------------------------------------------------
| Total Amount Donated
|--------------------------------------------------------------------------
|
*/
	 
	function _total_amount_donated()
	{
	  return $this->dashboard_model->total_amount_donated(); 
	}

/*
|--------------------------------------------------------------------------
| Toatal Donated Member 
|--------------------------------------------------------------------------
|
*/
	
	function _total_donors()
	{
	  return $this->dashboard_model->total_donors(); 
	}

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
|
*/
	
    function _dashboard_stats()
    { 
      $data['page_view']         = $this->_count_page_hit();  
      $data['amount_donated']    = $this->_total_amount_donated(); 
      //$data['non-profit']      = $this->user_nonprofit_donated(); 
      $data['amount_owner']	     = $this->_campaign_amount_owner(); 
	  $data['donors']            = $this->_total_donors();
      $data['donation_message']  = $this->_donation_message();      	  
	  return $data;   
    } 
    
	function _campaign_amount_owner()
	{
	  return $this->dashboard_model->campaign_amount_owner();
	}
	
/*
|--------------------------------------------------------------------------
| Donation Messages/comments
|--------------------------------------------------------------------------
|
*/	
	
	function _donation_message() 
	{
	  return $this->dashboard_model->donation_message();
	}
	
/*
|--------------------------------------------------------------------------
| Real Time data on high chart 
|--------------------------------------------------------------------------
|
*/
  function highchart()
  {
     $array = array(
	   'campaign_view_stat'   => $this->highchart_data(),
	   'donation_count_stat'  => $this->highchart_data_amount()
	 );
	echo json_encode($array,true);     
  }
  
  function highchart_data()
  {  
    //echo $_SERVER['REMOTE_ADDR']; 
    list($c_d,$c_m,$c_y) = explode('/',date('d/M/Y')); // ------ Current Date ------
    $result = $this->dashboard_model->page_counter();  
	$m_count = array();
	if(is_array($result)){ 
	foreach($result as $r)
	{
	  list($s_d,$s_m,$s_y) = explode('/',$r['date']); // ------- Stored Date --------
	  if($c_y==$s_y)
	  {  
	     $m_count[] = $s_m;   
	  }
	} 
	}
	 $array  = array_count_values($m_count);
	 $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');  
     foreach($months as $m) 
	 { 
	    if(array_key_exists($m,@$array))
		{
		  $x[] = $array[$m];
		}
		else
		{
		  $x[] = (float) 0.0;   
		}
        		
	 }
	 //$json = json_encode($x,TRUE); 
	 //echo $json;   
      return $x;   	 
   } 
 
 
   function highchart_data_amount()
   { 
     $data = array(); 
     $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
     list($c_d,$c_m,$c_y) = explode('/',date('d/M/Y'));    // ------- Current Date -------- //
     $result = $this->dashboard_model->donation_stat();
     foreach($result as $r)
     {  
	   $date  = $r['date'];  
       list($s_d,$s_m,$s_y) = explode('/',$date);          // ------- Stored Date ---------- //    
	   if($c_y==$s_y)
	   {
	   	 $data[] = $s_m;
         		 
	   }
	 }  
	 $count      = array_count_values($data);
     foreach($months as $m)
	 {
	    $array[] = (@$count[$m]==null) ? 0 : @$count[$m]; 
	 }
     //$json = 	json_encode($array,TRUE);  
     //echo $json; 
     return $array;  	 
   } 
 
  function piediagram_data()    
  {    
     $birthday_percentage = $this->dashboard_model->birthday_percentage();  
	 $charity_percentage  = $this->dashboard_model->charity_percentage();  
	 $array = array(
	   'birthday' => $birthday_percentage,
	   'charity'  => $charity_percentage
	 );
     $data  = json_encode($array,TRUE); 
	 echo $data; 	 
  }

/* ------- Test --------- */  
  
  function test()
  {
    print_r($this->dashboard_model->piechart());   
  }
  
  
  
/*
|--------------------------------------------------------------------------
| Similar Campaign
|--------------------------------------------------------------------------
|
*/	
	
    function similar_campaign()   
	{
	  return $this->dashboard_model->similar_campaign();  
	}	
	
/*
|--------------------------------------------------------------------------
| Check Session Existence
|--------------------------------------------------------------------------
|
*/	
	
	function _session_exist() 
	{
	   if ($this->tank_auth->is_logged_in()==FALSE)     
	   {
	      redirect('login');        
	   }
	}

/*
|
| 
|--------------------------------------------------------------------------
|  Check profile completeness   
|--------------------------------------------------------------------------
|
*/
   function profile_completeness()   
   {
      echo $this->profile_model->check_user_profile_complete();
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
