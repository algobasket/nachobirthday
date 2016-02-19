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
 @require_once dir(__DIR__).APPPATH.'libraries/firstgiving/FirstGivingPaypalExpressCheckoutRequest'.EXT;    
/*
|--------------------------------------------------------------------------
| First Giving Api Credential 
|--------------------------------------------------------------------------
| For Sandbox use End Point http://usapisandbox.fgdev.net/
| For Production use End Point https://api.firstgiving.com/  
*/ 

  //DEFINE('FIRST_GIVING_APP_KEY','b1d5db6b-1368-49cc-917c-e98758f28b36');
  //DEFINE('FIRST_GIVING_SECRET_KEY','277ce2dd-7d4e-4bf2-978d-f91af2624fad');
  //DEFINE('FIRST_GIVING_ENDPOINT','http://usapisandbox.fgdev.net/');   
  
  
/*
|--------------------------------------------------------------------------
| CAMPAIGN CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Campaign Class
| METHOD : index -> The default method when the page loads
|  
*/

final class Campaign extends CI_Controller{     
   
     
   private $api_username = 'pradent_api1.pradent.com';                                 /* ----- Paypal Username -------- */
   
   private $api_password = '1400496288';                                                /* ----- Paypal Password -------- */
   
   private $signature   = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AnGg-lpat0-XKrvPXXmxXSv9kqmr';   /* ----- Paypal Signature -------- */
   
   private $test_mode   = true;                                                         /* ----- Paypal Test Mode -------- */ 
   
    
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
   
   function index()  
   {  
     $this->_template($data=NULL,$templatename='campaign');       
   } 
    
	
   /*
|--------------------------------------------------------------------------
| Donate Method
|--------------------------------------------------------------------------
|
| 
| METHOD : donate -> This method use can create a donation and to make payment   
|
|
*/
     
