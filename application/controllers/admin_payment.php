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


    @require_once dir(__DIR__).APPPATH.'libraries/firstgiving/FirstGivingAPIClient'.EXT; 
    @require_once dir(__DIR__).APPPATH.'libraries/firstgiving/FirstGivingCreditCardDonationResponse'.EXT;
	
	
	/*
|--------------------------------------------------------------------------
| First Giving Api Credential 
|--------------------------------------------------------------------------
| For Sandbox use End Point http://usapisandbox.fgdev.net/
| For Production use End Point https://api.firstgiving.com/  
*/ 

  DEFINE('FIRST_GIVING_APP_KEY','b1d5db6b-1368-49cc-917c-e98758f28b36');
  DEFINE('FIRST_GIVING_SECRET_KEY','277ce2dd-7d4e-4bf2-978d-f91af2624fad');
  DEFINE('FIRST_GIVING_ENDPOINT','http://usapisandbox.fgdev.net/');    
	
/*
|--------------------------------------------------------------------------
| ADMIN GROUP CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday admin group Class
| METHOD : index -> The default method when the page loads
|  
*/
 
class Admin_payment extends CI_Controller{         

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
	 $this->load->model('admin_payment_model'); 
     $this->session_exist();    
  }
   
/*
|
| 
|--------------------------------------------------------------------------
| View All Payment
|--------------------------------------------------------------------------
|
|
*/   
   
   function view_all_payment()  
   {   
     $data['all_payments']  =  $this->admin_payment_model->get_all_payment('all',NULL); 
     $this->load->view('admin/view-all-payment',$data);         
   } 
   
/*
|
| 
|--------------------------------------------------------------------------
| View Detail
|--------------------------------------------------------------------------
|
|
*/
   
   function view_detail()
   {
     $id = $this->uri->segment(3);
	 $data['payment_detail'] = $this->admin_payment_model->get_all_payment('single',$id);  
     $this->load->view('admin/view-payment',$data);
   }

