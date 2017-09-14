<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/Library/WebServer/www/project/sep-7/application/user/view/login/reg.html";i:1505317316;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册页面</title>
	<link rel="stylesheet" href="__PUBLIC__/css/login.css" >
    <script src="__PUBLIC__/plugins/jQuery/jquery-2.2.3.min.js"></script>
</head>
<body>
	<div class="reg-box">

           <div class="login-info">

               <input class="info-box" id="phone_num" name="phone_num" data-type="phone" data-role="verify" placeholder="请输入手机号">
               <span class="error-tip">
                   手机号有误
               </span>
               <div>
               	<input class="verify_code info-box " id="img-code" name="verify_code" data-type="" data-role="" placeholder="验证码">
                <img src="<?php echo url('/get_verify'); ?>" class="code-img verifyimg reloadverify">
               </div>
      			
      			<div>
      				<input class="verify_code info-box " id="phone-code" name="" data-type="" data-role="verify" placeholder="短信验证码">
      				<a href="javascript:void(0)" class="get-code-btn">获取验证码</a>
      			</div>

               <input type="password" class="info-box" name="password" id="'password" data-type="password" data-role="verify" placeholder="密码(6-18位密码)">             <span class="error-tip">
               密码必须为6-18的字符
              </span>
               <button class="login-btn regist-btn">立即注册</button>
           </div>

   </div>
</body>
</html>
<script src="__PUBLIC__/plugins/verify.js"></script>
<script src="__PUBLIC__/adminlte/plugins/layer/2.4/layer.js"></script>
<script src="__PUBLIC__/js/base64.js"></script>
<script src="__PUBLIC__/js/login.js"></script>
<script>
    $(".regist-btn").click(function (e) {
        var base64Obj = new Base64();
        e.preventDefault();
        var phoneNum = $("#phone_num").val();
        var imgCode = $("#img-code").val();
        var phoneCode = $("#phone-code").val();
        var password = $("#password").val();
        if(!checkPhone(phoneNum)){
            layer.msg('电话号码有误',{icon: 2, time: 2000});
            return;
        }
        if(!checkPassword(password)){
            layer.msg('密码需6-18位字符',{icon: 2, time: 2000});
            return;
        }
        $.ajax({
           url:'/register',
           data:{'phone_num':base64Obj.encode(phoneNum),'verify_code':base64Obj.encode(imgCode),'phone_code':base64Obj.encode(phoneCode),'phone_num':base64Obj.encode(phoneNum)},
            type:'post',
            async:true,
            success:function (resJson) {
                if(resJson.code != 1){
                    layer.msg(resJson.msg,{icon:2,time:2000});
                    $(".reloadverify").trigger('click');
                    return;
                }else{
                    layer.msg('注册成功',{icon:1,time:2000});
                    setTimeout('window.location.href="/user/login"',2000);
                }
            }
        });
    });
</script>