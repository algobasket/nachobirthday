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
							    <h3 style="float:left">#Charities in <?php echo ucfirst($campaign_name);?> </h3>  
							</div>   
							<div class="module-body">
                              
							  <?php if($this->uri->segment(4)!='send_to_charity'){ ?>
							  
							  
							  <center><h4>Charities Stats</h4></center> 
							   <form method="POST">
							   <table class="table table-striped" > 
							        <thead></thead>
								    <tbody>
                                      <tr>									
									  <?php foreach($charity_names as $name){ ?>  
									  <th colspan="2"><h6><?php echo $name['charity_name'];$c_name[] = $name['charity_name'];?></h6>
									  </th> 
								      <?php } ?>
                                      </tr>
									  <tr>
									  <?php foreach($charity_percent as $percent){ ?>  
									  <th colspan="2"><h6><?php echo $percent['charity_percentage'];?>%</h6></th> 
								      <?php } ?>
                                      </tr> 
									  <tr> 
									  <?php foreach($charity_amount as $amt){ ?>  
									  <th colspan="2">
									  <h6>
									  <?php  
									  echo $amt['each_charity_amount'];
									  $charity_amt[] = $amt['each_charity_amount'];
									  ?>
									  $									  
									  </h6></th>   
								      <?php } ?>  									  
									</tr>
                                    <tr> 
                                      <th> 
									  <span>Total Charities Amount  <?php echo array_sum($charity_amt);?>$</span> 
									  <?php if($has_completed < 0){ ?>
									    <span class="pull-right"><a href="javascript:alert('Sorry you cannot send right now.Campaign Life Span has not over yet')" class="btn btn-primary" >Send to charity</a></span>
									  <?php }else{ ?>
									    <span class="pull-right"><a href="<?php echo $this->uri->segment(3);?>/send_to_charity" class="btn btn-primary" >Send to charity</a></span>
									  <?php } ?>
									  </th>								  
									</tr>									
								  </tbody> 
								</table>
								</form>
								<hr>
								     <center><h4>Charities Log</h4></center>   
							   <table class="table table-striped" >
							        <thead></thead>
								    <tbody>
                                      <tr>									
									  <th><h6>Name</h6></th>
									  <th><h6>Date</h6></th>							
									  <th><h6>Status</h6></th>
                                      </tr>
									 <?php foreach($charities_list as $list){ ?> 
								     <tr>									
									  <th><h6><?php echo ucfirst($list['name']);?></h6></th>                             									
									  <th><h6><?php echo $list['date'];?></h6></th>                                  									
									  <th>
									  <?php if($list['donated']==1){ ?>
									  <label class="label label-success">Donated</label>
									  <?php }else{ ?>
									  <label class="label label-warning">Pending</label>      
									  <?php } ?>
									  </th> 
                                      </tr>									
								      <?php } ?>
								  </tbody>
								</table>
					           <?php }else{ ?>
							   <center><h4>Charities Payment</h4></center>  
                              <form method="POST">							   
							   <table class="table table-striped">
							        <thead></thead>
								    <tbody>
									  <tr>
									  <?php foreach($charity_names as $name){ ?>  
									  <th>
									  <input type="hidden" value="<?php echo $name['charity_name'];?>" name="charity[]" />
									  </th> 
								      <?php } ?>
									  <?php foreach($charity_amount as $amt2){ ?>    
									  <th>
									  <input type="hidden" value="<?php echo $amt2['charity_id'];?>" name="charity_id[]" /> 
									  <input type="hidden" value="<?php echo $amt2['each_charity_amount'];?>" name="amount[]" />  
									  </th>   
								      <?php } ?> 
									  </tr>
                                      <tr>									
									    <th><h6>Card Number</h6></th>
									    <th><h6>4457010000000009<input type="hidden" name="card_number" value="4457010000000009"/></h6></th>							 
                                      </tr> 
									  <tr>									
									    <th><h6>Card CVV</h6></th>
									    <th><h6>349<input type="hidden" name="card_cvv" value="349"/></h6></th>							 
                                      </tr>
									  <tr>									
									    <th><h6>Card Type</h6></th>
									    <th><h6>VISA<input type="hidden" name="card_type" value="VI"/></h6></th>							 
                                      </tr>
									  <tr>									
									    <th><h6>Address</h6></th>
									    <th><h6>1 Main St.<input type="hidden" name="card_address" value="1 Main St."/></h6></th>							 
                                      </tr>
									  <tr>									
									    <th><h6>City : Burlington</h6> <h6> State : MA</h6> <h6>Zip : 01803</h6></th> 
									    <th>
										<input type="hidden" name="card_city" value="Burlington"/>
										<input type="hidden" name="card_state" value="MA"/>
										<input type="hidden" name="card_zip" value="01803"/>
										</h6></th>							 
                                      </tr>
								      <tr>									
									    <th><h6>Country</h6></th>
									    <th><h6>USA<input type="hidden" name="country" value="US"/></h6></th>							 
                                      </tr>
									  <tr>									
									    <th><h6>Month <input type="hidden" name="card_expiry_month" value="12"/></h6></th>
									    <th><h6>Year <input type="hidden" name="card_expiry_year" value="2014"/></h6></th>							 
                                      </tr>
                                      <tr>
                                        <th><h6><input type="submit" name="payment_to_charity" class="btn btn-primary" value="Pay to charity"/></h6></th>									  
									    <th><?php echo @$payment_processing_result;?></th> 							 
                                      </tr>									  
								  </tbody>
								</table>
							   </form>
							   <?php } ?>
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