<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/24
 * Time: 20:11
 */

namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\Setting as SettingModel;

class Setting extends Base
{

    function index(){

        $SettingMd = new SettingModel();
        $rd = $SettingMd->get(array('module'=>'pay'));
        $payment = string2array($rd['setting']);
        $this->assign('meta_title','支付配置');
        $this->assign('data',$payment);
        return $this->fetch();
    }

    function edit(){

        if(IS_POST) {
            $info = input('info/a');
            $data['setting'] = array2string($info,0);
            $data['edittime'] = time();
            $SettingMd = new SettingModel();
            if ($SettingMd->where(array('module' => 'pay'))->update($data)) {
                return $this->success('编辑成功', url('/admin/setting/index'));
            } else {
                return $this->error('编辑失败');
            }
        }
        $SettingMd = new SettingModel();
        $rd = $SettingMd->get(array('module'=>'pay'));
        $payment = string2array($rd['setting']);

        $this->assign('info',$payment);
        return $this->fetch();

    }

}