   function donate()   
   {   
    
      $uri = $this->uri->segment(3);   
     
	 if($uri==NULL)  
	     exit("Access Denied");   
	 
	 if($this->campaign_model->availability($uri,'pause')==FALSE || $this->campaign_model->availability($uri,'suspend')==FALSE)  
	     exit("This campaign is currently not available.Contact the site owner."); 
	 
	 if ($this->uri->segment(4)=='submit' && $this->input->server('REQUEST_METHOD') === 'POST')   
        {    
		    $campaign_id     = $uri; 
            $amount          = $this->input->post('amount'); 
            $payer_name      = $this->input->post('fullname');
			$comment         = $this->input->post('comment');
			$paymentType     = 'paypal';   
			$cardName        = $this->input->post('cardName');
			$cardNumber      = $this->input->post('cardNumber');
			$cvv             = $this->input->post('cvv');
			$cardMonth       = $this->input->post('month');
			$cardType        = $this->input->post('cardType');
            $cardAddress     = $this->input->post('cardAddress');
            $city            = $this->input->post('city');
            $state           = $this->input->post('state');
            $zip             = $this->input->post('zip');
            $country         = $this->input->post('country'); 			
			$cardYear        = $this->input->post('year');
            $processingFees  = $this->input->post('processingFees');      			
			
			//-------------Get Campaign Detail-------------------
			
			$campaign_detail = $this->campaign_model->get_all_campaigns($campaign_id);
			
			foreach($campaign_detail as $r)
			{
			
			  $title   = $r['title'];
			  $content = $r['content']; 
			  
			}
			
			/*-------------- Paypal Merchant Setting --------------- */
			 
			$this->load->library('merchant'); 
             
			 $data = array(
			    'payer_name'    => $payer_name,   
				'payer_user_id' => ($this->tank_auth->get_user_id()) ? $this->tank_auth->get_user_id() : Null, 
			    'campaign_id'   => $campaign_id, 
				'amount'        => $amount+$processingFees, 
				//'amount'        => $each_charity_amount, 
			    'comment'       => $comment,
                'payment_type'  => $paymentType, 
                'card_detail'      => array( 
				                             'card_name'    => $cardName, 
				                             'card_number'  => $cardNumber,
				                             'cvv'          => $cvv,
					                         'card_month'   => $cardMonth,
					                         'card_year'    => $cardYear,
											 'card_type'    => $cardType,
											 'card_address' => $cardAddress, 
											 'city'         => $city,
											 'state'        => $state,
											 'zip'          => $zip,
											 'country'      => $country 
				  )			
			   ); 
			 
			/*--------------- Paypal Merchant Setting -------------- */
			
			
			
			if($paymentType=='creditcard')    
			{ 
			   /* ----- This feature is removed ------ */
			}  
			
			
			if($paymentType=='paypal')    
			{ 	
     		   $data = array(
			      'payer_name'       => $payer_name,   
			      'payer_user_id'    => ($this->tank_auth->get_user_id()) ? $this->tank_auth->get_user_id() : NULL,    
			      'campaign_id'      => $campaign_id,   
				  'amount'           => $amount+$processingFees,
			      'comment'          => $comment,
                  'payment_type'     => $paymentType,
                  'processingFees'   => $processingFees  			
			   );
			   $this->session->set_userdata($data); 
			   
			 //--------- Payment Library ------------ 
			 
			  $return_url=  base_url().'campaign/payment_interface/';   
              $cancel_url=  base_url().'campaign/cancel_payment';      
              
			  $params = array( 
              'item_name'   => $title,  
              'item_number' => $campaign_id, 			  
              'amount'      => $amount+$processingFees,    
              'currency'    => 'USD',  
              'return_url'  => $return_url,   
              'cancel_url'  => $cancel_url,    
              'items' => array(
                             array(  
                             'name' => ucfirst($title), 
                             'desc' => strip_tags($content),   
                             'amt'  => $amount+$processingFees,  
                             'qty'  => 1    
                      ) 	
                  )	 				  
			  ); 
                $this->session->set_userdata($params);
                $response = $this->merchant->purchase($params);       				  
			  
			  if($response->success()) 
               { 
                   // ----- mark order as complete ------- // 
                   $gateway_reference = $response->reference();    
               } 
              else
               {
                  $message = $response->message();  
                  echo('Error processing payment: ' . $message);
                  exit; 
               }
			   
		     //----------Payment Library ------------  
		 
			}  
		}
		
        $data['donate_id'] = $uri; 
        $data['fullname'] = $this->campaign_model->get_session_user_fullname();    		
	    $this->_template($data,$templatename='donate');     
   }
   
/*
|
|--------------------------------------------------------------------------
| Paypal Interface
|-------------------------------------------------------------------------
|
*/  
 
 
  function payment_interface()   
  {  
       $params = array( 
              'item_name'   => $this->session->userdata('item_name'),   
              'item_number' => $this->session->userdata('item_number'), 			  
              'amount'      => $this->session->userdata('amount'),    
              'currency'    => 'USD'	 				  
			  ); 	   
	      
		 $response = $this->merchant->purchase_return($params);		 
		
		 // --------------- Converting Object response to Array ---------------
		 
		 $data = $this->convert_object_to_array($response); 

         $transaction_id = mysql_real_escape_string($data[2]);     // ----- Transaction Id after response is successful ----- 
         		
     if ($response->status() == Merchant_response::FAILED)
     {
       redirect('campaign/payment_failed/');   
     }  
	 
    if ($response->status() == Merchant_response::COMPLETE)
    {
		   $result = $this->campaign_model->payment_paypal($transaction_id,1);  
	       
		   $campaign_id = $this->session->userdata('campaign_id'); 
		   
		   if($result==TRUE)      
	       {   
		        $remove_item = array(
	            'name'             => '', 
			    'payment_user_id'  => '', 
			    'campaign_id'      => '', 
				'amount'           => '',
			    'comment'          => '',
                'payment_type'     => '',
                'payment_data'     => '',
                'processingFees'   => ''  				
	           ); 
			   
	           $this->session->unset_userdata($remove_item);
			   
	           redirect('campaign/thankyou/'.$transaction_id.'/'.$campaign_id);         
           }
 		   
    }
		  	 
  }
  
