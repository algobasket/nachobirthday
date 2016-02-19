<?php 
if(is_array($campaign))
{ 
 
  foreach($campaign as $r){
     $title              = ucfirst($r['title']); 
     $content            = ucfirst($r['content']);
     $link               = $r['youtube_link'];
     $created_date       = $r['created_date'];
	 $campaign_life_span = $r['campaign_life_span'];
     
    /* ---- Calculate Campaign Expiry ------ */
     $stored_date     = strtotime($r['created_date']);   
     $word            = ($r['campaign_life_span'] == 1) ? ' day' : ' days';  												   
	 $expiry_date =  date('Y-m-d',strtotime('+'.$r['campaign_life_span'].$word,$stored_date));      
	 $datediff = time() - strtotime($expiry_date);       
     $no_of_days =  -floor($datediff/(60*60*24));  	

	@list($domain,$key) = explode('=',$link);   
     $image             = json_decode($r['image'],TRUE);  
     
	 $social             = json_decode($r['social'],TRUE);  	 
     $campaign_fb_link   = $social['fb_page_url'];  
     $campaign_tw_link   = $social['twitter_page_url']; 
	 $campaign_li_link   = $social['linkedin_page_url']; 
	 $campaign_gp_link   = $social['gplus_page_url'];  
	 
	 
	 foreach($image as $r2)
	 {
	   $file[] = $r2;   
	 }
	 $donate_outlets    = $r['donate_outlets_percent'];  
     $content           = $r['content'];
     $goalAmount        = $r['setting'];   
     $pause             = $r['pause'];
		 $suspend           = $r['suspend']; 
	 } };   
	 if(is_array($campaign_owner))
	 { 
	   foreach($campaign_owner as $r2){
	   $owner       = ucfirst($r2['firstname']).' '.ucfirst($r2['lastname']);  
	   $avatar      = $r2['avatar'];
	   $description = $r2['description'];
	   $facebook    = $r2['facebook'];
	   $linkedin    = $r2['linkedin'];
	   $twitter     = $r2['twitter'];
	   $google      = $r2['google'];    
	   }
	 }
   foreach($raised_amount as $a)
   { 
      $raised = $a['SUM(amount)'];
   };
   if((int) $raised > (int) $goalAmount)
   {
     $percent_raised = 100;
   }
   else
   {
     $percent_raised = @((int) $raised/(int) $goalAmount)*100;   
   }
  ?>   
