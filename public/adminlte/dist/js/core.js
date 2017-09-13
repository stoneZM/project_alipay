/* 扩展QinfoCMS对象 */
// (function($) {
// 	/**
// 	 * 获取QinfoCMS基础配置
// 	 * @type {object}
// 	 */
// 	var QinfoCMS = window.Qinfo;
//
// 	/* 基础对象检测 */
// 	QinfoCMS || $.error("QinfoCMS基础配置没有正确加载！");
//
// 	/**
// 	 * 解析URL
// 	 * @param  {string} url 被解析的URL
// 	 * @return {object}     解析后的数据
// 	 */
// 	QinfoCMS.parse_url = function(url) {
// 		var parse = url.match(/^(?:([a-z]+):\/\/)?([\w-]+(?:\.[\w-]+)+)?(?::(\d+))?([\w-\/]+)?(?:\?((?:\w+=[^#&=\/]*)?(?:&\w+=[^#&=\/]*)*))?(?:#([\w-]+))?$/i);
// 		parse || $.error("url格式不正确！");
// 		return {
// 			"scheme": parse[1],
// 			"host": parse[2],
// 			"port": parse[3],
// 			"path": parse[4],
// 			"query": parse[5],
// 			"fragment": parse[6]
// 		};
// 	}
//
// 	QinfoCMS.parse_str = function(str) {
// 		var value = str.split("&"),
// 			vars = {},
// 			param;
// 		for (val in value) {
// 			param = value[val].split("=");
// 			vars[param[0]] = param[1];
// 		}
// 		return vars;
// 	}
//
// 	QinfoCMS.parse_name = function(name, type) {
// 		if (type) {
// 			/* 下划线转驼峰 */
// 			name.replace(/_([a-z])/g, function($0, $1) {
// 				return $1.toUpperCase();
// 			});
//
// 			/* 首字母大写 */
// 			name.replace(/[a-z]/, function($0) {
// 				return $0.toUpperCase();
// 			});
// 		} else {
// 			/* 大写字母转小写 */
// 			name = name.replace(/[A-Z]/g, function($0) {
// 				return "_" + $0.toLowerCase();
// 			});
//
// 			/* 去掉首字符的下划线 */
// 			if (0 === name.indexOf("_")) {
// 				name = name.substr(1);
// 			}
// 		}
// 		return name;
// 	}
//
// 	//scheme://host:port/path?query#fragment
// 	QinfoCMS.U = function(url, vars, suffix) {
// 		var info = this.parse_url(url),
// 			path = [],
// 			param = {},
// 			reg;
//
// 		/* 验证info */
// 		info.path || $.error("url格式错误！");
// 		url = info.path;
//
// 		/* 组装URL */
// 		if (0 === url.indexOf("/")) { //路由模式
// 			this.MODEL[0] == 0 && $.error("该URL模式不支持使用路由!(" + url + ")");
//
// 			/* 去掉右侧分割符 */
// 			if ("/" == url.substr(-1)) {
// 				url = url.substr(0, url.length - 1)
// 			}
// 			url = ("/" == this.DEEP) ? url.substr(1) : url.substr(1).replace(/\//g, this.DEEP);
// 			url = "/" + url;
// 		} else { //非路由模式
// 			/* 解析URL */
// 			path = url.split("/");
// 			path = [path.pop(), path.pop(), path.pop()].reverse();
// 			path[1] || $.error("QinfoCMS.U(" + url + ")没有指定控制器");
//
// 			if (path[0]) {
// 				param[this.VAR[0]] = this.MODEL[1] ? path[0].toLowerCase() : path[0];
// 			}
//
// 			param[this.VAR[1]] = this.MODEL[1] ? this.parse_name(path[1]) : path[1];
// 			param[this.VAR[2]] = path[2].toLowerCase();
//
// 			url = "?" + $.param(param);
// 		}
//
// 		/* 解析参数 */
// 		if (typeof vars === "string") {
// 			vars = this.parse_str(vars);
// 		} else if (!$.isPlainObject(vars)) {
// 			vars = {};
// 		}
//
// 		/* 解析URL自带的参数 */
// 		info.query && $.extend(vars, this.parse_str(info.query));
//
// 		if (vars) {
// 			url += "&" + $.param(vars);
// 		}
//
// 		if (0 != this.MODEL[0]) {
// 			url = url.replace("?" + (path[0] ? this.VAR[0] : this.VAR[1]) + "=", "/")
// 				.replace("&" + this.VAR[1] + "=", this.DEEP)
// 				.replace("&" + this.VAR[2] + "=", this.DEEP)
// 				.replace(/(\w+=&)|(&?\w+=$)/g, "")
// 				.replace(/[&=]/g, this.DEEP);
// 			if ("/" == url.substr(-1)) {
// 				url = url.substr(0, url.length - 1)
// 			}
//
// 			/* 添加伪静态后缀 */
// 			if (false !== suffix) {
// 				suffix = suffix || this.MODEL[2].split("|")[0];
// 				if (suffix) {
// 					url += "." + suffix;
// 				}
// 			}
// 		}
//
// 		url = this.APP + url;
// 		return url;
// 	}
//
// 	/* 设置表单的值 */
// 	QinfoCMS.setValue = function(name, value) {
// 		var first = name.substr(0, 1),
// 			input, i = 0,
// 			val;
// 		if (value === "") return;
// 		if ("#" === first || "." === first) {
// 			input = $(name);
// 		} else {
// 			input = $("[name='" + name + "']");
// 		}
//
// 		if (input.eq(0).is(":radio")) { //单选按钮
// 			input.filter("[value='" + value + "']").each(function() {
// 				this.checked = true
// 			});
// 		} else if (input.eq(0).is(":checkbox")) { //复选框
// 			if (!$.isArray(value)) {
// 				val = new Array();
// 				val[0] = value;
// 			} else {
// 				val = value;
// 			}
// 			for (i = 0, len = val.length; i < len; i++) {
// 				input.filter("[value='" + val[i] + "']").each(function() {
// 					this.checked = true
// 				});
// 			}
// 		} else { //其他表单选项直接设置值
// 			input.val(value);
// 		}
// 	}
//
// })(jQuery);