  function payment_failed() 
  {
     $this->_template($data=NULL,$templatename='payment_error');   
  }
  
/*
|
|
|
|--------------------------------------------------------------------------
| Credit Card Interface ( This feature is removed.From the client site .Only Admin Operates Now)
|-------------------------------------------------------------------------
|
|
*/ 
  
 /*--
 function payment_creditcard()
  {  
	 $result = $this->campaign_model->payment_creditcard();     
	
	if($result)   
	 { 
       $transaction_id = $this->session->userdata('transactionId'); 	 
	   $remove_item = array(
	            'payer_name'       => '',
			    'payment_user_id'  => '', 
			    'campaign_id'      => '', 
				'amount'           => '',
			    'comment'          => '',
                'payment_type'     => '',
              	'card_detail'      => '',
                'transactionId'	   => '', 
                'raw_response'	   => '',
                'response_code'	   => ''  			
	   );  
	   $this->session->unset_userdata($remove_item);  
	   redirect('campaign/thankyou/'.$transaction_id);   
	 }
	 else 
	 { 
	   exit("some error in payment"); 
	 }
  }
 --*/
 
/*
|
|
|
|--------------------------------------------------------------------------
| First Giving Payment Api  ( This feature is removed.From the client site .Only Admin Operates Now)
|--------------------------------------------------------------------------
|
| 
|

 
 
  function first_giving_payment_gateway($data,$charity_id)  
  {  
  
    $user_email     = $this->_get_current_user_email();
    $card_name      = $data['card_detail']['card_name']; 
	list($card_firstname,$card_lastname) = explode(' ',$card_name); 
	$card_number    = $data['card_detail']['card_number'];
	$card_cvv       = $data['card_detail']['cvv'];
	$card_exp_month = $data['card_detail']['card_month'];  
	$card_exp_year  = $data['card_detail']['card_year']; 
	$card_type      = $data['card_detail']['card_type']; 
	$card_address   = $data['card_detail']['card_address'];
	$city           = $data['card_detail']['city'];
	$zip            = $data['card_detail']['zip'];
	$state          = $data['card_detail']['state']; 
	$country        = $data['card_detail']['country']; 
	$amount_pay     = $data['amount'];
	$description    = ($data['comment']) ? $data['comment']:' ';  
    $campaign_id    = $data['campaign_id']; 
   
   
   
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
		// --- @var $firstGivingCreditCardDonationResponse FirstGivingCreditCardDonationResponse 
		$firstGivingCreditCardDonationResponse = $firstGivingApiClient->makeCreditCardDonation($donation, $creditCardPayment, $_SERVER['REMOTE_ADDR']);
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
 
  ---*/
 
  /* -------- Funds Approved ---------- */
 
  //**Logic for financial component**//

   //Variables
   //$user_percentage (The percentage the user selects for himself)
   //$total_deposit (The total amount donated)
   //$user_credit (The amount we add to the database to represent how much nacho birthday owes the user)
   //$non_profit_credit (The amount we tell the api to send to a non_profit)
   //$non_profit_percentage

   //Constants
   //5% - Nacho birthday the company takes 5% of all funds from the bottom line.  A coefficient of 0.95 will be used to reduce this

   //Calculations
   //$user_credit = $total_deposit * 0.95 * ($user_percentage / 100)
   //$non_profit_credit = $total_deposit * 0.95 * ($non_profit_percentage / 100)

    //Logic
    //When a deposit is made.  All money is put into paypal.  The user gets sent to paypal makes the payment, and then is redirected back to the site.  Upon confirmation that funds were sent, we run through this psudo logic
  
  
/*
|
|
|
|--------------------------------------------------------------------------
| First Giving Payment Api  ( This feature is removed.From the client site .Only Admin Operates Now)
|--------------------------------------------------------------------------
|
| 
|
*/  
   
