<?php if($this->tank_auth->get_user_id()==NULL)
      {
	    redirect('signin/redirect_campaign/campaign/id/'.$this->uri->segment(3));   
	  };
?>
<div class="row">
	<div class="eight columns">
	   <?php if($this->tank_auth->is_logged_in()){; ?>
		<?php echo form_open('campaign/donate/'.$this->uri->segment(3).'/submit/','id="submit_donation"');?> 
        <?php }else{ ?>
		<?php echo form_open('signin/redirect_campaign/campaign/id/'.$this->uri->segment(3),'id="submit_donation"');?>        
        <?php } ?> 		
		<h3 class="page-title">Make a donation</h3> 
		<div class="row">
			<div class="eight columns">
				<div class="prepend field">
				    <span class="adjoined">$</span>
				    <input class="xwide text input" type="text" placeholder="5000" name="amount" id="amount_donate" required='' />     
				</div>
            </div>
            <div class="four columns"> 
            Donation Amount 	
            </div>
        </div>
		<div class="row">
			<div class="five columns">
				<div class="prepend field">
				    <span class="adjoined">$</span>  
				    <input class="xwide text input" type="text" placeholder="Processing fees 1$" name="processingFees" required='' value='1' id="processingFees" />
				</div>
            </div>
            <div class="three columns">
            <a href="javascript:$('#processingFees').val('').attr('disabled','disabled')">Remove</a>   	
            </div>           
		   <div class="four columns">Processing Fees</div>
        </div>
        
		<div class="field"> 		 
		   <?php if($this->tank_auth->get_username()){; ?>  
		   <input class="input" type="text" placeholder="Name" name="fullname" required='' value="<?php echo $fullname;?>" disabled />
			<?php }else{ ?>
		   <input class="input" type="text" placeholder="Name" name="name" required='' />   
			<?php } ?> 	
		</div>
		
		<div class="field">
			<textarea class="input textarea" placeholder="Happy 10th Birthday. Have fun!" name="comment"></textarea> 
		</div>

		<!--
		<div class="field">
			<label class="radio" for="radio2">
			    <input id="payment-creditcard" value="creditcard" type="radio" name="paymentType" checked>  
			    <span></span> Credit Card 
			  </label>
		</div>
		
		<div class="row"> 
			<div class="six columns">
				<div class="field">
		            <input class="input" type="text" placeholder="Name on card" name="cardName" />
		        </div>
		        <div class="field">
		            <input class="input" type="text" placeholder="Card Number" name="cardNumber" />
		        </div>
				<div class="field">
		            <select class="input" name="cardType"> 
					  <option>Select your card</option>
					  <option value="MC">Master Card</option>
					  <option value="DI">Discovery Card</option>
					  <option value="VI">Visa Card</option>
					  <option value="AX">American Express</option> 
					</select> 
		        </div>
				<div class="field">
		             <input class="input" type="text" placeholder="Address 1" name="cardAddress" />
		        </div>
				<div class="field">
		            <select class="input" name="city">   
					  <option>City</option>
					   <option value="Burlington">Burlington</option> 
					</select>
		            <select class="input" name="state">  
					  <option>State</option>
					  <option value="MA">Massachussets</option> 
					</select>
					<input class="input" type="text" placeholder="Zip" name="zip" /> 
				</div>
                <div class="field">
		            <select class="input" name="country">  
					  <option>Country</option>
					  <option value="IN">India</option> 
                      <option value="US">USA</option> 					  
					</select>
				</div>
		        <div class="row">
		        	<div class="four columns">
			        	<div class="field">
				            <input class="input" type="text" placeholder="CCV" name="cvv" /> 
				        </div>
		        	</div>
		        	<div class="four columns">
						<div class="field">
							<div class="picker">
							    <select name="month">
							      <option>Month</option>
							      <option value="01">JAN</option>
							      <option value="02">FEB</option>
								  <option value="03">MAR</option>
								  <option value="04">APR</option>
								  <option value="05">MAY</option>
							      <option value="06">JUN</option>
								  <option value="07">JUL</option>
								  <option value="08">AUG</option>
								  <option value="09">SEP</option>
							      <option value="10">OCT</option>
								  <option value="11">NOV</option>
								  <option value="12">DEC</option> 
							    </select>
							</div>
						</div>
		        	</div> 
		        	<div class="four columns"> 
		        		<div class="field">
							<div class="picker">
							    <select name="year">
							      <option value="#" disabled>Year</option> 
							      <?php  
								 //$date =  date('d/m/Y');
								 //$array = explode('/',$date);
								 // for($i=1989;$i<=$array[2];$i++)
								  //{
								  // echo '<option value="'.$i.'">'.$i.'</option>';
								 // }
								  ;?>
							    </select>
							</div>
						</div>
		        	</div>
		        </div>
			</div>
			<div class="six columns">
				<div class="secure">
					<p>Secure Payments <i class="icon-lock pull-right"></i></p>
					<p class="small">We follow industry standard guidelines for processing payments. All payments are handled by trusted companies.</p>
				</div>
			</div>
		</div>
		--> 

	   <?php //echo form_submit('submit','Next Step','class="green-btn pull-right"');?>    

	   <button type="button" onclick="nextstep()" class="switch btn primary medium green-btn pull-right nc" >Proceed to Paypal</button>  
	 
	  <?php echo form_close();?>
	</div>
	<div class="four columns">
		<div class="highlight-box">
			<p><strong>Extra Info</strong></p>
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
		</div>
	</div>
</div> 

<!-- Modal --> 
<div class="modal" id="modal1"> 
  <div class="content">
    <a class="close switch" gumby-trigger="|#modal1"><i class="icon-cancel" /></i></a>
    <div class="row">
      <div class="ten columns centered text-center">
        <h4>Confirm Donation</h4> 
        <table>
		  <tr> 
		    <th>Donation Amount</th> 
			<th><span id="view_amount"></span>$</th>      
		    <th><a href="javascript:edit_donation()">Edit</a></th>   
		  </tr>
		  <tr>
		    <th>Optional Processing Fees</th>
			<th><span id="processing_amount"></span>$</th> 
			<th></th>
		  </tr>
		  <tr> 
		    <th>Total</th>
			<th><span id="total_amount"></span>$</th>  
			<th></th> 
		  </tr>
		</table>
		<p class="btn primary medium">  
          <button type="button" onclick="confirm_donation()" class="switch">Confirm Payment</button>
        </p>
		<p class="btn primary medium">
          <a href="#" class="switch" gumby-trigger="|#modal1">Cancel</a>
        </p>
      
	  </div>
    </div>
  </div>
</div>
<!-- Modal END -->  