/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
(function ($, AdminLTE) {

  "use strict";

  /**
   * List of all the available skins
   *
   * @type Array
   */
  var my_skins = [
    "skin-blue",
    "skin-black",
    "skin-red",
    "skin-yellow",
    "skin-purple",
    "skin-green",
    "skin-blue-light",
    "skin-black-light",
    "skin-red-light",
    "skin-yellow-light",
    "skin-purple-light",
    "skin-green-light"
  ];

  //Create the new tab
  var tab_pane = $("<div />", {
    "id": "control-sidebar-theme-demo-options-tab",
    "class": "tab-pane "
  });

  //Create the tab button
  var tab_button = $("<li />", {"class": ""})
      .html("<a href='#control-sidebar-theme-demo-options-tab' data-toggle='tab'>"
      + "<i class='fa fa-wrench'></i>"
      + "</a>");

  //Add the tab button to the right sidebar tabs
  $(".control-sidebar-tabs")
      .append(tab_button);

  //Create the menu
  var demo_settings = $("<div />");

  //Layout options
  demo_settings.append(
      "<h4 class='control-sidebar-heading'>"
      + "布局配置"
      + "</h4>"
        //Fixed layout
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-layout='fixed' class='pull-right'/> "
      + "固定布局"
      + "</label>"
      + "</div>"
        //Boxed layout
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-layout='layout-boxed'class='pull-right'/> "
      + "固定宽度"
      + "</label>"
      + "</div>"
        //Sidebar Toggle
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-layout='sidebar-collapse' class='pull-right'/> "
      + "切换侧边栏"
      + "</label>"
      + "</div>"
        //Sidebar mini expand on hover toggle
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-enable='expandOnHover' class='pull-right'/> "
      + "侧边栏浮动"
      + "</label>"
      + "</div>"
        //Control Sidebar Toggle
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-controlsidebar='control-sidebar-open' class='pull-right'/> "
      + "右侧边栏切换"
      + "</label>"
      + "</div>"
        //Control Sidebar Skin Toggle
      + "<div class='form-group'>"
      + "<label class='control-sidebar-subheading'>"
      + "<input type='checkbox' data-sidebarskin='toggle' class='pull-right'/> "
      + "右侧边栏皮肤"
      + "</label>"
      + "</div>"
  );
  var skins_list = $("<ul />", {"class": 'list-unstyled clearfix'});

  //Dark sidebar skins
  var skin_blue =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-blue' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上蓝</p>");
  skins_list.append(skin_blue);
  var skin_black =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-black' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上白</p>");
  skins_list.append(skin_black);
  var skin_purple =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-purple' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上紫</p>");
  skins_list.append(skin_purple);
  var skin_green =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-green' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上绿</p>");
  skins_list.append(skin_green);
  var skin_red =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-red' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上红</p>");
  skins_list.append(skin_red);
  var skin_yellow =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-yellow' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左黑上黄</p>");
  skins_list.append(skin_yellow);

  //Light sidebar skins
  var skin_blue_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-blue-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左白上蓝</p>");
  skins_list.append(skin_blue_light);
  var skin_black_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-black-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左白上白</p>");
  skins_list.append(skin_black_light);
  var skin_purple_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-purple-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左白上紫</p>");
  skins_list.append(skin_purple_light);
  var skin_green_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-green-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左白上绿</p>");
  skins_list.append(skin_green_light);
  var skin_red_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-red-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>左白上红</p>");
  skins_list.append(skin_red_light);
  var skin_yellow_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-yellow-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px;'>左白上黄</p>");
  skins_list.append(skin_yellow_light);

  demo_settings.append("<h4 class='control-sidebar-heading'>换肤</h4>");
  demo_settings.append(skins_list);

  tab_pane.append(demo_settings);
  $("#control-sidebar-home-tab").after(tab_pane);

  setup();

  /**
   * Toggles layout classes
   *
   * @param String cls the layout class to toggle
   * @returns void
   */
  function change_layout(cls) {
    $("body").toggleClass(cls);
    AdminLTE.layout.fixSidebar();
    //Fix the problem with right sidebar and layout boxed
    if (cls == "layout-boxed")
      AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
    if ($('body').hasClass('fixed') && cls == 'fixed') {
      AdminLTE.pushMenu.expandOnHover();
      AdminLTE.layout.activate();
    }
    AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
    AdminLTE.controlSidebar._fix($(".control-sidebar"));
  }

  /**
   * Replaces the old skin with the new skin
   * @param String cls the new skin class
   * @returns Boolean false to prevent link's default action
   */
  function change_skin(cls) {
    $.each(my_skins, function (i) {
      $("body").removeClass(my_skins[i]);
    });

    $("body").addClass(cls);
    store('skin', cls);
    return false;
  }

  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }

  /**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function get(name) {
    if (typeof (Storage) !== "undefined") {
      return localStorage.getItem(name);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }

  /**
   * Retrieve default settings and apply them to the template
   *
   * @returns void
   */
  function setup() {
    var tmp = get('skin');
    if (tmp && $.inArray(tmp, my_skins))
      change_skin(tmp);

    //Add the change skin listener
    $("[data-skin]").on('click', function (e) {
      if($(this).hasClass('knob'))
        return;
      e.preventDefault();
      change_skin($(this).data('skin'));
    });

    //Add the layout manager
    $("[data-layout]").on('click', function () {
      change_layout($(this).data('layout'));
    });

    $("[data-controlsidebar]").on('click', function () {
      change_layout($(this).data('controlsidebar'));
      var slide = !AdminLTE.options.controlSidebarOptions.slide;
      AdminLTE.options.controlSidebarOptions.slide = slide;
      if (!slide)
        $('.control-sidebar').removeClass('control-sidebar-open');
    });

    $("[data-sidebarskin='toggle']").on('click', function () {
      var sidebar = $(".control-sidebar");
      if (sidebar.hasClass("control-sidebar-dark")) {
        sidebar.removeClass("control-sidebar-dark")
        sidebar.addClass("control-sidebar-light")
      } else {
        sidebar.removeClass("control-sidebar-light")
        sidebar.addClass("control-sidebar-dark")
      }
    });

    $("[data-enable='expandOnHover']").on('click', function () {
      $(this).attr('disabled', true);
      AdminLTE.pushMenu.expandOnHover();
      if (!$('body').hasClass('sidebar-collapse'))
        $("[data-layout='sidebar-collapse']").click();
    });

    // Reset options
    if ($('body').hasClass('fixed')) {
      $("[data-layout='fixed']").attr('checked', 'checked');
    }
    if ($('body').hasClass('layout-boxed')) {
      $("[data-layout='layout-boxed']").attr('checked', 'checked');
    }
    if ($('body').hasClass('sidebar-collapse')) {
      $("[data-layout='sidebar-collapse']").attr('checked', 'checked');
    }

  }
})(jQuery, $.AdminLTE);

