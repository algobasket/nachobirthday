<?php  
 $email = array(
  'id'    => 'inputEmail',
  'class' => 'span12',
  'name'  => 'email',
  'placeholder' => 'Email Address',
  'required' => 'required' 
 );

 $password = array(
  'id'    => 'inputPassword',
  'class' => 'span12',
  'name'  => 'password',
  'placeholder' => 'Password', 
  'required'   => 'required' 
 );
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edmin</title>
	<link type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url();?>assetsbootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url();?>assets/css/theme.css" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url();?>assets/images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="index"> 
			  		Edmin
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					<ul class="nav pull-right">

						<li><a href="#">
							Sign Up
						</a></li>

						

						<li><a href="#">
							Forgot your password?
						</a></li>
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
				 <?php echo form_open('admin_login/login','class="form-vertical"');?>      
					
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
								    <?php echo form_input($email);?>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
								    <?php echo form_password($password);?>
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary pull-right">Login</button> 
									<label class="checkbox">
										<input type="checkbox"> Remember me
									</label>
									<?php echo @$error;?> 
								</div>
							</div>
						</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright">&copy; 2014 Edmin - EGrappler.com </b> All rights reserved.
		</div>
	</div> 
	<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>