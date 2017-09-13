<?php
namespace app\admin\controller;
use app\common\controller\Base;

class Admin extends Base
{
    public function login()
    {
        if (IS_POST){

            $user_name = input('username');
            $password = input('password');

            return $this->success('登录成功',url('/admin/user/index'));
        }
        return $this->fetch();
    }


    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
        $this->redirect(url('/admin/admin/login'));

    }
}