$(function () {
	window.Modal = function () {  
		var reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');  
		var alr = $("#com-alert");  
		var ahtml = alr.html();  
	  
		var _tip = function (options, sec) {  
			alr.html(ahtml);    // 复原  
			alr.find('.ok').hide();  
			alr.find('.cancel').hide();  
			alr.find('.modal-content').width(500);  
			_dialog(options, sec);  
			  
			return {  
				on: function (callback) {  
				}  
			};  
		};  
	  
		var _alert = function (options) {  
		  alr.html(ahtml);  // 复原  
		  alr.find('.ok').removeClass('btn-success').addClass('btn-primary');  
		  alr.find('.cancel').hide();  
		  _dialog(options);  
	  
		  return {  
			on: function (callback) {  
			  if (callback && callback instanceof Function) {  
				alr.find('.ok').click(function () { callback(true) });  
			  }  
			}  
		  };  
		};  
	  
		var _confirm = function (options) {  
		  alr.html(ahtml); // 复原  
		  alr.find('.ok').removeClass('btn-primary').addClass('btn-success');  
		  alr.find('.cancel').show();  
		  _dialog(options);  
	  
		  return {  
			on: function (callback) {  
			  if (callback && callback instanceof Function) {  
				alr.find('.ok').click(function () { callback(true) });  
				alr.find('.cancel').click(function () { return; });  
			  }  
			}  
		  };  
		};  
	  
		var _dialog = function (options) {  
		  var ops = {  
			msg: L('msg_content'),  
			title: L('msg_title'),  
			btnok: L('msg_btnok'),  
			btncl: L('msg_btncl')  
		  };  
	  
		  $.extend(ops, options);  
	  
		  var html = alr.html().replace(reg, function (node, key) {  
			return {  
			  Title: ops.title,  
			  Message: ops.msg,  
			  BtnOk: ops.btnok,  
			  BtnCancel: ops.btncl  
			}[key];  
		  });  
			
		  alr.html(html);  
		  alr.modal({  
			width: 250,  
			backdrop: 'static'  
		  });  
		}  
		return {  
			tip: _tip,  
			alert: _alert,  
			confirm: _confirm  
		}  
	}();  

    $('input[type="checkbox"].gl_checkbox, input[type="radio"].gl_checkbox').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });	

	
	
	//全选的实现
	var icheck_input = $('input[type="checkbox"].check-all,input[type="checkbox"].ids').iCheck({
	  checkboxClass: 'icheckbox_minimal-blue',
	});
	icheck_input.iCheck('uncheck');

	
	var checkAll = $('input[type="checkbox"].check-all');
	var checkboxes = $('input[type="checkbox"].ids');
	checkAll.on('ifChecked ifUnchecked', function(event) {
		if (event.type == 'ifChecked') {
		checkboxes.iCheck('check');
		} else {
		checkboxes.iCheck('uncheck');
		}
	});
	checkboxes.on('ifChanged', function(event){
		if(checkboxes.filter(':checked').length == checkboxes.length) {
		checkAll.prop('checked', 'checked');
		} else {
		checkAll.prop('checked','');
		}
		checkAll.iCheck('update');
	});
	
	//退出登录
	$('[data_role="user_logout"]').click(function (e) {
		$.get('/user/logout', '', function(data){
			if(data.code == 1){
				//$.messager.show(data.msg, {placement: 'center',type:'success'});
				layer.msg(data.msg,{icon: 6, time: 2000});
				setTimeout(function () {
					window.location.href = data.url;
				}, 1500);
				
			} 
		}, "json");
	});	
	//ajax get请求
	$(document).on('click', '.ajax-get', function (e) {
		var target;
		var that = this;
		var _is_loading  = false;
		if ($(that).hasClass('loading')){
			_is_loading  = true;
		}
		var get_data = function(){
			if (_is_loading){
				$('#loading').showLoading(
	 			 {
				    'addClass': 'loading-indicator-bars'
								
				 }
				);
			}
			$.get(target).success(function(data) {
				//var data = JSON.parse(data);
				if (data.code == 1) {
					if (_is_loading){
						$('#loading').hideLoading();
					}
					if (data.url) {
						updateAlert(data.msg, 'success');
					} else {
						updateAlert(data.msg, 'success');
					}
					setTimeout(function() {
						if (data.url) {
							location.href = data.url;
						} else if ($(that).hasClass('no-refresh')) {
							$('#top-alert').find('button').click();
						} else {
							location.reload();
						}
					}, 1500);
				} else {
					if (_is_loading){
						$('#loading').hideLoading();
					}
					updateAlert(data.msg, 'error');
					setTimeout(function() {
						//location.reload();
						// if (data.url) {
						// 	location.href = data.url;
						// } else {
						// 	$('#top-alert').find('button').click();
						// }
					}, 1500);
				}
			});
		}
		if ((target = $(this).attr('href')) || (target = $(this).attr('url'))) {
			
			if ($(this).hasClass('confirm')) {
				
				confirm_msg = $(this).attr('confirm_msg');
				if(!confirm_msg){
					confirm_msg = L('msg_confirm');
				}
				layer.confirm(confirm_msg, {
					btn: [L('msg_btnok'), L('msg_btncl')],
					title: L('msg_title'),
					icon: 3
				}, function () {
					get_data();
				}, function (index) {
					layer.close(index);
				});
			}else{
				get_data();
			}
		}
		return false;
	});

	//ajax post submit请求
	$(document).on('click', '.ajax-post', function (e) {
		var target, query, form;
		var target_form = $(this).attr('target-form');
		var that = this;
		var nead_confirm = false;
		var _is_loading  = false;
		if ($(that).hasClass('loading')){
			_is_loading  = true;
		}
		
		
		var post_data = function(){
			if (_is_loading){
				$('#loading').showLoading(
	 			 {
				    'addClass': 'loading-indicator-bars'
								
				 }
				);
			}
			$(that).addClass('disabled').attr('autocomplete', 'off').prop('disabled', true);
			$.post(target, query).success(function(data) {
				//var data = JSON.parse(data);
				if (data.code == 1) {
					if (_is_loading){
						$('#loading').hideLoading();
					}
					if (data.url) {
						updateAlert(data.msg, 'success');
					} else {
						updateAlert(data.msg, 'success');
					}
					setTimeout(function() {
						$(that).removeClass('disabled').prop('disabled', false);
						if (data.url) {
							location.href = data.url;
						} else if ($(that).hasClass('no-refresh')) {
							$('#top-alert').find('button').click();
						} else {
							location.reload();
						}
					}, 1500);
				} else {
					if (_is_loading){
						$('#loading').hideLoading();
					}
					updateAlert(data.msg, 'error');
					setTimeout(function() {
						$(that).removeClass('disabled').prop('disabled', false);
						//location.reload();
						// if (data.url) {
						// 	location.href = data.url;
						// } else {
						// 	$('#top-alert').find('button').click();
						// }
					}, 1500);
				}
			});
		}
		
		if (($(this).attr('type') == 'submit') || (target = $(this).attr('href')) || (target = $(this).attr('url'))) {
			
				
			form = $('.' + target_form);
			if ($(this).attr('hide-data') === 'true') { //无数据时也可以使用的功能
				form = $('.hide-data');
				query = form.serialize();
				
			} else if (form.get(0) == undefined) {
				
				return false;
			} else if (form.get(0).nodeName == 'FORM') {
				
				if ($(this).attr('url') !== undefined) {
					target = $(this).attr('url');
				} else {
					target = form.get(0).action;
				}
				query = form.serialize();
				if ($(this).hasClass('confirm')) {
					layer.confirm(L('msg_confirm'), {
						btn: [L('msg_btnok'), L('msg_btncl')],
						title: L('msg_title'),
						icon: 3
					}, function () {
						post_data();
					}, function (index) {
						layer.close(index);
					});
				}else{
					post_data();
				}
			} else if (form.get(0).nodeName == 'INPUT' || form.get(0).nodeName == 'SELECT' || form.get(0).nodeName == 'TEXTAREA') {
				form.each(function(k, v) {
					if (v.type == 'checkbox' && v.checked == true) {
						nead_confirm = true;
					}
				})
				
				query = form.serialize();
				if (nead_confirm) {
					if ($(this).hasClass('confirm')) {
						layer.confirm(L('msg_confirm'), {
							btn: [L('msg_btnok'), L('msg_btncl')],
							title: L('msg_title'),
							icon: 3
						}, function () {
							post_data();
						}, function (index) {
							layer.close(index);
						});
					}else{
						post_data();
					}
				}else{
					layer.msg(L('please_select_data'),{icon: 5, time: 2000});
				}
			} else {
				query = form.find('input,select,textarea').serialize();
				if ($(this).hasClass('confirm')) {
					layer.confirm(L('msg_confirm'), {
						btn: [L('msg_btnok'), L('msg_btncl')],
						title: L('msg_title'),
						icon: 3
					}, function () {
						post_data();
					}, function (index) {
						layer.close(index);
					});
				}else{
					post_data();
				}
			}
			
		}
		return false;
	});
	window.updateAlert = function(text, c) {
		if (typeof c != 'undefined') {
			
			if(c=='success'){
				layer.msg(text,{icon: 1, time: 2000});	
			}else if(c=='error'){
				layer.msg(text,{icon: 2, time: 2000});	
			}
		} else {
			/*var msg = $.messager.show(text, {
				placement: 'center'
			})*/
			layer.msg(text,{icon: -1, time: 2000});
		}
	};
});

