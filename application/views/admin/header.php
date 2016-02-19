<?php 
if(is_array(@$admin_info))
{
   foreach(@$admin_info as $r)
   {
     $avatar = @$r['avatar']; 
   }
}
?>
<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container"> 
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">  
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="<?php echo base_url();?>admin/welcome">Nachobirthday Admin </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <!--
						<ul class="nav nav-icons">
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        -->
					
                        <ul class="nav pull-right">
                            <!--
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Item No. 1</a></li>
                                    <li><a href="#">Don't Click</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Example Header</li>
                                    <li><a href="#">A Separated link</a></li>
                                </ul>
                            </li>
                            -->
							<li><a href="javascript:void(0)">Welcome</a></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php if(@$avatar){ ?>
								<img src="<?php echo base_url();?>uploads/admin-profile/<?php echo @$avatar;?>" class="nav-avatar" />
                                <?php }else{ ?>
								<img src="<?php echo base_url();?>assets/images/user.png" class="nav-avatar" />
								<?php } ?>
								<b class="caret"></b></a> 
                                <ul class="dropdown-menu">   
                                    <li><a href="<?php echo base_url().'admin/my_profile/';?>">Your Profile</a></li>
                                    <li><a href="<?php echo base_url().'admin/my_profile/edit';?>">Edit Profile</a></li> 
                                    <li><a href="#">Account Settings</a></li>  
									<li><a href="<?php echo base_url().'admin/page_setting/';?>">Page Settings</a></li> 

                                    <li class="divider"></li>
                                    <li><?php echo anchor('admin_dashboard/logout','Logout');?></li>      
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>