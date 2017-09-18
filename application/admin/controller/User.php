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
use app\common\controller\Excel;

define('USER_MAN_BACK_PARAMS','USERMANBACKPARAMS');

class User extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->user_model = new UserModel();
    }

    public function index(){

        $is_vip = input('is_vip')?:0;
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
        $params['is_vip'] =  $is_vip;
        $params['page'] = array_key_exists('page',$_REQUEST)?$_REQUEST['page']:1;
        cookie(USER_MAN_BACK_PARAMS,json_encode($params));
        return $this->fetch();
    }

    public function manage(){

        if(IS_POST){
            $id = input('id');
            $data['phone_num'] = input('phone_num');
            $password = input('password');
            if ($password){
                $data['password'] = md5($password);
            }
            $data['status'] = input('status');
            $data['is_vip'] = input('is_vip');

            $user_exist  = $this->user_model->where(array('id'=>$id))->count();
            if (!$user_exist){
                return $this->error('用户不存在');
            }
            //检查手机号是否存在
            $map['phone_num'] = array('eq',$data['phone_num']);
            $map['id'] = array('neq',$id);
            $phone_exist = $this->user_model->where($map)->count();
            if ($phone_exist){
                return $this->error('手机号已存在');
            }
            if($this->user_model->where(array('id'=>$id))->update($data)){
                $back_params = json_decode(cookie(USER_MAN_BACK_PARAMS),true);

                return $this->success('编辑成功',url('/admin/user/index',$back_params));
            }else{
                return $this->error('编辑失败');
            }
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

    public function get_user(){

        $phone_num = input('phone_num');
        $user = UserModel::get(['phone_num'=>$phone_num]);
        if ($user){
            $user = $user->toArray();
            $user['reg_time'] = date('Y-m-d H:m:i',$user['reg_time']);
            return json(array('code'=>1,'data'=>$user));
        }else{
            return json(array('code'=>0));
        }
    }


    // 导出用户表
    public function export_excel(){

        $type = input('export_type');
        if ($type == 'is_vip'){
            $data = UserModel::all(['is_vip'=>1]);
            $sheel_title = '会员用户列表';
        }else if($type == 'not_vip'){
            $sheel_title = '普通用户列表';
            $data = UserModel::all(['is_vip'=>0]);
        }else{
            $sheel_title = '全部用户';
            $data = UserModel::all();
        }
        if ($data){
            $vip_info = db('vip_info');
            $data = $data->toArray();
            foreach ($data as $key=>&$value){
                $info = $vip_info->where(array('user_id'=>$value['id']))->column('expir_time');
                if ($info){
                    $value['vip_expire_time'] = date('Y-m-d',current($info));
                }else{
                    $value['vip_expire_time'] = "- -";
                }
                $value['is_vip'] = $value['is_vip']?"是":"否";
                $value['reg_time'] = date('Y-m-d',$value['reg_time']);
            }
        }

        $col_titles = array('A1'=>'用户编号',"B1"=>'手机号',"C1"=>"是否为会员" ,"D1"=>'会员到期时间',"E1"=>'用户注册时间');
        $col_width = array('A'=>10,"B"=>20,"C"=>10,"D"=>15,"E"=>15);

        Excel::export_excel($sheel_title,$col_titles,$col_width,$data);
        return $this->success('导出成功');

    }

}