 function get_nonprofits($campaign_id)
 {  
   $this->load->model('admin_payment_model');  
   return $this->admin_payment_model->get_nonprofits($campaign_id); 
 }
 
 
 
  function get_user_percentage($campaign_id)
  {
     $this->load->model('admin_payment_model');
     return $this->admin_payment_model->keep_percentage($campaign_id);  
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
|--------------------------------------------------------------------------
| ThankYou if the payment via Paypal/CreditCard Success
|--------------------------------------------------------------------------
|
| 
| METHOD : thankyou -> This method display after the successful payment/donation   
|
|
*/
  
  
   function thankyou()   
   {    
      $data['campaign'] = $this->campaign_model->get_active_campaign_group();   
      $this->_template($data,$templatename='thank-you');     
   }   
   
   
/*
|--------------------------------------------------------------------------
| ID Method
|--------------------------------------------------------------------------
|
| 
| METHOD : id -> This method grab the current campaign unique id   
|
|
*/
    
  function id()   
  {      
      $cid = $this->uri->segment(3); 
      echo $this->create_site_hit($cid);    
	  
	 if($cid==NULL)  
	   exit("Access Denied"); 
	 
	 if($this->campaign_model->availability($cid,'suspend')==FALSE)    
	   exit("Sorry this campaign is suspended by the site admin");  
	  
     //if($this->campaign_model->check_campaign_lift_span($uri)==1)
	    //exit("Sorry this is expired"); 
	   
	   $data['sub_description']      = $this->get_owner_sub_description();  
       $data['valid_campaign_owner'] = $this->valid_campaign_owner($cid);  
	   $data['get_goal_visibility']  = $this->campaign_model->get_goal_visibility();	   
	   $data['campaign_owner']       = $this->campaign_model->get_campaign_user_detail($cid);   
	   $data['campaign']             = $this->campaign_model->get_campaign_detail($cid);
       $data['raised_amount']        = $this->campaign_model->campaign_raised_amount($cid);
       $data['campaign_donations']   = $this->campaign_model->campaign_donations($cid);     	   
       $this->_template($data,$templatename='campaign');
	   
   }       
     
/*
|
|
|
|--------------------------------------------------------------------------
| Create site hit as the user see the campaign page 
|--------------------------------------------------------------------------
|
| 
|
*/   
   
  function create_site_hit($cid)   
  { 
	$user_id = $this->tank_auth->get_user_id();
    if($cid && $user_id)   
	{ 
      $ip      = $this->input->ip_address(); 
	  $date    = date('d/M/Y'); 
	  $data    = array( 
	     'uid'         => $user_id, 
		 'date'        => $date,
		 'campaign_id' => $cid,   
		 'ip_address'  => '127.0.0.1'       
	  );   
	  $this->campaign_model->create_page_views($data);     	  
     } 
   }   

   
/*
|
|
|
|--------------------------------------------------------------------------
| Search  campaign list with specific keywords
|--------------------------------------------------------------------------
|
| 
|
*/   
   
   
   function campaign_search()
   {
     $search = $this->input->post('search'); 
     $result = $this->campaign_model->campaign_search($search);  
	 
	 $search_found = count($this->campaign_model->campaign_search($search));   
	 if(is_array($result))
	 { 
	  
	   echo '<section>          
		        <div class="row" style="padding: 0 15px;">   
			      <h3>Search Campaign '.$search_found.'</h3> 
			         <div id="owl-demo3" class="owl-carousel" >';
	                   foreach($result as $r) 
	                    {
	                     $title       = $r['title']; 
		                 $content     = $r['content']; 
		                 $array_image = json_decode($r['image'],true); 
        
		                 foreach($array_image as $i)
                         {
                            $image = base_url().'uploads/'.$i;  
                         }     	 
       echo '<a href="'.base_url().'campaign/id/'.$r['id'].'" class="item"> 
			         <img class="lazyOwl" data-src="'.$image.'" alt="Lazy Owl Image" />   
			         <h5>'.$title.'</h5> 
			           <p>'.substr($content,0,50).'<br/></p>
			            <div id="bar-2" class="bar-main-container emerald"> 
				           <div class="wrap">
					          <div class="bar-percentage" data-percentage="'.$r['raised_percent'].'">'.$r['raised_percent'].'</div> 
					          <div class="bar-container">
						         <div class="bar" style="width:'.$r['raised_percent'].'%"></div>
					          </div>
				           </div>
			            </div> 
			   <span class="money">$'.$r['raised_amount'].'</span>    
		       </a>'; 			   
	 } 
	    echo '</div>           
		 </div>		          
    </section>';
	
	 }
	 else
	 {
	  
	   echo '<li>';
	   echo '<h4>&nbsp;&nbsp;Search found 0 results</h4>'; 
	   echo '</li>';
	
	}
  }
  
  
  function see_all_campaign()  
  {
     $search = $this->uri->segment(2); 
	 $data['search_campaign'] =  $this->campaign_model->campaign_search($search,$limit=0);
     $this->_template($data,$templatename='search-campaign-list');  
  }

/*
|
|
|
|--------------------------------------------------------------------------
| Check whether the user is the owner if the valid campaign or not 
|--------------------------------------------------------------------------
|
| 
|
*/
 
   function valid_campaign_owner($id)  
   {
      $stored_campaign_userid = $this->campaign_model->get_campaign_user($id);   
	  return ($stored_campaign_userid == $this->tank_auth->get_user_id()) ? true:false; 
   }

/*
|
|
|
|--------------------------------------------------------------------------
| Get the current / Login user email id 
|--------------------------------------------------------------------------
|
| 
|
*/
   
   function _get_current_user_email()
   {  
      $this->load->model('profile_model'); 
      return $this->profile_model->get_current_user_email();       
   }

/*
|
|
|
|--------------------------------------------------------------------------
| Add sub description to the original campaign description by the campaign owner 
|-------------------------------------------------------------------------- 
|
| 
|
*/
   
   function add_sub_description()
   {
      $sub_description = $this->input->post('sub_description',true);
	  $campaign_id     = $this->input->post('campaign_id',true);
	  $data = array(
	    'user_id'         => $this->tank_auth->get_user_id(),
		'campaign_id'     => $campaign_id,
		'sub_description' => $sub_description,
        'date' => date('d,M Y') 		
	  ); 
	  $result = $this->campaign_model->add_sub_description($data);
	  foreach($result as $r)  
      {  
	      echo '<div class="edit">';  
		       echo '<p class="edit-date">'.$r['date'].'</p>';  
		       echo '<p class="edit-content">'.$r['sub_description'].'</p>';  
	      echo '</div>';   
      }	  
   } 
 
/*
|
|
|
|--------------------------------------------------------------------------
| Get campaign owner sub description    
|--------------------------------------------------------------------------
|
| 
|
*/
 
   function get_owner_sub_description()  
   {
     return $this->campaign_model->get_owner_sub_description($this->uri->segment(3));   
   }

   function donation_percent_calculate() 
   {
      $keep_percent     = $this->input->post('keep_percent');
	  $donate_percent   = $this->input->post('donate_percent');
	  $donate_person_id = $this->input->post('donate_person_id');
	  $json_data = json_encode(array('donatePercent'=>$keep_percent,'donatePersonID' => $donate_person_id),TRUE); 
	  echo "<tr><td>".ucfirst($this->_get_donation_outlet_name($donate_person_id))."</td><td>".$donate_percent."</td><td>".$keep_percent."</td><td><input type='hidden' value='".$json_data."' name='donateTo[]'/></td><td>X</td></tr>";  
   }
   
   function _get_donation_outlet_name($id)  
   {
     return $this->campaign_model->get_donation_outlet_name($id);
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