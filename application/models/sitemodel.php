<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemodel extends CI_Model       
{
 
  
  function createCampaign($TableCampaign,$uid,$title,$content,$image,$link,$social,$setting,$pub_stat,$mybirthday,$donate,$donatePercentage,$donateTo,$keepPercentage,$keepPercentageLimit)  
  {
    
	$data = array(  
	         'user_id'       => $uid,
             'title'         => $title,
             'content'       => $content, 
			 'image'         => $image,  
             'youtube_link'	 => $link,
			 'social'        => $social,
			 'setting'       => $setting,
			 'show_pub_stat' => $pub_stat,
			 'mybirthday'    => $mybirthday, 
			 'donate_outlets_percent' => $donatePercentage,  
			 'keep_percent' => $keepPercentageLimit    		 
	     ); 
		 
   $this->db->insert('new_campaign',$data);       
   return true;  
   
  }  
  
  
  function getAllCampaigns() 
  {
     $sql   = "SELECT id,user_id,title,content,image,youtube_link,social,setting,show_pub_stat,mybirthday,donate_outlets_percent,keep_percent FROM new_campaign ORDER BY id DESC LIMIT 5";
     $query = $this->db->query($sql);
	 if($query->num_rows() > 0)
	 {
	   foreach($query->result_array() as $r)
	   {
	      $data[] = $r; 
	   }
	   return $data; 
	 }
  }
  
  
  
  function getCampaignDetail($id) 
  {
     $sql   = "SELECT a.id,a.user_id,a.title,a.content,a.image,a.youtube_link,a.social,setting,".
	         "a.show_pub_stat,a.mybirthday,a.donate_outlets_percent,a.keep_percent FROM new_campaign".
			 " a WHERE a.id='$id'";    
     $query = $this->db->query($sql); 
	 if($query->num_rows() > 0)
	 {
	   foreach($query->result_array() as $r)
	   {
	      $data[] = $r; 
	   }
	   return $data; 
	 }
  }
  
  
}