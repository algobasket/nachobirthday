<?php
/*
|--------------------------------------------------------------------------
| BASE URL Exception
|--------------------------------------------------------------------------
|
| 
|Prevent From Direct Script Access     
|
|
*/ 

if (!defined('BASEPATH')) exit('No direct script access allowed');



/*
|--------------------------------------------------------------------------
| SITE MODEL CONTROLLER
|--------------------------------------------------------------------------
|
| Nacho birthday Admin Login Model Class
| 
| 
*/

class Admin_login_model extends CI_Model                
{

 private $admin_table = 'admin';   
  
/*  
|--------------------------------------------------------------------------
| Admin Login Model
|--------------------------------------------------------------------------
|
| 
| METHOD : authenticate the admin and retrieve it info   
|
|
*/ 
   function authenticate($email,$password)      
   { 
     $sql = "SELECT id,email,fullname FROM $this->admin_table WHERE email = ? AND password = ? LIMIT 1 ";    
	 $query = $this->db->query($sql,array($email,$password));     
	 
	 if($query->num_rows() ==1)
	 {
	   foreach($query->result_array() as $r)
	   {
	      $data[] = $r;
	   }
	   return $data;    
	 }
 
 } 
   
  
}