/*
|
| 
|--------------------------------------------------------------------------
| Track Payment
|--------------------------------------------------------------------------
|
|
*/
   
   function track_payment()
   {
     if($this->input->post('submit'))
	 {
	     $search = $this->input->post('search');
	     $data['payment_track'] = $this->admin_payment_model->track_payment($search); 
	     $data['result'] = "Search match found";
	 }
     $this->load->view('admin/track-payment',@$data); 
   } 
  
  /*
|
| 
|--------------------------------------------------------------------------
| Payment Setting 
|--------------------------------------------------------------------------
|
|
*/
  
   function payment_setting()
   {
      if($this->input->post('creditcard_submit')=='submit')
	 {   
	     $first_giving_app_key    = $this->input->post('first_giving_app_key');
		 $first_giving_app_secret = $this->input->post('first_giving_secret_key');
		 $first_giving_end_point  = $this->input->post('first_giving_end_point'); 
		 $data = array(
		      'first_giving_app_key'    => $first_giving_app_key,
		      'first_giving_app_secret' => $first_giving_app_secret,
		      'first_giving_endpoint'   => $first_giving_end_point   
		 );           		 
	        $result1 = $this->admin_payment_model->save_creditcard_setting($data);
         if($result1 == TRUE)  
		 {		 
	       $data['result_credit'] = "change saved";
		 }
	 }
	 if($this->input->post('paypal_submit')=='submit')   
	 {   
	    
	     $paypal_api_username    = $this->input->post('paypal_api_username');
		 $paypal_api_password    = $this->input->post('paypal_api_password');
		 $paypal_api_signature   = $this->input->post('paypal_api_signature');
		 $paypal_api_mode        = $this->input->post('paypal_api_mode'); 
		 $data = array(
		   'paypal_api_username'    => $paypal_api_username,
		   'paypal_api_password'    => $paypal_api_password,
		   'paypal_api_signature'   => $paypal_api_signature,
           'paypal_api_mode'        => $paypal_api_mode		   
		 ); 

	     $result2 = $this->admin_payment_model->save_paypal_setting($data);   
		 if($result2==TRUE)  
		 { 
	       $data['result_paypal'] = "change saved";
		 }
	 } 
	 
	 $data['get_paypal_setting']      = $this->admin_payment_model->get_paypal_setting();
	 $data['get_firstgiving_setting'] = $this->admin_payment_model->get_firstgiving_setting();
     $this->load->view('admin/payment-setting',@$data); 
   }
  
  function charities()   
  { 
    $campaign_id = $this->uri->segment(3);  // ----- Campaign Id ---------//
	
    if($this->uri->segment(4)=='send_to_charity') 
	{
	  if($this->input->post('payment_to_charity'))
	  {   
	     $charity_id_array     = $_POST['charity_id'];
	     $charity_name_array   = $_POST['charity'];    
	     $charity_amount_array = $_POST['amount'];    
		 for($i=0;$i<count($charity_name_array);$i++) 
		 {   
		    $fullname  =  $this->session->userdata('fullname');
		    list($firstname,$lastname) = explode(' ',$fullname); 
			$comment      = "This charity goes to ".$charity_name_array[$i]." ".date('d/m/y');  
		    $payment_data = array(   
		     'card_name'      => $fullname,
			 'card_number'    => $_POST['card_number'],
			 'card_firstname' => $firstname, 
			 'card_lastname'  => $lastname,      
			 'email'          => $this->session->userdata('email'),       
			 'cvv'            => $_POST['card_cvv'], 
			 'card_month'     => $_POST['card_expiry_month'],
			 'card_year'      => $_POST['card_expiry_year'],   
			 'card_type'      => $_POST['card_type'], 
			 'card_address'   => $_POST['card_address'],
			 'city'           => $_POST['card_city'],
			 'zip'            => $_POST['card_zip'],
			 'state'          => $_POST['card_state'], 
			 'country'        => $_POST['country'], 
			 'comment'        => $comment, 
             'amount'         => $charity_amount_array[$i],
             'campaign_id'    => $campaign_id			 
		    ); 
       		$result_object = $this->first_giving_payment_gateway($payment_data,$charity_id_array[$i]);	 
		} /*------------- END FOR LOOP ------------- */ 
		$result_array                      = $this->convert_object_to_array($result_object); 
		$data['payment_processing_result'] = $this->_firstgiving_status($result_array,$campaign_id);           
	  }  /* --------------- END IF ----------------- */ 
	}    /* --------------- END IF ----------------- */  
    $data['charity_names']             = $this->admin_payment_model->get_campaign_charity_name($campaign_id); 
	$data['charity_percent']           = $this->admin_payment_model->get_campaign_charity_percent($campaign_id); 
	$data['charity_amount']            = $this->admin_payment_model->get_campaign_charity_amount($campaign_id); 
	$data['charities_list']            = $this->admin_payment_model->payment_report_campaign($campaign_id);
    $data['campaign_name']             = $this->admin_payment_model->campaign_name_from_id($campaign_id);
	
	/* ----- Has Campaign Expectation / Goal Reached based on days ------- */
	
	$data['has_completed'] = $this->admin_payment_model->_has_completed($campaign_id);  
	
	$this->load->view('admin/payment-charity',$data);            
  }
   
  function first_giving_payment_gateway($data,$charity_id)       
  {    
    $card_name      = $data['card_name']; 
	$card_firstname = $data['card_firstname'];
	$card_lastname  = $data['card_lastname'];
	$card_number    = $data['card_number'];
	$card_cvv       = $data['cvv']; 
	$card_exp_month = $data['card_month'];  
	$card_exp_year  = $data['card_year']; 
	$card_type      = $data['card_type']; 
	$card_address   = $data['card_address']; 
	$city           = $data['city'];
	$zip            = $data['zip'];
	$state          = $data['state']; 
	$country        = $data['country']; 
	$amount_pay     = $data['amount'];
	$description    = ($data['comment']) ? $data['comment']:'';  
    $campaign_id    = $data['campaign_id'];   
    $user_email     = $data['email'];
   
   
   // Setup the connection information.
	
	$apiKey      = FIRST_GIVING_APP_KEY;
	$apiSecret   = FIRST_GIVING_SECRET_KEY;
	$apiEndpoint = FIRST_GIVING_ENDPOINT;
  
  
	// Create an instance of the API client library.
	$firstGivingApiClient = new FirstGivingAPIClient($apiKey,$apiSecret,$apiEndpoint); 
	
	
	// Create a donation.
	$donation = new FirstGivingDonation(); 
	// -------- GET CHARITY LIST TO DONATE ------- //
   
	  $donation->setCharityId($charity_id);      
	  $donation->setDescription($description); 
	  $donation->setAmount($amount_pay);
	  $donation->setCurrencyCode('USD');   
	  
	// Create a credit card payment.
	$creditCardPayment = new FirstGivingCreditCardPayment();
	$creditCardPayment->setCcNumber($card_number); 
	$creditCardPayment->setCcType($card_type); 
	$creditCardPayment->setCcExpDateMonth($card_exp_month);
	$creditCardPayment->setCcExpDateYear($card_exp_year);
	$creditCardPayment->setCcCardValidationNum($card_cvv);
	$creditCardPayment->setBillToFirstName($card_firstname);
	$creditCardPayment->setBillToLastName($card_firstname);
	$creditCardPayment->setBillToAddressLine1($card_address);  
	$creditCardPayment->setBillToCity($city);
	$creditCardPayment->setBillToState($state); 
	$creditCardPayment->setBillToZip($zip); 
	$creditCardPayment->setBillToCountry($country); 
	$creditCardPayment->setBillToEmail($user_email);  
	$creditCardPayment->setBillToPhone('1233211234');        
	
   	try 
	{ 
		/* @var $firstGivingCreditCardDonationResponse FirstGivingCreditCardDonationResponse */
		$firstGivingCreditCardDonationResponse = $firstGivingApiClient->makeCreditCardDonation($donation,$creditCardPayment,$_SERVER['REMOTE_ADDR']);  
        return $firstGivingCreditCardDonationResponse;  		

	// Uncategorized error reported by FirstGiving... 
	} 
	catch (FirstGivingGeneralException $e) 
	{
		// Do some custom error handling....
		$errorTarget             = $e->getErrorTarget();
		$friendlyConsumerError   = $e->getFriendlyConsumerError();
		$verboseExceptionMessage = $e->getVerboseExceptionMessage();
		$rawResponse             = $e->getRawResponse();
		$responseCode            = $e->getResponseCode();   
		
	// Invalid input reported by FirstGiving....	
	} 
	catch (FirstGivingInvalidInputException $e)
	{
		// Here you can do something useful with fields that valid validation.
		$errorTarget             = $e->getErrorTarget();
		$friendlyConsumerError   = $e->getFriendlyConsumerError();
		$verboseExceptionMessage = $e->getVerboseExceptionMessage();
		$rawResponse             = $e->getRawResponse();
		$responseCode            = $e->getResponseCode(); 
		//throw $e; 
		exit("Some problem with your card detail.Please enter a valid credit card");   
	
	// Something totally unexpected happened.	
	
	} 
	catch (Exception $e) 
	{ 
		$problem = $e->getMessage();
	}
    
  }

  function _firstgiving_status($result_array,$campaign_id)
  {
             if(is_array($result_array))   
				{  
				  if($result_array[2]==201)
				  { 
				    $this->admin_payment_model->update_donation_status($campaign_id,$status_flag = 1); // --- Update Donation status (Donated=1) -- //
				    $status = '<label class="label label-success">Your Donation has been send successfully</label>'; 
                  }
				   else if($result_array[2]==400)
				   {
				     $status = '<label class="label label-warning">Some parameter missing.Please enter the correct card detail</label>';
				   }
				   else if($result_array[2]==403) 
				   {
				     $status = '<label class="label label-danger">Access Forbidden</label>';
				   }
				   else if($result_array[2]==404)
				   {
				     $status = '<label class="label label-danger">UnKnown API Call</label>';
				   }
				   else if($result_array[2]==405)
				   {
				     $status = '<label class="label label-danger">Method not allowed</label>';
				   }
				   else if($result_array[2]==500)
				   {
				     $status = '<label class="label label-danger">Some internal error in Forgiving Server</label>'; 
				   } 
			   }
			else
			  {
				    $status = '<label class="label label-danger">Sorry ,some error occurs in processing payment</label>'; 
			  }
	   return $status;  		  
  
  }
  
  /*
|
|
|
|--------------------------------------------------------------------------
| Convert First Giving Response Object to Array 
|--------------------------------------------------------------------------
|
| 
|
*/
  
  function convert_object_to_array($obj)  
  {
    $array = (array) $obj; 
	foreach($array as $r)
    { 
	  $data[] = $r;
	}
	return @$data;  			 
  }
  
/*
|
| 
|--------------------------------------------------------------------------
| View Payment Report
|--------------------------------------------------------------------------
|
|
*/
  
   function payment_report()   
   {  
     if($this->uri->segment(3)=='export_file')
     {
        return true;     
     }		
      $data['payment_report']  = $this->admin_payment_model->payment_report();      
	  $this->load->view('admin/payment-report',$data);          
   }

   
   function convert_to_csv($input_array, $output_file_name, $delimiter)
  {
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);
  }
      
/* 
|
|
|
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