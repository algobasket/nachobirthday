<div class="seperator-40"></div>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'}); 
</script>
<script> 
 var callBack = "<?php echo base_url()."new_campaign/success";?>";     
   Dropzone.options.myDropzone = {  
   // Prevents Dropzone from uploading dropped files immediately 
   autoProcessQueue: false,
   uploadMultiple: true,    
   parallelUploads:10,
   previewsContainer:'.dropzone-previews',
   addRemoveLinks:true, 
   dictRemoveFile:'Remove',   
   dictCancelUpload:'Cancel',
   clickable:'#dropzonePreview',   
   acceptedFiles: ".png,.jpg,.jpeg,.gif",   
  init:function()  
  {   
    var submitButton = document.querySelector("#submit-all") 
    myDropzone = this; // closure   
    submitButton.addEventListener("click",function(){
       	myDropzone.processQueue(); 
    }); 
    // You might want to show the submit button only when 
    // files are dropped here: 
    this.on("addedfile", function()
	{
       // Show submit button here and/or inform user to click it. 
	    
    });
     myDropzone.on("complete", function(file) 
	 {
        myDropzone.removeFile(file);
		//document.form.reset();  
		  document.getElementById('success-confirmation').innerHTML="Campaign Created Successfully";   
          setTimeout("location.href = "+callBack,5000); 
		  window.location.href = callBack;      
	 });	
  }
};  
</script>	
<div class="row"> 
	<div class="eight columns border-right">
		<h3>Happy Birthday! Create Your Campaign</h3> 
		<p>Basic Information</p> 
		<?php echo form_open_multipart('new_campaign/create','class="field dropzone" id="my-dropzone" name="myform"');?>               
		 
		 <!------ Step 1 ------->
		 
		 <div class="step_1_new_campaign"> 	
			<input class="input" type="text" placeholder="Title" name="title" id="title" required=""/>   
            <br /><span id="error_title"></span><br>
			<textarea name="content" placeholder="Provide details about your campaign" id="content" >Provide details about your campaign here.</textarea>    
			<br /><span id="error_content"></span> 
			<br />
			  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar" id="dropzonePreview" style="cursor:pointer">  
            <div class="col-lg-7">
                <div class="fallback">
                   <input name="file" type="file" id="file" multiple />   
                </div>
		        <div class="dropzone-previews dropzone" > 
				<center>
				   <h3 style="color:#aaa;">Click or Drag & Drop your images here.</h3> 
				</center>				
				</div>   
		   </div>   
        </div>     
		    <!-- The table listing the files available for upload/download -->
			<br /> 
			<br />
			<input class="input" type="text" placeholder="Youtube Video Link" id="link" name="link" required=""/> 
			<br /><span id="error_link"></span>
			<br />
			<p>Social</p>
			 <div class="row">
                <div class="seven columns"> 
				<input class="input" type="text" placeholder="#Facebook Page Link" name="social_fb" id="social_link_1" required="" />
				<div class="seperator-10"></div>
			   <input class="input" type="text" placeholder="#Twitter Page Link" name="social_twitter" id="social_link_2" required="" />
			   <div class="seperator-10"></div>
			  <input class="input" type="text" placeholder="#Linked Page Link" name="social_linkedin" id="social_link_3" required="" />
			  <div class="seperator-10"></div>
			 <input class="input" type="text" placeholder="#Google Page Link" name="social_gplus" id="social_link_4" required="" /> 
                     
				  </div>
                  <div class="five columns">
                     
                  </div>
            </div>
			<br /><span id="error_social"></span>
			<br /> 
			
			<p>Settings</p> 
			<div class="row">
				<?php if($get_goal_visibility==1){ ?> 
				<div class="four columns">
				<label class="checkbox checked" for="check1">
				    <input id="check1" value="1" type="checkbox" checked="checked" name="showPubStat[]">
				    <span></span> Show public stats
				  </label>
				</div>
				<?php } ?>
				<div class="four columns">
				  <label class="checkbox checked" for="check1"> 
				    <input id="check1" value="1" type="checkbox" name="mybirthday[]" />    
				    <span></span> Its my birthday 
				  </label>
				</div>
				<br><br>
				<p>Campaign Life Span</p>
				<div class="four columns">
				 <div class="picker">	
				  <select name="campaign_life_span">
				    <option value="5">5 Days</option>
					<option value="10">10 Days</option>
					<option value="15">15 Days</option>
					<option value="30">30 Days</option>
					<option value="60">60 Days</option>
					<option value="90">90 Days</option>
				  </select>
				  </div>
				</div>
		  </div>
		  <hr /> 			
			<a href="javascript:next_donation()" class="btn nc">Next</a> 
		  </div>		  
		  <div class="step_2_new_campaign" style="display:none">   
           <span id="goal_set"> 
		   <p>Goal Amount / Target Amount</p> 
			<div class="row">
			   <?php if($get_goal_visibility==1){ ?>
				<div class="four columns">
				    <input class="input" type="text" placeholder="Goals" name="setting" id="setting" onkeyup="goal_amount_display(this.value,event)" value="10000" />       
				    <span><small>( Note :- Nachobirthday Share is 5% )</small></span> 
				</div>
				<div class="four columns"></div> 
				<?php } ?>
			</div>  
			</span>
			<div class="row" id="keep_percent_hide"> 
				<div class="four columns">  
					<label class="checkbox" for="check2" onclick="check_keep_percent()">  
					    <input id="check2" value="1" type="checkbox" name="keep-percentage[]" onclick="return check_keep_percent()" checked />
					    <span></span> Keep Percentage     
					</label>
				</div>
				<div class="four columns"> 
					 <!--<input type='number' size='100' id='numberinput_keep_percent' value='0' name="keep-percentage-limit" width="50"/>-->
					 <div class="picker" id="keep_percent_set">	
					<select id='numberinput_keep_percent' name="keep-percentage-limit" onchange="return keep_percentage_limit(this.value)" class="numberinput_keep_percent" style="width:300px">   
					  <option selected>What percent you need ?</option>
					  <option>0</option>  
					 <?php
                        $amount = 5; 					 
					    for($i=1;$i<=20;$i++){  
					 ?> 		
					<option value="<?php echo $amount;?>"><?php echo $amount;?> %</option>  
					   <?php $amount = $amount+5;} ?>   
					</select>     
				  </div>
				</div>
			</div> 
			<div class="row"> 
				<div class="four columns">
					<label class="checkbox checked" for="check1"> 
						<input id="check_donation" value="1" type="checkbox" checked="checked" name="donate[]">
						<span></span> Charity Percent  
					</label>
				</div>
				<div class="four columns">  
					<!--<input type='number' size='100' id='numberinput_donate_percent' value='0' name="donate-percentage[]"/>--> 
                   <div class="picker">			       
				   <select id='numberinput_donate_percent' onchange="donate_percent_select(this.value)" style="width:300px">  
                    <option selected>What percent for each charities ?</option>				   
					 <?php 
                      $amount = 5;					 
					 for($i=1;$i<=20;$i++){  ?>   
					   <option value="<?php echo $amount;?>"><small><?php echo $amount;?></small> %</option>   
					<?php $amount = $amount+5;} ?> 
					</select>
					</div>
				</div>  
			</div>
			
			<div class="row" id="charity_dropdownlist" style="display:none">       
			<div class="four columns">Charity </div>    
			<div class="four columns">
			<div class="picker" style="font-size:12px !important"> 
                    <select name="donateTo[]" id="donateTo" style="width:300px" onchange="submit_donation()"> 
                        <option value="#">Please choose your charity</option>
                      <?php foreach($outlets as $r):?>    
					    <option value="<?php echo $r['id'];?>"><small><?php echo $r['name'];?></small></option>     
					  <?php endforeach;?>   
                  </select>
           </div> 
			</div> 
			</div>
			<br>
			
			<div class="row">
                <div class="four columns"></div>				
				<div class="eight columns">  
					<button type="button" id="moreDonate" class="btn nc" onclick="more_donate()" style="visibility:hidden">Add donation</button>             
				    <br><span id="donation_error"></span>    
				</div> 
				 <div class="two columns"></div> 
			</div> 
		  
			<div class="row">  
			  <table>
                 <thead>			  
                     <tr>			  
				         <td colspan="2">Donation</td> 		  
				     </tr>
				 </thead>
				 <tbody>    
				  <tr>
				     <td colspan="2">
					  <table style="display:none" id="view_donation_list">  
					     <tbody>
					        <tr>			  
				               <th>&nbsp;&nbsp;&nbsp;Charity</th>  
                               <th>Percent %</th>
                               <th>Amount $</th>
                               <th>&nbsp;&nbsp;&nbsp;</th>							   
				           </tr>
					  </tbody>
					  <tbody class="moreDonate" data-donate="0"></tbody>
					  </table>
				    </td> 
				 </tr>    
				 <tr>  			  
				     <td>Goal Amount($)</td>   	 			  
					 <td id="goal_amount_display">10,000$</td>  
				 </tr>  				
				 <tr>  			  
				     <td>Keep Amount($)</td>
                     <td id="keep_percent_display">My Amount empty</td>       	 			  
				  </tr> 
				   </tbody>
                </table>
                 				
			</div>
			<div class="row" id="create_campaign_select">  
				 <div class="four columns">  
				 <input type="button" name="Create_Campaign" value="Create Campaign" id="submit-all" class="btn nc"/>    
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="success-confirmation"><?php echo $error;?></span>
		   </div>
		   <div class="seperator-40"></div>
