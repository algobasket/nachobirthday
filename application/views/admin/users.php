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
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
</head>
<body>
    <?php $this->load->view('admin/header') ;?>
    <!-- /navbar -->
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <?php $this->load->view('admin/sidebar');?> 
                    <!--/.sidebar-->
                </div>
                <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Users</h3>
                            </div>
                            <div class="module-option clearfix">
                                <form>
                                <div class="input-append pull-left">
                                    <input type="text" class="span3" placeholder="Filter by name...">
                                    <button type="submit" class="btn">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                                </form>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <button type="button" class="btn">
                                        All</button>
                                    <button type="button" class="btn">
                                        Male</button>
                                    <button type="button" class="btn">
                                        Female</button>
                                </div>
                            </div>
                            <div class="module-body">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="#">
                                                <img src="<?php echo base_url();?>assets/images/user.png">
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    User One
                                                </h3>
                                                <p>
                                                    <small class="muted">India</small></p>
                                                <div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small" title="Edit Profile">
                                                        <i class="icon-edit"></i>
                                                    </button>
                                                    <button class="btn btn-small" title="Profile">
                                                        <i class="icon-share-alt"></i>
                                                    </button>
													<button class="btn btn-small" title="Remove User">
                                                        <i class="icon-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="#">
                                                <img src="<?php echo base_url();?>assets/images/user.png">
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    Donga John</h3>
                                                <p>
                                                    <small class="muted">China</small></p>
                                                <div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small" title="Edit Profile">
                                                        <i class="icon-edit"></i>
                                                    </button>
                                                    <button class="btn btn-small" title="Profile">
                                                        <i class="icon-share-alt"></i>
                                                    </button>
													<button class="btn btn-small" title="Remove User">
                                                        <i class="icon-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/.row-fluid-->
                                <br />
                                <div class="pagination pagination-centered">
                                    <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <div class="footer">
        <div class="container">
            <b class="copyright">&copy; 2014 Edmin - EGrappler.com </b>All rights reserved.
        </div>
    </div>
	<script type="text/javascript">
	   $('document').ready(function(){
	       $('#toolTip').tooltip('show');
	   }); 
	</script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.js" type="text/javascript"></script> 
</body>
