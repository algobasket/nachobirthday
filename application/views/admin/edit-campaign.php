<?php 
if(is_array($campaign)){
   foreach($campaign as $r) 
   {
     $id                     = $r['id'];
	 $firstname              = $r['firstname']; 
	 $lastname               = $r['lastname'];
	 $title                  = $r['title'];
	 $content                = $r['content'];
     $images                 = $r['image'];
     $youtube                = $r['youtube_link'];
     $social                 = $r['social'];
     $setting                = $r['setting']; 
     $show_pub_stat          = $r['show_pub_stat'];
     $mybirthday             = $r['mybirthday'];
     $donate_outlets_percent = $r['donate_outlets_percent'];
     $keep_percent           = $r['keep_percent'];
     $created_date           = $r['created_date'];
     $campaign_life_span     = $r['campaign_life_span'];
	 
	 /* ----- Campaign Life Span Calculation ----- */ 
	 
	 $stored_date            = strtotime($r['created_date']);   
     $word                   = ($r['campaign_life_span'] == 1) ? ' day' : ' days'; 												   
	 $expiry_date            =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));       
	 
	 $datediff = time() - strtotime($expiry_date);       
     $no_of_days =  -floor($datediff/(60*60*24));   
      
	 if($no_of_days == 0)
	 {
	     $expiry_msg = ' <span class="label label-important">this campaign has been expired today.</span>';   
	 }
	 else if($no_of_days == 1)
	 {
	    $expiry_msg = ' <span class="label label-warning">this campaign will be going to expire tommorrow</span>';    
	 }
	 else if($no_of_days < 0)
	 {
	     $expiry_msg = ' <span class="label label-important">this campaign has been expired </span>';   
	 }
     else
     {
         $expiry_msg = ' <span class="label label-success">this campaign will expired after '.$no_of_days.' days</span>';
     }	 
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
							<div class="module-head"><h3>#Edit Campaign</h3></div> 
							<div class="module-body">
							         <div class="form-horizontal row-fluid">    
										<?php echo form_open('admin_campaign/edit/'.$id.'/save/');?>     
										<div class="control-group">
											<label class="control-label">Title </label>
											<div class="controls"> 
												<label class="radio inline">
													<input type="text" name="title" value="<?php echo $title;?>" required=""/>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Poster Images </label>
											<div class="controls"> 
												<label class="radio inline">
													<?php 
													if(is_array(json_decode($images,TRUE)))
													{ $counter = 1;
													foreach(json_decode($images,TRUE) as $i){;?>
					                                   <input type="hidden" name="images[]" required="" value="<?php echo $i;?>" id="campaign_image<?php echo $counter;?>"/>   
					                               <?php $counter++;} } ?>   
												   <ul class="thumbnails">
												      <?php 
													  if(is_array(json_decode($images,TRUE)))
													  { $counter = 1;
													  foreach(json_decode($images,TRUE) as $i){;?> 
					                              
													 <li class="span4" id="campaign_image_preview<?php echo $counter;?>">
                                                       <div class="thumbnail"> 
                                                         <a class="close" href="javascript:remove_campaign_image(<?php echo $counter;?>)">×</a>
                                                           <img src="<?php echo base_url().'uploads/'.$i;?>" />                              
                                                        </div>
                                                      </li>
													   
													   <?php $counter++;} }else{ echo "No Images"; }; ?> 
                                                        
												   </ul>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Youtube Link </label>
											<div class="controls"> 
												<label class="radio inline">
					                          <textarea type="text" name="youtube" value="<?php echo $youtube;?>" required=""><?php echo $youtube;?></textarea> 
													
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Content </label>
											<div class="controls"> 
												<label class="radio inline">
													<textarea name="content" value="<?php echo $content;?>" required=""><?php echo $content;?></textarea>     
												</label>
											</div>
										</div>
                                         <div class="control-group">
											<label class="control-label">Owner </label>
											<div class="controls"> 
												<label class="radio inline">
													 <?php echo ucfirst($r['firstname']).' '.ucfirst($r['lastname']);?><br>  
												</label>
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label">Created </label>
											<div class="controls"> 
												<label class="radio inline">
													 <input type="text" value="<?php echo $created_date;?>" name="created_date" required=""/><br>   
												</label>
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label">Campaign Life Span </label>  
											<div class="controls"> 
												<label class="radio inline">
													 <input type="text" value="<?php echo $campaign_life_span;?>" name="campaign_life_span" required=""/>
													 <?php echo @$expiry_msg;?>  
													 <br>  
												</label>
											</div>
										</div>
                                        										
									   <div class="control-group">
											<label class="control-label"></label>
											<div class="controls"> 
												<label class="radio inline"> 
													 <button type="submit" class="btn btn-primary">Save Changes</button>  
					                                <a href="javascript:deleteCampaign(<?php echo $r['id'];?>)" class="btn btn-danger">Delete Campaign</a>  
												</label>
											</div>
										</div>	
									<?php echo form_close();?>
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
		function deleteCampaign(obj)  
		{
		  $('#myModal').modal('show');
          $('#deleteSelect').val(obj);  		  
		}
		function deleteGroupConfirm()  
		{
		  var x = $('#deleteSelect').val();   
		 window.location.href = "<?php echo base_url();?>admin_campaign/delete_campaign/"+x;               
		}
		function remove_campaign_image(obj)
		{
		   $('#campaign_image'+obj).remove();   
           $('#campaign_image_preview'+obj).remove();  		   
		}
	</script>				
				
</body>
</html>
