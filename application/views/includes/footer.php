</div><!--.page-wrap-->  
<div class="modal" id="modal1">
			<div class="content">
		    <a class="close switch" gumby-trigger="|#modal1"><i class="icon-cancel" /></i></a>
		    <div class="">
		      <div class="twelve columns centered text-center">
		      	<img src="http://i.imgur.com/kc3IMXA.png">
		      </div>
		    </div>
		  </div>
		</div>
<div class="site-footer">
<section class="footer-primary">
	<div class="row">
			  
			  <?php echo anchor('how-it-works','How it Works');?> / 
			  <?php echo anchor('contact-us','Contact us');?> /
			  <?php echo anchor('faq','Faq');?> / 
			  <?php echo anchor('about-us','About us');?>         				
	</div>
</section> 
<section class="footer-secondary">
	<div class="row">
		<span class="pull-left">
				<a href="#"><i class="icon-facebook"></i></a>
				<a href="#"><i class="icon-twitter"></i></a>
				<a href="#"><i class="icon-linkedin"></i></a>
			</span>
		<div class="copyrights pull-right">&copy; 2014 NachoBirthday. All rights reserved. </div>
	</div>
</section>  
</div>
 
	<!-- Grab Google CDN's jQuery, fall back to local if offline -->
	<!-- 2.0 for modern browsers, 1.10 for .oldie -->
	<script>
	var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
	if(!oldieCheck)
	{
	  document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"><\/script>');
	}
	else 
	{
	  document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
	}

	if(!window.jQuery) 
	{ 
	  if(!oldieCheck)  
	  {
	     document.write('<script src="<?php echo base_url();?>assets/js/libs/jquery-2.0.2.min.js"><\/script>');
	  }
	  else
	  {
	     document.write('<script src="<?php echo base_url();?>assets/js/libs/jquery-1.10.1.min.js"><\/script>');
	  }
	}
	</script> 
	<!--
	Include gumby.js followed by UI modules followed by gumby.init.js
	Or concatenate and minify into a single file -->
	<script gumby-touch="js/libs" src="<?php echo base_url();?>assets/js/libs/gumby.js"></script>   
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.retina.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.fixed.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.skiplink.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.toggleswitch.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.checkbox.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.radiobtn.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.tabs.js"></script> 
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.navbar.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/jquery.validation.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/gumby.parallax.js"></script>
	<script src="<?php echo base_url();?>assets/js/libs/ui/owl.carousel.min.js"></script> 
	<script src="<?php echo base_url();?>assets/js/libs/gumby.init.js"></script>  
	<script src="http://code.highcharts.com/highcharts.js"></script>      
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/local.global.js"></script>                
   <!-- The main application script -->  
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/main.js"></script> 
  	<script src="<?php echo base_url();?>assets/js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
		$(window).load(function() {
		  $('.flexslider').flexslider({ 
		    animation: "slide"
		  });
		});
		</script>     	 
                         
  </body>
</html>