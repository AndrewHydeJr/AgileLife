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

$route['default_controller'] = "welcome";
$route['404_override'] = '';

//fetch
$route["fetch/users"] = "user/fetch";
$route["fetch/user/boards/(:any)"] = "board/fetchBoardsForUserId/$1";
$route["fetch/user/(:any)"] = "user/fetchById/$1";
$route["fetch/tasks"] = "task/fetch";
$route["fetch/board/tasks/(:any)"] = "task/fetchTasksForuserBoardId/$1";

//save
$route["save/user"] = 'user/save';
$route["save/board"] = 'board/save';
$route["save/task"] = 'task/save';

//delete
$route["delete/user/(:any)"] = "user/delete/$1";
$route["delete/board/(:any)"] = "board/delete/$1";
$route["delete/task/(:any)"] = "task/delete/$1";

//api test
$route["jsonForm"] = "jsonTest/jsonForm";

/* End of file routes.php */
/* Location: ./application/config/routes.php */