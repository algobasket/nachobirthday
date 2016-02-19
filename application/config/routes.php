<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

 // ----------- Client Reference URL -------------
 
$route['index']              = 'auth/index';  
$route['signin']             = 'auth/login'; 
$route['send-again']         = 'auth/send_again/';    
$route['login']              = 'auth/login';  
$route['logout']             = 'auth/logout'; 
$route['account/security']   = 'auth/change_password'; 
$route['signup']             = 'auth/register';   
$route['pre-campaign']       = 'pre_campaign/index';
$route['new-campaign']       = 'new_campaign/index'; 
$route['login/pre-campaign'] = 'auth/login/pre_campaign'; 
$route['login/new-campaign'] = 'auth/login/new_campaign'; 
$route['signin/redirect_campaign/campaign/id/(:num)'] = 'auth/login/redirect_campaign/campaign/id/$1';               
$route['activate']             = "auth/activate";      
$route['search-campaign-list/(:any)'] = "campaign/see_all_campaign";
$route['activate/(:any)']             = "auth/activate/(:any)";
$route['reset_email/(:any)']          = "auth/reset_email/(:any)";
$route['reset_password/(:any)']       = "auth/reset_password/(:any)";   
$route['default_controller']          = "auth"; 
$route['faq']                         = "welcome/faq";
$route['term-and-condition']          = "welcome/term_and_condition"; 
$route['how-it-works']                = "welcome/how_it_works"; 
$route['contact-us']                  = "welcome/contact_us";
$route['about-us']                    = "welcome/about_us";
$route['faq']                         = "welcome/faq";   
$route['404_override'] = '';


// ----------- Admin Reference URL -------------
$route['admin/other_login']                 = 'admin/other-login';
$route['admincampaign/new-campaign']        = 'admin_campaign/new_campaign';       
$route['admin/newgroup_other_user_profile'] = 'admin/newgroup-other-user-profile';  
$route['admin']                             = 'admin_login';    
//$route['default_controller'] = "auth";
//$route['default_controller'] = "auth";
//$route['default_controller'] = "auth"; 

/* End of file routes.php */
/* Location: ./application/config/routes.php */