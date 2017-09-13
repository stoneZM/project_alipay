/**
 * Created by stone on 2017/9/7.
 */

$("input[data-role='verify']").blur(function () {

    var _this = $(this);
    var dataType = _this.attr('data-type');
    var data = _this.val();
    if(dataType == 'phone'){

        if(!checkPhone(data)){
            _this.next().show();
        }else{
            _this.next().hide();
        }
    }
    if (dataType == 'password'){
        if(!checkPassword(data)){
            _this.next().show();
        }else{

            _this.next().hide();
        }
    }
});
<!--  获取验证码 -->
$(function(){
    var time = 0;
    var intervalProcess;
    var base64Obj = new Base64();
    $(".get-code-btn").click(function(e){
        e.preventDefault();
        var _this = $(this);
        var type = _this.attr('code-type');
         type = (type=='reset_pwd')?"reset_pwd":0;
        var phoneNum = $("#phone_num").val();
        if(!checkPhone(phoneNum)){
            layer.msg('电话号码有误',{icon: 2, time: 2000});
            return;
        }
        $.ajax({
            url:"/get_code",
            type:'get',
            data: {'phone':base64Obj.encode(phoneNum),'type':base64Obj.encode(type)},
            async: true,
            dataType:'json',
            success:function (resJson) {
                if (resJson.code == 1) {
                    time = 60;
                    clearInterval(intervalProcess);
                    _this.addClass("disabled");
                    layer.msg(resJson.message,{icon: 1, time: 1000});
                    intervalProcess = setInterval(refreshBtnHtml, 1000);
                } else {
                    layer.msg(resJson.message,{icon: 2, time: 2000});
                }
            }
        });
    });

    $(".regist-btn").click(function (e) {
        e.preventDefault();

    });

    function refreshBtnHtml() {
        if(time<=0){
            var getCodeBtn =   $(".get-code-btn");
            getCodeBtn.html('重新发送');
            getCodeBtn.removeClass("disabled");
        }else{
            time--;
            $(".get-code-btn").html('已发送('+time+'s)');
        }
    }



//        验证码
    var verifyimg = $(".verifyimg").attr("src");
    $(".reloadverify").click(function () {
        if (verifyimg.indexOf('?') > 0) {
            $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
        } else {
            $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
        }
    });

});