<?php
/**
 * 支付模型类
 * @Author: 云的缔造者
 * @Date: 2017/6/15
 * @email: 736383301@qq.com
 */
namespace app\pay\model;
use think\Model;
//include_once ROOT_PATH.'vendor/payment/alipay.php';

class PayAccount extends Model
{
    /**
     * @Description: 微信配置项
     * @return  string
     */
    public function _weixin_config(){
        vendor('payment.WxPay_Api');
    }

    public function _alipay_config(){
         vendor('payment.alipay');
    }

    /**
     * 支付宝生成支付代码
     * @param   array   $order      订单业务信息
     * @param   array   $paycode    支付类型
     * @param   array   $model      模块
     */
    function getAlipay($payConfigArry, $order, $paycode, $model)
    {
        $this->_alipay_config();
       
        $parameters = [
            "service"       	=> $payConfigArry['alipay_service'],
            "partner"       	=> $payConfigArry['alipay_partner'],
            "seller_id"  		=> $payConfigArry['alipay_seller_id'],
            "payment_type"		=> $payConfigArry['payment_type'], //支付类型 //必填，不能修改
            "notify_url"		=> $payConfigArry['alipay_notify_url'],
            "return_url"		=> $payConfigArry['alipay_return_url'],
            "anti_phishing_key"	=> $payConfigArry['alipay_key'],
            "exter_invoke_ip"	=> $payConfigArry['exter_invoke_ip'],
            "out_trade_no"		=> $order['tradeSn'],
            "subject"			=> $order['subject'],
            "total_fee"			=> $order['totalmMoney'],
            "body"				=> $order['body'],
            "_input_charset"	=> $payConfigArry['input_charset'],
            'seller_email'      => $payConfigArry['alipay_seller_email']
        ];
        $info = $this->getPayAccountId($order['tradeSn']);
        if(!$info){
            $this->module = $model;
            $this->userid = $order['userId'];
            $this->username = $order['username'];
            $this->month = $order['month'];
            $this->trade_sn = $order['tradeSn'];
            $this->contactname = $order['subject'];
            $this->email       = $order['email'];
            $this->seller_id   = $payConfigArry['alipay_seller_id'];
            $this->seller_email= $payConfigArry['alipay_seller_email'];
            $this->telephone   = $order['telephone'];
            $this->totalMoney  = $order['totalmMoney'];
            $this->num         = $order['num'];
            $this->addtime     = time();
            $this->pay_type    = $paycode; //操作类型 weixin alipay unpay
            $this->pay_ment     = '支付宝支付';
            $this->payment_type = $payConfigArry['payment_type']; //支付类型 1
            $this->ip           = $payConfigArry['exter_invoke_ip'];
            $this->status       = 0;  //0：刚刚提交支付  -1：删除   99：最终支付成功
            $this->trade_type = $order['tradeType'];   // 1: 续费 0：开通会员

            $this->save();
        }

        $alipaySubmit = new \AlipaySubmit($payConfigArry);
        return ['code'=>1,'msg'=>$alipaySubmit->buildRequestForm($parameters,"get", "确认")];
    }

    /**
     * @Description: 微信生成支付代码
     * @return  string
     */
    public function getWxpay($wxpayConfigArry, $data, $paycode, $model)
    {

        $this->_weixin_config();
        $info = $this->getPayAccountId($data['out_trade_no']);
        if(!$info){
            $this->module = $model;
            $this->userid = $data['userId'];
            $this->username = $data['username'];
            $this->trade_sn = $data['out_trade_no'];
            $this->contactname = $data['attach'];
            $this->email       = $data['email'];
            $this->wxpay_appid = $wxpayConfigArry['wxpay_appid'];
            $this->trade_type  = $data['trade_type'];//
            $this->telephone   = $data['telephone'];
            $this->totalMoney  = $data['total_fee']/100;
            $this->num         = $data['num'];
            $this->addtime     = time();
            $this->pay_type    = $paycode; //操作类型 weixin alipay unpay
            $this->pay_ment    = '微信支付';
            $this->openid      = '';
            $this->ip          = $data['exter_invoke_ip'];
            $this->status      = 0;  //0：刚刚提交支付  -1：删除   99：最终支付成功
            $this->month = $data['month'];

            $this->save();
        }

        $notify = new \NativePay();
        $input  = new \WxPayUnifiedOrder();
        $input->SetBody($data['body']);
        $input->SetAttach($data['attach']);
        $input->SetOut_trade_no($data['out_trade_no']);
        $input->SetTotal_fee($data['total_fee']);
        $input->SetTime_start($data['time_start']);
        $input->SetTime_expire($data['time_expire']);
        $input->SetGoods_tag($data['goods_tag']);
        $input->SetNotify_url($data['notify_url']);
        $input->SetTrade_type($data['trade_type']);
        $input->SetProduct_id($data['product_id']);
        $result = $notify->GetPayUrl($input);

        if($result['return_code'] != 'SUCCESS'){
            return ['code'=>0,'msg'=> $result['return_msg']];
        }
        if($result['result_code'] != 'SUCCESS'){
            return ['code'=>0,'msg'=> $result['err_code_des']];
        }
        return ['code'=>1,'msg'=>$result["code_url"]];
    }

    /**
     * @Description: 通过订单号查询状态记录
     * @return  string
     */
    public function getPayAccountId($tradeSn)
    {
        $result = $this->where('trade_sn', $tradeSn)->find();
        return $result;
    }

    /**
     * @Description: 通过记录id和站点id修改状态
     * @return  string
     */
    public function updateStatus($data, $id)
    {
        $result = $this->where(array('id' => $id))->update($data);
        return $result;
    }


}