function sToHms(s){
  s = Math.floor(s);  //如果输入的是浮点数，则舍弃小数位
   
  var h = Math.floor(s/3600);
  //计算得出小时数
  if(h<10){  //调整为两位数的格式
    h = '0'+h;
  }
   
  var m = Math.floor(s/60-h*60);
  //计算得出分钟数
  if(m<10){  //调整为两位数的格式
    m = '0'+m;
  }
   
  var s = s%60;  //计算得出剩下的秒数
  if(s<10){  //调整为两位数的格式
    s = '0'+s;
  }
   
  return h+':'+m+':'+s;  //最后连接成字符串并返回
}

function bytesToSize(bytes) {
    if (bytes === 0) return '0 B';
    var k = 1000, // or 1024
        sizes = ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
   return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
}

/**
 * 置顶函数
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function go_to_top(obj){
	var scrTop = $(window).scrollTop();
	var windowTop = $(window).height();
	if ((windowTop-300)<scrTop){
		$("#"+obj).fadeIn("slow");
	}else{
		$("#"+obj).fadeOut("slow");
	}	
}

/**
 * 弹出层
 * @param title 层标题
 * @param url 层链接(opt.type=2|默认)或者HTML内容(opt.type=1)
 * @param opt 选项 {w:WIDTH('800px|80%'),h:HEIGHT('600px|80%'),type:1|2,fn:CALLBACK(回调函数),confirm:BOOL(关闭弹层警告)}
 */
