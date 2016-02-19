<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
} 
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
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
				<a href="#">
				<img src="assets/images/fb.png" class="img-responsive center-block">
				</a>
				<p class="big-text text-center">OR</p>
				<ul>
				  <li class="field">
				    <input class="input" type="text" placeholder="First Name" />
				  </li>
				  <li class="field">
				    <input class="input" type="text" placeholder="Last Name" />
				  </li>
				  <li class="field">
				    <input class="input" type="email" placeholder="Email" />
				  </li>
				  <li class="field">
				    <input class="input" type="password" placeholder="Password" />
				  </li>
				  <li class="field">
				    <input class="input" type="password" placeholder="Confirm Password" />
				  </li>
				</ul>
				<a class="pull-right medium btn btn-default" href="#">REGISTER</a>
				</div>
			</div>
		</div>
		<div class="three columns">
		
		</div>

</div>
<div class="row">
	<p class="text-center">Already a member? <a href="login.php">Login</a></p>
</div>
<?php include 'includes/footer.php'?>