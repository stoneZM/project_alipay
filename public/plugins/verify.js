/**
 * Created by stone on 2017/9/7.
 */

/**
 * 正则检验手机号码
 * @param phone
 * @returns {boolean}
 */
function checkPhone(phone){

    if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone)))
        return false;
    else
        return true;
}

/**
 *  密码正则 6-18个字符
 * @param pwd
 * @returns {boolean}
 */
function checkPassword(pwd) {
    // 长度为6到18个字符
    var reg = /^.{6,18}$/;
    if (!reg.test(pwd)) {
        return false;
    }else{
        return true;
    }
}