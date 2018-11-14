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
$route['default_controller'] = 'reg_log/index';
$route['404_override'] = 'errors/index';
$route['error_404'] = 'errors/index';
$route['translate_uri_dashes'] = FALSE;
$route['korisnik/nalog'] = 'users/profile';
// $route['login'] = 'reg_log';
$route['logout'] = 'reg_log/logout';
$route['activate'] = 'reg_log/activate';
$route['reset_password'] = 'reg_log/reset_password_form';
$route['register_by_invite'] = 'reg_log/registration_by_invitation_form';
$route['rezervacije/sastanci/kreiraj/datum'] = 'reservations/meeting_create_by_date';
$route['rezervacije/sastanci/kreiraj/sala'] = 'reservations/meeting_create_by_room';
$route['rezervacije/oprema/kreiraj/datum'] = 'reservations/equipment_create_by_date';
$route['rezervacije/oprema/kreiraj/artikal'] = 'reservations/equipment_create_by_item';
$route['rezervacije/sastanci'] = 'reservations/room_reservations_by_user';
$route['rezervacije/sastanci/(:num)'] = 'reservations/single_room_reservation/$1';
$route['rezervacije/sastanci/izmena/(:num)'] = 'reservations/update_room_reservation_form/$1';
$route['rezervacije/sastanci/brisanje/(:num)'] = 'reservations/delete_room_reservation/$1';
$route['rezervacije/oprema'] = 'reservations/equipment_reservations_by_user';
$route['rezervacije/oprema/(:num)'] = 'reservations/single_equipment_reservation/$1';
$route['rezervacije/oprema/brisanje/(:num)'] = 'reservations/delete_equipment_reservation/$1';
$route['rezervacije/oprema/izmena/(:num)'] = 'reservations/show_update_equip_form/$1';
$route['admin/panel'] = 'admin';
$route['admin/rezervacije/sastanci'] ='admin/meetings';
$route['admin/rezervacije/oprema'] ='admin/equipment';
$route['admin/sastanci/sale'] = 'admin/conference_rooms';
$route['admin/oprema/artikli'] = 'admin/items';
$route['admin/oprema/vrste'] = 'admin/types';
$route['admin/korisnici/lista'] = 'admin/users';
$route['admin/korisnici/aktivnosti'] = 'admin/activities';
$route['admin/logovi'] = 'admin/logs';
$route['welcome'] = 'test';
