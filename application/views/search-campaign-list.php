<div class="choose-option center-block text-center">
	<h2> Campaign found <?php echo count($search_campaign);?><i class="icon-search"></i></h2>
	 
	 <div class="row">
	
	<?php 
	if(is_array($search_campaign))
	{
	  foreach($search_campaign as $r)  
	    {
	      $title       = $r['title']; 
		  $content     = $r['content']; 
		  $array_image = json_decode($r['image'],true);
        
		 foreach($array_image as $i)
          {
            $image = base_url().'uploads/'.$i; 
          } 	 
            if(file_exists(FCPATH."uploads/".$i))
		   {
		       echo '<div class="owl-item" style="width:235px;float:left"> 
		         <a href="'.base_url().'campaign/id/'.$r['id'].'" class="item"> 
		            <img class="lazyOwl" alt="Lazy Owl Image" src="'.$image.'" style="display: block;height:200px !important" width="200">   
			        <h5>'.$title.'</h5> 
			        <p>'.substr($content,0,25).'</p>     
		         </a>
		       </div>';   
           }		
	   }
    }	 
	 ?>
	 
	 </div> 	 
</div>    