<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/18
 * Time: 19:41
 */

namespace app\admin\model;
use app\common\model\Base;


class TransModel extends Base
{

    public $table = 'pay_account';

    public function getTransList($has_completed='',$order_by=''){

        $map = array();
        if ($has_completed!==''){
            if ($has_completed==1){
                $map['status'] = 99;
            }
            if ($has_completed===0){
                $map['status'] = 0;
            }
        }
        $list = $this->where($map)
            ->order($order_by)
            ->paginate($this->list_rows);
        return $list;
    }
}