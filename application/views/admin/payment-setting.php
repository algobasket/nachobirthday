<?php
if(is_array($get_paypal_setting))
{
 
  foreach($get_paypal_setting as $r)
  {
     $paypal_api_username  = $r['paypal_api_username'];
	 $paypal_api_password  = $r['paypal_api_password'];
	 $paypal_api_signature = $r['paypal_api_signature'];
	 $paypal_api_mode      = $r['paypal_api_mode'];
  }
}

if(is_array($get_firstgiving_setting))
{
  foreach($get_firstgiving_setting as $r2)
  {
     $firstgiving_app_key      = $r2['first_giving_app_key'];
	 $firstgiving_app_secret   = $r2['first_giving_app_secret'];
	 $firstgiving_app_endpoint = $r2['first_giving_endpoint'];
     
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
								<h3>Payment Setting</h3>     
							</div>
							<div class="module-body"> 
								<br />
								 
								<div class="form-horizontal row-fluid">   
									<?php echo form_open('admin_payment/payment_setting','class="form-horizontal row-fluid"');?>	  
									    <div class="control-group">
											<label class="control-label"><h5>Paypal Setting</h5> </label>
											<div class="controls"> 
												<label class="radio inline">
				                                  
												</label>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">Paypal Api Username</label>
											<div class="controls"> 
												<label class="radio inline">
				                               <input type="text" name="paypal_api_username" class="span12" placeholder="Your Paypal Api Username" value="<?php echo $paypal_api_username;?>"/>
												</label> 
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">Paypal Api Password</label>
											<div class="controls"> 
												<label class="radio inline">
				                               
												<input type="text" name="paypal_api_password" class="span12" placeholder="Your Paypal Api Password" value="<?php echo $paypal_api_password;?>"/>
												</label> 
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">Paypal Api Signature</label>
											<div class="controls"> 
												<label class="radio inline">
				                               
												<input type="text" name="paypal_api_signature" class="span12" placeholder="Your Paypal Api Signature" value="<?php echo $paypal_api_signature;?>"/> 
												</label> 
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">Paypal Api mode</label>
											<div class="controls"> 
												<label class="radio inline"> 
												   Test       <input type="radio" name="paypal_api_mode" class="span6" value="0" <?php echo (($paypal_api_mode==0) ? "checked" : "");?> /> 
												   Production <input type="radio" name="paypal_api_mode" class="span6" value="1" <?php echo (($paypal_api_mode==1) ? "checked" : "");?> />    
												</label>  
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"></label> 
											<div class="controls"> 
												<label class="radio inline">
													<input type="submit" name="paypal_submit" value="submit" /> <?php echo @$result_paypal;?> 
												</label>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><h5>First Giving Setting</h5></label>
											<div class="controls"> 
												<label class="radio inline">
				                                 
												</label> 
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">First Giving App Key</label>
											<div class="controls"> 
												<label class="radio inline">
				                               
												<input type="text" name="first_giving_app_key" class="span12" placeholder="Your First Giving Api" value="<?php echo $firstgiving_app_key;?>" />
												</label> 
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label">First Giving Secret Key</label>
											<div class="controls"> 
												<label class="radio inline">
				                               
												<input type="text" name="first_giving_secret_key" class="span12" placeholder="Your First Giving Api" value="<?php echo $firstgiving_app_secret;?>" /> 
												</label> 
											</div>
										</div>
									  
									  <div class="control-group">
											<label class="control-label">First Giving End Point</label>
											<div class="controls"> 
												<label class="radio inline">
				                               
												<input type="text" name="first_giving_end_point" class="span12" placeholder="Your First Giving End Point" value="<?php echo $firstgiving_app_endpoint;?>" /> 
												</label> 
											</div>
										</div>
										
									    <div class="control-group">
											<label class="control-label"></label> 
											<div class="controls"> 
												<label class="radio inline">
													<input type="submit" name="creditcard_submit" value="submit" /> <?php echo @$result_credit;?>  
												</label>
											</div>
										</div>
									<?php echo form_close();?>
									</div>

								<br />
								<!-- <hr />-->
								<br />

								

					<br />
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
	<input type="hidden" value="" id="deleteSelect" />
		<div class="container">
			 

			<b class="copyright">&copy; 2014 Example.com </b> All rights reserved.
		</div>
	</div>

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
		function deleteGroup(obj)
		{
		  $('#myModal').modal('show');
          $('#deleteSelect').val(obj);  		  
		}
		function deleteGroupConfirm()  
		{
		  var x = $('#deleteSelect').val();    
		 window.location.href= "<?php echo base_url();?>admin_group/delete_group/"+x;              
		}
	</script>
</body>