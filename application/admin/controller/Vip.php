<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/13
 * Time: 18:01
 */

namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\VipModel;

class Vip extends Base
{


    function __construct()
    {
        parent::__construct();
        $this->vip = new VipModel();
    }

    public function index(){

        $list = $this->vip->getList();

        $this->assign($list);

        $this->assign('meta_title','会员价格列表');
        return $this->fetch();
    }


    public function manage(){

        $id = input('id');
        if(IS_POST){

            $data['price'] = input('price')?:-1;
//            $data['desc'] = trim(input('desc'));
            $data['status'] = input('status');
            $data['is_recommend'] = input('is_recommend');
            $data['month'] = input('month')?:-1;
            if ($data['month']==-1){
                $this->error('总月份不能为空');
            }
            if ($data['price']==-1){
                $this->error('总价钱不能为空');
            }

            $data['sort'] = input('sort');
            $data['desc'] = $data['month'].'个月'.$data['price'].'元';

            if ($id){ //更新
                if($this->vip->where(array('id'=>$id))->update($data)){
                    return $this->success('修改成功',url('/admin/vip/index'));
                }
            }else{
                if ($this->vip->save($data)){
                    return $this->success('新增成功',url('/admin/vip/index'));
                }
            }
            $err_tip_str = $id?"修改失败":"修改成功";
            return $this->error($err_tip_str);
        }

        $vip_price = VipModel::get(['id'=>$id]);
        if ($vip_price)
            $vip_price = $vip_price->toArray();

        $this->vip->addOtherInfo($vip_price);
        $meta = $id?"修改价格":"新增价格";
        $this->assign('meta_title',$meta);
        $this->assign("vip_price",$vip_price);

        return $this->fetch('manage');
    }

    public function del(){

        $id = input('id');
        if (!$id){
            return $this->error('参数错误');
        }
        if (!$this->vip->get(['id'=>$id])){
            return $this->error('记录不存在');
        }
        if ($this->vip->where(array('id'=>$id))->delete()){
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败');
        }
    }
}