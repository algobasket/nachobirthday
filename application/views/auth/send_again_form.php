<?php
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'input'
);
?>

<?php echo form_open($this->uri->uri_string()); ?>
<div class="test row">
		<div class="three columns">
		
		</div>
		<div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Send Confirmation Again</h3>   
				</div>
				<div class="panel-body">
					<ul>
					<li class="field">
						<?php echo form_label('Email Address', $email['id']); ?>
						<?php echo form_input($email); ?>
						<?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
					</ul><?php echo form_submit('send', 'Send','class ="pull-right medium btn btn-default"'); ?>
<?php echo form_close(); ?> 
</div>
			</div>
		</div>
		<div class="three columns">
		
		</div>
</div>