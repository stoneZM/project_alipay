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
    public function mem_manage($member_type){

        $user_info = session('user_auth');
        if (!$user_info&&!$user_info['uid']){
            $this->error = '请登录后在进行操作';
            return false;
        }
        $uid = $user_info['uid'];
        $vip_model = db('vip_info');
        $vip_info = $vip_model->where(array('user_id'=>$uid))->find();
        // 续费会员
        if ($vip_info){

            $expir_time = $vip_info['expir_time'];
            $data['expir_time'] = self::get_member_expir_time($expir_time,$member_type);

            if($vip_model->where(array('user_id'=>$uid))->update($data)){
                //更新session
                self::update_user_auth_session($data);
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
                self::update_user_auth_session(array('expir_time'=>$data['expir_time'],'is_vip'=>1));
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



}