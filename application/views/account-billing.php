<div class="seperator-40"></div>
<div class="choose-option center-block text-center">
			  <?php if($this->uri->segment(3) == 'redeem'){ ?>
			   <h2>Redeem Overview<i class="icon-lock"></i></h2> 
			    <div class="row">
				  <table>
			         <thead>
			          <tr>
				        <th colspan="6">Detail Info </th>  
				      </tr>
			        </thead> 
			        <tbody>
			          <tr>
			            <th>#</th>
				        <th>Id</th>
				        <th>Campaign Name</th>
				        <th>Required Amount</th>
						<th>Raised Till Now</th>
				        <th></th>				 
			          </tr>    
					  <?php 
					     if(is_array($redeem_campaign_amount))  
						 {  
						    $counter = 1;
                            foreach($redeem_campaign_amount as $r)
							{
					  ?>
					   <tr>
			            <th><?php echo $counter;?></th>    
				        <th><?php echo $r['cid'];?></th>
				        <th><?php echo $r['campaign_name'];?></th> 
				        <th><?php echo $r['campaign_amount'];?></th>
                        <th>
						<?php if($r['is_redeem_available']==1){ ?>
						
						   <?php echo $r['campaign_amount'];?>	
					
						<?php }else{ ?>

						   <?php echo $r['campaign_donation_amount'];?>      
						   
						<?php } ?>
						</th> 						

				        <th>
						<?php if($r['is_redeem_available']==1){ ?>
						   <?php if($r['redeem_request']==1){  ?>
						       <?php if($r['admin_approval']==1){ ?>
							     <li class="success label">Redeem Completed <i class="icon-check"></i></li>  
							   <?php }else{ ?>
							     <li class="primary label">Request Sent <i class="icon-check"></i></li> 
							   <?php } ?>    
						   <?php }else{  ?> 
						   <a href="<?php echo base_url();?>account/billing/redeem/redeem_request/<?php echo $r['cid'];?>/<?php echo $r['campaign_amount'];?>" class="success label">Redeem Available $</a>
						   <?php } ?>
						<?php }else{ ?> 
						  <li class="warning label">Not Available Yet <i class="icon-attention"></i></li>  
						<?php } ?>  
						</th>				 
			          </tr>  
					  <?php $counter++;} }else{ ?> 
					  <tr><td colspan="6">No Redeem</td></tr>
					  <?php } ?>
			        </tbody>
			    </table>
				</div>
			   
			   
			   
			   <?php }else{ ?>
			   
			   
			  <h2>Account Overview<i class="icon-lock"></i></h2> 
			  <div class="row">
			  <table>
			  <thead>
			    <tr>
				<th colspan="4">Detail Info </th>
				</tr>
			  </thead>
			  <tbody>
			  <tr>
			     <th>#</th>
				 <th>Campaign Name</th>
				 <th>Donation Amount</th>
				 <th>Expiry Date</th>    
			  </tr>
			 <?php
			   if(is_array($billing_detail)){
               $counter = 1;			 
			   foreach($billing_detail as $r){; 
             ?>			 
			 <tr>  
	   		     <th><?php echo $counter;?></th>  
				 <th><?php echo $r['campaign_name'];?></th> 
				 <th><?php echo $r['donation'];?></th>
				 <th>
				 <?php 
				 list($y,$m,$d) = explode('-',$r['expiry']);
				 echo $m.'-'.$d.'-'.$y;  
				 ?>
				 </th>  
			  </tr>   
			 <?php $counter++;} }else{ ?>
			 
                <tr><td colspan="7">No Info</td></tr>       
            
			
			<?php } ?>			 
			   </tbody>
			</table>
			 </div>
			 




			 <?php } // ------ END ELSE ?>
	 
	 </div>    
	  