 <div class="sidebar">
                <ul class="widget widget-menu unstyled">  
                      <li><a class="collapsed" data-toggle="collapse" href="#togglePages2"><i class="menu-icon icon-user"></i>Campaign</a> 
					       <ul id="togglePages2" class="collapse unstyled">               
                                <li><a href="<?php echo base_url();?>admin_campaign/campaign_redeem"><i class="icon-plus"></i>Campaign Redeems</a></li>     								
                                <li><a href="<?php echo base_url();?>admin_campaign/view_all_campaign"><i class="icon-plus"></i>View All Campaign</a></li>  
						   </ul>   
					  </li>  
					  <li><a class="collapsed" data-toggle="collapse" href="#togglePages1"><i class="menu-icon icon-user"></i>Users</a>
					       <ul id="togglePages1" class="collapse unstyled">       
                                <li><a href="<?php echo base_url();?>admin/add_user"><i class="icon-plus"></i> Add New User</a></li>
                                <li><a href="<?php echo base_url();?>admin/other_users"><i class="icon-group"></i> View All Users</a></li>               
                           </ul>  
					  </li>   
					  <li><a class="collapsed" data-toggle="collapse" href="#togglePages"><i class="icon-flag icon-cog">
                      </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Groups</a> 
                           <ul id="togglePages" class="collapse unstyled">   
                              <li><a href="<?php echo base_url();?>admin_group/new_group"><i class="icon-plus"></i> Add New Group</a></li>
                              <li><a href="<?php echo base_url();?>admin_group/view_all_group"><i class="icon-group"></i> View All Groups</a></li>               
                           </ul> 
                     </li>
                     <li><a class="collapsed" data-toggle="collapse" href="#togglePages3"><i class="icon-flag icon-cog">
                      </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Payment History</a> 
                           <ul id="togglePages3" class="collapse unstyled">   
                              <li><a href="<?php echo base_url();?>admin_payment/track_payment"><i class="icon-plus"></i> Track Payment</a></li>
							  <li><a href="<?php echo base_url();?>admin_payment/payment_setting"><i class="icon-plus"></i> Payment Setting</a></li>
                              <li><a href="<?php echo base_url();?>admin_payment/payment_report"><i class="icon-plus"></i>Payment Report</a></li>  							  
                              <li><a href="<?php echo base_url();?>admin_payment/view_all_payment"><i class="icon-group"></i> View all</a></li>							  
                           </ul> 
                     </li>
                     <li><a class="collapsed" data-toggle="collapse" href="#togglePages4"><i class="icon-flag icon-cog">
                      </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Setting</a>  
                           <ul id="togglePages4" class="collapse unstyled">   
                              <li><a href="<?php echo base_url();?>admin_setting/social_setting"><i class="icon-plus"></i>Social Setting</a></li>  
                              <li><a href="<?php echo base_url();?>admin_setting/maintainance"><i class="icon-group"></i>Maintainance</a></li>                
                           </ul> 
                     </li>					 
                     <li><a href="<?php echo base_url();?>admin_dashboard/logout"><i class="menu-icon icon-signout"></i>Logout </a></li> 
			</ul> 
 </div> 
<!--/.sidebar-->

<!-- Modal -->   
					<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel">Delete </h3>
					  </div>
					<div class="modal-body">
						<div class="alert alert-block"> 
							<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Warning!</h4>
								    Are You Sure You Want To Remove..!!!  
						</div>
				  </div>
				  <div class="modal-footer"> 
					  <button class="btn btn-primary" onclick="deleteGroupConfirm()">Yes</button> 
					  <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				  </div>
				</div> 