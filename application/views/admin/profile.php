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
							<div class="module-head"><h3>#Campaign</h3></div> 
							<div class="module-body">
							         <div class="form-horizontal row-fluid">   
										<?php foreach($userinfo as $r):?>  
									
										<div class="control-group">
											<label class="control-label"></label>
											<div class="controls"> 
												<label class="radio inline">
				
												     <?php if($r['avatar']){;?>  
												   <img src="<?php echo base_url();?>uploads/profile/<?php echo $r['avatar'];?>">   
                                                   <?php }else{ ;?>
												  <img src="<?php echo base_url();?>assets/images/user.png"> 
												<?php } ?>
												<h4><?php echo ucfirst($r['firstname']).' '.ucfirst($r['lastname']);?></h4>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Email </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo $r['email'];?>
												</label>
											</div>
										</div>                                       
										<div class="control-group">
											<label class="control-label">Created </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo ($r['created']) ? "<b>Joined on &nbsp;&nbsp;&nbsp;</b>".$r['created']:"Not available";?>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Status </label>
											<div class="controls"> 
												<label class="radio inline"> 
													<?php if($r['banned']==0){; ?>
													Active &nbsp;&nbsp;<?php echo anchor('admin/profile/'.$this->uri->segment(3).'/ban','Ban this user');?>  
													<?php }else{ ?>
													Banned &nbsp;&nbsp;<?php echo anchor('admin/profile/'.$this->uri->segment(3).'/activate','Activate this user');?>
													<?php } ?>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"> </label>
											<div class="controls"> 
												<label class="radio inline">
													<a href="javascript:deleteGroup(<?php echo $r['id'];?>)" class="btn btn-danger">Delete Account</a>
												</label>
											</div>
										</div>
									 <?php endforeach;?> 	
									</div> 
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
		function deleteGroup(obj) 
		{
		  $('#myModal').modal('show');
          $('#deleteSelect').val(obj);  		  
		}
		function deleteGroupConfirm()  
		{
		  var x = $('#deleteSelect').val();   
		 window.location.href= "<?php echo base_url();?>admin/delete_profile/"+x;              
		}
	</script>				
				
</body>
</html>
