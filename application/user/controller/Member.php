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

class Member extends Base
{
    public function index(){
        $this->assign('meta_title','会员中心');
        return $this->fetch();
    }


    //注册会员或续费
    public function manage(){

//        if(IS_POST){
//            $price = db('vip_price')->where(array('status'=>1))->column('price','month');
//            $member_type = base64_decode(input('member_type'));
//            if (!array_key_exists($member_type,$price)){
//                return json(array('code'=>0,'message'=>'选择的类型不正确'));
//            }
//            $money = $price[$member_type];
//            if(true){
//                $mem_model = new MemberModel();
//               if($mem_model->mem_manage($member_type)){
//                   return json(array('code'=>1,'message'=>'操作成功'));
//               }else{}
//                return json(array('code'=>0,'message'=>$mem_model->getError()));
//            }
//        }
        $vip_price = db('vip_price')->where(array('status'=>1))->order('sort desc')->select();

        //生成一个订单号
        $order_no = date("YmdHis").random();

        $this->assign('order_no',$order_no);
        $this->assign('vip_price',$vip_price);
        $this->assign('meta_title','注册或续费');
        return $this->fetch();
    }



}