<div class="row">
	<div class="eight columns campaign-content">
		<!--<h3 class="page-title"><?php //echo $owner;?> </h3>-->
		<h4 class="campaign-title with-balloons"><img src="http://i.imgur.com/x0HG8RA.png" class="pull-right"><?php echo substr($title,0,50);?></h4>  
		<div class="media tabs">

		    <ul class="tab-nav">  
		        <li> <a href="#">Photos</a></li>
		        <?php if($key){ ?>
				<li class="active"><a href="#">Videos</a></li> 
		        <?php } ?>
		   </ul>
		
		    <div class="tab-content ">
		        <div id="owl-slider" class="owl-carousel owl-theme">  
				<?php foreach($file as $slide_pic){;?>		
		        <div class="item"><img src="<?php echo base_url();?>uploads/<?php echo $slide_pic;?>" width="200" class="lazyOwl"/></div> 
			   <?php } ?>
			   </div>
			</div>
		      <?php if($key){ ?>
			<div class="tab-content active">        
		     <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo $key;?>" frameborder="0" allowfullscreen></iframe>
			</div> 
		      <?php } ?> 
		</div>
		<div class="highlight-box">
			<div class="row">
				<div class="four columns"> 
					<?php if($raised){;?> 
					<p><strong>$<?php echo $raised;?></strong> raised </strong></p>         
					<?php } ?>
					<?php if($get_goal_visibility == 1){; ?>
					<div id="bar-2" class="bar-main-container emerald"> 
					    <div class="wrap">
					      <div class="bar-percentage" data-percentage="<?php echo $percent_raised;?>"></div> 
					      <div class="bar-container">
					        <div class="bar"></div>
					      </div>
					    </div>
					</div>
				   <?php } ?>
				</div>  
				<div class="four columns pull-right">
					<p><strong>More</strong></p>
					
					<?php if($campaign_fb_link || $campaign_tw_link || $campaign_li_link || $campaign_gp_link){ ?>
					<div class="green-hover" style="margin-left:-100px">  
					  <table style="width:100px !important">     
					    <tr>  
					      <?php if($campaign_fb_link){ ?>
						  <td onclick="window.open('<?php echo $campaign_fb_link;?>','_blank')">
						  <i class="icon-facebook"></i>
						  </td>
                          <?php }?>
						  <?php if($campaign_tw_link){ ?>
						  <td onclick="window.open('<?php echo $campaign_tw_link;?>','_blank')">
						  <i class="icon-twitter"></i>
						  </td>						  
					      <?php } ?>
						  <?php if($campaign_li_link){ ?>
						  <td onclick="window.open('<?php echo $campaign_li_link;?>','_blank')">
						  <i class="icon-linkedin"></i>
						  </td>
						  <?php } ?>
						  <?php if($campaign_gp_link){ ?> 
						  <td onclick="window.open('<?php echo $campaign_gp_link;?>','_blank')"> 
						  <i class="icon-gplus"></i>
						  </td>
						  <?php } ?>
						</tr>  
					   </table>   
					</div>
				   <?php } ?> 
				</div> 
			</div>
		</div>
		
		<p><?php echo $content;?>.</p>
		<p></p>  
		<?php if($valid_campaign_owner==true){ ?>
		<p>
		<div id="display_sub_description">
		<?php if(is_array($sub_description)){ 
		foreach($sub_description as $c){ ?>
		    <div class="edit">   
		       <p class="edit-date"><?php echo $c['date'];?></p>   
		       <p class="edit-content"><?php echo $c['sub_description'];?></p> 
	        </div>
		<?php } } ?>
		</div>
		<input type="text" class="input" id="description_sub_val" placeholder="Please enter a description" style="padding:10px 60px"/>   
		<a href="javascript:description_sub(<?php echo $this->uri->segment(3);?>)" class="btn nc">Add post</a>
		</p>   
		<?php } ?>
	</div>
	<div class="four columns campaign-sidebar">   
	   <?php if($pause==0){ ?>
	    <?php   if($no_of_days < 0){  ?> 
               <a href="javascript:void(0)" class="bordered-btn xxlarge danger btn">Expired</a>  		
		 <?php }else{ ?> 
		     <?php echo anchor('campaign/donate/'.$r['id'],'DONATE NOW','class="bordered-btn xxlarge"');?>
		 <?php } ?>
	  <?php } ?>
		<div class="birthday-boy">
		<?php if($avatar){ ?>
		     <img src="<?php echo base_url();?>uploads/profile/<?php echo $avatar;?>" >  
		<?php }else{ ;?>
             <img src="<?php echo base_url();?>assets/images/profile_placeholder.png"> 
        <?php } ?>		
		<div class="row">
		<span class="name pull-left">Meet <?php echo $owner;?></span>
		<span class="pull-right"> 
         <?php if($facebook){ ?>		
		<a href="<?php echo $facebook;?>"><i class="icon-facebook-squared"></i></a>
		<?php };if($linkedin){ ?>
		<a href="<?php echo $linkedin;?>"><i class="icon-linkedin"></i></a>
		<?php };if($twitter){ ?>
		<a href="<?php echo $twitter;?>"><i class="icon-twitter"></i></a>
		<?php };if($google){ ?>
		<a href="<?php echo $google;?>"><i class="icon-gplus"></i></a>
        <?php } ?> 		
		</span>
		</div> 
		
		<?php
		  if($no_of_days > 0)
           {
		     echo '<h4 style="margin-top:20px;" class="nc text-center">';
             echo $no_of_days." days left"; 
             echo '</h4>';
		   }		   
		?> 
		<p class="desc"><?php echo $description;?></p>
		</div> 
		 <?php if(is_array($campaign_donations)){  ?>
		 <h4 style="margin-top:20px;">Donations</h4> 

		<div class="donation-list">
			<?php 
			  foreach($campaign_donations as $r2)    
			  { 
			  ?>
			 <div class="row donation-item">    
				<?php if($r2['avatar']==NULL){ ?> 
				<div class="two columns">
				   <img class="donator" src="<?php echo base_url();?>assets/images/profile_placeholder.png">
				</div> 
				<?php }else{ ?> 	 
				 <div class="two columns">      
				     <img class="donator" src="<?php echo base_url();?>uploads/profile/<?php echo $r2['avatar'];?>" /> 
				 </div>     
				<?php } ?>  
				<div class="eight columns"><p class="donation-desc"><?php echo $r2['comment'];?></p></div> 
				<div class="two columns"><span class="amount">$<?php echo $r2['amount'];?></span></div>
			</div> 
		   <?php } ?>   
		</div>
		<?php } ?>
	</div>
</div>
<div id="fb-root"></div>
<script>
(function(d, s, id) { 
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1480738918850534&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk')); 
</script> 
<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
<script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript';
	po.async = true; 
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>