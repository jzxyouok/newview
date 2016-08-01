/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : xuanyucms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-07-31 18:12:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '标识',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='幻灯片';

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('2', '1', '1', '1', '100', null, null, null, null);

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `title` varchar(50) DEFAULT '' COMMENT '配置标题',
  `name` varchar(50) DEFAULT '' COMMENT '配置名称',
  `value` varchar(255) DEFAULT '' COMMENT '配置值',
  `config_group_id` int(10) DEFAULT NULL COMMENT '配置组标识',
  `type` varchar(50) DEFAULT '' COMMENT '配置项类型',
  `param` varchar(255) DEFAULT '' COMMENT '参数',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `sort` int(10) unsigned DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES ('45', '标题', 'title', '标题', '1', 'text', '', '一般不超过80个字符', '1', '1');
INSERT INTO `config` VALUES ('48', '关闭说明', 'stop_run_explain', '关闭说明', '1', 'textarea', '', null, '1', '100');
INSERT INTO `config` VALUES ('47', '关闭站点', 'stop_run', '1', '1', 'radio', '1|开启,0|关闭', '', '1', '100');
INSERT INTO `config` VALUES ('51', '关键字', 'keywords', '关键字', '1', 'textarea', '', '一般不超过100个字符，使用“,”隔开', '1', '2');
INSERT INTO `config` VALUES ('52', '描述', 'description', '描述', '1', 'textarea', '', '一般不超过200个字符', '1', '3');

-- ----------------------------
-- Table structure for config_group
-- ----------------------------
DROP TABLE IF EXISTS `config_group`;
CREATE TABLE `config_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `sort` int(10) DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='配置组';

-- ----------------------------
-- Records of config_group
-- ----------------------------
INSERT INTO `config_group` VALUES ('1', '基本配置', '1', '', '100');

-- ----------------------------
-- Table structure for data_to_upload
-- ----------------------------
DROP TABLE IF EXISTS `data_to_upload`;
CREATE TABLE `data_to_upload` (
  `upload_id` int(10) NOT NULL COMMENT '上传文件标识',
  `data_id` int(10) NOT NULL COMMENT '数据标识',
  `tbname` varchar(50) DEFAULT NULL COMMENT '数据所属表名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据与上传文件关系表';

-- ----------------------------
-- Records of data_to_upload
-- ----------------------------
INSERT INTO `data_to_upload` VALUES ('5', '2', 'banner');
INSERT INTO `data_to_upload` VALUES ('17', '5', 'infoarticle');
INSERT INTO `data_to_upload` VALUES ('19', '6', 'infoarticle');

-- ----------------------------
-- Table structure for dict
-- ----------------------------
DROP TABLE IF EXISTS `dict`;
CREATE TABLE `dict` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '标识',
  `name` varchar(50) DEFAULT '' COMMENT '名称',
  `ident` varchar(10) DEFAULT '' COMMENT '标识',
  `type` tinyint(4) DEFAULT NULL COMMENT '字典类型',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='通用字典';

-- ----------------------------
-- Records of dict
-- ----------------------------
INSERT INTO `dict` VALUES ('30', '新增', 'i', '3', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('31', '修改', 'u', '3', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('32', '删除', 'd', '3', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('33', '审核', 'a', '3', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('36', '查看', 'l', '3', '', '1', null, null, null, null);
INSERT INTO `dict` VALUES ('7', '隐藏', '0', '1', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('6', '显示', '1', '1', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('37', '开发者', 'developer', '2', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('38', '生产者', 'producter', '2', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('39', '文本', 'text', '4', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('40', '单选', 'radio', '4', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('41', '复选', 'checkbox', '4', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('42', '下拉列表', 'select', '4', '', '100', null, null, null, null);
INSERT INTO `dict` VALUES ('43', '文本域', 'textarea', '4', '', '100', null, null, null, null);

-- ----------------------------
-- Table structure for infoarticle
-- ----------------------------
DROP TABLE IF EXISTS `infoarticle`;
CREATE TABLE `infoarticle` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '标识',
  `category_id` int(10) DEFAULT NULL COMMENT '分类标识',
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `remark` varchar(255) DEFAULT '' COMMENT '摘要',
  `content` text COMMENT '内容',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `sort` int(10) DEFAULT '100' COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of infoarticle
-- ----------------------------
INSERT INTO `infoarticle` VALUES ('2', '6', '标题', '摘要', '<p><span style=\"color: rgb(51, 51, 51); line-height: 20px; text-align: right; background-color: rgb(255, 255, 255);\">内容</span></p>', '1', '100', null, null, '1468477171', null);
INSERT INTO `infoarticle` VALUES ('3', '6', '标题1', '摘要', '<p><span style=\"color: rgb(51, 51, 51); line-height: 20px; text-align: right; background-color: rgb(255, 255, 255);\">内容</span></p>', '1', '100', null, null, '1468477178', null);
INSERT INTO `infoarticle` VALUES ('5', '8', '123', '', '', '1', '100', null, null, '1469955307', null);
INSERT INTO `infoarticle` VALUES ('6', '8', '234', '', '', '1', '100', null, null, '1469955388', null);

-- ----------------------------
-- Table structure for infocategory
-- ----------------------------
DROP TABLE IF EXISTS `infocategory`;
CREATE TABLE `infocategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `level` tinyint(3) DEFAULT NULL COMMENT '级别【从0开始】',
  `infomodel_id` int(11) DEFAULT NULL COMMENT '信息模型标识',
  `url` varchar(255) DEFAULT '' COMMENT '跳转url【外链使用】',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) DEFAULT NULL COMMENT '显示：0=隐藏，1=显示',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='分类信息';

