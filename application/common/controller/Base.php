<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/7
 * Time: 19:55
 */


namespace app\common\controller;
use \think\Request;
use think\Session;
define('LOGIN',"LOGONFLAG");


class Base extends \think\Controller {

    protected $url;
    protected $request;
    protected $module;
    protected $controller;
    protected $action;

    public function _initialize() {
        //获取request信息
        $this->requestInfo();
        //免登录行为

        if (no_login($this->url)){
            return;
        }
        if (!is_login() && !in_array($this->url, array('user/login/login', 'user/login/logout'))) {
            $this->redirect('/login');
        }

        $user_auth = session('user_auth');
        $this->assign('is_vip',$user_auth['is_vip']);
        $this->assign('expir_time',$user_auth['expir_time']);

    }

    //request信息
    protected function requestInfo() {
        $this->param = $this->request->param();
        defined('MODULE_NAME') or define('MODULE_NAME', $this->request->module());
        defined('CONTROLLER_NAME') or define('CONTROLLER_NAME', $this->request->controller());
        defined('ACTION_NAME') or define('ACTION_NAME', $this->request->action());
        defined('IS_POST') or define('IS_POST', $this->request->isPost());
        defined('IS_GET') or define('IS_GET', $this->request->isGet());
        $this->url = strtolower($this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action());
        $this->assign('request', $this->request);
        $this->assign('param', $this->param);
    }

    /**
     * 获取单个参数的数组形式
     */
    protected function getArrayParam($param) {
        if (isset($this->param['id'])) {
            return array_unique((array) $this->param[$param]);
        } else {
            return array();
        }
    }


    /**
     * 验证码
     * @param  integer $id 验证码ID
     */
    public function verify($id = 1) {
        $verify = new \org\Verify(array('length' => 4));
        $verify->entry($id);
    }

    /**
     * 检测验证码
     * @param  integer $id 验证码ID
     * @return boolean     检测结果
     */
    public function checkVerify($code, $id = 1) {
        if ($code) {
            $verify = new \org\Verify();
            $result = $verify->check($code, $id);
            if (!$result) {
                return $this->error('验证码错误');
            }
        } else {
            return $this->error("验证码不能为空");
        }
    }



    public function checkPhoneCode($code,$phoneNum){

        $save_code = Session::get($phoneNum);
        if ($code != $save_code){
            Session::delete($phoneNum);
            $this->error('手机验证码错误');
        }
    }

    public function verify_code(){

        $code = base64_decode(input('code'));
        // 1: 图片验证码
//        2：手机验证码
        $code_type = base64_decode(input('type'));
        if ($code_type == 1){
            $verify = new \org\Verify();
            $result = $verify->check($code, 1);
            if ($result){
                return json(array('code'=>1,'message'=>'验证成功'));
            }else{
                return json(array('code'=>0,'message'=>'验证码错误'));
            }
        }else{
            $phoneNum = base64_decode(input('phone_num'));
            $save_code = Session::get($phoneNum);
            if ($code == $save_code){
                return json(array('code'=>1,'message'=>'验证成功'));
            }else{
                return json(array('code'=>0,'message'=>'验证码错误'));
            }
        }
    }
}
