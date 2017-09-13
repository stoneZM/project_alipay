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
	Language['Please_select_the_host_to_connect_to'] = 'Please select the host to connect to';
	Language['Linking_host'] = 'Linking host';
	Language['Select_the_host_to_execute_the_command'] = 'Select the host to execute the command';
	Language['Parameter_error'] = 'Parameter error';
	Language['Sending_messages'] = 'Sending messages';
	Language['Please_make_sure_you_want_to_point_to_the_line'] = 'Please make sure you want to point to the line.';
	Language['Telephone'] = 'Telephone';
	Language['headquarters'] = 'HQ';
	Language['Family'] = '';
	
	Language['Anhui'] = 'Anhui';
	Language['Beijing'] = 'Beijing';
	Language['Chongqing'] = 'Chongqing';
	Language['Fujian'] = 'Fujian';
	Language['Gansu'] = 'Gansu';
	Language['Guangdong'] = 'Guangdong';
	Language['Guangxi'] = 'Guangxi';
	Language['Guizhou'] = 'Guizhou';
	Language['Hainan'] = 'Hainan';
	Language['Hebei'] = 'Hebei';
	Language['Henan'] = 'Henan';
	Language['Heilongjiang'] = 'Heilongjiang';
	Language['Hubei'] = 'Hubei';
	Language['Hunan'] = 'Hunan';
	Language['Jilin'] = 'Jilin';
	Language['Jiangsu'] = 'Jiangsu';
	Language['Jiangxi'] = 'Jiangxi';
	Language['Liaoning'] = 'Liaoning';
	Language['Inner_Mongolia'] = 'Inner Mongolia';
	Language['Ningxia'] = 'Ningxia';
	Language['Qinghai'] = 'Qinghai';
	Language['Shandong'] = 'Shandong';
	Language['Shanxi'] = 'Shanxi';
	Language['Shaanxi'] = 'Shaanxi';
	Language['Shanghai'] = 'Shanghai';
	Language['Hainan'] = 'Hainan';
	Language['Sichuan'] = 'Sichuan';
	Language['Tianjin'] = 'Tianjin';
	Language['Tibet'] = 'Tibet';
	Language['Xinjiang'] = 'Xinjiang';
	Language['Yunnan'] = 'Yunnan';
	Language['Zhejiang'] = 'Zhejiang';
	Language['Macao'] = 'Macao';
	Language['Taiwan'] = 'Taiwan';
	
	Language['msg_content'] = 'content';
	Language['msg_title'] = 'Prompt';
	Language['msg_btnok'] = 'Submit';
	Language['msg_btncl'] = 'cancel';	
	Language['msg_confirm'] = 'Are you sure you want to perform this operation ?';
	Language['please_select_data'] = 'Please select data？';
	Language['close_window'] = 'Are you sure you want to close the current window';
	
	
	
	
	return Language[lang];
  }

}(jQuery));
