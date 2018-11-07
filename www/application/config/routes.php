<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['error_404'] = 'errors/index';
$route['translate_uri_dashes'] = FALSE;
$route['profile'] = 'users/profile';
$route['login'] = 'reg_log';
$route['logout'] = 'reg_log/logout';
$route['activate'] = 'reg_log/activate';
$route['reset_password'] = 'reg_log/reset_password_form';
$route['register_by_invite'] = 'reg_log/registration_by_invitation_form';
$route['reservations/create'] = 'reservations/create_reservation';
$route['reservations/meeting/create_by_date'] = 'reservations/meeting_create_by_date';
$route['reservations/meeting/create_by_room'] = 'reservations/meeting_create_by_room';
$route['reservations/equipment/create_by_date'] = 'reservations/equipment_create_by_date';
$route['reservations/equipment/create_by_item'] = 'reservations/equipment_create_by_item';
$route['reservations/meetings'] = 'reservations/room_reservations_by_user';
$route['reservations/meetings/(:num)'] = 'reservations/single_room_reservation/$1';
$route['reservations/meetings/edit/(:num)'] = 'reservations/update_room_reservation_form/$1';
$route['reservations/meetings/delete/(:num)'] = 'reservations/delete_room_reservation/$1';
$route['reservations/equipment'] = 'reservations/equipment_reservations_by_user';
$route['reservations/equipment/(:num)'] = 'reservations/single_equipment_reservation/$1';
$route['reservations/equipment/delete/(:num)'] = 'reservations/delete_equipment_reservation/$1';
$route['reservations/equipment/update/(:num)'] = 'reservations/show_update_equip_form/$1';
$route['welcome'] = 'test';
