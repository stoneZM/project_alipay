<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 12:49
 */

namespace app\user\controller;
use app\common\controller\Base;
use app\user\model\AccountModel;

class Account extends Base
{

    public function index()
    {
        $this->assign('meta_title','账户中心');
        return $this->fetch();
    }


    /*
     *  修改密码
     */
    public function modify_pwd(){

        $new_password = base64_decode(input('new_password'));
        $r_new_password = base64_decode(input('r_new_password'));
        $old_password = base64_decode(input('old_password'));

        if ($r_new_password != $new_password){
            return json(array('code'=>0,'message'=>'新密码两次输入不一致!'));
        }
         $user_info = session('user_auth');
         if (!$user_info['uid']){
             return $this->redirect('/login');
         }else{
             $account = new AccountModel();
             if ($account->modify_pwd($user_info['uid'],$old_password,$new_password,$r_new_password)){
                 return json(array('code'=>1));
             }else{
                 return json(array('code'=>0,'message'=>$account->getError()));
             }
         }
    }


}