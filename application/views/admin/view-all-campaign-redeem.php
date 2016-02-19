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
								<h3>Campaign Redeem</h3>   
							</div>
							<div class="module-body">
								<br />
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>#</th>
									  <th>ID</th>
									  <th>Campaign</th>
									  <th>User</th>
									  <th>Redeem Amount</th>
									  <th></th>    
									</tr>
								  </thead>
								  <tbody>
								  <?php
								  if(is_array($campaign_redeem_list)){
								  $counter = 1;
                                  foreach($campaign_redeem_list as $r){ ?> 							  
								   <tr>
									  <th><?php echo $counter;?></th>
									  <th><?php echo $r['cid'];?></th>
									  <th><?php echo $r['ctitle'];?></th>
									  <th><?php echo $r['username'];?>(<?php echo $r['uid'];?>)</th>
									  <th><?php echo $r['redeem_amount'];?>$</th>
									  <th>
									  <?php if($r['redeem_admin_approval_status']==0){ ?>						  
									  <a href="<?php echo base_url();?>admin_campaign/campaign_redeem/redeem_for_user/<?php echo $r['cid'];?>/<?php echo $r['redeem_amount'];?>" class="btn btn-success">Approve Now</a></th>    
									  <?php }else{ ?>
                                      Approved
                                      <?php } ?>									  
									</tr>
								  <?php $counter++;} }else{ ?>
								   <tr><th colspan="6">No Redeem Request</th></tr>   
								  <?php } ?>
								  </tbody>
								</table>
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
		function deleteCampaign(obj) 
		{
		  $('#myModal').modal('show');
          $('#deleteSelect').val(obj);  		  
		}
		function deleteGroupConfirm()   
		{
		  var x = $('#deleteSelect').val();    
		 window.location.href= "<?php echo base_url();?>admin_campaign/delete_campaign/"+x;               
		}
	</script>
</body>