function layer_open(title, url, opt) {
    if (typeof opt === "undefined") opt = {nav: true};
    w = opt.w || "80vw";
    h = opt.h || "80vh";
    // 不支持vh,vw单位时采取js动态获取
    if (!attr_support('height', '10vh')) {
        w = w.replace(/([\d\.]+)(vh|vw)/, function (source, num, unit) {
            return $(window).width() * num / 100 + 'px';
        });
        h = h.replace(/([\d\.]+)(vh|vw)/, function (source, num, unit) {
            return $(window).height() * num / 100 + 'px';
        });
    }
    return layer.open({
        type: opt.type || 2,
        area: [w, h],
        fix: false, // 不固定
        maxmin: true,
        shade: 0.4,
        title: title,
        content: url,
        success: function (layero, index) {
            if (typeof opt.confirm !== "undefined" && opt.confirm === true) {
                layero.find(".layui-layer-close").off("click").on("click", function () {
                    layer.alert(L('close_window'), {
                        btn: [L('msg_btnok'), L('msg_btncl')] //按钮
                    }, function (i) {
                        layer.close(i);
                        layer.close(index);
                    });
                });
            }
            // 自动添加面包屑导航
            if (true === opt.nav) {
                layer.getChildFrame('#nav-title', index).html($('#nav-title').html() + ' <span class="c-gray en">&gt;</span> ' + $('.layui-layer-title').html());
            }
            if (typeof opt.fn === "function") {
                opt.fn(layero, index);
            }
        }
    });
};

