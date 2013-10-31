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

//user
$route["save/user"] = 'user/save';
$route["fetch/users"] = "user/fetch";
$route["fetch/user/boards/(:any)"] = "user/fetchBoardsForUserId/$1";
$route["fetch/user/(:any)"] = "user/fetchById/$1";
$route["delete/user/(:any)"] = "user/delete/$1";


//board
$route["save/board"] = 'board/saveForUser';
$route["save/board/createTest"] = 'board/saveTest/1';
$route["save/board/updateTest"] = 'board/saveTest/0';
$route["fetch/boards"] = "board/fetch";
$route["fetch/boardTest"] = "board/fetchTest";
$route["delete/board/(:any)"] = "board/delete/$1";
$route["delete/boardDeleteTest"] = "board/deleteTest";

//task
$route["save/task"] = 'task/saveToBoard';
$route["save/task/createTest"] = 'task/saveTest/1';
$route["save/task/updateTest"] = 'task/saveTest/0';
$route["fetch/tasks"] = "task/fetch";
$route["fetch/taskTest"] = "task/fetchTest";
$route["delete/task/(:any)"] = "task/delete/$1";
$route["delete/taskDeleteTest"] = "task/deleteTest";

//lane
$route["save/lane"] = 'user/lane';
$route["save/lane/createTest"] = 'lane/saveTest/1';
$route["save/lane/updateTest"] = 'lane/saveTest/0';
$route["fetch/lanes"] = "lane/fetch";
$route["fetch/laneTest"] = "lane/fetchTest";
$route["delete/lane/(:any)"] = "lane/delete/$1";
$route["delete/laneDeleteTest"] = "lane/deleteTest";

//boards to users
$route["save/boardToUser"] = "user/saveBoardForUser";
$route["save/boardToUserTest"] = "user/saveBoardForUserTest";

//tasks to boards
$route["save/taskToBoard"] = "board/saveTaskForBoard";
$route["save/taskToBoardTest"] = "board/saveTaskForBoardTest";

//test pages
$route["save/user/form"] = "user/form";

$route["jsonForm"] = "jsonTest/jsonForm";

/* End of file routes.php */
/* Location: ./application/config/routes.php */