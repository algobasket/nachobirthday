
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>NachoBirthday!</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="humans.txt"> 
	<link rel="shortcut icon" href="assets/images/main-icon.png" type="image/x-icon" />

	<!-- Stylesheets /-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/gumby.css"> 
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flexslider.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
	<script src="<?php echo base_url();?>assets/js/jquery.flexslider-min.js"></script>  
	<script src="<?php echo base_url();?>assets/js/libs/modernizr-2.6.2.min.js"></script>  
</head>
<?php 
	//This will echo the page name as a class in the body tag.
	//Helpful for styling pages dynamically.
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
		    <li><?php echo anchor('how-it-works','HOW IT WORKS');?></li>
		    <li><?php echo anchor('login/pre-campaign','START A CAMPAIGN');?></li> 
		    <li><?php echo anchor('faq','FAQ');?></li> 
		    <li><?php echo anchor('signin','LOGIN');?></li>
		    <li><?php echo anchor('signup','REGISTER');?></li>  
			</ul>
		</div>
	</nav> 
	<nav id="navbar-main-nav2" class="navbar second-nav"> 
  <div class="row">
    <a class="toggle" gumby-trigger="#navbar-main-nav2 #main-nav2" href="#"><i class="icon-menu"></i></a>
    <ul id="main-nav2" class="twelve columns">
	    <li><a class="switch" href="#" gumby-trigger="#modal1">HOW IT WORKS</a></li>
	    <li><?php echo anchor('login/pre-campaign','START A CAMPAIGN');?></li>   
	    <li><?php echo anchor('faq','FAQ');?></li>  
	    <li><?php echo anchor('signin','LOGIN');?></li> 
	    <li><?php echo anchor('signup','REGISTER');?></li>
		</ul>
  </div>
</nav>