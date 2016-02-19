<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<!-- Use the .htaccess and remove these lines to avoid edge case issues.
			 More info: h5bp.com/b/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>NachoBirthday!</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="humans.txt">
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/main-icon.png" type="image/x-icon" />

	<!-- Google+ Metadata /-->
	<meta itemprop="name" content="NachoBirthday">
	<meta itemprop="description" content="">
	
	<!-- Stylesheets /-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/gumby.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flexslider.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css"> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	
	<!-- jQuery UI styles -->  
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fileupload.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fileupload-ui.css"> 
  <!-- CSS adjustments for browsers with JavaScript disabled -->
  <noscript><link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fileupload-noscript.css"></noscript>
  <noscript><link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fileupload-ui-noscript.css"></noscript>   
	<link href="<?php echo base_url(); ?>assets/css/dropzone.css" type="text/css" rel="stylesheet" /> 
  <script src="<?php echo base_url();?>assets/js/dropzone.min.js"></script>    
	<script src="<?php echo base_url();?>assets/js/libs/modernizr-2.6.2.min.js"></script>   
</head>
<?php 
	$url = $_SERVER['PHP_SELF'];
	$uri = @end(explode('/',$url));   
	$array = explode('.',$uri); 
	$class = $array[0];
?> 
<body class="<?php echo $class; ?>"> 
<div class="page-wrap">
<nav id="navbar-main-nav" class="navbar"> 
  <div class="row">
    <a class="toggle" gumby-trigger="#navbar-main-nav #main-nav" href="#"><i class="icon-menu"></i></a>
    <h1 class="four columns logo">
    	<?php echo anchor('',img(array('src'=>'assets/images/n.png' )));?> 
		</h1>
    <ul id="main-nav" class="six columns pull-right">
	    <li><?php echo anchor('pre_campaign','New Campaign','class="nc"');?></li>
	    <li><?php echo anchor('dashboard','Dashboard');?></li>
	    
	    <li><a href="#">Account</a>
				<div style="max-width: 200px;" class="dropdown">
        	<ul>
          	<li><a href="<?php echo base_url();?>account/billing">Billing</a></li> 
						<li><a href="<?php echo base_url();?>account/security">Security</a></li>  
					</ul>
				</div>
      </li>
      <li><a href="#">Me <?php //echo ucfirst($this->session->userdata('user_firstname'));?></a>     
				<div style="max-width: 200px;" class="dropdown">
        	<ul>
        		<li><a href="<?php echo base_url();?>profile">Profile</a></li>
          	<li><?php echo anchor('logout','Logout');?></li>     
					</ul>
				</div>
      </li>
			 
		</ul>
  </div>
</nav>
