<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
	'class' => 'xwide text input',
	'placeholder' => 'Old Password',
	'required' => '""'
);
$new_password = array(
	'name'	=> 'new_password', 
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'xwide text input',
	'placeholder' => 'New Password',
	'required' => '""'
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'class' => 'xwide text input',
	'placeholder' => 'Confirm Password', 
	'required' => '""'
);
?>
<div class="choose-option center-block rounded"> 
<br>
	<h2 class="text-center">Security/Privacy <i class="icon-lock"></i></h2>
	 <br>
	<?php echo form_open($this->uri->uri_string(),'class=""'); ?>  
		<div class="row">
			<div class="centered twelve columns">
				<div class="prepend field">
				 <ul>
				   <li class="prepend field">
					 <span class="adjoined">Old Password</span>  
					  <?php echo form_password($old_password); ?> 
				   </li>
				 </ul>
				</div>
            </div> 
        </div><!--row Ended-->
		<div class="row">
			<div class="centered twelve columns">
				<div class="prepend field">
				 <ul>
				   <li class="prepend field">
					 <span class="adjoined">New Password</span>
					  <?php echo form_password($new_password); ?>
				   </li>
				 </ul>
				</div>
            </div> 
        </div><!--row Ended-->
		<div class="row">
			<div class="centered twelve columns">
				<div class="prepend field">
				 <ul>
				   <li class="prepend field">
					 <span class="adjoined">Confirm Password</span>
					  <?php echo form_password($confirm_new_password); ?>
				   </li>
				 </ul>
				</div>
            </div> 
        </div><!--row Ended-->
		<div class="row">
			<div class="centered twelve columns">
				<div class="prepend field">
				 <ul>
				   <li class="prepend field four columns">
					 <input class="background-btn xxlarge" type="submit" value="Change Password"/>  
				   </li>
				 </ul>
				</div>
            </div> 
        </div><!--row Ended-->
		
</div>
	
	 <?php echo form_close(); ?>