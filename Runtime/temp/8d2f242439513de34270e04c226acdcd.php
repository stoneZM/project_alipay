<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/Library/WebServer/www/project/sep-7/application/user/view/user/index.html";i:1505313964;s:77:"/Library/WebServer/www/project/sep-7/application/common/view/public/base.html";i:1505197405;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>后台管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/qinfoicon/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/hui-iconfont/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/iCheck/all.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/bootstrap-slider/bootstrap-slider.css">
    <link rel="stylesheet" href="__PUBLIC__/adminlte/plugins/showloading/css/showloading.css">
    <link rel="stylesheet" href="__PUBLIC__/css/main.css">
    

    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <script src="__PUBLIC__/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/adminlte/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="__PUBLIC__/adminlte/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>


<body class="hold-transition skin-blue sidebar-mini fixed" id="loading">

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <div class="logo">
            <img src="#" alt="LOGO" class="logo-img" >
        </div>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                 Hi 欢迎回来
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo url('user/login/logout'); ?>">
                            退出登录
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


    <aside class="main-sidebar">
            <ul class="sidebar-menu  sidebar">
                <li ><a href="<?php echo url('/user/user/index'); ?>"><i class="fa fa-circle-o text-red"></i> <span>用户中心</span></a></li>
                <li><a href="<?php echo url('/user/index/nav1'); ?>"><i class="fa fa-circle-o text-green"></i> <span>导航一</span></a></li>
                <li><a href="<?php echo url('/user/index/nav2'); ?>"><i class="fa fa-circle-o text-yellow"></i> <span>导航二</span></a></li>
                <li><a href="<?php echo url('/user/index/nav3'); ?>"><i class="fa fa-circle-o text-blue"></i> <span>导航三</span></a></li>
                <?php if($is_vip == 1): ?>
                <li><a href="<?php echo url('/user/vip/index'); ?>"><i class="fa fa-circle-o text-gray"></i> <span>VIP专区</span></a></li>
                <?php endif; ?>
                <li><a href="<?php echo url('/user/member/index'); ?>"><i class="fa fa-circle-o text-aqua"></i> <span>会员服务</span></a></li>
                <li><a href="<?php echo url('/user/account/index'); ?>"><i class="fa fa-circle-o text-red"></i> <span>账户中心</span></a></li>
            </ul>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <section class="content-header">
            <h1><small><?php echo $meta_title; ?></small></h1>
            <?php if($is_vip == 0): ?>
            <div class="no-vip-tip">
                <span >您当前的身份是普通用户,<a href="/user/member/manage">点击这里立即升级为VIP用户</a></span>
            </div>
           <?php endif; if($is_vip == 1): ?>
            <div class="no-vip-tip">
                <span >尊敬的VIP用户,您的会员到期时间为:<?php echo $expir_time; ?>,<a href="/user/member/manage">点击这里续费</a></span>
            </div>
            <?php endif; if($is_vip == -1): ?>
            <div class="no-vip-tip">
                <span >尊敬的VIP用户,您的会员已到期,<a href="/user/member/manage">点击这里续费</a></span>
            </div>
            <?php endif; ?>
        </section>
        

<section class="content">
    <div class="box box-solid clearfix">
        <div class="box-body clearfix member-content">
            <h3 class="text-center">User</h3>
        </div>
    </div>
</section>


    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div style="text-align: center">

            如有问题，请联系<a>在线客服</a>&nbsp;&nbsp;
            客服邮箱：123456789@qq.com
        </div>

    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<script src="__PUBLIC__/js/base64.js"></script>
<script src="__PUBLIC__/adminlte/bootstrap/js/bootstrap.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script src="__PUBLIC__/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/iCheck/icheck.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/select2/select2.full.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/moment/2.11.2/moment.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<script src="__PUBLIC__/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/fastclick/fastclick.js"></script>
<script src="__PUBLIC__/adminlte/plugins/template/template.js"></script>
<script src="__PUBLIC__/adminlte/dist/js/app.js"></script>
<script src="__PUBLIC__/adminlte/plugins/hopscotch/hopscotch.js"></script>
<script src="__PUBLIC__/adminlte/plugins/messager/messager.js"></script>
<script src="__PUBLIC__/adminlte/plugins/layer/2.4/layer.js"></script>
<script src="__PUBLIC__/adminlte/dist/js/pace.min.js"></script>
<script src="__PUBLIC__/adminlte/plugins/showloading/js/jquery.showLoading.min.js"></script>
<script type="text/javascript">

</script>
<script src="__PUBLIC__/adminlte/dist/js/core.js"></script>
<script type="application/javascript">

    var base64Obj = new Base64();

    function showTip(msg,icon) {
        layer.msg(msg,{icon:icon,time:2000});
    }

    function friendlyTip(msg,errorMsg,time,errorTime) {

        var oldTime = Date.parse(new Date());
        time = time ? time : 6000;
        errorTime = errorTime ? errorTime : 2000;
        layer.msg(msg, {
            icon: 16,
            time: time
        }, function () {
            var newTime = Date.parse(new Date());
            if ((newTime - oldTime) < (time - 0.001)) {
                return false;
            } else {
                layer.msg(errorMsg, {icon: 5, time: errorTime}, function () {
                    location.reload();
                });
            }
        })
    }
</script>


</body>
</html>