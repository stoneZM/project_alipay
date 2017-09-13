<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 10:30
 */

namespace app\user\controller;
use app\common\controller\Base;

class Index extends Base
{

    public function nav1(){

        $this->assign('meta_title','nav1');
        return $this->fetch();
    }


    public function nav2(){

        $this->assign('meta_title','nav2');
        return $this->fetch();
    }


    public function nav3(){

        $this->assign('meta_title','nav3');
        return $this->fetch();
    }
}