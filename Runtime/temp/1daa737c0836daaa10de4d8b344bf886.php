<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/Library/WebServer/www/project/sep-7/application/user/view/member/pay.html";i:1505267484;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>个人中心-支付订单</title>
    <script src="__PUBLIC__/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/adminlte/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/member.css">
    <link rel="stylesheet" href="__PUBLIC__/css/pay.css">
    <script src="__PUBLIC__/adminlte/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
<div id="bd" style="min-height: 800px;">
    <div class="order-msg">
        <dl>
            <dt><i class="iconfont glyphicon glyphicon-ok-circle"></i>订单提交成功，请您尽快付款</dt>
            <dd class="first">
                订单编号：<span class="blue-light mr30"><?php echo $order_no; ?></span>
                应付金额：<span class="orange">￥0.01</span>
            </dd>
            <dd class="grey">
                请您在提交订单后 <span class="orange">24小时内</span> 完成支付，否则订单将会自动取消
            </dd>
        </dl>
    </div>

    <!--订单提交成功 在线支付-->

    <form  name="myform" id="myform" action="<?php echo url('pay/payments/alipay'); ?>" method="post" onsubmit="getPayUrl()" target="_blank">
        <input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no; ?>"/>
        <input type="hidden" name="price" id="price" value="0.01"/>
        <input type="hidden" name="payCode" id="payCode" value="alipay" />
        <div class="pay-ol pay-ol-tab o-wp xs-tab" id="payment_ol">
            <div class="hd">
                <ul class="tab-hd cl">
                    <li class="tab-btn xs-active">
                        <a href="javascript:;">选择支付方式</a>
                    </li>
                </ul>
            </div>
            <div class="bd">
                <div class="tab-bd">
                    <p>付款时需跳转到以下对应的支付渠道进行支付。</p>
                    <ul class="pay-list cl">
                        <li class="icon-alipay active" id="alipay" data="alipay" title="使用支付宝支付">
                            <img src="__PUBLIC__/image/alipay.png" alt="支付宝支付">
                        </li>
                        <li class="icon-tenpay" id="weixin" data="weixin" title="使用微信支付">
                            <img src="__PUBLIC__/image/weixin.png" alt="微信支付">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pay-submit o-wp o-wp-l order-submit clearfix">
            <div class="fr">
                <button class="btn btn-order">立即支付</button>
            </div>
        </div>
    </form>

</div>

</body>
<script type="text/javascript">
    $(function () {
        $('.pay-list li').click(function() {
            var $this = $(this);
            if (!$this.hasClass('more')) {
                $this.addClass('active').siblings().removeClass('active');
                $('#payCode').val($this.attr('data'));
            }
        });
    });
    function getPayUrl(){
        var action = '';
        var payCode = $.trim($("#payCode").val());
        if(payCode == 'weixin'){
            action = "<?php echo url('pay/payments/wxpay'); ?>";
        }else if(payCode == 'alipay'){
            action = "<?php echo url('pay/payments/alipay'); ?>"
        }else{
            action = "<?php echo url('pay/payments/unpay'); ?>"
        }
        $('form').attr('action',action);
    }
</script>
</html>