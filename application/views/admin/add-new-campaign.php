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
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body> 
	
  <?php $this->load->view('admin/header');?> 

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="span3">
					<?php $this->load->view('admin/sidebar');?> 
				</div><!--/.span3-->


				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Add New Group</h3>
							</div>
							<div class="module-body">

									<!--<div class="alert">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Warning!</strong> Something fishy here!
									</div>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Oh snap!</strong> Whats wrong with you? 
									</div>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Well done!</strong> Now you are listening me :) 
									</div>-->

									<br />

									<?php echo form_open('admin_group/new_group/create','class="form-horizontal row-fluid"');?>  
										<div class="control-group">
											<label class="control-label" for="basicinput">Group Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Assign a name to your group here..." class="span8" name="new-group-name"> 
												<span class="help-inline">Minimum 5 Characters</span>
											</div>
										</div>

										<!--<div class="control-group">
											<label class="control-label" for="basicinput">Disabled Input</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="You can't type something here..." class="span8" disabled>
											</div>
										</div>-->

										<!--<div class="control-group">
											<label class="control-label" for="basicinput">Tooltip Input</label>
											<div class="controls">
												<input data-title="A tooltip for the input" type="text" placeholder="Hover to view the tooltip…" data-original-title="" class="span8 tip">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Prepended Input</label>
											<div class="controls">
												<div class="input-prepend">
													<span class="add-on">#</span><input class="span8" type="text" placeholder="prepend">       
												</div>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Appended Input</label>
											<div class="controls">
												<div class="input-append">
													<input type="text" placeholder="5.000" class="span8"><span class="add-on">$</span>
												</div>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Dropdown Button</label>
											<div class="controls">
												<div class="dropdown">
													<a class="dropdown-toggle btn" data-toggle="dropdown" href="#">Dropdown Button <i class="icon-caret-down"></i></a>
													<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
														<li><a href="#">First Row</a></li>
														<li><a href="#">Second Row</a></li>
														<li><a href="#">Third Row</a></li>
														<li><a href="#">Fourth Row</a></li>
													</ul>
												</div>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Dropdown</label>
											<div class="controls">
												<select tabindex="1" data-placeholder="Select here.." class="span8">
													<option value="">Select here..</option>
													<option value="Category 1">First Row</option>
													<option value="Category 2">Second Row</option>
													<option value="Category 3">Third Row</option>
													<option value="Category 4">Fourth Row</option>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Radiobuttons</label>
											<div class="controls">
												<label class="radio">
													<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
													Option one
												</label> 
												<label class="radio">
													<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
													Option two
												</label> 
												<label class="radio">
													<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
													Option three
												</label>
											</div>
										</div>-->

										<div class="control-group">
											<label class="control-label">Show Group On Homepage </label>
											<div class="controls">
												<label class="radio inline">
													<input type="radio" name="optionsRadios[]" id="optionsRadios1" value="1" checked="">
													Yes
												</label> 
												<label class="radio inline">
													<input type="radio" name="optionsRadios[]" id="optionsRadios2" value="0">   
													No
												</label>
											</div>
										</div>

										<div class="control-group">
											<div class="controls"> 
											    <?php echo form_submit('createGroup','Create Group');?> <?php echo @$error;?>  
                                                  												
											</div>
										</div>
								<?php echo form_close();?>
							</div>
						</div>

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright">&copy; 2014 Example.com </b> All rights reserved. 
		</div>
	</div>

	<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.js" type="text/javascript"></script> 
</body>