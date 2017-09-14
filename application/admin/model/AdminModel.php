<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/13
 * Time: 21:41
 */

namespace app\admin\model;
use app\common\model\Base;

class AdminModel extends Base
{


    protected $table = 'admin';

    /**
     * 用户登录
     */
    public function login($user_name,$password){

        if (!$user_name || !$password) {
            $this->error = '用户名或密码不能为空';
            return false;
        }
        $user = $this->get(array('username'=>$user_name));
        if ($user){
            $user = $user->toArray();
        }
        if(is_array($user) && $user['status']){
            /* 验证用户密码 */
            if(md5($password) === $user['password']){
                $this->autoLogin($user); //更新用户登录信息
                return $user['id']; //登录成功，返回用户ID
            } else {
                $this->error = '密码错误';
                return false; //密码错误
            }
        } else {
            $this->error = '用户不存在或被禁用';
            return false; //用户不存在或被禁用
        }
    }

    private function autoLogin($user){


        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'last_login_time' => time(),
        );

        session('admin_auth', $auth);
        session('admin_auth_sign', data_auth_sign($auth));
    }


    public function logout(){

        session('admin_auth', null);
        session('admin_auth_sign', null);

    }
}