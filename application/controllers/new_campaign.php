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
| NEWCAMPAIGN CONTROLLER 
|--------------------------------------------------------------------------
|
| Nacho birthday PreCampaign Class
| METHOD : index -> The default method when the page loads
| 
*/

final class New_campaign extends CI_Controller 
 {
	
 	
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
      foreach($this->_get_maintainance() as $m) 
       {
          if($m['maintainance']==1)
		  {
		    die($m['maintainance_message']);
		  }
       }	  
      if($this->tank_auth->is_logged_in()==FALSE) 
		 {
			   redirect('login/new_campaign');            
		 } 	  
		 
		 $donation_array = array();
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
	
	function index($val=NULL)   
	{   
       $data['get_goal_visibility'] = $this->campaign_model->get_goal_visibility();        	
	   $data['error']               = $val;   
	   $data['outlets']             = $this->campaign_model->donation_outlet_list();  
       $this->_template($data,$templatename='new-campaign'); // Dynamic Page View   	    
	}

/*
|--------------------------------------------------------------------------
| CREATE Method
|--------------------------------------------------------------------------
|
| 
| METHOD : create -> This method can be use to create new fresh campaign   
|
|
*/
	
	
    function create()  
    {  
	   $this->load->helper('string'); // -------- Load String Helper
       $this->load->library('cart'); 	
	   $uid                 = $this->tank_auth->get_user_id(); 
	   $title               = $this->input->post('title'); 
	   $content             = quotes_to_entities($this->input->post('content'));      
	   $link                = $this->input->post('link');
	   $social_fb           = $this->input->post('social_fb');
	   $social_twitter      = $this->input->post('social_twitter');
	   $social_linkedin     = $this->input->post('social_linkedin'); 
	   $social_gplus        = $this->input->post('social_gplus');  
	   $setting             = $this->input->post('setting');
	   $pub_stat            = $this->input->post('showPubStat')[0];  
	   $mybirthday          = ($this->input->post('mybirthday')[0]) ? 1 : 0;      
	   $keepPercentage      = $this->input->post('keep-percentage')[0]; // checkbox
	   $donate              = $this->input->post('donate')[0];          // checkbox 
       $keepPercentageLimit = ($keepPercentage==1) ? $this->input->post('keep-percentage-limit'):NULL;     
	   $campaign_life_span  = $this->input->post('campaign_life_span');     
	  
	   $social_link = array( 
	      'fb_page_url'       => $social_fb,
		  'twitter_page_url'  => $social_twitter,
		  'linkedin_page_url' => $social_linkedin,
		  'gplus_page_url'    => $social_gplus 
	   ); 
	   
	   $social = json_encode($social_link,TRUE);    
	   
	   /* ================== Multi File Upload ============== */
         		 
		  if (!empty($_FILES))    
         {          
                $tempFile = $_FILES['file']['tmp_name']; 
				$fileName = $_FILES['file']['name']; 
                $targetPath = './uploadstest/';     
                $targetFile = $targetPath . $fileName ; 
				//Loop through each file
                  for($i=0;$i<count($fileName);$i++){
                   //Get the temp file path
                      $tmpFilePath = $tempFile[$i]; 

                  //Make sure we have a filepath
                       if ($tmpFilePath != "")
					   {
                               //Setup our new file path
                          $newFilePath = "./uploads/" .$fileName[$i]; 

                         //Upload the file into the temp dir
						 
                             if(move_uploaded_file($tmpFilePath,$newFilePath))
							  {
                                 $file[] = $fileName[$i];    
                              }
                         }
                }  //END FOR LOOP 
				  
				$JsonImage = json_encode($file,TRUE);
                				   
		} 	
		 else  
		 {
		    $image = NULL;  
		 }  
	   if($donate==1)     
	     {   		 
		    
			$donatePer  = $this->input->post('donate-percentage');
			$donateToID = $this->input->post('donateToID');
			
			$array = array();
			
		    for($i=0;$i<count($donateToID);$i++)   
			{    
			   $row                     = json_decode($donateToID[$i]); 
			   $row2                    = json_decode($donatePer[$i]); 
			   $remaining               = $goal-($goal*$keepPercentageLimit/100); 
			   $data['donatePercent']   = $row2;   
			   $data['donatePersonID']  = $row;   
			   $data['donateAmount']    = $remaining*$row2/100;  
			   array_push($array,$data);      
			} 
			
			 $donateTo          = json_encode($array,true);  
			 $donatePercentage  = json_encode($array,true); 
	         $result = $this->campaign_model->create_campaign($TableCampaign=NULL,$uid,$title,$content,$JsonImage,$link,$social,$setting,$pub_stat,$mybirthday,$donate,$donatePercentage,$donateTo,$keepPercentage,$keepPercentageLimit,$campaign_life_span);
			 
			 /*----- Store the Campaign Id -------- */
             $this->session->set_userdata(array('create_campaign_id' => $result));      			 
	     
		 }  
		 else 
		 {
		     $donateTo = NULL; 
             $donatePercentage = NULL;       
	         $result = $this->campaign_model->create_campaign($TableCampaign=NULL,$uid,$title,$content,$JsonImage,$link,$social,$setting,$pub_stat,$mybirthday,$donate,$donatePercentage,$donateTo,$keepPercentage,$keepPercentageLimit); 
		      
			 /*----- Store the Campaign Id -------- */
             $this->session->set_userdata(array('create_campaign_id' => $result));           
		
		}          
  } 

function success()
{
  $this->_template($data=NULL,$templatename='campaign-success'); // Load Campaign Success Page   	    
}  
 
/*
|--------------------------------------------------------------------------
| DonationOutletList in Ajax Method
|--------------------------------------------------------------------------
|
| 
| METHOD : DonationOutletAjax -> Display the DonationOutletList with Ajax 
|
|
*/  
      
  
  function donation_outlet_ajax()   
  { 
    $row_id          = $this->input->post('row_id');      
    $donateToID      = $this->input->post('donateTo');   
    $goal_amount     = $this->input->post('goal_amount'); 
    $donate_percent  = $this->input->post('donate_percent'); 
    $keep_percent    = $this->input->post('keep_percent');  	    
	$get_donation_outlet_name = $this->campaign_model->get_donation_outlet_name($donateToID); 
	$donation_percent_total = $this->input->post('donation_percent_total');
	$limit = $donation_percent_total+$keep_percent;	
	$array  = array(       
	             $row_id => array(     
	                              'row_id'                            =>  $row_id,  
								  'donate_organisation'               =>  $get_donation_outlet_name,                                                       /* --- Organisation / Charity Name -----*/
								  'donate_organisation_id'            =>  $donateToID,                                                                     /* --- Organisation Id / Charity Id -----*/
								  'goal_amount'                       =>  $goal_amount,                                                                    /* --- Goal Amount -----*/
								  'keep_percent'                      =>  $keep_percent, 
								  'keep_amount'                       => ($goal_amount * $keep_percent/100) - ($goal_amount * $keep_percent/100) * 0.05,      /* --- Keep Amount -----*/
								  'after_keep_amount_deduction'       => $goal_amount - ($goal_amount * $keep_percent/100),                                   /* --- Amount left after Keep deduction(Is is to be distributed to all charity) -----*/
								  'donate_percent'                    => $donate_percent,                                                                      /* --- Percentage to Donate to charity -----*/
								  'donate_amount'                     => ($goal_amount * $donate_percent/100) - ($goal_amount * $donate_percent/100) * 0.05,  /* --- Amount to Donate to charity -----*/
							  )     	  					 
	            );
	   if($limit > 100)        
	  {   	  
	      echo '<script>$("#modal2").addClass("active");</script>'; 				
	  }else{
	      $this->view_current_charity_donated($array);  
	 }
	
	}   
	
	 
   function view_current_charity_donated($array)    
   {
     foreach($array as $r)
	 {
	    $html = '<tr class="donation_row'.$r['row_id'].'" data-donationpercent="'.$r['donate_percent'].'">      			  
			     <th>&nbsp;&nbsp;&nbsp;<small>'.$r['donate_organisation'].'</small></th>  
                 <th class="donate_percent_row">'.$r['donate_percent'].'</th> 
				 <th>'.$r['donate_amount'].'</th>      
                 <th>      
                 <input type="hidden" value="'.$r['donate_amount'].'" class="donate_amount" name="donate_amount[]" /> 
                 <input type="hidden" value="'.$r['donate_percent'].'" class="donate_percent" name="donate_percent[]" />       				 
				 <input type="hidden" value="'.$r['donate_organisation_id'].'" id="donateToID" name="donateToID[]" class="donateToID" />     
				 <input type="hidden" value="'.$r['donate_percent'].'" name="donate-percentage[]" class="donate-percentage" /> 
				 <a href="javascript:remove_donation_row('.$r['row_id'].')" id="remove_donation" data-remove_donation=""><i class="icon-cancel-squared"></i></a>    
				 </th>    				 
		       </tr>';          
     echo $html; 
	 } 
   }
   
   function campaign_active() 
  {
     $this->_template($data=array('active'=> 1),$templatename='campaign'); 
  }  
   function campaign_passive() 
  {
     $this->_template($data=array('active'=> 0),$templatename='campaign'); 
  }   
   
/*
|--------------------------------------------------------------------------
| Image in Ajax Method 
|--------------------------------------------------------------------------
|
| 
| METHOD : DonationOutletAjax -> Display the DonationOutletList with Ajax 
|
|
*/      
   
  function image_upload($name)   
  { 
        $config['upload_path'] = './uploads/'; 
		$config['allowed_types'] = 'gif|jpg|png';     
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';   
		$this->load->library('upload',$config);   
        $this->upload->do_multi_upload($name);      
        return true;		
  }
  
  function campaign_success() 
  {
     $this->_template($data=NULL,$templatename='campaign-success'); 
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
| METHOD : template -> This method dynamically load the dynamic page view   
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
