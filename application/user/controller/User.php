<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 12:31
 */

namespace app\user\controller;
use app\common\controller\Base;
use think\Session;

class User extends Base
{
    public function index(){

        $this->assign('meta_title','用户中心');
        return $this->fetch();
    }

}