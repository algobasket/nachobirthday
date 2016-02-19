
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
								<h3>Payment <span class="pull-right"><a href="<?php echo base_url();?>admin_payment/view_all_payment">Advance Search</a></span></h3>     
							</div>
							<div class="module-body">
								<br />
								<table>
								   <tr>
								      <td>ID 
									  <select>
									    <option>=</option>
										<option>></option>
										<option><</option>
									  </select>
									  </td>
									  <td>Campaign Id
									   <select>
									    <option>=</option>
										<option>></option>
										<option><</option>
									  </select>
									  </td>
									  <td>Payment Type</td>
									  <td>Payer Name</td>
									  <td>Amount</td>
									  <td>Transaction Id</td>
								   </tr>
								<table>
								<div class="form-horizontal row-fluid">   
								<?php 
 
                               if(is_array($payment_track))
                                {
                                    foreach($payment_track as $r) 
                                        {
                                         $payment_id    = $r['id'];
	                                     $campaign_name = $r['campaign_name'];
	                                     $user          = $r['user'];
	                                     $date          = $r['date']; 
	                                     $status        = $r['status'];
	                                     $transactionId = $r['transactionId'];
	                                     $amount = $r['amount'];
	                                     $comment = $r['comment']; ?>		  
									    <div class="control-group">
											<label class="control-label">Payment Id</label>
											<div class="controls"> 
												<label class="radio inline">
				                                # <?php echo $payment_id;?> 
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Campaign Name</label>
											<div class="controls"> 
												<label class="radio inline">
				                                <?php echo $campaign_name;?>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">User</label>
											<div class="controls"> 
												<label class="radio inline"><?php echo $user;?>
																									</label>
											</div>
										</div>                                       
										<div class="control-group">
											<label class="control-label">Transaction Id </label>
											<div class="controls"> 
												<label class="radio inline"><?php echo $transactionId;?>
																									</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Amount </label>
											<div class="controls"> 
												<label class="radio inline">$ <?php echo $amount;?> 
												  
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Date</label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo $date;?>
												</label>
											</div>
										</div>
									  	<div class="control-group">
											<label class="control-label">Status</label>
											<div class="controls"> 
												<label class="radio inline">
											    <?php echo ($status==1) ? 'paid':'unpaid';?> 
												</label>
											</div>
										</div>
									    <div class="control-group">
											<label class="control-label">Comment</label> 
											<div class="controls"> 
												<label class="radio inline">
													<?php echo $comment;?> 
												</label>
											</div>
										</div>
									
									
<?php  }
} 
?> 
									
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