<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/13
 * Time: 18:02
 */

namespace app\admin\model;
use app\common\model\Base;

class VipModel extends Base
{
    protected $table = 'vip_price';
    protected $createTime = 'create_time';
    protected $updateTime = '';


    //增加其他信息
    public function addOtherInfo(&$info){

        if (!$info){
            $info['id'] = '';
            $info['title'] = '';
            $info['desc'] = '';
            $info['price'] = '';
            $info['month'] = '';
            $info['sort'] = '';
        }
        $info['status_on'] = (!array_key_exists('status',$info) || $info['status']==1) ? "checked":"";
        $info['status_off'] = ($info['status_on'] ) ? "":"checked";
        $info['recommend_on'] = (!array_key_exists('is_recommend',$info) || $info['is_recommend']==1 ) ? 'checked':"";
        $info['recommend_off'] = ( $info['recommend_on']) ? '':"checked";

    }

}