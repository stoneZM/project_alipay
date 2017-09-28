# demo

#### 实现简单的管理平台
#### 实现支付宝支付和微信支付功能


## 使用方法
### 环境要求：
	Linux 平台
	Apache版本 > 2.0
	或者 nginx版本 > 1.12
	PHP版本 > 5.4
	mysql版本> 5.6
	将sep-7下的所有文件放置apache根目录,
	
### 数据库导入
    
    1、建立数据库
    2、更改 application/database.php 数据库相关信息
    3、执行 sql.sql文件将表导入数据库

### 支付配置
    1、登录后台管理系统
     链接： 域名/index.php/admin/login
     账号：admin
     密码：123456
     在支付配置页签直接填写自己的支付配置信息，然后提交即可 

### 前台访问
    链接： 域名/index.php/user/login	