<p>
	<strong>Charity selection</strong><br>
Note: If you do not see your favorite charity listed, you can raise money in honor of your birthday and then personally donate to the charity of your choice. Once again just make sure you tell people what you're doing within the campaign details. You can also notify us so we can work on adding your charity of choice to our list.
</p>
<p>
<strong>Goal / Splitting funds</strong><br>
Set a goal you want to raise. This is just to track your progress. Don't worry, you will get all the funds you raise regardless of if your goal was met or not. Think of it as a motivation for both you and your donors.
This is where you decided how you want to allocate the funds raised. You have three options: keep all of the funds, donate all of the funds to your favorite charity, or split the funds between both options any way you want. Ex: 90% goes to Red Cross and the remaining 10% goes to me.
Make sure you are transparent with what you are doing. If you are splitting the funds, be sure you tell people that is what you are doing within the campaign details.
</p>
		  </div>

		<!----- Step 2 End-----> 
		
   <?php echo form_close();?>  
	</div>
	<div class="four columns"> 
	<div class="seperator-80"></div>
	<p> 
		<strong>Title</strong><br>
            <p>Make sure your title represents what you are doing or make your friends, family and fans curious enough to be interested e.g. Ari's 21st birthday "Game Changer". Great titles do at least one of the following: make a promise, create intrigue, identify a need, or state the content. Be creative, and “catchy” to tell what your campaign is about in the few words allowed for a title.</p>
		<div class="seperator-120"></div>
		<p><strong>Pictures</strong><br>
