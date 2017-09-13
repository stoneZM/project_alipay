<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/10
 * Time: 14:36
 */

namespace app\user\model;
use app\common\model\Base;
use app\user\model\User;


class AccountModel extends Base
{

      public function modify_pwd($uid,$old_pwd,$new_pwd,$r_new_pwd){

        if ($r_new_pwd != $new_pwd){
            $this->error = '新密码两次输入不一致!';
            return false;
        }
        $user = User::get(function($query) use ($uid){
            $query->field('phone_num,password')->where(array('id'=>$uid));
        });



        if ($user&&($user->password!=md5($old_pwd))){
            $this->error = '原密码错误';
            return false;
        }
        if ($user->reset_password($user->phone_num,$new_pwd)){
            return true;
        }else{
            $this->error = $user->getError();
            return false;
        }


    }




}