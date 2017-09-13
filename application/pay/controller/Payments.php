<?php
namespace app\pay\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\pay\model\PayAccount as model_pay_account;
use app\admin\model\Setting  as SettingModel;

class Payments extends Controller
{
    public $alipay_sslcert_path;
    public $alipay_sslkey_path;
    public $wxpay_sslcert_path;
    public $wxpay_sslkey_path;
    public $payment;
    public function __construct()
    {
        parent::__construct();
        $this->module = 'pay';
        $this->ip  = Request::instance()->ip();
        $SettingMd = new SettingModel();
        $rd = $SettingMd->get(array('module' => $this->module));
        if($rd){
            $this->payment = string2array($rd['setting']);
        }
        $this->alipay_sslcert_path = '';
        $this->alipay_notify_url   = urldecode(request()->domain().url('pay/payments/alipay_notify'));
        $this->alipay_return_url   = urldecode(request()->domain().url('pay/payments/alipay_return'));
        $this->wxpay_notify_url    = urldecode(request()->domain().url('pay/payments/wxpay_notify'));
        $this->wxpay_return_url    = urldecode(request()->domain().url('pay/payments/wxpay_return'));
        $this->payment['alipay_notify_url'] = $this->alipay_notify_url;
        $this->payment['alipay_return_url'] = $this->alipay_return_url;
        $this->payment['alipay_sslcert_path'] = $this->alipay_sslcert_path;
        $this->payment['wxpay_notify_url']  = $this->wxpay_notify_url;
        $this->payment['wxpay_return_url']  = $this->wxpay_return_url;
        $this->payment['sign_type'] = strtoupper('MD5');
        $this->payment['transport'] = 'http';
        $this->payment['payment_type']   = 1;
        $this->payment['alipay_partner'] = $this->payment['alipay_parterid'];
        $this->payment['cacert'] = $this->alipay_sslcert_path;
        $wxpayConfigArry = array();
//        $wxpayConfigArry['wxpay_appid']   = $this->payment['wxpay_appid'];
//        $wxpayConfigArry['wxpay_mchid']   = $this->payment['wxpay_mchid'];
//        $wxpayConfigArry['wxpay_key']     = $this->payment['wxpay_key'];
//        $wxpayConfigArry['wxpay_appsecret']  = $this->payment['wxpay_appsecret'];
        $wxpayConfigArry['wxpay_appid']   = "wx2cdc50e475ad21b9";
        $wxpayConfigArry['wxpay_mchid']   = "1486574132";
        $wxpayConfigArry['wxpay_key']     = "LoHover2a0B1c7D6e6F8g8H9iLoHover";
        $wxpayConfigArry['wxpay_appsecret']  = "9c39bbec840d1267f67805ec9cb9f84d";
        $wxpayConfigArry['wxpay_notify_url'] = $this->payment['wxpay_notify_url'];
        $this->wxpay = $wxpayConfigArry;
        $this->PayAccount = new model_pay_account();
        //$this->orders     = new model_orders();
        vendor('payment.alipay');
        vendor('payment.WxPay_Api');

    }
    /**
     * @Description: 处理支付宝支付
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  json
     */
    public function alipay()
   {
       $tradeSn = input('order_no');
       $payCode = input('payCode');
	   //查询订单表
       //$getOrders = $this->orders->where(array('order_no' => $tradeSn))->find();
       $order = array();
       $order['userId']   = 1;
       $order['username'] = '广州公司';
       $order['tradeSn']  = $tradeSn;
       $order['num']      = 1;
       $order['email']    = 'lohover@163.com@qq.com';
       $order['telephone']    = '18052338858';
       $order['totalmMoney']  = 0.01;
       $order['subject']  = '开通会员及续费';
       $order['body']     = '开通3个月会员';
       $payConfigArry = array();
       $payConfigArry['alipay_service']   = 'create_direct_pay_by_user';
       $payConfigArry['alipay_partner']   = $this->payment['alipay_partner'];
       $payConfigArry['alipay_seller_id'] = $this->payment['alipay_partner'];
       $payConfigArry['alipay_key']           = $this->payment['alipay_key'];
       $payConfigArry['alipay_seller_email']  = $this->payment['alipay_seller_email'];
       $payConfigArry['alipay_notify_url']= $this->payment['alipay_notify_url'];
       $payConfigArry['alipay_return_url']= $this->payment['alipay_return_url'];
       $payConfigArry['sign_type'] = $this->payment['sign_type'];
       $payConfigArry['input_charset'] = strtolower('utf-8');
       $payConfigArry['cacert']    = $this->payment['alipay_sslcert_path'];
       $payConfigArry['transport'] = $this->payment['transport'];
       $payConfigArry['payment_type']  = $this->payment['payment_type'];
       $payConfigArry['anti_phishing_key'] = '';
       $payConfigArry['exter_invoke_ip']   = $this->ip;
       /* if(empty($getOrders)){
           $data['status'] = -1;
           $data['msg'] = '下单失败，订单不存在';
       }elseif (empty($getOrders['order_no'])){
           $data['status'] = -2;
           $data['msg'] = '下单失败，订单编号不能为空';
       }else{ */
           //$order= $getOrderInfo;
           $result  = $this->PayAccount->getAlipay($payConfigArry, $order, $payCode, $this->module);
           if(!$result['code']){
               return $this->error($result['msg']);
           }
           return $result['msg'];
       //}
   }

