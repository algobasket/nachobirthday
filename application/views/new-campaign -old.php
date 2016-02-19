<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'}); 
</script>
<script> 
 var callBack = "<?php echo base_url()."dashboard/";?>";     
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
	var title               = document.getElementById('title').value;
	var content             = document.getElementById('content').value;  
	var link                = document.getElementById('link').value; 
	var social              = document.getElementById('social').value;
	var donate_percent      = document.getElementById('check_donation');  
	var donate_percent_val  = document.getElementById('numberinput_donate_percent').value; 
	var keep_percent        = document.getElementById('check2'); 
    var keep_percent_val    = document.getElementById('numberinput_keep_percent').value;   
	if(title=="" || title==null)
	{
	   document.getElementById('error_title').innerHTML="<a href='#'>Required Value</a>";
	}
   if(content=="" || content==null)
	{
	    document.getElementById('mceu_29-0').innerHTML="<a href='#'>Required Value</a>";
	}
   if(social=="" || social==null)
	{
	    document.getElementById('error_social').innerHTML="<a href='#'>Required Value</a>";
	}
	if(link=="" || social==link)
	{
	    document.getElementById('error_link').innerHTML="<a href='#'>Required Value</a>";
	}
   if(donate_percent.checked==true) 
	{  
	   if(donate_percent_val=="" || donate_percent_val==null)
	   {
	      alert("DONATION PERCENTAGE CANNOT BE EMPTY");
	   } 
	}
	else
	{
	   document.getElementById('numberinput_donate_percent').disabled=true;
	}
   if(keep_percent.checked==true)
	{  
	   if(keep_percent_val=="" || keep_percent_val==null)
	   {
	     alert("KEEP PERCENTAGE CANNOT BE EMPTY");
	   }
	}
	else
	{
	   document.getElementById('numberinput_keep_percent').disabled=true;  
	}
	if(title && social && donate_percent && keep_percent)
	{
       	myDropzone.processQueue(); 
	}
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
			<input class="input" type="text" placeholder="Title" name="title" id="title" required=""/>  
            <br /><span id="error_title"></span><br />
			<textarea name="content">Provide details about your campaign here.</textarea>   
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
				<center><h3 style="color:#aaa;">Click or Drag & Drop your images here.</h3></center>				
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
			<input class="input" type="text" placeholder="#RyansBday" name="social" id="social" required=""/>
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
			</div>
			<hr />
			<p>Goal Amount / Target Amount</p> 
			<div class="row">
			   <?php if($get_goal_visibility==1){ ?>
				<div class="four columns">
				    <input class="input" type="text" placeholder="Goals" name="setting" id="setting" onkeyup="goal_amount_display(this.value,event)" value="10000" />       
				</div>
				<div class="four columns"></div>
				<?php } ?>
			</div>  
			<div class="row">
				<div class="four columns"> 
					<label class="checkbox" for="check2" onclick="check_keep_percent()"> 
					    <input id="check2" value="1" type="checkbox" name="keep-percentage[]" onclick="check_keep_percent()" checked />
					    <span></span> Keep Percentage
					</label>
				</div>
				<div class="four columns"> 
					 <!--<input type='number' size='100' id='numberinput_keep_percent' value='0' name="keep-percentage-limit" width="50"/>-->
					 <div class="picker">	
					<select id='numberinput_keep_percent' name="keep-percentage-limit" onchange="keep_percentage_limit(this.value)">  
					  <option>0</option> 
					 <?php
                      $amount = 5;					 
					 for($i=1;$i<=20;$i++){  ?>  
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
						<span></span> Donate Percent  
					</label>
				</div>
				<div class="four columns">  
					<!--<input type='number' size='100' id='numberinput_donate_percent' value='0' name="donate-percentage[]"/>--> 
                   <div class="picker">			       
				   <select id='numberinput_donate_percent' onchange="donate_percent_select(this.value)">   
					 <?php 
                      $amount = 5;					 
					 for($i=1;$i<=20;$i++){  ?>   
					   <option value="<?php echo $amount;?>"><?php echo $amount;?> %</option>   
					<?php $amount = $amount+5;} ?>
					</select>
					</div>
				</div>  
			</div>
			
			<div class="row">  
			<div class="four columns">Donate Outlift</div>   
			<div class="four columns">
			<div class="picker">
                    <select name="donateTo[]" id="donateTo"> 
                        <option value="#" disabled>Select donation organisation</option>
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
					<button type="button" id="moreDonate" class="btn nc" onclick="more_donate()">Add donation</button>            
				    <br><span id="donation_error"></span>    
				</div> 
				 <div class="two columns"></div> 
			</div> 
			 <hr />
			 <p>Donation Review</p>
			<div class="row">  
			  <table>
                 <thead>			  
                  <tr>			  
				     <td colspan="4">Donation Added</td> 		  
				  </tr>
				 </thead>
				 <tbody class="moreDonate" data-donate="0">   
				     <tr>			  
				       <td>&nbsp;&nbsp;&nbsp;Name</td>  
                       <td>Percent %</td>
                       <td>Amount $</td>
                       <td></td>  					   
				     </tr>
				</tbody> 
				 <tr>  			  
				     <td>Goal Amount</td>  	 			  
				     <td></td>
					 <td id="goal_amount_display">10,000$</td>
				 </tr>  				
				 <tr>  			  
				     <td>Keep Amount</td>
                     <td></td>					 
                     <td id="keep_percent_display">No keep amount</td>        	 			  
				  </tr>  				
                </table>
                 				
			</div>
			<div class="row" id="create_campaign_select">  
				 <div class="four columns">  
				 <input type="button" name="Create_Campaign" value="Create Campaign" id="submit-all" class="btn nc"/>    
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="success-confirmation"><?php echo $error;?></span>
		   </div>
		<?php echo form_close();?>  
	</div>
	<div class="four columns">
		<h4>Did you know?</h4> 
		<p> 
		Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
		laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation 
		ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor
		in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at
		vero eros et accumsan et iusto odio dignissim qui blandit praesent.
		</p>
	</div>
</div> 
<!-- Modal --> 
<div class="modal" id="modal2">   
  <div class="content">
    <a class="close switch" gumby-trigger="|#modal2"><i class="icon-cancel" /></i></a>
    <div class="row">
      <div class="ten columns centered text-center"> 
        <h4>Opps.Maximum limit has reached</h4>   
	  </div>
    </div>
  </div>
</div>
<!-- Modal END --> 
<input type="hidden" id="all_donation_store" />
<input type="hidden" id="all_donation_amount_store" />
<input type="hidden" value="0" class="donate_amount_store" />  
<input type="hidden" value="0" class="donate_percent_store" />           
<script >
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
   $('#goal_amount_display').html(obj+"$").show(); 
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;   
}
 
function keep_percentage_limit(obj)  
{  
  var goal = $('#setting').val();
  var x = parseInt(obj)*parseInt(goal); 
  var y = x/100;
  var remaining = parseInt(goal)-y;  
  $('#goal_amount_display').html(remaining+"$").show();  
  $('#keep_percent_display').html(y+"$").show();  
}

</script>   