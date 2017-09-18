<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/18
 * Time: 19:40
 */

namespace app\admin\controller;
use app\admin\model\TransModel;
use app\common\controller\Base;
use app\common\controller\Excel;

class Trans extends Base
{

    public function __construct()
    {
        parent::__construct();
        $this->trans = new TransModel();
    }

    public function index(){

//        $has_completed = input('status');
//        if ($has_completed == -1)
        $has_completed = '';
        $trans = $this->trans->getTransList($has_completed);
        $data = array(
            'list'=>$trans,
            'page'=>$trans->render()
        );
        $this->assign($data);
        $this->assign('meta_title','活动列表');
        return $this->fetch();
    }

    public function get_trade(){

        $phone_num = input('phone_num');
        $trade = TransModel::all(['telephone'=>$phone_num]);
        if ($trade){
            $trade = $trade->toArray();
            foreach ($trade as $key=>&$value){
                $value['edittime'] = date('Y-m-d H:i:s', $value['edittime'] );
            }
            return json(array('code'=>1,'data'=>$trade));
        }else{
            return json(array('code'=>0));
        }
    }

    public function export_excel(){

        $data = TransModel::all();
        if ($data){
            $data = $data->toArray();
        }
        $sheet_title = '交易记录表格';
        $col_title = array('A1'=>'交易编号','B1'=>'交易手机号','C1'=>'交易订单号','D1'=>'支付方式','E1'=>'支付金额','F1'=>'商品内容','G1'=>'交易状态','H1'=>'交易开始时间','I1'=>'交易结束时间');
        $col_width = array("A"=>'10',"B"=>'15',"C"=>'45',"D"=>'13',"E"=>'10',"F"=>'18',"G"=>'10',"H"=>'15',"I"=>'15');

        Excel::export_trans_excel($sheet_title,$col_title,$col_width,$data);
    }

}