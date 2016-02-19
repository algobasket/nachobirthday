<?php  
if(is_array($campaign)){ 
   foreach($campaign as $r) 
   {
     $id        = $r['id'];
	 $firstname = $r['firstname'];  
	 $lastname  = $r['lastname'];
	 $title     = $r['title'];
	 $content   = $r['content'];
     $images    = $r['image'];
     $youtube   = $r['youtube_link'];
     @list($domain,$key) = explode('=',$youtube); 
	 $social    = $r['social'];
     $setting   = $r['setting']; 
     $show_pub_stat = $r['show_pub_stat'];
     $mybirthday = $r['mybirthday'];
     $donate_outlets_percent = $r['donate_outlets_percent'];
     $keep_percent = $r['keep_percent'];   	 
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
							<div class="module-head"><h3>#Campaign</h3> <a href="<?php echo base_url().'admin_campaign/edit/'.$id;?>" class="pull-right">Edit</a></div> 
							<div class="module-body">
							         <div class="form-horizontal row-fluid">   
										
										<div class="control-group">
											<label class="control-label">Title </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo $title;?>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Poster Images </label>
											<div class="controls"> 
												<label class="radio inline">													
													<?php
													if(is_array(json_decode($images,TRUE)))
													{
													  foreach(json_decode($images,TRUE) as $i){;?> 
					                                   <img src="<?php echo base_url().'uploads/'.$i;?>" class="img-polaroid" width="150"/>  
					                                <?php } }else{ echo "No Images";} ?>  
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Youtube Link </label>
											<div class="controls"> 
												<label class="radio inline">
												      <h5><?php echo $youtube;?></h5>  
													 <iframe width="300" src="https://www.youtube.com/embed/<?php echo $key;?>" frameborder="0" allowfullscreen></iframe>
													
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Content </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo $content;?>
												</label>
											</div>
										</div>
                                         <div class="control-group">
											<label class="control-label">Owner </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php echo ucfirst($r['firstname']).' '.ucfirst($r['lastname']);?>
												</label>
											</div>
										</div>	
										<div class="control-group">
											<label class="control-label">Created</label>
											<div class="controls"> 
											     <label class="radio inline">
													<?php echo $r['created_date'];?>
												 </label>  
											</div>
										</div>		
                                        <div class="control-group">
											<label class="control-label">Campaign Life Span </label>
											<div class="controls"> 
											     <label class="radio inline">
													<?php echo $r['campaign_life_span'];?> days
												 </label>
											</div>
										</div>												
									    <div class="control-group">
											<label class="control-label">Expire Date </label>
											<div class="controls"> 
											     <label class="radio inline">
													<?php 
  													   $stored_date     = strtotime($r['created_date']);   
                                                       $word            = ($r['campaign_life_span'] == 1) ? ' day' : ' days';  												   
													   echo $expiry_date =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));      
													   $datediff = time() - strtotime($expiry_date);       
                                                       $no_of_days =  -floor($datediff/(60*60*24));   
      
	                                                   if($no_of_days == 0)
	                                                   {
	                                                      echo $expiry_msg = ' <span class="label label-important">this campaign has been expired today.</span>';   
	                                                   }
	                                                   else if($no_of_days == 1)
	                                                   {
	                                                      echo $expiry_msg = ' <span class="label label-warning">this campaign will be going to expire tommorrow</span>';    
	                                                   }
	                                                   else if($no_of_days < 0)
	                                                   {
	                                                       echo $expiry_msg = ' <span class="label label-important">this campaign has been expired </span>';   
	                                                   }
                                                       else
                                                       {
                                                           echo $expiry_msg = ' <span class="label label-success">this campaign will expired after '.$no_of_days.' days</span>';
                                                       }										   
													?> 
													
												 </label>
												 
											</div>
										</div>	
									</div> 
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