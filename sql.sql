# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.33)
# Database: demo
# Generation Time: 2017-09-25 01:45:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `status` tinyint(1) DEFAULT '1',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;

INSERT INTO `admin` (`id`, `username`, `password`, `status`, `create_time`)
VALUES
	(1,'admin','e10adc3949ba59abbe56e057f20f883e',1,1505142729);

/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pay_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pay_account`;

CREATE TABLE `pay_account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT '模块',
  `userid` int(10) unsigned DEFAULT '0' COMMENT '用户ID',
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `trade_sn` varchar(50) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `seller_id` varchar(40) DEFAULT NULL,
  `seller_email` varchar(40) DEFAULT NULL,
  `wxpay_appid` varchar(40) DEFAULT NULL,
  `openid` varchar(90) DEFAULT NULL,
  `month` tinyint(2) DEFAULT '0',
  `trade_type` varchar(40) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `contactname` varchar(150) DEFAULT NULL COMMENT '商品名称',
  `totalMoney` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `num` int(8) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `pay_type` enum('alipay','weixin','unpay') NOT NULL DEFAULT 'alipay' COMMENT '支付类型',
  `pay_ment` varchar(90) NOT NULL COMMENT '支付类型名称',
  `payment_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '支付类型',
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '客户端ip',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态：0（未支付） 99（支付成功）',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付添加时间',
  `edittime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `userid` (`userid`),
  KEY `trade_sn` (`trade_sn`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `setting` mediumtext,
  `addtime` int(10) DEFAULT '0',
  `edittime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;

INSERT INTO `setting` (`id`, `module`, `setting`, `addtime`, `edittime`)
VALUES
	(1,'pay','{\\\"alipay_account\\\":\\\"2088721377760576\\\",\\\"alipay_parterid\\\":\\\"2088721377760576\\\",\\\"alipay_key\\\":\\\"j7flonukyahxtiecb4b0yx4fq425y8r5\\\",\\\"alipay_seller_email\\\":\\\"lohover@163.com\\\",\\\"alipay_sslcert_path\\\":\\\"\\\\/cert\\\\/apiclient_cert.pem\\\",\\\"alipay_sslkey_path\\\":\\\"\\\\/cert\\\\/apiclient_key.pem\\\",\\\"wxpay_appid\\\":\\\"wx2cdc50e475ad21b9\\\",\\\"wxpay_appsecret\\\":\\\"9c39bbec840d1267f67805ec9cb9f84d\\\",\\\"wxpay_mchid\\\":\\\"1486574132\\\",\\\"wxpay_key\\\":\\\"LoHover2a0B1c7D6e6F8g8H9iLoHover\\\",\\\"wxpay_sslcert_path\\\":\\\"\\\\/cert\\\\/apiclient_cert.pem\\\",\\\"wxpay_sslkey_path\\\":\\\"\\\\/cert\\\\/apiclient_key.pem\\\"}',1498442732,1506258814),
	(2,'attachment','{\\\"upload_img_maxsize\\\":\\\"2048\\\",\\\"upload_img_allowext\\\":\\\"jpg,jpeg,gif,bmp,png\\\",\\\"upload_file_maxsize\\\":\\\"20480\\\",\\\"upload_file_allowext\\\":\\\"doc,docx,xls,xlsx,ppt,pptx,pdf,txt,rar,zip\\\",\\\"upload_video_maxsize\\\":\\\"20480\\\",\\\"upload_video_allowext\\\":\\\"flv,wm,swf,rm,avi,mp4,3gp,rmvb,mov,m4v\\\",\\\"watermark_minwidth\\\":\\\"300\\\",\\\"watermark_minheight\\\":\\\"300\\\",\\\"watermark_img\\\":\\\"mark.gif\\\",\\\"watermark_pct\\\":\\\"100\\\",\\\"watermark_quality\\\":\\\"80\\\",\\\"watermark_pos\\\":\\\"1\\\"}',1498443024,1498443024);

/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone_num` bigint(11) unsigned NOT NULL,
  `password` varchar(40) NOT NULL DEFAULT '',
  `user_name` varchar(40) DEFAULT NULL,
  `is_vip` tinyint(1) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `reg_time` int(11) unsigned NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` int(11) unsigned DEFAULT '0',
  `login` mediumint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `phone_num` (`phone_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table vip_activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vip_activity`;

CREATE TABLE `vip_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(1) unsigned NOT NULL,
  `title` varchar(200) DEFAULT ' ' COMMENT '活动的标题',
  `content` text,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `vip_activity` WRITE;
/*!40000 ALTER TABLE `vip_activity` DISABLE KEYS */;

INSERT INTO `vip_activity` (`id`, `user_id`, `title`, `content`, `status`, `create_time`)
VALUES
	(8,1,'活动一','<ul>\n	<li>\n	<p>活动一的内容</p>\n	</li>\n</ul>\n\n<ol>\n	<li>活动一的内容</li>\n</ol>\n\n<ul>\n	<li>\n	<p>活动一/<a href=\"https://www.baidu.com\" id=\"11\" name=\"11\">https://www.baidu.com</a></p>\n	</li>\n</ul>\n',1,1505282600),
	(9,1,'活动二','<p><u>活动二的内容</u><br></p><p><u>活动二的内容</u><br></p><p><u>活动二的内容</u><br></p><p><u>活动二的内容</u><br></p>',1,1505283199);

/*!40000 ALTER TABLE `vip_activity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vip_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vip_info`;

CREATE TABLE `vip_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `begin_time` int(11) DEFAULT NULL COMMENT '会员开始时间',
  `expir_time` int(11) DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




# Dump of table vip_price
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vip_price`;

CREATE TABLE `vip_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `price` smallint(5) DEFAULT '0',
  `month` tinyint(12) NOT NULL DEFAULT '1',
  `desc` varchar(200) DEFAULT ' ',
  `sort` tinyint(4) DEFAULT '0',
  `is_recommend` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vip_price` WRITE;
/*!40000 ALTER TABLE `vip_price` DISABLE KEYS */;

INSERT INTO `vip_price` (`id`, `price`, `month`, `desc`, `sort`, `is_recommend`, `create_time`, `status`)
VALUES
	(1,30,1,'1个月30元',4,0,1505301683,1),
	(4,78,3,'3个月78元',3,0,1505304455,1),
	(5,120,6,'6个月120元',2,0,1505304474,1),
	(6,180,12,'12个月180元',1,1,1505304493,1);

/*!40000 ALTER TABLE `vip_price` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
