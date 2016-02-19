<div class="seperator-40"></div>
<?php  
if(is_array($dashboard_stats))
{
  $page_view        = $dashboard_stats['page_view'];
  $amount_donated   = $dashboard_stats['amount_donated']; 
  $donors           = $dashboard_stats['donors'];
  $donation_message = $dashboard_stats['donation_message'];
  $amount_owner     = $dashboard_stats['amount_owner'];   
}
?>
   <?php 
   if(@$profile_completeness==false){; ?>  
	   <div class="row">
		 <li class="warning alert">Your profile is not complete. Update now to increase traffic.<a href="<?php echo base_url();?>profile/edit">Update</a></li>
	   </div> 
   <?php } ?>  
	<?php 
	if(is_array($my_campaign)):?>  
	<div class="row">  	
		<div id="container" style="width:100%; height:400px;"></div>
	</div>
	<div class="row">
		<div class="six columns"> 
		<br/>
			<table>
				<thead>
					<tr>
						<th>Description</th>
						<th>Value</th>  
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>Views</td>
						<td><?php echo $page_view;?></td>
					</tr>
					
					<tr>
						<td>Donors</td>
						<td><?php echo $donors;?></td>   
					</tr>
					
					<tr>
						<td>Amount Donated</td>  
						<td>$<?php echo $amount_donated;?></td>      
					</tr>
					
					<tr>
						<td>Non Profit</td>
						<td>$1,343,232</td> 
					</tr>
					
					<tr>
						<td>Birthday</td> 
						<td>$<?php echo @$amount_owner;?></td> 
					</tr>
				
				</tbody>
			</table>
			Share: <div class="green-hover">
						<a href="#"><i class="icon-facebook-squared"></i></a><a href="#"></a><a href="#"><i class="icon-linkedin"></i></a><a href="#"><i class="icon-twitter"></i></a><a href="#"><i class="icon-gplus"></i></a> 
					</div>
		</div>
		
		<div class="six columns">
			<div id="container2" style="width:100%; height:400px;"></div>
		</div>
	</div>
	<hr>
	<?php endif ?>
	
	
<section style="padding:50px 0;">
	<div class="row">
		<h4>Donation Messages</h4> 
		<ul class="messages"> 
	     <?php
		 if(is_array($donation_message))
		 {   
		   foreach($donation_message as $m){ 
		     if($m['comment']!=''){
		   ?>
		     <li><a href="#"><i class="icon-mail"></i><?php echo ucfirst($m['comment']);?></a></li> 
		 <?php } } }else{ ?> 
           
		 <li>You have no donation messages</li>  
        
		<?php }  ?>		 
		</ul>
	</div>
</section>
<section style="padding:50px 0; background:#f3f3f3;">
	<div class="row">
		<h4>My Campaigns</h4>
		<div id="owl-demo" class="owl-carousel">
		  <?php 
		  if(is_array($my_campaign)){
		     foreach($my_campaign as $r){
		         $images = json_decode($r['image'],TRUE);  
                    if(is_array($images)){ 
				      foreach($images as $image)
                       {
			             $file = $image;  
                       }  
		           }
			if($r['suspend']==0){
                if(file_exists(FCPATH."uploads/".$file)){ 			
		  ;?> 
		      
		  <a href="<?php echo base_url();?>campaign/id/<?php echo $r['id'];?>" class="item">
		          <img class="lazyOwl" data-src="<?php echo base_url()."uploads/".$file;?>" alt="Lazy Owl Image">
			        <h5><?php echo ucfirst($r['title']);?></h5>
			        <p><?php echo ucfirst(substr($r['content'],0,50));?><br/>
			        <?php if($get_goal_visibility==1){ ?>
			       <span class="percent"><?php echo (int) $r['raised_percent'];?>%</span>  
			  <?php } ?>
			  <span class="money">$<?php echo ($r['raised_amount']==0) ? 0:$r['raised_amount'];?></span></p>
		  </a>
		  <?php } } } } ?> 
		 	  
		  <a href="<?php echo base_url();?>pre_campaign" class="item add-new-campaign">
		  	<p class="hover-visible">New campaign</p>
		  </a>
		</div>
	</div>
</section>
<section style="padding:50px 0;">
	<div class="row">
		<h3>Popular Campaigns</h3>  
		
		<div id="owl-demo2" class="owl-carousel"> 
		  <?php   
		  $counter=1;		  
		  if(is_array($campaign)){
		  foreach($campaign as $x)
		  {          			  
		   $count = count($x)-1;
		   for($i=0;$i<$count;$i++)
		   {
		        $images = json_decode($x[$i]['image'],TRUE);  
                if(is_array($images))
				{ 
				  foreach($images as $image)
                   {
			         $file = $image;  
                   } 
		        }
			if($x[$i]['suspend']==0) 
			{ 
		?>  
	    
		<a href="<?php echo base_url();?>campaign/id/<?php echo $x[$i]['id'];?>" class="item"> 
		      <img class="lazyOwl" data-src="<?php echo base_url()."uploads/".$file;?>" alt="Lazy Owl Image" />   
			  <h5><?php echo ucfirst($x[$i]['title']);?></h5> 
			  <p><?php echo ucfirst(substr($x[$i]['content'],0,50));?><br/>    
			  <?php if($get_goal_visibility==1){ ;?>
			  <span class="percent">% <?php echo (int) $x[$i]['raised_percent'];?></span> 
			  <?php } ?>
			  <span class="money">$<?php echo ($x[$i]['raised_amount']==0) ? 0:$x[$i]['raised_amount'];?></span></p>   
		</a>
        <?php  } } ;?>  

  <?php $counter++;break;} } ?> 
		  
		  
		</div>
	</div>
</section>
<div class="seperator-40"></div>