<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/12
 * Time: 00:11
 */

namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\ActivityModel;

class Activity extends Base
{

    function __construct()
    {
        parent::__construct();
        $this->acModel = new ActivityModel();
    }

    public function index(){

        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }

    public function add_activity(){

        if(IS_POST){
            $content = input('content');
            if ($this->acModel->publish($content)){
                return json(array('code'=>1));
            }else{
                return json(array('code'=>0,"message"=>$this->vip->getError()));
            }
        }
        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }
}