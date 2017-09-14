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

        $list = $this->acModel->get_activity_list();
        $data = array(
            'list'=>$list,
            'page'=>$list->render()
        );
        $this->assign($data);
        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }

    public function add_activity(){

        if(IS_POST){
            $content = input('content');
            $title = input('title');
            if ($this->acModel->publish($title,$content)){
                return json(array('code'=>1));
            }else{
                return json(array('code'=>0,"message"=>$this->vip->getError()));
            }
        }
        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }


    public function edit_activity(){

        if(IS_POST){
            $content = input('content');
            $title = input('title');
            $id = input('id');

            if ($this->acModel->publish($title,$content,$id)){
                return json(array('code'=>1));
            }else{
                return json(array('code'=>0,"message"=>$this->acModel->getError()));
            }
        }
        $id = input('id');
        $activity = ActivityModel::get(['id'=>$id]);

        if (!$activity){
            return $this->error('活动不存在');
        }else{
            $activity = $activity->toArray();
        }

        $this->assign($activity);
        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }

    public function del_activity(){

        $id = input('id');
        if (!$id){
            return $this->error('参数错误');
        }
        if (!$this->acModel->get(['id'=>$id])){
            return $this->error('该活动不存在');
        }
        if ($this->acModel->where(array('id'=>$id))->delete()){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
}