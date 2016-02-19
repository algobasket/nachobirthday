<?php
    
?>
<br><br>
<div class="twelve columns">  
    <h3>Your campaign has been completed.</h3><br>
    <a href="<?php echo base_url();?>dashboard/" class="primary alert">Go to dashboard</a>  	
</div>  
<br> 
<div class="five columns">    
   <h3>Share</h3>     
   <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url();?>campaign/id/<?php echo $this->session->userdata('create_campaign_id');?>" target="_blank">Share on Facebook</a> |
   <a href="https://twitter.com/home?status=Checkout%20in%20Nachobirthday%0A<?php echo base_url();?>campaign/id/<?php echo $this->session->userdata('create_campaign_id');?>" target="_blank">Share on Twitter</a> |
   <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url();?>campaign/id/<?php echo $this->session->userdata('create_campaign_id');?>&title=Checkout%20this%20Nachobirthday&summary=&source=" target="_blank">Share on LinkedIn</a> |
   <a href="https://pinterest.com/pin/create/button/?url=<?php echo base_url();?>campaign/id/<?php echo $this->session->userdata('create_campaign_id');?>&media=&description=Checkout%20this%20Nachobirthday" target="_blank">Pin on Pinterest</a>   
</div>
<br><br>