/**
 * 全屏打开窗口，参数见layer_open
 */
function full_page(title, url, opt) {
    var index = layer_open(title, url, opt);
    layer.full(index);
    return index;
};

/**
 * iframe内打开新窗口
 * @param title
 * @param url
 */
function open_window(title, url) {
    //解决在非iframe页里打开不了页面的问题
    if (window.parent.frames.length == 0) {
        window.open(url);
        return false;
    }
    var bStop = false;
    var bStopIndex = 0;
    var topWindow = $(window.top.parent.document);
    var show_navLi = topWindow.find("#min_title_list li");
    var iframe_box = topWindow.find('#iframe_box');
    show_navLi.each(function () {
        if ($(this).find('span').attr("data-href") == url) {
            bStop = true;
            bStopIndex = show_navLi.index($(this));
            return false;
        }
    });
    if (!bStop) {
        var show_nav = topWindow.find('#min_title_list');
        show_nav.find('li').removeClass("active");
        show_nav.append('<li class="active"><span data-href="' + url + '">' + title + '</span><i></i><em></em></li>');
        var taballwidth = 0,
            $tabNav = $(".acrossTab", window.top.parent.document),
            $tabNavitem = $(".acrossTab li", window.top.parent.document);
        $tabNavitem.each(function (index, element) {
            taballwidth += Number(parseFloat($(this).width() + 60))
        });
        $tabNav.width(taballwidth + 25);
        var iframeBox = iframe_box.find('.show_iframe');
        iframeBox.hide();
        iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src=' + url + '></iframe></div>');
        var showBox = iframe_box.find('.show_iframe:visible');
        showBox.find('iframe').attr("src", url).load(function () {
            showBox.find('.loading').hide();
        });
    }
    else {
        show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
        iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src", url);
    }

}
/**
 * 操作对象发送ajax请求
 * @param url 请求地址
 * @param data 请求参数
 * @param callback 成功回调
 * @param param 回调参数
 * @param shade 是否遮罩
 */
