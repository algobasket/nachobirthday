<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
                    <!--/.sidebar-->
                </div>
                <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Members</h3>
                            </div>
                            <!--<div class="module-option clearfix">
                                <?php //echo form_open('admin/other_users/search');?>  
                              <div class="input-append pull-left">
                                    <input type="text" class="span3" placeholder="Filter by name..." name="search" /> 
                                    <button type="submit" class="btn" href="#">
                                        <i class="icon-search"></i>
                                    </button>  
                                </div>
                                <?php //echo form_close();?>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <button type="button" class="btn" onclick="window.location.href='<?php //echo base_url();?>admin/other_users/all'">   
                                        All</button> 
                                    <button type="button" class="btn" onclick="window.location.href='<?php //echo base_url();?>admin/other_users/active'">
                                        Active</button>
                                    <button type="button" class="btn" onclick="window.location.href='<?php //echo base_url();?>admin/other_users/passive'"> 
                                        Passive</button>
                                </div>
                            </div>-->
                            <div class="module-body">
                                <div class="row-fluid">
                                <?php if(is_array($users)){?>
								<?php foreach($users as $r){;?>  
									<div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="#">
                                                <?php if($r['avatar']){;?>  
												 <img src="<?php echo base_url();?>uploads/profile/<?php echo $r['avatar'];?>">   
                                                <?php }else{ ;?>
												<img src="<?php echo base_url();?>assets/images/user.png"> 
												<?php } ?>
										   </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    <?php echo ucfirst($r['firstname']).' '.ucfirst($r['lastname']);?> 
                                                </h3> 
                                                <p> 
                                                    <small class="muted"><?php echo ($r['banned']==0) ? "Active ":"Banned" ;?></small></p> 
                                                <div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small">
                                                        <i class="icon-envelope"></i>
                                                    </button>
                                                    <a class="btn btn-small" href="<?php echo base_url();?>admin/profile/<?php echo $r['id'];?>" title="View Profile" data-toggle="tooltip">    
                                                        <i class="icon-share-alt"></i>
                                                    </a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php };?>
									<?php }else{;?> 
									 <div class="span6"><h3>No Result Found</h3></div> 
									<?php };?>
                                </div>
                                <!--/.row-fluid-->
                                <br /> 
                               <!-- <div class="pagination pagination-centered">
                                    <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li> 
                                    </ul>
                                </div>-->
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
    <script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script> 
</body>
