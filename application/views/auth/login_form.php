
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => ($this->session->userdata('email')) ? $this->session->userdata('email'):set_value('login'), 
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'input',
	'placeholder' => 'Email'
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password', 
	'id'	=> 'password',
	'size'	=> 30,
	'class' => 'input',
	'placeholder' => 'Password' 
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'), 
	'style' => 'margin:0;padding:0',
	 'class' => 'checkbox checked'
);  
?>
<div class="row">
		<div class="three columns"></div> 
		<div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading"> 
					<h3>Login</h3>
				</div>
				<div class="panel-body">
				<?php echo form_open($this->uri->uri_string());?> 
				<?php
				if($this->uri->segment(2)=='redirect_campaign')
				{
				  $this->session->set_userdata('redirect_campaign',$this->uri->segment(5));        
				}
				?>
				<a href="<?php echo base_url();?>fb_login/authenticate">  
				
					<img src="<?php echo base_url();?>assets/images/fb.png" class="img-responsive center-block">
				</a>
				<p class="big-text text-center">OR</p>
				<ul>
				  <li class="field">
					<?php echo form_label($login_label,$login['id']); ?>
		            <?php echo form_input($login); ?> 
		            <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
				  </li>
				  <li class="field">
					<?php echo form_label('Password', $password['id']); ?>
                    <?php echo form_password($password); ?>
	                <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
				  </li>
				 
				  <li class="field">
					<label class="checkbox checked" for="check1">
					<?php echo form_checkbox($remember); ?>
				    <span></span> <?php echo form_label('Remember me', $remember['id']); ?>  
					</label>
				 </li>
				</ul> 
				<p>Forgot your password? <?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?> <?php echo form_submit('submit', 'Login','class="pull-right medium btn btn-default" style="cursor:pointer;"'); ?></p>
				<p class="text-center">Not a member? <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('signup', 'Register'); ?></p>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<div class="three columns"> 
		
		</div>

</div>
