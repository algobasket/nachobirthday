<?php
if(is_array($site_front_page_data))
{
    foreach($site_front_page_data as $p)
    {
      $front_page_video_link    = $p['front_page_video_link'];
      $highlight_text_big       = $p['highlight_text_big'];
      $sub_highlight_text_small = $p['sub_highlight_text_small'];
   }
 } ;
?>
<div class="flexslider">
  <ul class="slides">
    <li>
      <img src="<?php echo base_url();?>assets/images/slide1.jpg" />
    </li>
    <li>
      <img src="<?php echo base_url();?>assets/images/slide2.jpg" />
    </li>
    <li>
      <img src="<?php echo base_url();?>assets/images/slide3.jpg" />
    </li>
    <li>
      <img src="<?php echo base_url();?>assets/images/slide4.jpg" />
    </li>
  </ul>
</div>
<div class="pull-up">
	<h1 class="text-center"><span class="highlight">Celebrating Life, Everyday.</h1>
	<?php if($this->tank_auth->get_user_id()==null){ ?>
	<div class="text-center">
	   <a class="background-btn" href="<?php echo base_url();?>login">Login</a>
	   <a class="background-btn" href="<?php echo base_url();?>register">Register</a>
	</div>
    <?php } ?>
	</div>

<section class="border-bottom balloon-bg">
	<div class="row">
		<div class="six columns">
			<h3 class="paint">
			      First Birthday Funding Engine
				     <?php //echo ucfirst($highlight_text_big);?>  
				
				 
			</h3>
			<p><?php //echo ucfirst($sub_highlight_text_small);?>
			NachoBirthday is for those who want to Celebrate Life, Everyday!
It’s for those who want to have a positive impact, for those who know that every day should be honored by giving something back.
<br>
NachoBirthday makes it easy!
Birthdays are the one thing everyone on Earth has in common and the best reason to Celebrate Life.
<br>
By leveraging your Birthday - or every other day of the year - with a NachoBirthday campaign, you can generate awareness, but most of all money for your favorite cause.
<br>
So, whether it's your Birthday or any other day, NachoBirthday will help you Celebrate Life, Every Day.
			</p>
			<div class="text-center">
			<a class="how-it-works" href="<?php echo base_url();?>how-it-works">How it Works</a>
			
			</div>
		</div>
		<div class="six columns">
			<iframe src="//fast.wistia.net/embed/iframe/9qs7sxj9iu" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="500" height="315"></iframe>
		</div>
	</div>
</section>

<div class="row">
<br>
<br>
        <h3 class="text-center">Search</h3>
  <div class="home-search">
      <input placeholder="What do you want to find?" id="search" onkeyup="campaign_search(this.value)" />
  </div>
</div> <!--.row-->

<div class="home-campaigns">
	<span class="owl-demo-search-result"></span>

<?php
	$counter=1;
  	if(is_array($campaign)){
			foreach($campaign as $x)   
    {
 ?>

   <section>
	<div class="row" style="padding: 0 15px;">
		<h3 class="text-center"><?php echo $x['group'];?></h3>
		<div id="owl-demo<?php echo ($counter==1) ? '': $counter;?>" class="owl-carousel">
		<?php
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
			    $created_date        = $x[$i]['created_date'];
				$campaign_life_span  = $x[$i]['campaign_life_span'];   
		 ?>
		<a href="<?php echo base_url();?>campaign/id/<?php echo $x[$i]['id'];?>" class="item"> 
			<img class="lazyOwl" data-src="<?php echo base_url()."uploads/".$file;?>" alt="Lazy Owl Image" />
			<h5><?php echo ucfirst($x[$i]['title']);?></h5>   
			<p><?php echo ucfirst(substr($x[$i]['content'],0,30));?><br/>    </p>
				<?php if($get_goal_visibility==1){ ;?> 
			<div id="bar-2" class="bar-main-container emerald"> 
				<div class="wrap">
					<div class="bar-percentage" data-percentage="<?php echo (int) $x[$i]['raised_percent'];?>"><?php echo (int) $x[$i]['raised_percent'];?></div>
					<div class="bar-container">     
						<div class="bar" style="width: <?php echo (int) $x[$i]['raised_percent'];?>;"></div> 
					</div>  
				</div>
			</div>
		<?php } ?>
			<span class="money">$<?php echo ($x[$i]['raised_amount']==0) ? 0 : $x[$i]['raised_amount'];?></span>  
		</a>
		<?php  } } ;?>
	</div>
</div>
</section>

  <?php $counter++;} } ?>
</div>
</div><!--.home-campaigns-->