-- ----------------------------
-- Records of infocategory
-- ----------------------------
INSERT INTO `infocategory` VALUES ('1', '框架', '0', '0', '38', '', '', '', '', '1', '127', null, null, null, null);
INSERT INTO `infocategory` VALUES ('2', 'CMS', '0', '0', '38', 'URL', 'SEO标题', 'SEO描述', '备注', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('3', '前端库', '0', '0', '38', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('5', '代码分享', '2', '1', '38', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('6', '下载', '0', '0', '39', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('7', '代码分享', '3', '1', '38', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('8', 'BUG反馈', '1', '1', '39', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('11', '案例', '0', '0', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('12', '框架案例', '11', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('13', 'CMS案例', '11', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('14', '话题讨论', '1', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('15', '话题讨论', '2', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('16', '话题讨论', '3', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('17', '论坛', '0', '0', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('18', '插件扩展', '2', '1', '38', '', '', '', '', '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('19', '教程文档', '1', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('20', '教程文档', '2', '1', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('21', '单文章', '0', '0', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('22', '后盾网', '0', '0', null, '', '', '', null, '1', '100', null, null, null, null);
INSERT INTO `infocategory` VALUES ('23', '系统更新', '2', '1', null, '', '', '', null, '1', '100', null, null, null, null);

-- ----------------------------
-- Table structure for infomodel
-- ----------------------------
DROP TABLE IF EXISTS `infomodel`;
CREATE TABLE `infomodel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(60) DEFAULT '' COMMENT '名称',
  `front_controller` varchar(20) DEFAULT NULL COMMENT '前台控制器',
  `controller` varchar(20) DEFAULT NULL COMMENT '控制器',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `is_show` varchar(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `sort` smallint(5) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='信息模型';

-- ----------------------------
-- Records of infomodel
-- ----------------------------
INSERT INTO `infomodel` VALUES ('38', '单页', 'single', 'infosingle', '例如：公司简介，联系我们等', '1', '100', null, null, null, null);
INSERT INTO `infomodel` VALUES ('39', '文章', 'article', 'infoarticle', '', '1', '100', null, null, null, null);

-- ----------------------------
-- Table structure for information
-- ----------------------------
DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `id` int(10) NOT NULL COMMENT '标识',
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='信息';

-- ----------------------------
-- Records of information
-- ----------------------------

-- ----------------------------
-- Table structure for infosingle
-- ----------------------------
DROP TABLE IF EXISTS `infosingle`;
CREATE TABLE `infosingle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `category_id` int(10) unsigned DEFAULT NULL COMMENT '分类标识',
  `content` text COMMENT '内容',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='单页信息表';

-- ----------------------------
-- Records of infosingle
-- ----------------------------
INSERT INTO `infosingle` VALUES ('19', '2', '<p>这就是14号字</p><p>This is 14 Font</p>', null, null, null, null);
INSERT INTO `infosingle` VALUES ('20', '5', null, null, null, null, null);
INSERT INTO `infosingle` VALUES ('21', '18', null, null, null, null, null);
INSERT INTO `infosingle` VALUES ('22', '3', null, null, null, null, null);
INSERT INTO `infosingle` VALUES ('23', '1', null, null, null, null, null);
INSERT INTO `infosingle` VALUES ('26', '7', null, null, null, null, null);

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `user_id` int(10) DEFAULT NULL COMMENT '用户标识',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `menu_id` int(10) DEFAULT NULL COMMENT ' 节点标识',
  `menu_name` varchar(50) DEFAULT NULL COMMENT '节点名称',
  `menu_auth_ident` varchar(20) DEFAULT NULL COMMENT '动作标识',
  `menu_auth_name` varchar(50) DEFAULT NULL COMMENT '动作名称',
  `ip` varchar(36) DEFAULT NULL COMMENT 'IP 地址',
  `time` int(10) DEFAULT NULL COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465268278');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465268292');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465268296');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465268304');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'i', '新增', '::1', '1465268318');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465268344');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465273686');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465268355');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465268410');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465270005');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465270008');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465270010');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465270412');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465271063');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465271077');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465271079');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465271103');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465271104');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465271105');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465271155');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465271157');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465272241');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465272243');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'i', '新增', '::1', '1465272246');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465272248');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465272249');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465272251');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465273690');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465274564');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465274567');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465274608');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465274611');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465274631');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465274633');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465274799');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465274801');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465274803');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465284053');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465284739');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465284867');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465284869');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465284871');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465284873');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465285444');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465285445');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465285722');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465286957');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465286960');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465287163');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465287188');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465287347');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465287353');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465287354');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465287355');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465287357');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465287447');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465287449');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465287698');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465287700');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465287703');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465287704');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465289220');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465290179');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465293783');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465294388');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465294392');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465294395');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465294396');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465294460');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465483609');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'i', '新增', '::1', '1465483612');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465483618');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465483620');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465483621');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465483636');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465483639');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465484186');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465484187');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465484215');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465484216');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465484803');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465484967');
