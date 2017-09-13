<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return array(

    '__domain__'=>array(
        'm'       =>  'mobile',
    ),


    '__pattern__'    => array(
        'name' => '\w+',
    ),

    'login'          => 'user/login/login',
    'register'       => 'user/login/reg',
    'logout'         => 'user/login/logout',
    'reset'          => 'user/login/reset_pwd',
    'get_code'       => 'user/login/get_phone_code',
    'verify_code'    => 'user/login/verify_code',
    'modify_pwd'     => 'user/account/modify_pwd',
    'admin/login'    =>  'admin/admin/login',
//    'publish'        => 'admin/activity/publish',
);