 
if( window.location.host == "localhost" ){
    var BASE_URL = 'http://localhost/nachobirthday/'; 
} else {
    var BASE_URL = 'http://nachobirthday.appstudev.com/';
}
 
 
 $(function () { 
          
                var processed_json = new Array();   
                $.getJSON(BASE_URL + 'dashboard/highchart',function(data){   
                
                    // Populate series
                     
                   
                    // draw chart
                            $('#container').highcharts({ 
            title: {
                text: 'Views vs Donation',
                x: -20 //center
            },
            subtitle: {
                text: 'Updated in realtime',  
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Amount (USD)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }] 
            },
            tooltip: {
                valueSuffix: ''
            },
             credits: {
      enabled: false
  },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Views',
                data: data.campaign_view_stat
            }, {
                name: 'Donations',   
				data: data.donation_count_stat
            }]
        });
            });
        });
		   
  $(function () {
  
  $.getJSON(BASE_URL + 'dashboard/piediagram_data',function(data){ 
    
     $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: 'Donation amount breakdown'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true, 
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Birthday',data.birthday], 
                {
                    name: 'Charity', 
                    y: data.charity,  
                    sliced: true,
                    selected: true
                }
            ]
        }]
    }); 
  });	
}); 
    
$(document).ready(function() {

      $("#owl-demo0").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true,
        stopOnHover: true
      });

    });
	
    $(document).ready(function() {

      $("#owl-demo").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true,
        stopOnHover: true
      });

    });
  
    $(document).ready(function() {

      $("#owl-demo2").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true,
        stopOnHover: true
      });

    });
  
   
    $(document).ready(function() {

      $("#owl-demo4").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true, 
        stopOnHover: true
      });

    });
	
	//---------- slider ----------
	
   $(document).ready(function() {
 
  $('#owl-slider').owlCarousel({
    center: true,
    items:2,
    loop:true,
    margin:10,
    responsive:{
        600:{
            items:4 
        }
    }
});
}); 
	
 $(document).ready(function(){ 
  $('#owl-slider-search').owlCarousel({
      autoPlay: 3000, //Set AutoPlay to 3 seconds
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
  });
 }); 

(function($) {
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 500) {
        $('.second-nav').addClass('visible');
    }
    if (scroll < 500) {
        //clearHeader, not clearheader - caps H
        $(".second-nav").removeClass("visible"); 
    } 
  }); //missing );
}); //missing );

var count = 0;
var sum_donation_per = 0; 
function more_donate()   // -------------- add the selected donation to the list --------------------
{   
  var goal               = $('#setting').val();   
  var donateTo           = $('#donateTo').val(); 
  var donation_percent   = $('#numberinput_donate_percent').val(); 
  var keep_percent       = $('#numberinput_keep_percent').val();   
  var check_keep_percent = (document.getElementById('check2').checked == true) ? keep_percent:0;       
  sum_donation_per       = parseInt(donation_percent) + parseInt(sum_donation_per); 
  total_donation_per     = sum_donation_per + parseInt(keep_percent); 
  
  var data = {
      'row_id' : count,   
      'donateTo':donateTo,    
	  'goal_amount':goal,  
      'donate_percent':donation_percent,  	 
	  'keep_percent':check_keep_percent,
      'donation_percent_total':	sum_donation_per  
  }; 
  
	$.ajax({   
               type:'POST',  
	           url:BASE_URL + 'new_campaign/donation_outlet_ajax',               
	           data:data,      
	           success:function(msg)  
	           {     		   
                   document.getElementById('numberinput_keep_percent').disabled=true;  
                   document.getElementById('check2').disabled  = true;
                   document.getElementById('setting').disabled = true;      				  
			       $('.moreDonate').append(msg).show();    
			       $("#donateTo option[value='"+donateTo+"']").each(function(){
                   $(this).remove();
				   after_donation_success();
				   count++; 
				   if(total_donation_per > 100)
					{ 
                       sum_donation_per = sum_donation_per - parseInt(donation_percent);  
                    } 
                 });  				
	            } 
              });          
}
 function after_donation_success()
 { 
    $('#setting').hide();
    $('#keep_percent_hide').hide();
    $('#view_donation_list').show();   
    document.getElementById('check_donation').disabled=true;     
 }
   
  function next_donation()
  {   
     var title                = document.getElementById('title').value;
	var content               = document.getElementById('content').value;  
   
	if(title=="" || title==null)
	{
	   document.getElementById('error_title').innerHTML="<a href='#'>Required Value</a>";
	}
   if(content=="" || content==null)
	{
	    document.getElementById('mceu_29-0').innerHTML="<a href='#'>Required Value</a>";
	}
   
   if(title && content)
   {
      $('.step_1_new_campaign').hide();  
      $('.step_2_new_campaign').show();  
   } 
  }    
   
   // ------------ Get donate percent from the input fields ---------------  
 
  function donate_percent_select(obj) 
  {  
     $('#charity_dropdownlist').show();     
     $('.donate_percent_store').val(obj);      	 
  }

   // ------------ Remove selected donation row ---------------
  
  function remove_donation_row(obj)
  { 
     $('.donation_row'+obj).remove();
  }
 
 // ------------------------ Read Image on Change------------------------ //

  function readImage(input)
  {   
   if (input.files && input.files[0])
   {  
       var reader = new FileReader();               
	   reader.onload = function (e) {  
      $('#imageUpload').attr('src',e.target.result); // setting ur image here		
	  };               							  
      reader.readAsDataURL(input.files[0]);   // Read in the image file as a data URL.   			}      		
   }
 } 
 
 // ------------------------ More Donate Remove ------------------------ //
 
