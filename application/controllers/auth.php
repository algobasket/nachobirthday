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
  
 @require_once dir(__DIR__).APPPATH.'libraries/phpass-0.1/PasswordHash'.EXT; 
  
if (!defined('BASEPATH')) exit('No direct script access allowed');  

/*
|--------------------------------------------------------------------------
| Auth CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Auth Class
| METHOD : index -> The default method when the page loads
| 
*/


class Auth extends CI_Controller     
{
  

	function __construct()  
	{
		parent::__construct();    
		$this->load->library('form_validation');   
		$this->load->library('security');
        foreach($this->_get_maintainance() as $m)
        {
          if($m['maintainance']==1)
		  {
		    die($m['maintainance_message']);
		  }
        }		
	} 

	
   function index()
	{
		if ($message = $this->session->flashdata('message'))
		{ 
		    $data['message'] = $message;
			$this->_template($data,$templatename='auth/general_message'); // Dynamic Page View  
		}
		else 
		{   
		     $data['get_goal_visibility']  = $this->campaign_model->get_goal_visibility();
       		 $data['site_front_page_data'] = $this->admin_model->site_front_page_data();  
             $data['campaign']             = $this->campaign_model->get_active_campaign_group();      			 
			 $this->_template($data,$templatename='index');        
		}
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	
	
	function login()    
	{    
        $this->tank_auth->get_user_id();
		if ($this->tank_auth->is_logged_in())
		{  									// logged in
			redirect('dashboard');   

		} elseif ($this->tank_auth->is_logged_in(FALSE))
		{						// logged in, not activated
			redirect('send-again');  

		}
		else
		{  
		    
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email','tank_auth'); 
			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts','tank_auth') AND 
					($login = $this->input->post('login'))){ 
				$login = $this->security->xss_clean($login);
			}
			else
			{
				$login = '';
			}
			$data['use_recaptcha'] = $this->config->item('use_recaptcha','tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login))
			{
				if ($data['use_recaptcha']) 
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			} 
			$data['errors'] = array();
            
			if ($this->form_validation->run()) 
			{   
			     
			  // ---------- validation ok -------------
			  
				$array = array(
				  'username'       => $this->input->post('login')
				);
				$this->session->set_userdata($array);     
				if ($this->tank_auth->login( 
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'), 
						$data['login_by_username'],
						$data['login_by_email'])){ 								// success
						
						 /*  ----- Generate Session and Store Firstname ------ */
						 
						 $this->session->set_userdata(array('user_firstname' => $this->user_firstname()));
						
					   if($this->uri->segment(2)=='pre-campaign') 
		                 {
		                     redirect('pre-campaign');  
		                 } 
		                else if($this->uri->segment(2)=='new-campaign')   
		                {
		                      redirect('new-campaign');    
		                }
						else
						{    if($this->uri->segment(2)=='redirect_campaign')  
						     {   
						       redirect('campaign/id/'.$this->uri->segment(5)); 
							 }
							 else
							 {
							   redirect('dashboard');  
							 }
						}
					    
                
				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned']))
					{								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('send-again'); 
					}
					else
					{													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}  
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha'])
				{
					$data['recaptcha_html'] = $this->_create_recaptcha();
				}
				else
				{
					$data['captcha_html'] = $this->_create_captcha();
				}
			}   
		     $this->_template($data,$templatename='auth/login_form'); 
		}
	}
   
   /**
	 * Current user's Firstname
	 *
	 * @return void
	 */
   
   function user_firstname()  
   { 
      $this->load->model('profile_model'); 
      return $this->profile_model->get_user_firstname();
   }   
  
	
	/**
	 * Logout user
	 *
	 * @return void
	 */
		
	function logout()
	{   
        session_destroy();  
		$this->tank_auth->logout();  
		$this->_show_message($this->lang->line('auth_message_logged_out'));  
    } 	  
	

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	
	
	function register()
	{  
		if ($this->tank_auth->is_logged_in()){									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)){ 	 					// logged in, not activated
			redirect('/auth/send_again/');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));

		}else{ 
		    $this->form_validation->set_rules('firstname','First Name','trim|required|xss_clean|max_length[20]|alpha'); 
			$this->form_validation->set_rules('lastname','Last Name','trim|required|xss_clean|max_length[20]|alpha');   
			$use_username = $this->config->item('use_username','tank_auth');       
			$this->form_validation->set_rules('username','Username','trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash'); 
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');  
			$this->form_validation->set_rules('password','Password','trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required|xss_clean|matches[password]');  
			$captcha_registration	= $this->config->item('captcha_registration','tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha','tank_auth');    
			if (!$captcha_registration){
				if ($use_recaptcha)
				{    
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			$data['errors'] = array(); 

			$email_activation = $this->config->item('email_activation', 'tank_auth'); 

			if ($this->form_validation->run())
			{								// validation ok
				 if(!$this->input->post('agree') == 1)     
				 {
				   $this->form_validation->set_message('accept_terms', 'Please read and accept our terms and conditions.');
                 }
				  else{
				 $fb_oauth_id = ($this->session->userdata('oauth_id')) ? $this->session->userdata('oauth_id'):NULL ;
				
				if (!is_null($data = $this->tank_auth->create_user(  
				        $this->form_validation->set_value('firstname'),
                        $this->form_validation->set_value('lastname'),  						
						$this->form_validation->set_value('username'), 
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),   
						$email_activation)))    
						{ 	 								// success
                  
					     $data['site_name'] = $this->config->item('website_name','tank_auth');  

					if ($email_activation)
					{									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

						$this->_send_email('activate', $data['email'], $data);
                              
						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					
					}
					else
					{ 
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email
                      
							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			  }
			} // END RUN
			if ($captcha_registration){
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			} 
			$data['use_username']         = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha']        = $use_recaptcha;
		    $this->_template($data,$templatename='auth/register_form');  
		}	   
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	
	
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email'); 

			$data['errors'] = array();

			if ($this->form_validation->run()){ 								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))){			// success
 
					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);  

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$data['template'] ="auth/send_again_form";    
			//$this->load->view('includes/template',$data);  
			$this->_template($data,$templatename='auth/send_again_form');  
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	
	
	function activate() 
	{
		$user_id		= $this->uri->segment(2);
		$new_email_key	= $this->uri->segment(3);       
		
		      // ------------ Activate user ---------------
		
		if ($this->tank_auth->activate_user($user_id,$new_email_key))
		{    
		     // ---------------- After successful -------------
             
			 if($this->tank_auth->create_autologin($user_id)==TRUE)   
			  {
			      redirect('dashboard');    
			  }
			 //$this->tank_auth->logout(); 
			//$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));
		}
		else
		{																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}
	
   
	/**
	 * Generate reset code (to change password) and send it to user 
	 *
	 * @return void
	 */
	
	
	function forgot_password()
	{
		if ($this->tank_auth->is_logged_in())
		{ 									// logged in
			redirect('');

		} 
		else if($this->tank_auth->is_logged_in(FALSE))
		{      						// logged in, not activated
		   redirect('/auth/send_again/');
		} 
		else 
		{
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean'); 
			$data['errors'] = array();
			
			if ($this->form_validation->run())
			{	    
			       // ------------ Validation ok ----------------
				    if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))){

					    $data['site_name'] = $this->config->item('website_name','tank_auth');

					// ----------- Send email with password activation link ----------- 
					
					$this->_send_email('forgot_password', $data['email'], $data);
					$this->_show_message($this->lang->line('auth_message_new_password_sent')); 
					
				} 
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			} 
			$this->_template($data,$templatename='auth/forgot_password_form'); 
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	
	
	function reset_password() 
	{    
		$user_id		= $this->uri->segment(2);
		$new_pass_key	= $this->uri->segment(3);  
        $data = array();		
        if($this->input->post('change')) 
		{
		
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
         
		$data['errors'] = array();
        $this->ci =& get_instance();          
		 
		if ($this->form_validation->run()){  								/* ------- validation ok -------- */ 
		
			$hasher = new PasswordHash($this->ci->config->item('phpass_hash_strength','tank_auth'),$this->ci->config->item('phpass_hash_portable', 'tank_auth')); 
			
		    $hashed_password = $hasher->HashPassword($this->input->post('new_password'));
			
		    $this->load->model('profile_model');        
			
		    $result = $this->profile_model->_reset_password_user($user_id,$new_pass_key,$hashed_password);   
			
		    if($result == true) 
			{  
			   $this->_show_message($this->lang->line('auth_message_new_password_activated'));      	 	   
			}else{
			   $this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
           			
		}else{ 
		     echo validation_errors();             
		  }   
		} 
        $this->_template($data,$templatename='auth/reset_password_form');  		
	}
	
	/**
	 * Change user password
	 *
	 * @return void 
	 */
	
	function change_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('old_password','Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->_template($data,$templatename='auth/change_password_form'); 
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	
	
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in())
		{								// not logged in or not activated
			redirect('/auth/login/'); 

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {		// ------- Validation ok ---------
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {	// ----------- Success -------

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				}
				else 
				{ 
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				} 
			};
			$this->_template($data,$templatename='auth/change_email_form'); 
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	
	
	function reset_email()
	{
		$user_id		= $this->uri->segment(2);
		$new_email_key	= $this->uri->segment(3); 

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed')); 
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('login'); 
		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run())
			{								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}  
			$this->_template($data,$templatename='auth/unregister_form');
		}
	}

	
	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */

	 function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('index'); 
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE)); 
		$this->email->send();
	}

	
	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	 
	 
	function _create_captcha() 
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// ---------- Save captcha params in session --------------
		
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}


	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	 
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}
	

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	
	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	 
	 
	function _check_recaptcha() 
	{ 
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);  

		if (!$resp->is_valid) 
		{ 
			$this->form_validation->set_message('_check_recaptcha',$this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;   
	}
	
	/**
	 * Site Campaign function. Display all the recent and popular campaign.
	 *
	 * @return	bool
	 */
	
   function siteCampaign()   
   {   
	  $data = $this->campaign_model->carousel_campaign_display();   
	  return $data; 
   }
   
   
 
/* ---- Testing Function ------- */
 
   function test()
   {
      $data = $this->campaign_model->check_campaign_lift_span(238);   
	  print_r($data); 
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

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */ 