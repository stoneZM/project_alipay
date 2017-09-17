<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 12:54
 */

namespace app\user\controller;
use app\user\model\MemberModel;
use app\common\controller\Base;
use app\user\model\User;

class Member extends Base
{
    public function index(){

        //为了支付 异步通知跳转，重新设置session的会员信息
        self::reset_session();
        $user_auth = session('user_auth');
        $this->assign('is_vip',$user_auth['is_vip']);
        $this->assign('expir_time',$user_auth['expir_time']);
        $this->assign('meta_title','会员中心');
        return $this->fetch();
    }



    function pay(){


        return $this->fetch();
    }

    //注册会员或续费
    public function manage(){

        $vip_price = db('vip_price')->where(array('status'=>1))->order('sort desc')->select();

        //生成一个订单号
        $order_no = date("YmdHis").random();

        $this->assign('order_no',$order_no);
        $this->assign('vip_price',$vip_price);
        $this->assign('meta_title','注册或续费');
        return $this->fetch();
    }

    static public function reset_session(){

        $user_session_info= session('user_auth');
        $uid = $user_session_info['uid'];
        $vip_info = db('vip_info')->where(array('user_id'=>$uid))->find();
        $user_db_info = User::get(['id'=>$uid]);
        if ($vip_info||$user_db_info->is_vip==1){
            $data['is_vip'] = $user_db_info->is_vip;
            $data['expir_time'] = $vip_info['expir_time'];
            MemberModel::update_user_auth_session($data);
        }elseif($user_db_info->is_vip!=1){
            $data['is_vip'] = 0;
            MemberModel::update_user_auth_session($data);
        }
    }


}