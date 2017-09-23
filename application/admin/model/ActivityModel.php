<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/11
 * Time: 21:36
 */

namespace app\admin\model;
use app\common\model\Base;

class ActivityModel extends Base
{

    protected $table = 'vip_activity';
    protected $createTime = 'create_time';
    protected $updateTime = '';


    public function get_activity_list($map=array(),$order_by=''){

        $_field = array('vip_activity.id','vip_activity.content','vip_activity.title','vip_activity.create_time','vip_activity.status','admin.username');
        $list = $this->where($map)
            ->join('admin',"vip_activity.user_id=admin.id",'left')
            ->field($_field)
            ->order($order_by)
            ->paginate($this->list_rows,false,array('path'=>url('/admin/activity/index')));
        return $list;
    }


    public function publish($title,$content,$id=0){

        $user_info = session('admin_auth');
        if (!$user_info&&!$user_info['uid']){
            $this->error = '请登录后在进行操作';
            return false;
        }
        $data['user_id'] = $user_info['uid'];
        if(!$content){
            $this->error = '内容不能为空';
            return false;
        }
        $data['content'] = $content;
        $data['title'] = $title;

        if($id !== 0){

           if($this->where(array('id'=>$id))->update($data)){
               return true;
           }

        }else{
            if ($this->save($data)) {
                return true;
            }
        }
         return false;
    }



}