function ajax_req(url, data, callback, param, shade) {
    if (shade == true) var loading = layer.load(2);
    $.post(url, data, function (ret) {
        shade == true && layer.close(loading);
        ajax_progress(ret, callback, param);
    }, 'json')
}

/**
 * ajax 处理，对应服务端 ajax_return_adv 方法返回的 json 数据处理
 * @param data ajax返回数据
 * @param callback 成功回调函数
 * @param param 回调参数
 */
function ajax_progress(data, callback, param) {
    if (data.code == 0) {
        if (typeof data.opt == "object") {
            var index = parent.layer.getFrameIndex(window.name);
            if (data.opt.close) {
                parent.layer.close(index);
            }
            if (data.opt.redirect == 'current') {
                // 当前页重定向
                if (!data.opt.url) {
                    // 刷新
                    window.location.reload();
                } else {
                    // 重定向到 url
                    window.location.href = data.opt.url;
                }
            } else if (data.opt.redirect == 'parent') {
                // 父层重定向
                if (!data.opt.url) {
                    // 刷新
                    window.parent.location.reload();
                } else {
                    // 重定向到 url
                    window.parent.location.href = data.opt.url;
                }
                // 关闭当前层
                parent.layer.close(index);
            }
            // 父层弹出信息
            if (data.opt.alert) {
                parent.layer.alert(data.opt.alert);
                parent.layer.close(index);
            }
            if (!data.opt.close && !data.opt.redirect && !data.opt.alert) {
                parent.layer.msg(data.msg);
                parent.layer.close(index);
            }
        } else {
            layer.msg(data.msg);
        }
        if (typeof callback == "function") {
            if (typeof param != "undefined" && param) {
                param.unshift(data)
            } else {
                param = [data];
            }
            callback.apply(this, param);
        }
    } else {
        if (data.code == 400) {
            login(data.data);
        } else {
            layer.alert(data.msg, {title: "错误信息", icon: 2});
        }
    }
}
/**
 * 恢复禁用等状态改变回调函数
 * @param ret
 * @param obj
 * @param type
 */
