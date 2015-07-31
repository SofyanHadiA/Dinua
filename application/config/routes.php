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
$route['default_controller']    = 'userpage';
$route['index']                 = 'userpage/loginPage';
$route['info']                  = 'userpage/infoPage';
$route['mywall']                = 'userpage/wallPage';
$route['wall/friend']           = 'userpage/wallPage';

$route['theworld']              = 'userpage/worldPage';

$route['friend/delete']         = 'friend/deleteFriend';
$route['friend/request']        = 'friend/requestFriend';
$route['friend/request/acc']    = 'friend/accRequestFriend';
$route['friend/request/ignore'] = 'friend/ignoreRequestFriend';

$route['search']                = 'friend/findFriend';

$route['profile']               = 'userpage/profilePage';
$route['profile/save']          = 'profile/setProfile';
$route['profile/setavatar']     = 'profile/setPhotoProfile';

$route['profile/startedit']     = 'profile/editProfile';

$route['friend/online']         = 'friend/getOnlineFriends';

$route['user/getdata']          = 'user/getOnlineUserData';

$route['chat/send']             = 'message/sendChat';
$route['chat/check']            = 'message/checkNewChat';
$route['chat/get']              = 'message/getChatNew';
$route['chat/get/history']      = 'message/getChatHistory';
$route['message']               = 'userpage/messagePage';
$route['message/get']           = 'message/getMessage';

$route['album/add']             = 'album/addAlbum';
$route['album/edit']            = 'album/editAlbum';
$route['album/delete']          = 'album/deleteAlbum';

$route['photo']                 = 'userpage/albumPage';
$route['photo/show/:num']       = 'userpage/contentPage';
$route['photo/show/:num/:num']  = 'userpage/contentPage';
$route['photo/getlist']         = 'album/getContentList';

$route['ebook']                 = 'userpage/albumPage';
$route['ebook/show/:num']       = 'userpage/contentPage';
$route['ebook/show/:num/:num']  = 'userpage/contentPage';
$route['ebook/getlist']         = 'album/getContentList';

$route['note']                 = 'userpage/albumPage';
$route['note/show/:num']       = 'userpage/contentPage';
$route['note/show/:num/:num']  = 'userpage/contentPage';
$route['note/save']            = 'note/Add';
$route['note/getlist']         = 'album/getContentList';

$route['login']                 = 'login';
$route['logout']                = 'login/logout';

$route['signup']                = 'signup';
$route['verify']                = 'signup/verify';

$route['remember_password']     = 'signup/forgetPassword';

$route['password_reset']     = 'signup/resetPassword';

$route['updatestatus']          = 'status/setStatus';
$route['status/getnew']         = 'status/getNewStatus';
$route['status/get']            = 'status/getStatus';
$route['status/get/:num']       = 'status/getStatus';
$route['status/delete']         = 'status/deleteStatus';

$route['status/get/world/:num']      = 'status/getWorldStatus';

$route['like/add']              = 'like/setLike';
$route['like/get/:any']         = 'like/getLike';

$route['comment/add']           = 'comment/setComment';
$route['comment/get']           = 'comment/getComment';
$route['comment/get/:any']      = 'comment/getComment';

$route['comment/delete']        = 'comment/deleteComment';

$route['report/add']            = 'report/addReport';

$route['photo/add']             = 'photo/add';
$route['ebook/add']             = 'ebook/add';

$route['notify']               = 'notify/getAllNotify';

$route['404_override'] = '';


// Admin
$route['admin/login']             = 'admin/adminlogin/login';
//-------------

/* End of file routes.php */
/* Location: ./application/config/routes.php */