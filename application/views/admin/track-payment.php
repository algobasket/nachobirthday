
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
								<form method="post"> 
								<table>
								   <tr>
									  <td><h4>Search&nbsp;&nbsp;&nbsp;</h4></td>
									   <td><input type="" class="span6" name="search" required="" placeholder="Search any payment by transaction id,campaign id,user id and more"/></td>
									   <td>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="search" /></td>
								   </tr>
								<table>
								</form>
								<br>
								<div class="form-horizontal row-fluid">   
								
							<table class="table table-striped">
								   <?php $i=1; 
								 if(is_array(@$payment_track)){ ?>
								 <thead><tr><th>Search found <?php echo count($payment_track);?> results</th></tr></thead>
								  <thead>
									<tr>
									  <th>#</th>
									  <th>ID</th>
									  <th>Campaign</th>
									  <th>User</th>
									  <th>Date</th>
									  <th>Status</th>
									  <th></th>
									</tr>
								  </thead>
								  <tbody>
								<?php 
								 foreach(@$payment_track as $r){ 
								 ?>	
									<tr>
									  <td><?php echo $i;?></td>
									  <td><?php echo $r['id'];?></td>
									  <td><?php echo $r['campaign_name'];?></td>
									  <td><?php echo $r['user'];?></td>    
									  <td><?php echo $r['date'];?></td>
									  <td><?php echo ($r['status']==1) ? 'paid':'unpaid';?></td>
                                      <td><a href="<?php echo base_url();?>admin_payment/view_detail/<?php echo $r['id'];?>">view</a></td>									  
									</tr>
								  <?php $i++; } ;}else{;?> 
								  <tr>
								     <th colspan="7">No record found</th>
								  </tr>
								  <?php } ;?>
								  
								  </tbody>
								</table>

									
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