function change_status(ret, obj, type) {
    //配置数据，TYPE:['下一状态文字描述','当前状态class颜色','下一状态class颜色','下一状态方法名','状态标签选择器','下一状态标签icon','下一状态标签title']
    var data = {
        'resume': ['禁用', 'success', 'warning', 'forbid', '.status', '&#xe615;', '正常'],
        'forbid': ['恢复', 'warning', 'success', 'resume', '.status', '&#xe631;', '禁用'],
    };
    var $this = $(obj);
    $this.html(data[type][0])
        .attr("title", "点击" + data[type][0])
        .removeClass("label-" + data[type][1])
        .addClass("label-" + data[type][2])
        .attr("onclick", $this.attr("onclick").replace(new RegExp(type, 'g'), data[type][3]));
    $this.parents("tr")
        .find(data[type][4])
        .html(data[type][5])
        .removeClass("c-" + data[type][2])
        .addClass("c-" + data[type][1])
        .attr("title", data[type][6]);
}
/*
**
 * 动态加载javascript或style文件
 * @param src
 * @param callback
 * @param type
 */
function load_file(src, callback, type) {
    type = type || 'script';
    var head = document.getElementsByTagName('head')[0];
    if (type == 'script') {
        var node = document.createElement('script');
        node.type = 'text/javascript';
        node.charset = 'UTF-8';
        node.src = src;
    } else {
        var node = document.createElement('link');
        node.rel = 'stylesheet';
        node.href = src;
    }

    if (node.addEventListener) {
        node.addEventListener('load', function () {
            typeof callback == "function" && callback();
        }, false);
    } else if (node.attachEvent) {
        node.attachEvent('onreadystatechange', function () {
            var target = window.event.srcElement;
            if (target.readyState == 'loaded') {
                typeof callback == "function" && callback();
            }
        });
    }
    head.appendChild(node);
}

/**
 * 表格无限宽横向溢出
 * @param selector
 * @param width 不赋值默认为th的width值和
 * @param force 强制将表格宽度设置成实际的宽度
 */
function table_fixed(selector, width, force) {
    var attr = typeof force == 'undefined' ? 'min-width' : 'width';
    $(selector).each(function () {
        $this = $(this);
        //未设置宽度自动获取width属性的宽
        if (typeof width === "undefined") {
            width = 0;
            $this.find("tr:first th").each(function () {
                width += parseInt($(this).attr("width") || $(this).innerWidth());
            })
        }
        $this.css(attr, width + "px");
        $this.css("table-layout", "fixed");
        $this.wrap('<div style="width:100%;overflow:auto"></div>');
    });
}

/**
 * 检查浏览器是否支持某属性
 * @param attrName
 * @param attrValue
 * @returns {boolean}
 */
function attr_support(attrName, attrValue) {
    try {
        var element = document.createElement('div');
        if (attrName in element.style) {
            element.style[attrName] = attrValue;
            return element.style[attrName] === attrValue;
        } else {
            return false;
        }
    } catch (e) {
        return false;
    }
}


/**
 * 高级版 Tab 切换
 * @param tabBar Tab 标签
 * @param tabCon Tab 容器
 * @param class_name 被选中标签class
 * @param tabEvent 触发 Tab 切换的事件
 * @param i 被激活索引
 * @param callback 切换回调函数 callback(index,$tabCon,$tabBar)
 * @param finished 初始化完成之后的回调函数 finished(index,$tabCon,$tabBar)
 */
jQuery.tpTab = function (tabBar, tabCon, class_name, tabEvent, i, callback, finished) {
    var $tabBar = $(tabBar), $tabCon = $(tabCon);

    function chg(index) {
        $tabBar.removeClass(class_name).eq(index).addClass(class_name);
        $tabCon.hide().eq(index).show();
    }

    // 初始化操作
    chg(i || 0);
    typeof finished === "function" && finished(i, $tabCon, $tabBar);

    $tabBar.bind(tabEvent, function () {
        var index = $tabBar.index(this);
        chg(index);
        typeof callback === "function" && callback(index, $tabCon, $tabBar);
    });
};