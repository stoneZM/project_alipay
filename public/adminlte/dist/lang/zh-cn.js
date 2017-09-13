/*
 * TODO LIST CUSTOM PLUGIN
 * -----------------------
 * This plugin depends on iCheck plugin for checkbox and radio inputs
 *
 * @type plugin
 * @usage $("#todo-widget").todolist( options );
 */
(function ($) {

  L = function (lang) {
	  
	var Language = new Array();
	Language['Please_select_the_host_to_connect_to'] = '请选择要连接的主机';
	Language['Linking_host'] = '正在链接主机';
	Language['Select_the_host_to_execute_the_command'] = '请选择要执行命令的主机';
	Language['Parameter_error'] = '参数出错';
	Language['Sending_messages'] = '正在发送消息';
	Language['Please_make_sure_you_want_to_point_to_the_line'] = '请确定要指行的命令';
	Language['Telephone'] = '电话';
	Language['headquarters'] = '总部';
	Language['Family'] = ' 家';
	
	
	Language['Anhui'] = '安徽';
	Language['Beijing'] = '北京';
	Language['Chongqing'] = '重庆';
	Language['Fujian'] = '福建';
	Language['Gansu'] = '甘肃';
	Language['Guangdong'] = '广东';
	Language['Guangxi'] = '广西';
	Language['Guizhou'] = '贵州';
	Language['Hainan'] = '海南';
	Language['Hebei'] = '河北';
	Language['Henan'] = '河南';
	Language['Heilongjiang'] = '黑龙江';
	Language['Hubei'] = '湖北';
	Language['Hunan'] = '湖南';
	Language['Jilin'] = '吉林';
	Language['Jiangsu'] = '江苏';
	Language['Jiangxi'] = '江西';
	Language['Liaoning'] = '辽宁';
	Language['Inner_Mongolia'] = '内蒙古';
	Language['Ningxia'] = '宁夏';
	Language['Qinghai'] = '青海';
	Language['Shandong'] = '山东';
	Language['Shanxi'] = '山西';
	Language['Shaanxi'] = '陕西';
	Language['Shanghai'] = '上海';
	Language['Hainan'] = '海南';
	Language['Sichuan'] = '四川';
	Language['Tianjin'] = '天津';
	Language['Tibet'] = '西藏';
	Language['Xinjiang'] = '新疆';
	Language['Yunnan'] = '云南';
	Language['Zhejiang'] = '浙江';
	Language['Macao'] = '澳门';
	Language['Taiwan'] = '台湾';

	Language['msg_content'] = '内容';
	Language['msg_title'] = '操作';
	Language['msg_btnok'] = '确定';
	Language['msg_btncl'] = '取消';	
	Language['msg_confirm'] = '确认要执行该操作吗？';
	Language['please_select_data'] = '请选择数据？';
	Language['close_window'] = '您确定要关闭当前窗口吗？';
	
	
	
	
	return Language[lang];
  }

}(jQuery));
