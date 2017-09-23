<?php
namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\AdminModel;
use think\Cookie;

class Admin extends Base
{

    function __construct()
    {
        parent::__construct();
        $this->admin = new AdminModel();
    }

    public function login()
    {
        if (IS_POST){
            $user_name = input('username');
            $password = input('password');
            if ($this->admin ->login($user_name,$password)){
                return json(array('code'=>1,'message'=>'登录成功'));
            }else{
                return json(array('code'=>0,'message'=>$this->admin->getError()));
            }
        }
        return $this->fetch();
    }


    public function logout(){
        $this->admin ->logout();
        $this->redirect(url('/admin/login'));
    }
}
