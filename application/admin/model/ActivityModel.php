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

    public function publish($content){

        $user_info = session('user_auth');
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
        if ($this->save($data)){
            return true;
        }else{
            $this->error = '发布失败';
            return false;
        }
    }

}