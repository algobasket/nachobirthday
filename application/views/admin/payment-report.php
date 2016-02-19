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
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
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
				</div><!--/.span3-->
				<div class="span9">
					<div class="content"> 
						<div class="module"> 
						    <div class="module-head">
							    <h3 style="float:left">#Payment Report</h3> |    
								<a href="<?php echo base_url().'admin_payment/payment_report/export_file';?>" style="right:5px;">Export</a>  
							</div> 
							<div class="module-body" style="overflow:scroll">
                               <table class="table table-striped" >
								  <thead>
									<tr>
									  <th>#</th>
									  <th>Transaction ID</th>
									  <th>Campaign Name</th> 
									  <th>Donor Name</th>
									  <th>Donor Email</th>
									  <th>Donation Amount</th>
                                      <th>Total Donation Amount</th>
									  <th>Percentage for campaign</th>
									  <th>Amount for campaign</th>
									  <th>Percentage for Charity</th> 
									  <th>Amount for Charity</th> 
									  <th>Charity Break Down</th>
									  <th>% NB share</th> 
									  <th>NB Share in $</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php if(is_array($payment_report))  
								 {    
								    $counter = 1;
                                    foreach($payment_report as $r) 
                                     {
                                  ?>									 
									<tr>
									  <td><?php echo $counter;?></td>									 
									  <td><a href="#"><?php echo $r['transactionId'];?></a></td> 
									  <td><a href="<?php echo base_url();?>admin_campaign/show/<?php echo $r['campaign_id'];?>"><?php echo $r['campaign_name'];?>(#<?php echo $r['campaign_id'];?>)</a></td>  
									  <td><?php echo $r['donor_name'];?></td>
									  <td><?php echo $r['donor_email'];?></td>
									  <td><?php echo $r['donation_amount'];?>$</th> 
                                      <th><?php echo $r['total_donation_amount'];?>$</th> 									  
									  <td><?php echo $r['per_going_to_campaign'];?>%</td> 
									  <td><?php echo $r['amt_going_to_campaign'];?>$</td>
									  <td><?php echo $r['per_going_to_donated'];?>%</td>
									  <td><?php echo $r['amt_going_to_donated'];?>$</td>   
									  <td><a href="<?php echo base_url();?>admin_payment/charities/<?php echo $r['campaign_id'];?>">see</a></td> 
									  <td><?php echo $r['per_nb_share'];?>%</td>
									  <td><?php echo $r['per_nb_share_amt'];?>$</td>  									  
									</tr>
								  <?php 
								   $counter++;
								    } 
								    }else{
								  ?>
                                  <tr><td colspan="14">No Payment</td></tr> 
                                  <?php } ?>								  
								  </tbody>
								</table>
					        </div>
						  <!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	 
	 
	 
	 </div>
  </div>	 
</div>
	<div class="footer">
	<input type="hidden" value="" id="deleteSelect" />
		<div class="container"> 
			<b class="copyright">&copy; 2014 Example.com </b> All rights reserved.   
		</div>
	</div>

	<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.js"></script>
</body>