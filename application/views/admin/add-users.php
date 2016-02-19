<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edmin</title> 
    <link type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/css/theme.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
</head>
<body>
    <?php $this->load->view('admin/header');?>  
    <!-- /navbar -->
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <?php $this->load->view('admin/sidebar');?> 
                    <!--/.sidebar-->
                </div>
                <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    Add Users</h3>
                            </div>
                            <br /> 
                             
                             <?php echo form_open('admin/add_user/post','class="form-horizontal row-fluid"');?>    
							   <div class="row-fluid">
                                        <div class="control-group">
											<label class="control-label" for="basicinput">First Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Enter Your Name" class="span6" name="firstname">
												<?php echo form_error('firstname'); ?> 
											</div>
										</div>
                                </div>
								<br />
								<div class="row-fluid">
                                        <div class="control-group">
											<label class="control-label" for="basicinput">Last Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Enter Your Last Name" class="span6" name="lastname">
											    <?php echo form_error('lastname'); ?> 
											</div>
										</div>
                                </div>
								<br />
								<div class="row-fluid">
                                        <div class="control-group">
											<label class="control-label" for="basicinput">User Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Desired Username" class="span6" name="username">
											    <?php echo form_error('username'); ?> 
											</div>
										</div>
                                </div>
								<br />
								<div class="row-fluid">
                                        <div class="control-group">
											<label class="control-label" for="basicinput">Email</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Your Email" class="span6" name="email"> 
											    <?php echo form_error('email'); ?> 
											</div>
										</div>
                                </div>
								<br />
								<div class="row-fluid">
                                        <div class="control-group">
											<label class="control-label" for="basicinput">Password</label>
											<div class="controls">
												<input type="password" id="basicinput" placeholder="Password" class="span6" name="password">
											    <?php echo form_error('password'); ?> 
											</div>
										</div>
                                </div>
								<br />
								<div class="row-fluid">
                                        <div class="control-group"> 
											<label class="control-label" for="basicinput">Confirm Password</label>
											<div class="controls">
												<input type="password" id="basicinput" placeholder="Confirm Password" class="span6" name="confirm_password">
											    <?php echo form_error('confirm_password'); ?> 
											</div>  
										</div>
                                </div>
								<br/>
								
								<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn">Go.!</button> <?php echo @$result;?>    
											</div>
										</div>
								<?php echo form_close();?>
                                <!--/.row-fluid-->
                                <br />
                            </div>
                        </div>
                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <div class="footer">
        <div class="container">
            <b class="copyright">&copy; 2014 Edmin - EGrappler.com </b>All rights reserved. 
        </div>
    </div>
	<script type="text/javascript">
	   $('document').ready(function(){
	       $('#toolTip').tooltip('show'); 
	   }); 
	</script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.js" type="text/javascript"></script>
</body>