INSERT INTO `logs` VALUES ('25', 'admin', null, null, 'd', '删除', '::1', '1465484969');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465484972');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465484974');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465485264');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465485271');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'i', '新增', '::1', '1465485273');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465485276');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'd', '删除', '::1', '1465485278');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465485281');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465485282');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465485329');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'u', '修改', '::1', '1465485339');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465485340');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465485344');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465485345');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465485405');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465485407');
INSERT INTO `logs` VALUES ('25', 'admin', '25', '修改密码', 'l', '查看', '::1', '1465485408');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465485409');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465485410');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465485729');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465522961');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465523003');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465523004');
INSERT INTO `logs` VALUES ('25', 'admin', '7', '管理员', 'l', '查看', '::1', '1465523006');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465523007');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465523094');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465523134');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465523136');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465523138');
INSERT INTO `logs` VALUES ('25', 'admin', '6', '角色管理', 'l', '查看', '::1', '1465523140');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465523165');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465782703');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465782707');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'i', '新增', '::1', '1465782710');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465782712');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465782829');
INSERT INTO `logs` VALUES ('25', 'admin', '30', '幻灯片', 'l', '查看', '::1', '1465783801');
INSERT INTO `logs` VALUES ('25', 'admin', '5', '站点配置', 'l', '查看', '::1', '1465783804');
INSERT INTO `logs` VALUES ('25', 'admin', '26', '欢迎页', 'l', '查看', '::1', '1465783806');
INSERT INTO `logs` VALUES ('25', 'admin', '29', '操作日志', 'l', '查看', '::1', '1465783808');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '49', '操作日志', 'l', '查看', '::1', '1468478294');
INSERT INTO `logs` VALUES ('26', 'login', '43', '配置组', 'l', '查看', '::1', '1468478382');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '26', '欢迎页', 'l', '查看', '::1', '1468478445');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '6', '角色管理', 'l', '查看', '::1', '1468478470');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '7', '管理员', 'l', '查看', '::1', '1468478473');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '6', '角色管理', 'l', '查看', '::1', '1468478474');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '6', '角色管理', 'u', '修改', '::1', '1468478476');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '6', '角色管理', 'l', '查看', '::1', '1468478477');
INSERT INTO `logs` VALUES ('26', 'login', '49', '操作日志', 'l', '查看', '::1', '1468478492');
INSERT INTO `logs` VALUES ('26', 'login', '43', '配置组', 'l', '查看', '::1', '1468478568');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '26', '欢迎页', 'l', '查看', '::1', '1468478592');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '49', '操作日志', 'l', '查看', '::1', '1468478604');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '52', '通用字典', 'l', '查看', '::1', '1468478791');
INSERT INTO `logs` VALUES ('31', 'xuanyunet', '49', '操作日志', 'l', '查看', '::1', '1468478793');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '标识',
  `name` varchar(50) DEFAULT '' COMMENT '名称',
  `parent_id` int(10) DEFAULT '0' COMMENT '上级标识',
  `level` tinyint(4) DEFAULT NULL COMMENT '级别',
  `module` varchar(50) DEFAULT '' COMMENT '目录',
  `controller` varchar(50) DEFAULT '' COMMENT '控制器',
  `method` varchar(50) DEFAULT '' COMMENT '方法',
  `param` varchar(100) DEFAULT '' COMMENT '参数',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '显示：0=隐藏，1=显示',
  `user_type` varchar(10) DEFAULT '' COMMENT '用户类型：d=开发者，p=生产者',
  `sort` int(10) DEFAULT '100' COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='系统菜单';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '开始', '0', '0', '', '', '', '', '', '1', 'producter', '1', null, null, null, null);
