<?php
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => ($this->session->userdata('username')) ? $this->session->userdata('username') : set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'placeholder'=>'User Name', 
	    'class' => 'input'
	);

$firstname = array(
    'name'	=> 'firstname',
	'id'	=> 'firstname',  
	'maxlength'	=> $this->config->item('firstname_max_length', 'tank_auth'),    
	'size'	=> 30,
	'placeholder'=>'First Name',  
	'class' => 'input',
	'value' => ($this->session->userdata('firstname')) ? $this->session->userdata('firstname'):set_value('firstname')
  );
  $lastname = array( 
    'name'	=> 'lastname', 
	'id'	=> 'lastname',
	'maxlength'	=> $this->config->item('lastname_max_length', 'tank_auth'),
	'size'	=> 30,
	'placeholder'=>'Last Name', 
	'class' => 'input',
    'value' => ($this->session->userdata('lastname')) ? $this->session->userdata('lastname'):set_value('lastname')	
  );
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> ($this->session->userdata('email')) ? $this->session->userdata('email'):set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'placeholder'=>'Email', 
	'class' => 'input'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'), 
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'placeholder'=>'Password', 
	'class' => 'input'
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'placeholder'=>'Confirm Password', 
	'class' => 'input'
);
$captcha = array(
	'name'	=> 'captcha', 
	'id'	=> 'captcha',
	'maxlength'	=> 8,   
);
?>
<div class="row">
		<div class="three columns">
		
		</div>
		<div class="six columns">
			<div class="panel register-box">
				<div class="panel-heading">
					<h3>Register</h3>
				</div>
				<div class="panel-body">
				<a href="<?php echo base_url();?>fb_login/authenticate"> 
				<img src="<?php echo base_url();?>assets/images/fb.png" class="img-responsive center-block">
				</a>
				<p class="big-text text-center">OR</p>
                <?php echo form_open($this->uri->uri_string()); ?>   
                 <ul>
		<li class="field">  
		<?php echo form_label('First Name', $firstname['id']); ?>  
		<?php echo form_input($firstname); ?>
		<?php echo form_error($firstname['name']); ?><?php echo isset($errors[$firstname['name']]) ? $errors[$firstname['name']]:''; ?>
	    </li>
		<li class="field"> 
		<?php echo form_label('Last Name', $lastname['id']); ?>  
		<?php echo form_input($lastname); ?>  
		<?php echo form_error($lastname['name']); ?><?php echo isset($errors[$lastname['name']]) ? $errors[$lastname['name']]:''; ?>
	    </li>
		<li class="field">  
		<?php echo form_label('Username', $username['id']); ?> 
		<?php echo form_input($username); ?>
		<?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']]:''; ?>
	    </li>
		<li class="field">
		<?php echo form_label('Email Address', $email['id']); ?>
		<?php echo form_input($email); ?>
		<?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']]:''; ?>
        </li>
		<li class="field">
	   <?php echo form_label('Password', $password['id']); ?>
	  <?php echo form_password($password); ?>
      <?php echo form_error($password['name']); ?>
	   <li>
	   <li class="field">
		<?php echo form_label('Confirm Password', $confirm_password['id']); ?>
		<?php echo form_password($confirm_password); ?>
		<?php echo form_error($confirm_password['name']); ?> 
	   </li>
	   <li class="field"> 
	        
			<!--<label class="checkbox checked" for="check1">-->    
			 <input type="checkbox" name="agree" value="1" id="agree" style="margin:0;padding:0" class="checkbox checked"> 
			 <span><i class="icon-check"></i></span> I agree to the <a href="<?php echo base_url();?>term-and-condition">terms and conditions </a>
			<!--</label>-->
			
	 </li>
	<li class="field"> 
<?php echo form_submit('register', 'Register','class="pull-right medium btn btn-default" style="cursor:pointer"'); ?>   
   </li> 
 </ul>
<?php echo form_close(); ?>
   </div>
	</div>
		</div>
		<div class="three columns">
		
		</div>

</div>
<div class="row">
	<p class="text-center">Already a member? <a href="<?php echo base_url();?>login">Login</a></p>
</div>