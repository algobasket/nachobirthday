<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'input',
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="test row">
		<div class="three columns">
		
		</div>
		<div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Reset Password</h3>
				</div>
				<div class="panel-body">
					<ul> 
					<li class="field">
						<?php echo form_label($login_label, $login['id']); ?>
						<?php echo form_input($login); ?>
						<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
					</ul>
					<?php echo form_submit('reset', 'Reset Password','class ="pull-right medium btn btn-default"'); ?>

</div>
			</div>
		</div>
		<div class="three columns">
		
		</div>

</div>
<?php echo form_close(); ?>