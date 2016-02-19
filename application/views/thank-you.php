<?php
/* ------ Campaign Link Share --------------- */

$share_link = base_url().'/campaign/id/'.$this->uri->segment(4);
$call_back  = base_url().'/campaign/id/'.$this->uri->segment(4);

$share = array(
 'facebook_link_share'     => 'https://www.facebook.com/dialog/share?app_id=145634995501895&display=popup
                               &href='.$share_link.'
                               &redirect_uri='.$call_back,
 'twitter_link_share'	  =>  'http://twitter.com/share?text=Nachobirthday Campaign&url='.$share_link.'&hashtags=Nachobirthday Campaign',
 'linkedin_link_share'    =>  'https://www.linkedin.com/shareArticle?mini=true&url='.$share_link.'&title=Nachobirthday%20Campaign&summary=&source=', 
 'gplus_link_share'       =>  'http://plus.google.com/share?url='.$share_link
)
?>
<div class="row"></div>
<div style="padding-bottom:50px;" class="row">
	<div class="eight columns">
	<h3>Thank you for your payment!</h3>
	<p>Congratulations on your donation with NachoBirthday. Check our other donations below. Also, don't forget to share your donation with all your friends.</p>
	<p>Your Payment transaction ID is &nbsp;&nbsp;&nbsp;<?php echo $this->uri->segment(3);?> </p></div>
	<div class="four columns">
		<h4>Share</h4>
		<div class="green-hover">
			<a href="javascript:window.open('<?php echo $share['facebook_link_share'];?>','_self')"><i class="icon-facebook-squared"></i></a>
			
			<a href="javascript:window.open('<?php echo $share['linkedin_link_share'];?>','_self')"><i class="icon-linkedin"></i></a>
			
			<a href="javascript:window.open('<?php echo $share['twitter_link_share'];?>','_self')"><i class="icon-twitter"></i></a>
			
			<a href="javascript:window.open('<?php echo $share['gplus_link_share'];?>','_self')"><i class="icon-gplus"></i></a>  
		
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