INSERT INTO `menu` VALUES ('2', '配置', '0', '0', '', '', '', '', '', '1', 'producter', '2', null, null, null, null);
INSERT INTO `menu` VALUES ('3', '信息', '0', '0', '', '', '', '', '', '1', 'producter', '4', null, null, null, null);
INSERT INTO `menu` VALUES ('4', '扩展', '0', '0', '', '', '', '', '', '1', 'producter', '5', null, null, null, null);
INSERT INTO `menu` VALUES ('5', '网站配置', '2', '1', '', 'configure', '', '', '', '1', 'developer', '1', null, null, null, null);
INSERT INTO `menu` VALUES ('6', '角色管理', '47', '1', '', 'role', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('7', '管理员', '47', '1', '', 'user', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('26', '欢迎页', '1', '1', '', 'welcome', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('25', '修改密码', '47', '1', '', 'update_psw', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('29', '日志', '1', '1', '', '', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('30', '幻灯片', '4', '1', '', 'banner', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('34', '信息分类', '3', '1', '', 'infocategory', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('35', '信息管理', '3', '1', '', 'information', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('40', '菜单', '0', '0', '', '', '', '', '', '1', 'producter', '6', null, null, null, null);
INSERT INTO `menu` VALUES ('43', '配置组', '2', '1', '', 'config_group', '', '', '', '1', 'producter', '2', null, null, null, null);
INSERT INTO `menu` VALUES ('41', '后台菜单', '40', '1', '', '', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('44', '配置项', '2', '1', '', 'config_item', '', '', '', '1', 'producter', '3', null, null, null, null);
INSERT INTO `menu` VALUES ('45', '信息模型', '3', '1', '', 'infomodel', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('46', '前台菜单', '40', '1', '', '', '', '', '', '0', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('47', '用户', '0', '0', '', '', '', '', '', '1', 'producter', '3', null, null, null, null);
INSERT INTO `menu` VALUES ('49', '操作日志', '29', '2', '', 'operation_log', '', '', '', '1', 'producter', '100', null, null, null, null);
INSERT INTO `menu` VALUES ('51', '菜单管理', '41', '2', '', 'menu', '', '', '', '1', 'producter', '1', null, null, null, null);
INSERT INTO `menu` VALUES ('52', '通用字典', '1', '1', '', 'dict', '', '', '', '1', 'producter', '100', null, null, null, null);

-- ----------------------------
-- Table structure for menu_to_auth
-- ----------------------------
DROP TABLE IF EXISTS `menu_to_auth`;
CREATE TABLE `menu_to_auth` (
  `menu_id` int(10) NOT NULL COMMENT '节点标识',
  `menu_auth_id` int(10) NOT NULL COMMENT '节点权限标识'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统菜单权限关系表';

-- ----------------------------
-- Records of menu_to_auth
-- ----------------------------
INSERT INTO `menu_to_auth` VALUES ('52', '31');
INSERT INTO `menu_to_auth` VALUES ('52', '36');
INSERT INTO `menu_to_auth` VALUES ('52', '32');
INSERT INTO `menu_to_auth` VALUES ('49', '36');
INSERT INTO `menu_to_auth` VALUES ('6', '31');
INSERT INTO `menu_to_auth` VALUES ('6', '36');
INSERT INTO `menu_to_auth` VALUES ('6', '32');
INSERT INTO `menu_to_auth` VALUES ('2', '36');
INSERT INTO `menu_to_auth` VALUES ('6', '30');
INSERT INTO `menu_to_auth` VALUES ('7', '31');
INSERT INTO `menu_to_auth` VALUES ('1', '36');
INSERT INTO `menu_to_auth` VALUES ('25', '31');
INSERT INTO `menu_to_auth` VALUES ('7', '36');
INSERT INTO `menu_to_auth` VALUES ('7', '32');
INSERT INTO `menu_to_auth` VALUES ('7', '30');
INSERT INTO `menu_to_auth` VALUES ('26', '36');
INSERT INTO `menu_to_auth` VALUES ('21', '36');
INSERT INTO `menu_to_auth` VALUES ('25', '36');
INSERT INTO `menu_to_auth` VALUES ('3', '36');
INSERT INTO `menu_to_auth` VALUES ('29', '36');
INSERT INTO `menu_to_auth` VALUES ('5', '31');
INSERT INTO `menu_to_auth` VALUES ('5', '36');
INSERT INTO `menu_to_auth` VALUES ('4', '36');
INSERT INTO `menu_to_auth` VALUES ('30', '31');
INSERT INTO `menu_to_auth` VALUES ('30', '36');
INSERT INTO `menu_to_auth` VALUES ('30', '32');
INSERT INTO `menu_to_auth` VALUES ('34', '31');
INSERT INTO `menu_to_auth` VALUES ('34', '36');
INSERT INTO `menu_to_auth` VALUES ('34', '32');
INSERT INTO `menu_to_auth` VALUES ('34', '30');
INSERT INTO `menu_to_auth` VALUES ('30', '30');
INSERT INTO `menu_to_auth` VALUES ('35', '31');
INSERT INTO `menu_to_auth` VALUES ('35', '36');
INSERT INTO `menu_to_auth` VALUES ('35', '32');
INSERT INTO `menu_to_auth` VALUES ('35', '30');
INSERT INTO `menu_to_auth` VALUES ('52', '30');
INSERT INTO `menu_to_auth` VALUES ('41', '36');
INSERT INTO `menu_to_auth` VALUES ('38', '33');
INSERT INTO `menu_to_auth` VALUES ('38', '31');
INSERT INTO `menu_to_auth` VALUES ('38', '36');
INSERT INTO `menu_to_auth` VALUES ('38', '32');
INSERT INTO `menu_to_auth` VALUES ('38', '30');
INSERT INTO `menu_to_auth` VALUES ('40', '36');
INSERT INTO `menu_to_auth` VALUES ('51', '36');
INSERT INTO `menu_to_auth` VALUES ('44', '36');
INSERT INTO `menu_to_auth` VALUES ('44', '33');
INSERT INTO `menu_to_auth` VALUES ('44', '31');
INSERT INTO `menu_to_auth` VALUES ('44', '30');
INSERT INTO `menu_to_auth` VALUES ('51', '32');
INSERT INTO `menu_to_auth` VALUES ('43', '36');
INSERT INTO `menu_to_auth` VALUES ('43', '32');
INSERT INTO `menu_to_auth` VALUES ('43', '31');
INSERT INTO `menu_to_auth` VALUES ('43', '30');
INSERT INTO `menu_to_auth` VALUES ('51', '31');
INSERT INTO `menu_to_auth` VALUES ('45', '31');
INSERT INTO `menu_to_auth` VALUES ('45', '36');
INSERT INTO `menu_to_auth` VALUES ('45', '32');
INSERT INTO `menu_to_auth` VALUES ('45', '30');
INSERT INTO `menu_to_auth` VALUES ('51', '30');
INSERT INTO `menu_to_auth` VALUES ('46', '36');
INSERT INTO `menu_to_auth` VALUES ('46', '32');
INSERT INTO `menu_to_auth` VALUES ('46', '31');
INSERT INTO `menu_to_auth` VALUES ('46', '30');
INSERT INTO `menu_to_auth` VALUES ('47', '36');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '名称',
  `role_type` tinyint(1) DEFAULT '0' COMMENT '超级管理员：0=普通管理员，1=超级管理员【拥有所有生产者的权限】',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('29', '文章管理员', '0', '', null, null, null, null);
INSERT INTO `role` VALUES ('28', '超级管理员', '1', '拥有所有权限', null, null, null, null);

-- ----------------------------
-- Table structure for role_to_auth
-- ----------------------------
DROP TABLE IF EXISTS `role_to_auth`;
CREATE TABLE `role_to_auth` (
  `role_id` int(11) DEFAULT NULL COMMENT '角色标识',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目标识',
  `menu_auth_id` int(11) DEFAULT NULL COMMENT '栏目权限标识'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色权限关系表';

-- ----------------------------
-- Records of role_to_auth
-- ----------------------------
INSERT INTO `role_to_auth` VALUES ('29', '43', '36');
INSERT INTO `role_to_auth` VALUES ('29', '2', '36');
INSERT INTO `role_to_auth` VALUES ('29', '49', '36');
INSERT INTO `role_to_auth` VALUES ('28', '6', '32');
INSERT INTO `role_to_auth` VALUES ('28', '6', '31');
INSERT INTO `role_to_auth` VALUES ('28', '6', '30');
INSERT INTO `role_to_auth` VALUES ('28', '6', '36');
INSERT INTO `role_to_auth` VALUES ('28', '21', '36');
INSERT INTO `role_to_auth` VALUES ('28', '20', '36');
INSERT INTO `role_to_auth` VALUES ('28', '5', '36');
INSERT INTO `role_to_auth` VALUES ('28', '2', '36');
INSERT INTO `role_to_auth` VALUES ('28', '1', '36');
INSERT INTO `role_to_auth` VALUES ('29', '29', '36');
INSERT INTO `role_to_auth` VALUES ('29', '1', '36');
INSERT INTO `role_to_auth` VALUES ('29', '47', '36');
INSERT INTO `role_to_auth` VALUES ('29', '6', '36');
INSERT INTO `role_to_auth` VALUES ('29', '7', '36');

-- ----------------------------
-- Table structure for upload
-- ----------------------------
DROP TABLE IF EXISTS `upload`;
CREATE TABLE `upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `file_name` varchar(100) DEFAULT '' COMMENT '上传文件的文件名【包含后缀名】',
  `file_type` varchar(20) NOT NULL DEFAULT '' COMMENT '文件的 MIME 类型',
  `file_path` varchar(100) NOT NULL DEFAULT '' COMMENT '文件的绝对路径',
  `full_path` varchar(100) DEFAULT NULL COMMENT '文件的绝对路径【包含文件名】',
  `file_relative_path` varchar(100) DEFAULT NULL COMMENT '文件的相对路径',
  `full_relative_path` varchar(100) DEFAULT NULL COMMENT '文件的相对路径【包含文件名】',
  `raw_name` varchar(50) NOT NULL DEFAULT '' COMMENT '文件名【不含后缀名】',
  `orig_name` varchar(50) NOT NULL DEFAULT '' COMMENT '原始的文件名【只有在使用了 encrypt_name 参数时该值才有用】',
  `client_name` varchar(100) NOT NULL COMMENT '用户提交过来的文件名【还没有对该文件名做任何处理】',
  `file_ext` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀名【包括句点】',
  `file_size` double(10,0) NOT NULL COMMENT '文件大小【单位 kb】',
  `is_image` tinyint(1) NOT NULL COMMENT '文件是否为图片：1=是，0=不是',
  `image_width` tinyint(20) DEFAULT NULL COMMENT '图片宽度',
  `image_height` tinyint(20) DEFAULT NULL COMMENT '图片高度',
  `image_type` varchar(20) DEFAULT '' COMMENT '图片类型【通常是不带句点的文件后缀名】',
  `image_size_str` varchar(50) DEFAULT '' COMMENT '一个包含了图片宽度和高度的字符串【用于放在 image 标签中】',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='上传文件';

-- ----------------------------
-- Records of upload
-- ----------------------------
INSERT INTO `upload` VALUES ('1', '84984c69e7e4bb0d30792b742813a51c.png', 'image/png', 'E:/wamp/www/uploads/20160731024028/', 'E:/wamp/www/uploads/20160731024028/84984c69e7e4bb0d30792b742813a51c.png', '/uploads/20160731024028/', '/uploads/20160731024028/84984c69e7e4bb0d30792b742813a51c.png', '84984c69e7e4bb0d30792b742813a51c', '84984c69e7e4bb0d30792b742813a51c.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469947228');
INSERT INTO `upload` VALUES ('2', 'f4c79608de31bf9cd5aeab2b8e2b70db.gif', 'image/gif', 'E:/wamp/www/uploads/20160731024545/', 'E:/wamp/www/uploads/20160731024545/f4c79608de31bf9cd5aeab2b8e2b70db.gif', '/uploads/20160731024545/', '/uploads/20160731024545/f4c79608de31bf9cd5aeab2b8e2b70db.gif', 'f4c79608de31bf9cd5aeab2b8e2b70db', 'f4c79608de31bf9cd5aeab2b8e2b70db.gif', 'T1lni5XhXXXXXXXXXX-9-14.gif', '.gif', '0', '1', '9', '14', 'gif', 'width=\"9\" height=\"14\"', '1469947545');
INSERT INTO `upload` VALUES ('3', 'a32b741c518725c5c90a71997d1d4d9f.png', 'image/png', 'E:/wamp/www/uploads/20160731024545/', 'E:/wamp/www/uploads/20160731024545/a32b741c518725c5c90a71997d1d4d9f.png', '/uploads/20160731024545/', '/uploads/20160731024545/a32b741c518725c5c90a71997d1d4d9f.png', 'a32b741c518725c5c90a71997d1d4d9f', 'a32b741c518725c5c90a71997d1d4d9f.png', 'TB17w6xLVXXXXXoXXXXXXXXXXXX-10-12.png', '.png', '0', '1', '10', '12', 'png', 'width=\"10\" height=\"12\"', '1469947545');
INSERT INTO `upload` VALUES ('4', 'e89f6ba6b7cddd9afff9acd60f8ca6bd.png', 'image/png', 'E:/wamp/www/uploads/20160731024615/', 'E:/wamp/www/uploads/20160731024615/e89f6ba6b7cddd9afff9acd60f8ca6bd.png', '/uploads/20160731024615/', '/uploads/20160731024615/e89f6ba6b7cddd9afff9acd60f8ca6bd.png', 'e89f6ba6b7cddd9afff9acd60f8ca6bd', 'e89f6ba6b7cddd9afff9acd60f8ca6bd.png', 'TB17w6xLVXXXXXoXXXXXXXXXXXX-10-12.png', '.png', '0', '1', '10', '12', 'png', 'width=\"10\" height=\"12\"', '1469947575');
INSERT INTO `upload` VALUES ('5', 'fe12b0b4c2fa9acce9fa3bd0ae06b884.png', 'image/png', 'E:/wamp/www/uploads/20160731024732/', 'E:/wamp/www/uploads/20160731024732/fe12b0b4c2fa9acce9fa3bd0ae06b884.png', '/uploads/20160731024732/', '/uploads/20160731024732/fe12b0b4c2fa9acce9fa3bd0ae06b884.png', 'fe12b0b4c2fa9acce9fa3bd0ae06b884', 'fe12b0b4c2fa9acce9fa3bd0ae06b884.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469947652');
INSERT INTO `upload` VALUES ('6', '0a3c60e12269c48c90db533ba5e91375.png', 'image/png', 'E:/wamp/www/uploads/20160731025329/', 'E:/wamp/www/uploads/20160731025329/0a3c60e12269c48c90db533ba5e91375.png', '/uploads/20160731025329/', '/uploads/20160731025329/0a3c60e12269c48c90db533ba5e91375.png', '0a3c60e12269c48c90db533ba5e91375', '0a3c60e12269c48c90db533ba5e91375.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469948009');
INSERT INTO `upload` VALUES ('7', 'dabffd090106aab83abacffcd9ad471b.chm', 'application/octet-st', 'E:/wamp/www/uploads/20160731025330/', 'E:/wamp/www/uploads/20160731025330/dabffd090106aab83abacffcd9ad471b.chm', '/uploads/20160731025330/', '/uploads/20160731025330/dabffd090106aab83abacffcd9ad471b.chm', 'dabffd090106aab83abacffcd9ad471b', 'dabffd090106aab83abacffcd9ad471b.chm', 'uploadify3.2中文API.chm', '.chm', '176', '0', null, null, '', '', '1469948010');
INSERT INTO `upload` VALUES ('8', '5704e0455ce419f35ab75105e8ae01b5.png', 'image/png', 'E:/wamp/www/uploads/20160731031041/', 'E:/wamp/www/uploads/20160731031041/5704e0455ce419f35ab75105e8ae01b5.png', '/uploads/20160731031041/', '/uploads/20160731031041/5704e0455ce419f35ab75105e8ae01b5.png', '5704e0455ce419f35ab75105e8ae01b5', '5704e0455ce419f35ab75105e8ae01b5.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469949041');
INSERT INTO `upload` VALUES ('9', 'ba78d23ce81e716c1bf7d0cf6d76c564.chm', 'application/octet-st', 'E:/wamp/www/uploads/20160731031042/', 'E:/wamp/www/uploads/20160731031042/ba78d23ce81e716c1bf7d0cf6d76c564.chm', '/uploads/20160731031042/', '/uploads/20160731031042/ba78d23ce81e716c1bf7d0cf6d76c564.chm', 'ba78d23ce81e716c1bf7d0cf6d76c564', 'ba78d23ce81e716c1bf7d0cf6d76c564.chm', 'uploadify3.2中文API.chm', '.chm', '176', '0', null, null, '', '', '1469949042');
INSERT INTO `upload` VALUES ('10', 'a8ef25bd864b62247413d744901b07d1.png', 'image/png', 'E:/wamp/www/uploads/20160731031541/', 'E:/wamp/www/uploads/20160731031541/a8ef25bd864b62247413d744901b07d1.png', '/uploads/20160731031541/', '/uploads/20160731031541/a8ef25bd864b62247413d744901b07d1.png', 'a8ef25bd864b62247413d744901b07d1', 'a8ef25bd864b62247413d744901b07d1.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469949341');
INSERT INTO `upload` VALUES ('11', '8373bb09e55fadd1a579dd1abfddbe1f.chm', 'application/octet-st', 'E:/wamp/www/uploads/20160731031542/', 'E:/wamp/www/uploads/20160731031542/8373bb09e55fadd1a579dd1abfddbe1f.chm', '/uploads/20160731031542/', '/uploads/20160731031542/8373bb09e55fadd1a579dd1abfddbe1f.chm', '8373bb09e55fadd1a579dd1abfddbe1f', '8373bb09e55fadd1a579dd1abfddbe1f.chm', 'uploadify3.2中文API.chm', '.chm', '176', '0', null, null, '', '', '1469949342');
INSERT INTO `upload` VALUES ('12', 'c01f87ed10cf9e10e5f98b6e2a533b08.png', 'image/png', 'E:/wamp/www/uploads/20160731031745/', 'E:/wamp/www/uploads/20160731031745/c01f87ed10cf9e10e5f98b6e2a533b08.png', '/uploads/20160731031745/', '/uploads/20160731031745/c01f87ed10cf9e10e5f98b6e2a533b08.png', 'c01f87ed10cf9e10e5f98b6e2a533b08', 'c01f87ed10cf9e10e5f98b6e2a533b08.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469949465');
INSERT INTO `upload` VALUES ('13', '69c116b0c8855d34029fca35387aa50d.png', 'image/png', 'E:/wamp/www/uploads/20160731032720/', 'E:/wamp/www/uploads/20160731032720/69c116b0c8855d34029fca35387aa50d.png', '/uploads/20160731032720/', '/uploads/20160731032720/69c116b0c8855d34029fca35387aa50d.png', '69c116b0c8855d34029fca35387aa50d', '69c116b0c8855d34029fca35387aa50d.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469950040');
INSERT INTO `upload` VALUES ('14', '55456e680848cd23d19b9a780a453206.png', 'image/png', 'E:/wamp/www/uploads/20160731032727/', 'E:/wamp/www/uploads/20160731032727/55456e680848cd23d19b9a780a453206.png', '/uploads/20160731032727/', '/uploads/20160731032727/55456e680848cd23d19b9a780a453206.png', '55456e680848cd23d19b9a780a453206', '55456e680848cd23d19b9a780a453206.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469950047');
INSERT INTO `upload` VALUES ('15', '8bf7087f0ee1b1e3dd13af9a3dcb1767.png', 'image/png', 'E:/wamp/www/uploads/20160731033025/', 'E:/wamp/www/uploads/20160731033025/8bf7087f0ee1b1e3dd13af9a3dcb1767.png', '/uploads/20160731033025/', '/uploads/20160731033025/8bf7087f0ee1b1e3dd13af9a3dcb1767.png', '8bf7087f0ee1b1e3dd13af9a3dcb1767', '8bf7087f0ee1b1e3dd13af9a3dcb1767.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469950225');
INSERT INTO `upload` VALUES ('16', '35fc5def4abcf21cdfdd0b6ec1400398.png', 'image/png', 'E:/wamp/www/uploads/20160731033031/', 'E:/wamp/www/uploads/20160731033031/35fc5def4abcf21cdfdd0b6ec1400398.png', '/uploads/20160731033031/', '/uploads/20160731033031/35fc5def4abcf21cdfdd0b6ec1400398.png', '35fc5def4abcf21cdfdd0b6ec1400398', '35fc5def4abcf21cdfdd0b6ec1400398.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469950231');
INSERT INTO `upload` VALUES ('17', '13a20efd5048950539b16dcc6c04123f.png', 'image/png', 'E:/wamp/www/uploads/20160731045503/', 'E:/wamp/www/uploads/20160731045503/13a20efd5048950539b16dcc6c04123f.png', '/uploads/20160731045503/', '/uploads/20160731045503/13a20efd5048950539b16dcc6c04123f.png', '13a20efd5048950539b16dcc6c04123f', '13a20efd5048950539b16dcc6c04123f.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469955303');
INSERT INTO `upload` VALUES ('18', '7a93b800f644002a8e287171eda0536a.png', 'image/png', 'E:/wamp/www/uploads/20160731045544/', 'E:/wamp/www/uploads/20160731045544/7a93b800f644002a8e287171eda0536a.png', '/uploads/20160731045544/', '/uploads/20160731045544/7a93b800f644002a8e287171eda0536a.png', '7a93b800f644002a8e287171eda0536a', '7a93b800f644002a8e287171eda0536a.png', 'QQ截图20160717213843.png', '.png', '77', '1', '127', '127', 'png', 'width=\"655\" height=\"478\"', '1469955344');
INSERT INTO `upload` VALUES ('19', '93527e8362036beed9ca36766ea95d77.png', 'image/png', 'E:/wamp/www/uploads/20160731045624/', 'E:/wamp/www/uploads/20160731045624/93527e8362036beed9ca36766ea95d77.png', '/uploads/20160731045624/', '/uploads/20160731045624/93527e8362036beed9ca36766ea95d77.png', '93527e8362036beed9ca36766ea95d77', '93527e8362036beed9ca36766ea95d77.png', 'logo.png', '.png', '4', '1', '127', '30', 'png', 'width=\"140\" height=\"30\"', '1469955384');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `username` varchar(50) DEFAULT '' COMMENT '用户名',
  `password` varchar(50) DEFAULT '' COMMENT '密码',
  `realname` varchar(50) DEFAULT '' COMMENT '昵称',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT '角色标识',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `forzen` tinyint(1) DEFAULT '1' COMMENT '冻结：0=已冻结，1=未冻结',
  `user_type` varchar(10) DEFAULT 'producter' COMMENT '用户类型：developer=开发者，producter=生产者',
  `root` tinyint(1) DEFAULT '0' COMMENT '系统默认管理员：0=否，1=是',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `last_login_time` int(10) DEFAULT NULL COMMENT '最后一次登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后一次登录ip',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user` int(10) DEFAULT NULL COMMENT '创建人',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `update_user` int(10) DEFAULT NULL COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('26', 'login', 'e10adc3949ba59abbe56e057f20f883e', '', '29', '', '1', 'producter', '0', null, null, null, null, null, null, null, null);
INSERT INTO `user` VALUES ('25', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '孟祥涵', '28', '', '1', 'producter', '1', null, null, null, null, null, null, null, null);
INSERT INTO `user` VALUES ('31', 'xuanyunet', 'e10adc3949ba59abbe56e057f20f883e', '轩宇网络工作室', '28', '', '1', 'developer', '0', '1469959668', '::1', '1469959530', '::1', null, null, null, null);