    /**
     * @Description: 处理微信支付
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  json
     */
   public function wxpay()
   {
       $tradeSn = input('order_no');
       $payCode = input('payCode');
	   //查询订单表
       //$getOrders = $this->orders->where(array('order_no' => $tradeSn))->find();
       $data = array();
       $data['userId']   = 1;
       $data['username'] = '广州公司';
       $data['out_trade_no']  = $tradeSn;
       $data['num']      = 1;
       $data['email']    = 'lohover@163.com@qq.com';
       $data['telephone']  = '18052338858';
       $data['total_fee']  = 0.01*100;
       $data['attach']   = '开通会员及续费';
       $data['body']     = '开通3个月会员';
       $data['time_start'] = date("YmdHis");//交易开始时间
       $data['time_expire']= date("YmdHis", time() + 604800);//一周过期
       $data['goods_tag']  = '开通3个月会员';
       $data['notify_url']  = $this->wxpay['wxpay_notify_url'];//回调地址
       $data['trade_type']  = 'NATIVE';//交易类型
       $data['product_id']  = rand(1,999999);//交易id
       $data['exter_invoke_ip']  = $this->ip;
       $result  = $this->PayAccount->getWxpay($this->wxpay, $data, $payCode, $this->module);

       if(!$result['code']){
           return $this->error($result['msg']);
       }

       vendor('phpqrcode.phpqrcode');
       $errorCorrectionLevel = 3 ;//容错级别
       $matrixPointSize = 4;//生成图片大小
       //生成二维码图片
       //echo $_SERVER['REQUEST_URI'];
       $object = new \QRcode();
       ob_end_clean();
       $object->png($result['msg'], false, $errorCorrectionLevel, $matrixPointSize, 2);
   }

