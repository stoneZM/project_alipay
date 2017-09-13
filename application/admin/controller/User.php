<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/11
 * Time: 23:54
 */

namespace app\admin\controller;
use app\admin\model\UserModel;
use app\common\controller\Base;

class User extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->user_model = new UserModel();
    }

    public function index(){

        $is_vip = base64_decode(input('is_vip'))?:0;
        $user_list = $this->user_model->getUserList($is_vip);
       
        $data = array(
            'user_list' => $user_list,
            'page' => $user_list->render()
        )  ;
        $select_str['select_0'] = ($is_vip==0)?'selected="selected"':'';
        $select_str['select_1'] = ($is_vip==1)?'selected="selected"':"";
        $select_str['select_2'] = ($is_vip==2)?'selected="selected"':"";

        $this->assign($data);
        $this->assign($select_str);
        $this->assign('meta_title','用户列表');
        return $this->fetch();
    }

    public function manage(){

        if(IS_POST){
            return ;
        }
        $id = input('id');
        if (!$id){
            return $this->error('参数错误');
        }
        $user = $this->user_model->getUser($id,1);
        if (!$user){
            return $this->error($this->user_model->getError());
        }

        $this->assign($user);
        $this->assign('meta_title','用户管理');
        return $this->fetch();
    }

}