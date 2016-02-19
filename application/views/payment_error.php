
<div class="row"></div>
<div style="padding-bottom:50px;" class="row">
	<div class="eight columns">
	<h3>Sorry,your payment is failed.</h3>
	<p>Your transaction encountered and error please redirect to the payment again.</p>
	<p></p></div>
	<div class="four columns">
		<h4>Share</h4>
		<div class="green-hover">
			<a href="#"><i class="icon-facebook-squared"></i></a><a href="#"></a><a href="#"><i class="icon-linkedin"></i></a><a href="#"><i class="icon-twitter"></i></a><a href="#"><i class="icon-gplus"></i></a>
		</div>
		<div class="share-text">"I just donated on NachoBirtday. You should too!"</div>
	</div>
</div>

<section style="padding:50px 0; background:#f3f3f3;"> 
	<div class="row">
		<h3>Similar Campaigns</h3>
		
		<div id="owl-demo" class="owl-carousel">
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
			  <?php if(@$get_goal_visibility==1){ ;?>
			  <span class="percent">% <?php echo (int) $x[$i]['raised_percent'];?></span> 
			  <?php } ?>
			  <span class="money">$<?php echo ($x[$i]['raised_amount']==0) ? 0:$x[$i]['raised_amount'];?></span></p>   
		  </a>
	
        <?php  } } ;?>  

  <?php $counter++;break;} } ?> 
		  
		</div>
	</div>
</section>
