<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/12
 * Time: 10:09
 */

namespace app\admin\model;
use app\common\model\Base;

class UserModel extends Base
{

    public $table = 'user';



    // 获取用户列表
    /**
     * @param $type   是否是会员
     * 0 => 全部   1=> 普通用户  2=> 会员用户
     */
    public function getUserList($is_vip=0,$order_by=''){

       $map = array();
       switch ($is_vip){
           case 0:
               break;
           case 1:
               $map['is_vip'] = 0;
               break;
           case 2:
               $map['is_vip'] = 1;
               break;

       }
        $list = $this->where($map)
            ->order($order_by)
            ->paginate($this->list_rows,false,array('query'=>array('is_vip'=>$is_vip)));

        return $list;
    }

    /**
     *  获取某个用户的信息
     * @param $id
     * @param $type
     */
     public function getUser($id,$type=0){

         if (!$id){
             $this->error = '参数错误';
             return false;
         }
         $user = $this->get(['id'=>$id]);
         if (!$user){
             $this->error = '用户不存在';
             return false;
         }
         $user = $user->toArray();
         if ($type==1){
             $this->addOtherInfo($user);
         }
         return $user;
     }

     //增加其他信息
     private function addOtherInfo(&$user){
         $user['vip_radio_1'] = ($user['is_vip']==1)?"checked":"";
         $user['vip_radio_2'] = ($user['is_vip']==0)?"checked":"";
         $user['status_radio_1'] = ($user['status']==1)?'checked':"";
         $user['status_radio_2'] = ($user['status']==0)?'checked':"";

     }


}