function moreDonateRemove(obj)  
{
   $('#PercentID'+obj).hide(function(){ $(this).remove(); });       
}

 // ------------------------ Drag and Drop Image in Campaign ------------------------ //
 
$(function()
 {
    'use strict'; 
    // Initialize the jQuery File Upload widget:
	var x =  $('#fileupload');
   x.fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url:BASE_URL + 'uploads/'        
    });

    // Enable iframe cross-domain access via redirect option:
    x.fileupload(
        'option',
        'redirect',
        window.location.href.replace( 
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    ); 

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        x.fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        x.addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0] 
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        }); 
    }

}); 


 // ------------------------ Add Multiple Upload ------------------------ // 
 
       function addMore(obj)    
	   {  
		     var html = '<input type="file" name="filesall[]" id="test'+obj+'" onchange="filename(this)" style="visibility:hidden;position:absolute" />';  
		     $('#moreUpload').append(html).show(); 
			 $('.addmorebt').attr('id',parseInt(obj)+1);   
             $('#currentImageID').val(obj); 			 
		     $('#test'+obj).click(); 
		} 
  
  // ------------------------ Get File Name ------------------------ //
  
	   function filename(path)
		{     
		   var currentImageID = $('#currentImageID').val();
                
			if (path.files && path.files[0])
			{
               var reader = new FileReader();   
            }; 
               reader.onload = function(e)     
		    {    
                   $('#Image2').append('<div style="float:left;margin:3px" class="imgRemove'+currentImageID+'" onclick="imageRemove(id)" id="'+currentImageID+'"><img src="'+e.target.result+'" width="150" class="img-thumbnail" /><span>Remove</span></div>').show();    
            }
                 reader.readAsDataURL(path.files[0]); 
        } 
	
  // ------------------------ Remove All ------------------------ //
	
	    function removeAll()
	    {
			    $('#Image2').html('');
                $('#moreUpload').html('');   			  
	    }
  
  // ------------------------ Remove Image ------------------------ //
  
	    function imageRemove(obj) 
		{ 
       		$('#test'+obj).remove();  
			$('.imgRemove'+obj).remove();  				
		}
  
  // ------------------------ Next Step ------------------------ //
        
		function nextstep()
		{       
		      
		  var amount  = parseInt($('#amount_donate').val());   
		  
		  if(amount!=='')      
		  {
		    $('#modal1').addClass("active");
			
		   var processFees = parseInt($('#processingFees').val());
		    
		   if(processFees)  
		   { 
		      var processingFees = processFees;  
		   }
		    else
		   {
		      processingFees=0;
		   }
		      var total_amount = amount+processingFees;   
		      $('#view_amount').html(amount).show();    
		      $('#processing_amount').html(processingFees).show();
		      $('#total_amount').html(total_amount).show();     		   
		   } 
		   
		}
	
  // ------------------------ Remove Image ------------------------ //
	
		function confirm_donation() 
		{
		  $('#submit_donation').submit();  
		}
   
  // ------------------------ Edit Donation ------------------------ //
   
        function edit_donation()   
        {
          $('#modal1').removeClass("active");       
        };
  
   // ------------------------ Campaign Search ------------------------ //
          
		
	   function campaign_search(search)
		{
		  var data = {
		   'search':search 
		  };
		  if(search)
		  {
		     $.ajax({
		       'type':'POST',
		       'url':BASE_URL + 'campaign/campaign_search',  
			   'data':data,     
			     success:function(html)  
			     { 
			  	    $('.owl-demo-search-result').html(html).fadeIn(300,function(){ 
					   $("#owl-demo3").owlCarousel({
                           items : 4,
                           lazyLoad : true,
                           navigation : true,
                           stopOnHover: true
                          }).owlCarousel('refresh'); 
					});
					   
				  }	
		      });
          }
          else
		  {
              $('.owl-demo-search-result').fadeOut();  
          }		  
		}
    
    // ------------------------ Campaign Sub Description ------------------------ //
    
	   function description_sub(id)
		{ 
		  var txt  = document.getElementById('description_sub_val').value;
		  var data = {
		     'sub_description':txt,
			 'campaign_id':id			 
		  }
          if(txt=='' || txt==null)
           {
              alert("enter some values");   
           }
           else
           {
		      $.ajax({
			     'type':'POST',
				 'url':BASE_URL + 'campaign/add_sub_description', 
				 'data':data,
				 success:function(html)
				 {
				   $('#display_sub_description').html(html).fadeIn(); 
                   	$('#description_sub_val').val(''); 			   
				 }
			  });
           }		   
		} 
	// ------------ noUISlider---------------//

    function put_social_link(obj)
	{
	  if(obj==1)
	  {
	    $('#social_link_1').show();
		$('#social_link_2').hide();
		$('#social_link_3').hide();
		$('#social_link_4').hide();
	  }
	  if(obj==2)
	  {
	   $('#social_link_1').hide();
		$('#social_link_2').show();
		$('#social_link_3').hide();
		$('#social_link_4').hide();
	  }
	  if(obj==3)
	  {
	    $('#social_link_1').hide();
		$('#social_link_2').hide();
		$('#social_link_3').show();
		$('#social_link_4').hide();
	  }
	  if(obj==4)
	  {
	    $('#social_link_1').hide();
		$('#social_link_2').hide();
		$('#social_link_3').hide();
		$('#social_link_4').show();   
	  }
	}
	
  
		
	//----- Allow only numeric in Donation Goal ---------------//
		$(function () { 
    "use strict";

    function addEvent(elem, event, fn) {
        if (typeof elem === "string") {
            elem = document.getElementById(elem);
        }

        function listenHandler(e) {
            var ret = fn.apply(null, arguments);

            if (ret === false) {
                e.stopPropagation();
                e.preventDefault();
            }

            return ret;
        }

        function attachHandler() {
            window.event.target = window.event.srcElement; 

            var ret = fn.call(elem, window.event);

            if (ret === false) {
                window.event.returnValue = false;
                window.event.cancelBubble = true;
            }

            return ret;
        }

        if (elem.addEventListener) {
            elem.addEventListener(event, listenHandler, false);
        } else {
            elem.attachEvent("on" + event, attachHandler); 
        }
    }

    function verify(e)
	{
        return " 0123456789".indexOf(String.fromCharCode(e.keyCode || e.charCode)) !== -1; 
    }

    addEvent("setting", "keypress", verify); 
}());
 //----- Allow only numeric in Donation Goal ---------------//       
