<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 12:40
 */

namespace app\user\controller;
use app\common\controller\Base;
use app\user\model\VipModel;

class Vip extends Base
{

   public function __construct()
   {
       parent::__construct();
       $this->vip = new VipModel();
   }

    public function index(){

        $activity = db('vip_activity')->where(array('status'=>1))->select();

        $this->assign('activity',$activity);
        $this->assign('meta_title','Vip中心');
        return $this->fetch();
    }


}