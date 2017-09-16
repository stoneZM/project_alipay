<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/10
 * Time: 17:56
 */

namespace app\user\model;
use app\user\model\User;
use app\common\model\Base;
use think\Db;


class MemberModel extends Base
{

    // 会员开通或续费
    public function mem_manage($member_type,$uid=0,$is_async=false){

        $user_info = session('user_auth');

        if ($is_async||!$user_info&&$uid){
            $user_info = User::get(['id'=>$uid])->toArray();
            $uid = $user_info['id'];
        }else{
            $uid = $user_info['uid'];
        }

        $vip_model = db('vip_info');
        $vip_info = $vip_model->where(array('user_id'=>$uid))->find();
        // 续费会员
        if ($vip_info){

            $expir_time = $vip_info['expir_time'];
            $data['expir_time'] = self::get_member_expir_time($expir_time,$member_type);

            if($vip_model->where(array('user_id'=>$uid))->update($data)){
                //更新session
                if (!$is_async){
                    self::update_user_auth_session($data);
                }
                // 发送短信消息
                \org\Smsbao::send($user_info['phone_num'],2,$member_type);
                return true;
            }else{
                $this->error = '续费失败，请联系客服人员!';
                return false;
            }
        }else{  // 开通会员

            $data['user_id'] = $uid;
            $data['begin_time'] = time();
            $data['expir_time'] = self::get_member_expir_time($data['begin_time'],$member_type);
            if($vip_model->insert($data)){
                if (!$is_async){
                    self::update_user_auth_session(array('expir_time'=>$data['expir_time'],'is_vip'=>1));
                }
                $user_update_field['is_vip'] = 1;
                db('user')->where(array('id'=>$uid))->update($user_update_field);
                \org\Smsbao::send($user_info['phone_num'],2,$member_type);
                return true;
            }else{
                $this->error = '会员开通失败，请联系客服人员!';
                return false;
            }
        }

    }

    /*
     *  更改会员时间
     * +3 month
     */
    static function get_member_expir_time($origin_time,$duration){

        $time_str = "+".$duration." month";
        $expir_time = strtotime($time_str,$origin_time);
        return $expir_time;

    }


    //根据选择的会员类型获取响应的会员价格与月份
    static function get_vip_info($id,$field_name){

        $vip_info = db('vip_price')->field($field_name)->where(array('id'=>$id))->find();
        if (!$vip_info){
            exit('请选择正确的会员类型');
        }else{
            return $vip_info[$field_name];
        }
    }



}