Some say, “Pictures speak louder than words” and “a picture is worth more than a thousand words”. This is where you can place compelling pictures of yourself and/or project. Try to think about what your friends, family, or audience would want to see. You need to offer an eye-catching photo that will connect emotionally with your donors. Ask yourself if the picture will put them in the mood to donate towards your cause.
		</p>
		<div class="seperator-80"></div>
		<p><strong>Video</strong><br>
A video can make a big difference. If you are able to add one make sure you do. First create a video telling your friends and family exactly what you're doing and/or want you are raising money for. Upload the video to YouTube, then place the YouTube link here. (It’s nice to have a high quality recording, but it's ok if you don't. The point is to show the world who you are, what you're doing, and ask nicely for their donations).</p>
<p>
<strong>Connect your social networks.</strong><br>
Allow visitors to connect with you on social media. This is the easiest way to notify friends of your campaign.
</p>
<div class="seperator-40"></div>
<p><strong>Settings</strong><br>
Make sure you check “show public stats" if you would like the public to see your goal amount, and the amount you raised so far. We advise you check it, as it tends to give people a good feeling of knowing how much they are contributing towards your goal, but the choice is yours.
</p>
	</div> 
</div> 
<!-- Modal --> 

<div class="modal" id="modal2">   
  <div class="content">
    <a class="close switch" gumby-trigger="|#modal2"><i class="icon-cancel" /></i></a>
    <div class="row">
      <div class="six columns centered text-center"> 
        <h4>Exceeds 100% limit has reached</h4>     
	  </div>
    </div>
  </div>
</div>

<!-- Modal END --> 

<input type="hidden" id="all_donation_store" />
<input type="hidden" id="all_donation_amount_store" />
<input type="hidden" value="0" class="donate_amount_store" />  
<input type="hidden" value="0" class="donate_percent_store" />  

<script> 
function check_keep_percent() 
{ 
   var keep_percent = document.getElementById('check2');   
   if(keep_percent.checked == true) 
   {
     document.getElementById('numberinput_keep_percent').disabled=true;     	 
   } 
   else 
   {
     document.getElementById('numberinput_keep_percent').disabled=false; 
   } 
}
   
function goal_amount_display(obj,evt)  
{  
   var keep_percent = $('#numberinput_keep_percent').val();  
   $('#goal_amount_display').html(obj).show(); 
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
	{
        return false;  
    }
    return true;   
}
 
function keep_percentage_limit(obj)  
{  
   var goal_amount             = $('#setting').val();   
   var keep_amount             = parseInt(obj) * parseInt(goal_amount)/100; 
   var calculated_keep         = keep_amount - keep_amount * 0.05;    
  $('#goal_amount_display').html(goal_amount).show();          
  $('#keep_percent_display').html(calculated_keep+"&nbsp;&nbsp;&nbsp;&nbsp;("+obj+"%)").show();             
  $('#keep_percent_set').hide(); 
  $('#keep_percent_hide').hide();         
}

function submit_donation() 
{
  $('#moreDonate').click();
  $('#goal_set').hide();  
}


</script>            
