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

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['company_add'] = "home/company_add";
$route['register'] = "home/register";
$route['dashboard'] = "home/dashboard";
$route['roles'] = "home/roles";
$route['employee'] = "home/employee";
$route['employee_add'] = "home/employee_add";
$route['employee_add/edit/(:any)'] = "home/employee_add/edit/$1";
$route['add_roles'] = "home/add_roles";
$route['employee'] = "home/employee";
$route['employee_add'] = "home/employee_add";
$route['employee_add/edit/(:any)'] = "home/employee_add/edit/$1";
$route['customers'] = "home/customers";
$route['customer_add/edit/(:any)'] = "home/customer_add/edit/$1";
$route['customer_enquiry'] = "home/customer_enquiry";
$route['customer_enquiry/cust/(:any)'] = "home/customer_enquiry/cust/$1";
$route['customer_enquiry/emp/(:any)'] = "home/customer_enquiry/emp/$1";
$route['customer_enquiry/(:any)'] = "home/customer_enquiry/$1";
$route['customer_enquiry_add'] = "home/customer_enquiry_add";
$route['customer_enquiry_add/(:any)'] = "home/customer_enquiry_add/$1";
$route['profile/customer/(:any)'] = "home/profile/customer/$1";
$route['profile/emp/(:any)'] = "home/profile/emp/$1";
$route['tracking'] = "home/tracking";
$route['services'] = "home/services";
$route['services/(:any)'] = "home/services/$1";
$route['services/filter/(:any)'] = "home/services/filter/$1";
$route['services/(:any)/invoice_print'] = "home/services/(:any)/invoice_print";
$route['service_add'] = "home/service_add";
$route['service_add/(:any)'] = "home/service_add/$1";
$route['trip_add'] = "home/trip_add";
$route['trips'] = "home/trips";
$route['expenses_add'] = "home/expenses_add";
$route['expenses'] = "home/expenses";
$route['vehicle_add'] = "home/vehicle_add";
$route['vehicle'] = "home/vehicle";
$route['incomes'] = "home/incomes";
// $route['get_modules'] = "home/get_modules";
$route['login'] = "home/login";
$route['logout'] = "home/logout";



/* End of file routes.php */
/* Location: ./application/config/routes.php */