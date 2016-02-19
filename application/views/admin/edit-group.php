<?php 
 if(is_array($get_group_by_id))
 {
   foreach($get_group_by_id as $r)
   {
     $group_id         = $r['id'];  
     $group_name       = $r['group_name'];
     $visibility       = $r['visibility']; 
     @$selectedCampaign = @json_decode($r['campaigns'],TRUE);      
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
	<!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="span3">
					  <?php $this->load->view('admin/sidebar');?> 
                        <!--/.sidebar-->
				</div><!--/.span3-->


				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Edit Group</h3> 
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

									<?php echo form_open('admin_group/edit_group/'.$this->uri->segment(3),'class="form-horizontal row-fluid"');?>    
									   
										<span id="ajaxResult">        
										<div class="control-group">
											<label class="control-label" for="basicinput">Edit Group Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Assign a name to your group here..." value="<?php echo $group_name;?>" class="span8" name="editGroupName" required=""> 
												<span class="help-inline">Minimum 5 Characters</span>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Show Group On Homepage </label>
											<div class="controls">
												<label class="radio inline">
													<input type="radio" name="optionsRadios[]" id="optionsRadios1" value="1" <?php if($visibility==1){ echo 'checked="checked"';};?> > 
													Yes 
												</label> 
												<label class="radio inline"> 
													<input type="radio" name="optionsRadios[]" id="optionsRadios2" value="0" <?php if($visibility==0){ echo 'checked="checked"';};?> >  
													No
												</label>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">Add Campaign To Group</label>
											<div class="controls">
												<select multiple="multiple" name="campaignSelect[]" class="span8">   
												  <?php foreach($all_campaign as $c):?>  
												  <?php $campaign = (in_array($c['id'],$selectedCampaign)) ? "selected='selected'":'';?> 
												  <option value="<?php echo $c['id'];?>" <?php echo $campaign;?>  ><?php echo $c['title'];?></option>     
												  <?php endforeach;?>
												</select>  
											</div>
										</div>
                                        </span>
										<div class="control-group">
											<div class="controls">  
											   <?php echo form_submit('update','update','class="btn"');?> <?php echo @$result;?>     
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
			 

			<b class="copyright">&copy;2014 Example.com </b> All rights reserved.
		</div>
	</div>

	<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.js" type="text/javascript"></script> 
	
</body>
