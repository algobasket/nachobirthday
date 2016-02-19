<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nachobirthday</title>
        <link type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url();?>assets/css/theme.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url();?>assets/images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    </head>
    <body>
        <?php $this->load->view('admin/header');?>  
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                       <?php $this->load->view('admin/sidebar');?>  
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                       
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div> 
        <!--/.wrapper-->
        <div class="footer"> 
            <div class="container">
                <b class="copyright">&copy; 2014 Nachobirthday.com </b>All rights reserved. 
            </div> 
        </div>
        <script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/common.js" type="text/javascript"></script>
      
    </body>