    /**
     * @Description: 支付结果异步回调
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  string
     */
    public function alipay_notify()
    {
        $url = Request::instance()->post();
        //商户订单号
        $out_trade_no = $url['out_trade_no'];
        //支付宝交易号
        $trade_no     = $url['trade_no'];
        //交易状态
        $trade_status = $url['trade_status'];
        $total_fee    = $url['total_fee'];
        $seller_id    = $url['seller_id'];
        $config = $this->payment;
        $alipayNotify = new \AlipayNotify($config);
        $result = $alipayNotify->verifyNotify($url);
        if($result){
            $_payaccount = $this->PayAccount->getPayAccountId($out_trade_no);
			//查询订单
            //$_orders     = $this->orders->where(array('order_no' => $out_trade_no))->find();
            if(!$_payaccount){
                return ''; //订单号不存在
            }
            if($_payaccount['seller_id'] != $seller_id){
                return ''; //商户id不一致
            }
            if($_payaccount['totalMoney'] != $total_fee){
                return '';  //订单金额不匹配
            }
            //订单未处理过
            if($_payaccount['status'] == 0){
                if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                    $data = array();
                    $arr  = array();
                    $data['edittime'] = time();
                    $data['status']   = 99;
                    /* $arr['status']   = 99;
                    $arr['pay_ment'] = '支付宝支付';
                    $arr['pay_status'] = 1;
                    $arr['pay_time']  = time(); */
                    
                    $this->PayAccount->updateStatus($data, $_payaccount['id']);
                    //$this->orders->save($arr,['id' => $_orders['id']]);
                    return "success";
                }
            }
        }else{
            return 'fail';
        }
    }
    /**
     * @Description: 支付结果同步回调
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  string
     */
    public function alipay_return()
    {
        $url = Request::instance()->get();
        //商户订单号
        $out_trade_no = $url['out_trade_no'];
        //支付宝交易号
        $trade_no     = $url['trade_no'];
        //交易状态
        $trade_status = $url['trade_status'];
        $total_fee    = $url['total_fee'];
        $seller_id    = $url['seller_id'];
        $config = $this->payment;
        $alipayNotify = new \AlipayNotify($config);
        $result = $alipayNotify->verifyNotify($url);
        if($result){
            $_payaccount = $this->PayAccount->getPayAccountId($out_trade_no);
            //$_orders     = $this->orders->where(array('order_no' => $out_trade_no))->find();
            if(!$_payaccount){
                return ''; //订单号不存在
            }
            if($_payaccount['seller_id'] != $seller_id){
                return ''; //商户id不一致
            }
            if($_payaccount['totalMoney'] != $total_fee){
                return '';  //订单金额不匹配
            }
            //订单未处理过
            if($_payaccount['status'] == 0){
                if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                    $data = array();
                    $arr  = array();
                    $data['edittime'] = time();
                    $data['status']   = 99;
                    /* $arr['status']   = 99;
                    $arr['pay_ment'] = '支付宝支付';
                    $arr['pay_status'] = 1;
                    $arr['pay_time']  = time(); */
                    
                    $this->PayAccount->updateStatus($data, $_payaccount['id']);
                    //$this->orders->save($arr,['id' => $_orders['id']]);
                    $this->redirect('admin/index/recordList');
					//如果没有设定重定向则走设置好的同步回调地址pay/payments/alipay_return
					//return "success";
                }
            }
        }else{
            return 'fail';
        }
    }

    /**
     * @Description: 支付结果异步回调
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  string
     */
    public function wxpay_notify()
    {
        $notify_data = file_get_contents("php://input");
        if(!$notify_data){
            $notify_data = $GLOBALS['HTTP_RAW_POST_DATA'] ?: '';
        }
        if(!$notify_data){
            exit('');
        }
        if(!$notify_data){
            return false;
        }
        $doc = new \DOMDocument();
        $doc->loadXML($notify_data);
        $out_trade_no   = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;//订单编号
        $transaction_id = $doc->getElementsByTagName("transaction_id")->item(0)->nodeValue;//交易单号
        $openid = $doc->getElementsByTagName("openid")->item(0)->nodeValue;//用户openid

        $input  = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS"){
            // 处理支付成功后的逻辑业务
            $_payaccount = $this->PayAccount->getPayAccountId($out_trade_no);
            //$_orders     = $this->orders->where(array('order_no' => $out_trade_no))->find();
            if(!$_payaccount){
                return ''; //订单号不存在
            }
            $data = array();
            $arr  = array();
            $data['edittime'] = time();
            $data['status']   = 99;
            // $arr['status']   = 99;
            // $arr['pay_ment'] = '微信支付';
            // $data['openid']   = $openid;
            // $arr['pay_status'] = 1;
            // $arr['pay_time']  = time();
            
            $this->PayAccount->updateStatus($data, $_payaccount['id']);
            //$this->orders->save($arr,['id' => $_orders['id']]);
            return "success";
        }
        return false;
    }


}