<?php
//--------Including Facebook Library ------------

@require_once dir(__DIR__).APPPATH.'libraries/facebook'.EXT;


/*----- For Development App -----*/

DEFINE('APP_ID','1480739818850444'); 
DEFINE('APP_SECRET','3228c62e549b83bc5030fe1f4994374e');  

/*----------- End ------------*/

class Fb_login extends CI_Controller 
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
     $this->load->model('facebook_model');
   }

   function authenticate()
   {   
        $current_url = "http://".$_SERVER['HTTP_HOST'];
		
	    if($current_url == 'http://nachobirthday.com') 
		{
		  $facebook = new Facebook(array(
            'appId'  => $this->fb_appid(),
            'secret' => $this->fb_secret()
            ));
		}else if($current_url == 'http://nachobirthday.appstudev.com')
		{   
			$facebook = new Facebook(array(
            'appId'  => $this->fb_appid(),
            'secret' => $this->fb_secret()
            ));
		}else if($current_url == 'http://nachobirthday.dev')
		{
			 $facebook = new Facebook(array(
            'appId'  => APP_ID,
            'secret' => APP_SECRET
            ));
		}else if($current_url == 'http://localhost')
		{
		     $facebook = new Facebook(array(
            'appId'  => APP_ID,  
            'secret' => APP_SECRET
            ));
		} 
      
     
	 $user = $facebook->getUser();
      if($user)
	  {
          try{
            // Proceed knowing you have a logged in user who's authenticated.
             $user_profile = $facebook->api('/me');
	   }
	  catch(FacebookApiException $e)
	  {
	     session_destroy();
         error_log($e);
         $user = null;
      }
    if ($user_profile)
	{
        # User info ok? Let's print it (Here we will be adding the login and registering routines)

		   $firstname =  $user_profile['first_name'];
		   $lastname  =  $user_profile['last_name'];
           $username  =  $user_profile['name'];
		    $uid       = $user_profile['id'];
		    $email     = $user_profile['email'];

			$data = array(
			 'firstname'       => $firstname,
			 'lastname'        => $lastname,
			 'oauth_id'        => $uid,
			 'username'        => $username,
			 'email'           => $email,
			 'oauth_provider'  => 'facebook'
			);
			$result = $this->facebook_model->facebook_user_check($email,$firstname,$lastname,$uid,$username);
			$this->session->set_userdata($result);
			 if($result)
			 {  
			    if($this->session->userdata('redirect_campaign'))   
				{  
				  $call_back_link = 'campaign/id/'.$this->session->userdata('redirect_campaign');    
				  redirect($call_back_link);
				}else{
				  redirect('dashboard');    
				}
			    
             
			 }
   }
  else
  {
	    session_destroy();
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
   }
  }
  else
  {
      # There's no active session, let's generate one
	  $login_url = $facebook->getLoginUrl(array('scope' => 'email'));
      header("Location: " . $login_url);
   }
 }

function logout()
{
   if($this->session->userdata('oauth_provider'))
  {
          $facebook = new Facebook(array(
            'appId'  => $this->fb_appid(),
            'secret' => $this->fb_secret()
            ));
     $this->facebook->destroySession();
     session_destroy();
    unset ($_SESSION['fb_' . APP_ID . '_code']);
    unset ($_SESSION['fb_' . APP_ID . '_access_token']);
    unset ($_SESSION['fb_' . APP_ID . '_user_id']);
    redirect('signin');

  }

 }

 function fb_appid()
 {
   foreach($this->facebook_model->get_facebook_detail() as $r)
   {
     $app_id = $r['fb_app_id'];
   }
   return $app_id;
 }

 function fb_secret()
 {
   foreach($this->facebook_model->get_facebook_detail() as $r)
   {
     $app_secret = $r['fb_app_secret'];
   }
   return $app_secret;
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



}

