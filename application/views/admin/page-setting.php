<?php 
if(is_array($site_front_page_data)) 
{
foreach($site_front_page_data as $a)
{
  $front_page_video_link    = $a['front_page_video_link'];
  $sub_highlight_text_small =   $a['sub_highlight_text_small']; 
  $campaign_goal_status     = $a['campaign_goal_status'];  
}
}
?>
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
								<h3>Update Page Setting</h3> 
							</div>
							<div class="module-body">

									
									<br /> 
                                      
									<?php echo form_open('admin/page_setting/','class="form-horizontal row-fluid"');?>  
										<div class="control-group">
											<label class="control-label" for="basicinput">Front Page Description</label> 
											<div class="controls">
												<textarea type="text" id="basicinput" placeholder="Enter some description" class="span8" name="description" ><?php echo $sub_highlight_text_small;?></textarea> 
												
											</div>
										</div>

										<div class="control-group"> 
											<label class="control-label">Add Vimeo Video Link</label>
                                            <div class="controls">
												<input type="text" id="basicinput" placeholder="Enter video link" class="span8" name="videoLink" value="<?php echo $front_page_video_link;?>" /> 
											</div>
										</div>
                                          
										<div class="control-group">
											<label class="control-label">Show Donation Goal</label>   
                                            <div class="controls">
												<input type="checkbox" id="basicinput" value="1" name="show-donation-goal" <?php echo ($campaign_goal_status==1) ? 'checked':'';?>> 
											</div>
										</div>  
										  
										<div class="control-group">
											<div class="controls"> 
											    <?php echo form_submit('save_page_setting','Update');?> <?php echo @$error;?>    
                                                  												
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