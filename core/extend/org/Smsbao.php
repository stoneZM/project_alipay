<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 19:22
 */

namespace org;


class Smsbao
{
    static function send($phoneNum,$type=0,$extend=0){

        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = "http://www.smsbao.com/"; //短信网关
        $user = "lohover"; //短信平台帐号
        $pass = md5("20188888"); //短信平台密码

        //要发送的短信内容
        $content = self::getMsmContent(self::getRandCode($phoneNum),$type,$extend);
        $phone = $phoneNum;
//        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
//        $result =file_get_contents($sendurl) ;
//        return array('code'=>$result,'message'=>$statusStr[$result]);
        return array('code'=>0,'message'=>'验证码发送成功');
    }

    static function getMsmContent($code,$type,$extend){
        /*
         *   type : 0   注册时发送短信
         *          1   重置密码
         *          2   购买会员
         */
        $content = '';
        $time = 10;
        switch ($type){
            case 0:
                $content = "【龙中翔】您的验证码为".$code."，请在".$time."分钟内输入";
                break;
            case 1:
                $content = "【龙中翔】您正在重置登录密码，验证码为 ".$code ."，请在".$time."分钟内输入，如果不是您本人操作，请立即修改您的密码！";
             break;
            case 2:
                $content = "【龙中翔】尊敬的VIP用户，您已成功开通".$extend."个月会员服务，感谢您的支持！";
                break;
        }
        return $content;
    }

    /**
     *  获取四位随机验证码
     */
    static function getRandCode($phoneNum){

//        $random_num =  rand(100000,999999);
//        \think\Session::set($phoneNum,$random_num);
        \think\Session::set($phoneNum,1111);
        return 1111;
    }



}