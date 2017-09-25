<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 14:57
 */

namespace app\user\model;
use app\common\model\Base;
define("EXPIRE_TIME",7200);


class User extends Base
{
    protected $table = 'user';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'reg_time';
    protected $updateTime = '';


    // 验证规则
    protected $rule = array(
        "phone_num"=>'require',
        "password"=>'require',
    );

    //验证信息
    protected $msg = array(
        'phone_num.require'=>'电话号码不能为空',
        'password.require' => '密码不能为空',
    );


    /**
     * 用户登录模型
     */
    public function login($phone_num,$password,$rem_pwd = 0){

        if (!$phone_num || !$password) {
            $this->error = '手机号或密码不能为空';
            return false;
        }
        $user = $this->get(array('phone_num'=>$phone_num));
        if ($user){
            $user = $user->toArray();
        }
        if(is_array($user) && $user['status']){
            /* 验证用户密码 */
            if(md5($password) === $user['password']){
                $this->autoLogin($user); //更新用户登录信息
                if ($rem_pwd==1){
                    cookie('user_id',base64_encode($user['id']),array('expire'=>EXPIRE_TIME,'prefix'=>'remember_'));
                    cookie('user_phone',base64_encode($user['phone_num']),array('expire'=>EXPIRE_TIME,'prefix'=>'remember_'));
                }
                return $user['id']; //登录成功，返回用户ID
            } else {
                $this->error = '密码错误';
                return false; //密码错误
            }
        } else {
            $this->error = '用户不存在或被禁用';
            return false; //用户不存在或被禁用
        }
    }
    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'id'             => $user['id'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => time(),
            'last_login_ip'   => get_client_ip(1),
        );

        $this->where(array('id'=>$user['id']))->update($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'user_name'       => $user['user_name'],
            'last_login_time' => $data['last_login_time'],
            'is_vip' => $user['is_vip'],
            'phone_num'=>$user['phone_num']
        );

        if($user['is_vip'] == 1){
            $vip_info = db('vip_info')->where(array('user_id'=>$user['id']))->find();
            //检查会员是否已到期
            if ($vip_info['expir_time']<time()){
                //取消会员
                $auth['is_vip'] = 0;
                db('user')->where(array('id'=>$user['id']))->update(array('is_vip'=>0));
                db('vip_info')->where(array('user_id'=>$user['id']))->delete();
            }
            $auth['expir_time'] = date('Y年m月d日',$vip_info['expir_time']);
            $auth['begin_time'] = date('Y年m月d日',$vip_info['begin_time']);

        }else{
            $auth['expir_time'] = 0;
            $auth['begin_time'] = 0;
        }
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
    }

    public function reset_password($phone_num,$password)
    {
        $user = $this->get(['phone_num'=>$phone_num]);
        if ($user){
            $data['password'] = md5($password);
            $id = $user->id;
            if ($data['password'] == $user->password){
                return true;
            }
            if ($this->where(array('id'=>$id))->update($data)){
                return true;
            }else{
                $this->error = '密码重置失败';
                return false;
            }
        }else{
            $this->error = '该账号不存在';
            return false;
        }
    }

    public function logout(){

        cookie(null,'remember_');
        session('user_auth', null);
        session('user_auth_sign', null);
    }

}