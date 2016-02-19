<?php

// Errors
$lang['auth_incorrect_password'] = 'Incorrect password';
$lang['auth_incorrect_login'] = 'Incorrect login';
$lang['auth_incorrect_email_or_username'] = 'Login or email doesn\'t exist';
$lang['auth_email_in_use'] = 'Email is already used by another user. Please choose another email.';
$lang['auth_username_in_use'] = 'Username already exists. Please choose another username.';
$lang['auth_current_email'] = 'This is your current email';
$lang['auth_incorrect_captcha'] = 'Your confirmation code does not match the one in the image.';
$lang['auth_captcha_expired'] = 'Your confirmation code has expired. Please try again.';

// Notifications 
$completed_1_html = '<div class="row"><div class="three columns"></div><div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Signup Completed</h3>
				</div>
				<div class="panel-body">
				<ul>
					<li class="field">					
						 You have successfully registered. Check your email address to activate your account. 											
					</li>
				</ul>
			  </div>
			</div>
</div></div>'; 
$completed_password_change = '<div class="row"><div class="three columns"></div><div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Password Changed</h3>
				</div>
				<div class="panel-body">
				<ul>
					<li class="field"> 					
						 Your password has been successfully changed											
					</li>
				</ul>
			  </div>
			</div>
</div></div>';
 
$lang['auth_message_logged_out']               = pop_template('You have been successfully logged out.'); 
$lang['auth_message_registration_disabled']    = 'Registration is disabled.';
$lang['auth_message_registration_completed_1'] = $completed_1_html;
$lang['auth_message_registration_completed_2'] = pop_template('You have successfully registered.');
$lang['auth_message_activation_email_sent']   = pop_template('A new activation email has been sent to %s. Follow the instructions in the email to activate your account.'); 
$lang['auth_message_activation_completed']   = pop_template('Your account has been successfully activated.'); 
$lang['auth_message_activation_failed']      = pop_template('The activation code you entered is incorrect or expired.'); 
$lang['auth_message_password_changed']       = $completed_password_change;    
$lang['auth_message_new_password_sent']      = pop_template('An email with instructions for creating a new password has been sent to you.');
$lang['auth_message_new_password_activated'] = pop_template('You have successfully reset your password');
$lang['auth_message_new_password_failed']    = pop_template('Your activation key is incorrect or expired. Please check your email again and follow the instructions.'); 
$lang['auth_message_new_email_sent']         = pop_template('A confirmation email has been sent to %s. Follow the instructions in the email to complete this change of email address.');
$lang['auth_message_new_email_activated']    = pop_template('You have successfully changed your email');
$lang['auth_message_new_email_failed']       = pop_template('Your activation key is incorrect or expired. Please check your email again and follow the instructions.'); 
$lang['auth_message_banned']                 = 'You are banned.';
$lang['auth_message_unregistered']           = 'Your account has been deleted...';

// Email subjects
$lang['auth_subject_welcome'] = 'Welcome to %s!';
$lang['auth_subject_activate'] = 'Welcome to %s!';
$lang['auth_subject_forgot_password'] = 'Forgot your password on %s?';
$lang['auth_subject_reset_password'] = 'Your new password on %s';
$lang['auth_subject_change_email'] = 'Your new email address on %s';

function pop_template($message)
{
   $html = '<div class="row"><div class="three columns"></div><div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Password Changed</h3>
				</div>
				<div class="panel-body">
				<ul>
					<li class="field">'.$message.'</li> 
				</ul>
			  </div>
			</div>
</div></div>';
  return $html;
}

/* End of file tank_auth_lang.php */
/* Location: ./application/language/english/tank_auth_lang.php */