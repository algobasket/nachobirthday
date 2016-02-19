<?php  
if(is_array($admin_info)){ 
   foreach($admin_info as $r)  
   {
     $fullname        = $r['fullname'];
	 $email           = $r['email'];
     $avatar          = $r['avatar'];  	 
   } 
}
;?> 
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
							<div class="module-head"><h3>Edit Profile</h3></div>    
							<div class="module-body"> 
                              <?php echo form_open_multipart('admin/my_profile/edit/update');?>  							       
								   <div class="form-horizontal row-fluid">   
										<div class="control-group">
											<label class="control-label">Avatar</label> 
											<div class="controls"> 
												<label class="radio inline"> 
												<?php if($avatar==NULL){ ?> 
												  <img src="<?php echo base_url();?>assets/images/user.png" class="img-circle"/>  
												<?php }else{ ?>
												  <img src="<?php echo base_url();?>uploads/admin-profile/<?php echo $avatar;?>" width="150" class="img-circle"/>
												<?php } ?>
												
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Upload Avatar</label>
											<div class="controls"> 
												<label class="radio inline"> 
													 <input type="file" name="avatar"/> 
												</label>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Full Name</label>
											<div class="controls"> 
												<label class="radio inline">
												  <input type="text" name="fullname" value="<?php echo $fullname;?>" required=""/>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Email </label>
											<div class="controls"> 
												<label class="radio inline">
													<input type="text" name="email" value="<?php echo $email;?>" required=""/>
												</label>
											</div>
										</div>                                       
										<div class="control-group">
											<label class="control-label"></label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo form_submit('submit','Save Changes');?> 
												</label>
											</div>
										</div>
					
									</div> 
									<?php echo form_close();?> 
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
					
										
				
							
			</div>
		</div>		
	</div>			
    <input type="hidden" value="" id="deleteSelect" />
	<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.js"></script> 
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
		
	</script>				
				
</body>
</html>
