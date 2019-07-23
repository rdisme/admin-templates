#
# SQL Export
# Created by Querious (201048)
# Created: 2019年3月15日 GMT+8 下午2:19:24
# Encoding: Unicode (UTF-8)
#


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `admin_user`;
DROP TABLE IF EXISTS `admin_rule`;
DROP TABLE IF EXISTS `admin_role`;


CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `ruleid` varchar(128) DEFAULT NULL COMMENT '权限ID admin表示无敌权限',
  `description` varchar(32) DEFAULT NULL COMMENT '角色描述 不能超过32字符',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常 2禁用',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniname` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台角色表';


CREATE TABLE `admin_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '权限名称 不超过10个字符',
  `icon` varchar(32) DEFAULT NULL COMMENT '图标',
  `c` varchar(32) DEFAULT NULL COMMENT '控制器名',
  `m` varchar(32) DEFAULT NULL COMMENT '方法名',
  `pid` int(1) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权限类型 1表示隐藏菜单栏',
  PRIMARY KEY (`id`),
  KEY `cm` (`c`,`m`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='后台权限表';


CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(1) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(32) DEFAULT NULL COMMENT '公司邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常 2禁用',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `ip` varchar(31) DEFAULT NULL COMMENT 'ip限制 顶多2个\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


LOCK TABLES `admin_role` WRITE;
ALTER TABLE `admin_role` DISABLE KEYS;
INSERT INTO `admin_role` (`id`, `name`, `ruleid`, `description`, `status`, `addtime`) VALUES 
	(1,'超级管理员','admin','具有至高无上的权利',1,'2018-06-18 16:50:17');
ALTER TABLE `admin_role` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `admin_rule` WRITE;
ALTER TABLE `admin_rule` DISABLE KEYS;
INSERT INTO `admin_rule` (`id`, `name`, `icon`, `c`, `m`, `pid`, `status`, `addtime`, `type`) VALUES 
	(1,'管理员管理','layui-icon-zzuser-secret','','',0,1,'2018-06-19 11:06:21',0),
	(2,'管理员列表',NULL,'userAdmin','index',1,1,'2018-06-19 11:45:09',0),
	(3,'角色管理',NULL,'userAdmin','role',1,1,'2018-06-19 15:14:09',0),
	(4,'权限管理',NULL,'userAdmin','rule',1,1,'2018-06-19 15:20:38',0),
	(5,'权限分类',NULL,'userAdmin','cate',1,1,'2018-06-19 15:26:14',0);
ALTER TABLE `admin_rule` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `admin_user` WRITE;
ALTER TABLE `admin_user` DISABLE KEYS;
INSERT INTO `admin_user` (`id`, `roleid`, `username`, `password`, `phone`, `email`, `status`, `addtime`, `ip`) VALUES 
	(1,1,'admin','2b09270d5243002c67de3ea85d76c7c6','18888888888','gmail@gmail.com',1,'2018-06-13 16:02:24','');
ALTER TABLE `admin_user` ENABLE KEYS;
UNLOCK TABLES;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


