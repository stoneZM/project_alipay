<?php

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login($type='user') {
    if ($type=='user'){
        $user = session('user_auth');
    }else{
        $user = session('admin_auth');
    }

    if (empty($user)) {
        return 0;
    } else {
        if ($type=='user'){
            return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
        }else{
            return session('admin_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
        }

    }
}

/**
 * 免登录行为
 * @return
 */
function no_login($url){

    $urls = array(
        'user/login/login',
        'user/login/reg' ,
        'user/login/get_phone_code',
        'user/login/verify',
        'user/login/reset_pwd',
        'user/login/verify_code',
        'admin/admin/login',
        'pay/payments/alipay_notify', // 支付宝异步回调
        'pay/payments/alipay_return', // 支付宝同步回调
        'pay/payments/wxpay_notify'
    );
    if (in_array($url,$urls)){
        return true;
    }else{
        return false;
    }

}



/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data) {
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type      = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip[$type];
    }

    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }

            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 将字符串转换为数组
 * @param	string	$data	字符串
 * @return	array	返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data) {
    if(is_array($data)){return $data;}
    $data = trim($data);
    if($data == ''){return array();}
    if(strpos($data, 'array')===0){
        @eval("\$array = $data;");
    }else{
        if(strpos($data, '{\\')===0) $data = stripslashes($data);
        $array=json_decode($data,true);
        /*
        if(strtolower(CHARSET)=='gbk'){
            $array = mult_iconv("UTF-8", "GBK//IGNORE", $array);
        }
        */
    }
    return $array;
}
/**
 * 将数组转换为字符串
 * @param	array	$data		数组
 * @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return	string	返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1) {
    if($data == '' || empty($data)) return '';
    if($isformdata) $data = new_stripslashes($data);
    /*
    if(strtolower(CHARSET)=='gbk'){
        $data = mult_iconv("GBK", "UTF-8", $data);
    }
    */
    if (version_compare(PHP_VERSION,'5.3.0','<')){
        return addslashes(json_encode($data));
    }else{
        return addslashes(json_encode($data,JSON_FORCE_OBJECT));
    }
}

/**
 * 产生随机字符串
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 123456789
 * @return   string     字符串
 */
function random($length=18, $types=0) {
    if(intval($types)==0){
        $chars = '123456789';
    }else{
        $chars = 'abcdefghigklmnopqrstuvwxwyABCDEFGHIGKLMNOPQRSTUVWXWY123456789';
    }

    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

function get_user_info($name){

    $user_info = session('user_auth');
    return $user_info[$name];
}

/**
 *  判断是否是手机访问还是电脑
 * @return bool
 */
function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi",
        "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio",
        "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu",
        "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ",
        "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi",
        "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "iphone", "ipod", "jbrowser", "kddi",
        "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo",
        "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-",
        "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia",
        "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-",
        "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo",
        "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank",
        "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit",
        "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin",
        "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce",
        "wireless", "xda", "xde", "zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}
