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
								<h3>All Campaign</h3>   
							</div>
							<div class="module-body">
								<br />
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>#</th>
									  <th>ID</th>
									  <th>Title</th>
									  <th>User</th>
									  <th>Pause</th>
									  <th>Suspend</th> 
									  <th>Edit</th>
									  <th>Delete</th>   
									</tr>
								  </thead>
								  <tbody>
								 <?php $i=1;
								 if(is_array($campaign)){
								 foreach($campaign as $r){ 
								 ?>	
									<tr>
									  <td><?php echo $i;?></td> 
									  <td><?php echo $r['id'];?></td> 
									  <td><a href="<?php echo base_url();?>admin_campaign/show/<?php echo $r['id'];?>"><?php echo $r['title'];?></a></td>
									  <td><?php echo ucfirst($r['firstname']).' '.($r['lastname']);?></td>   
                                      <td>
									  <?php if($r['pause']==0){; ?>
									  <a href="<?php echo base_url();?>admin_campaign/pause/<?php echo $r['id'];?>"><span class="label label-success">Active</span></a>
									  <?php }else{;?>
									 <a href="<?php echo base_url();?>admin_campaign/activate/pause/<?php echo $r['id'];?>"><span class="label label-success">Paused</span></a> 
									  <?php } ?>
									  </td>
                                      <td> 
									  <?php if($r['suspend']==0){ ;?> 
									  <a href="<?php echo base_url();?>admin_campaign/suspend/<?php echo $r['id'];?>"><span class="label label-warning">Active</span></a>  
									  <?php }else{ ;?>
									  <a href="<?php echo base_url();?>admin_campaign/activate/suspend/<?php echo $r['id'];?>"><span class="label label-warning">Supended</span></a>
									  <?php } ?>
									 </td> 									  
									  <td><a href="<?php echo base_url();?>admin_campaign/edit/<?php echo $r['id'];?>"><span class="label label-info">Edit</span></a></td>
									  <td><a href="javascript:deleteCampaign(<?php echo $r['id'];?>)"><span class="label label-important">Delete</span></a></td>
									</tr> 
								  <?php $i++; } ;}else{;?>  
								  <tr>
								     <th colspan="7">No record found</th> 
								  </tr>
								  <?php } ;?>
								  
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