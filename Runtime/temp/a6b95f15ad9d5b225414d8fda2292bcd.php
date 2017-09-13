<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/Library/WebServer/www/project/sep-7/application/user/view/login/login.html";i:1505198502;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>
    <link rel="stylesheet" href="__PUBLIC__/css/login.css" >
    <link href="__PUBLIC__/adminlte/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <div class="login-box">

           <div class="login-info">
               <input class="info-box" name="phone_num" id="phone_num" data-type="phone" data-role="verify" placeholder="请输入手机号">
               <span class="error-tip">
                   手机号有误
               </span>
               <input class="info-box" type="password" name="password" id="password" data-type="password" data-role="verify" placeholder="密码(6-18位密码)">           <span class="error-tip">
               密码必须为6-18的字符
              </span>
               <!--<input class="login-btn" type="submit" value="立即登录">-->
               <button  class="btn submit login-btn">
                    <span class="hidden">
                        <i class="fa-loading"></i>
                        正在登录 ...
                    </span>
                   <span class="show">立即登录</span>
               </button>
           </div>
           <div class="bottom-info">
               <input type="checkbox" name="rem_pwd" value="1">
               <span class=" tip">2小时内免密登录</span>
               <span class="forget-pwd-btn tip">
                    <a href="<?php echo url('/reset'); ?>">忘记密码?</a>
                </span>
           </div>
   </div>
</body>
<script src="__PUBLIC__/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/layer/2.4/layer.js"></script>
<script src="__PUBLIC__/plugins/verify.js"></script>
<script src="__PUBLIC__/js/base64.js"></script>
<script src="__PUBLIC__/js/login.js"></script>


    <script type="text/javascript">
            $(function() {
                var base64Obj = new Base64();
                $('.login-btn').click(function (e) {
                    e.preventDefault();
                    var phoneNum = $("#phone_num").val();
                    var password = $("#password").val();

                    $.ajax({
                        url:'/login',
                        type:'post',
                        data:{"phone_num":base64Obj.encode(phoneNum),"password":base64Obj.encode(password)},
                        async:true,
                        success:function (resJson) {
                            if(resJson.code==1){
                                layer.msg(resJson.message,{icon:1,time:2000});
                                setTimeout('window.location.href = "/user/user/index";',2000);
                                return;
                            }else{
                                layer.msg(resJson.message,{icon:2,time:2000});
                                return false;
                            }
                        }
                    })
                })
            })

</script>
</html>