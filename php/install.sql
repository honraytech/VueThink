/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkphp5

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-03-27 11:24:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oa_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_access`;
CREATE TABLE `oa_admin_access` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_admin_access
-- ----------------------------
INSERT INTO `oa_admin_access` VALUES ('2', '15');

-- ----------------------------
-- Table structure for oa_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_group`;
CREATE TABLE `oa_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `rules` varchar(4000) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_admin_group
-- ----------------------------
INSERT INTO `oa_admin_group` VALUES ('15', '普通会员', '1,2,3,4,5,6,7,8,9,10,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,61,62,63,28,29', '0', '最厉害的组别', '1');

-- ----------------------------
-- Table structure for oa_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_menu`;
CREATE TABLE `oa_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '上级菜单ID',
  `title` varchar(32) DEFAULT '' COMMENT '菜单名称',
  `url` varchar(127) DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) DEFAULT '' COMMENT '图标',
  `menu_type` tinyint(4) DEFAULT NULL COMMENT '菜单类型',
  `sort` tinyint(4) unsigned DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `rule_id` int(11) DEFAULT NULL COMMENT '权限id',
  `module` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL COMMENT '三级菜单吗',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='【配置】后台菜单表';

-- ----------------------------
-- Records of oa_admin_menu
-- ----------------------------
INSERT INTO `oa_admin_menu` VALUES ('52', '0', '管理', '', '', '1', '0', '1', '59', 'Administrative', '');
INSERT INTO `oa_admin_menu` VALUES ('53', '52', '系统配置', '', '', '1', '0', '1', '61', 'Administrative', '');
INSERT INTO `oa_admin_menu` VALUES ('54', '53', '菜单管理', '/home/menu/list', '', '1', '0', '1', '21', 'Administrative', 'menu');
INSERT INTO `oa_admin_menu` VALUES ('55', '53', '系统参数', '/home/config/add', '', '1', '0', '1', '29', 'Administrative', 'systemConfig');
INSERT INTO `oa_admin_menu` VALUES ('56', '53', '权限规则', '/home/rule/list', '', '1', '0', '1', '13', 'Administrative', 'rule');
INSERT INTO `oa_admin_menu` VALUES ('57', '52', '组织架构', '', '', '1', '0', '1', '63', 'Administrative', '');
INSERT INTO `oa_admin_menu` VALUES ('58', '57', '岗位管理', '/home/position/list', '', '1', '0', '1', '31', 'Administrative', 'position');
INSERT INTO `oa_admin_menu` VALUES ('59', '57', '部门管理', '/home/structures/list', '', '1', '0', '1', '39', 'Administrative', 'structures');
INSERT INTO `oa_admin_menu` VALUES ('60', '57', '用户组管理', '/home/groups/list', '', '1', '0', '1', '47', 'Administrative', 'groups');
INSERT INTO `oa_admin_menu` VALUES ('61', '52', '账户管理', '', '', '1', '0', '1', '62', 'Administrative', '');
INSERT INTO `oa_admin_menu` VALUES ('62', '61', '账户列表', '/home/users/list', '', '1', '0', '1', '55', 'Administrative', 'users');

-- ----------------------------
-- Table structure for oa_admin_post
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_post`;
CREATE TABLE `oa_admin_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT '岗位名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '岗位备注',
  `create_time` int(11) DEFAULT NULL COMMENT '数据创建时间',
  `status` tinyint(5) DEFAULT '1' COMMENT '状态1启用,0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='岗位表';

-- ----------------------------
-- Records of oa_admin_post
-- ----------------------------
INSERT INTO `oa_admin_post` VALUES ('5', '后端开发工程师', '', '1484706862', '1');
INSERT INTO `oa_admin_post` VALUES ('6', '前端开发工程师', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('7', '设计师', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('11', '文案策划', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('12', '产品助理', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('15', '总经理', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('20', '项目经理', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('25', '职能', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('26', '项目助理', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('27', '测试工程师', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('28', '人事经理', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('29', 'CEO', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('30', '品牌策划', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('31', '前端研发工程师', '', '1484706863', '1');
INSERT INTO `oa_admin_post` VALUES ('32', '后端研发工程师', '', '1484706863', '1');

-- ----------------------------
-- Table structure for oa_admin_rule
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_rule`;
CREATE TABLE `oa_admin_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '' COMMENT '名称',
  `name` varchar(100) DEFAULT '' COMMENT '定义',
  `level` tinyint(5) DEFAULT NULL COMMENT '级别。1模块,2控制器,3操作',
  `pid` int(11) DEFAULT '0' COMMENT '父id，默认0',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态，1启用，0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_admin_rule
-- ----------------------------
INSERT INTO `oa_admin_rule` VALUES ('10', '系统基础功能', 'admin', '1', '0', '1');
INSERT INTO `oa_admin_rule` VALUES ('11', '权限规则', 'rules', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('13', '规则列表', 'index', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('14', '权限详情', 'read', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('15', '编辑权限', 'update', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('16', '删除权限', 'delete', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('17', '添加权限', 'save', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('18', '批量删除权限', 'deletes', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('19', '批量启用/禁用权限', 'enables', '3', '11', '1');
INSERT INTO `oa_admin_rule` VALUES ('20', '菜单管理', 'menus', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('21', '菜单列表', 'index', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('22', '添加菜单', 'save', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('23', '菜单详情', 'read', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('24', '编辑菜单', 'update', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('25', '删除菜单', 'delete', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('26', '批量删除菜单', 'deletes', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('27', '批量启用/禁用菜单', 'enables', '3', '20', '1');
INSERT INTO `oa_admin_rule` VALUES ('28', '系统管理', 'systemConfigs', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('29', '修改系统配置', 'save', '3', '28', '1');
INSERT INTO `oa_admin_rule` VALUES ('30', '岗位管理', 'posts', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('31', '岗位列表', 'index', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('32', '岗位详情', 'read', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('33', '编辑岗位', 'update', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('34', '删除岗位', 'delete', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('35', '添加岗位', 'save', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('36', '批量删除岗位', 'deletes', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('37', '批量启用/禁用岗位', 'enables', '3', '30', '1');
INSERT INTO `oa_admin_rule` VALUES ('38', '部门管理', 'structures', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('39', '部门列表', 'index', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('40', '部门详情', 'read', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('41', '编辑部门', 'update', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('42', '删除部门', 'delete', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('43', '添加部门', 'save', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('44', '批量删除部门', 'deletes', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('45', '批量启用/禁用部门', 'enables', '3', '38', '1');
INSERT INTO `oa_admin_rule` VALUES ('46', '用户组管理', 'groups', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('47', '用户组列表', 'index', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('48', '用户组详情', 'read', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('49', '编辑用户组', 'update', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('50', '删除用户组', 'delete', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('51', '添加用户组', 'save', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('52', '批量删除用户组', 'deletes', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('53', '批量启用/禁用用户组', 'enables', '3', '46', '1');
INSERT INTO `oa_admin_rule` VALUES ('54', '成员管理', 'users', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('55', '成员列表', 'index', '3', '54', '1');
INSERT INTO `oa_admin_rule` VALUES ('56', '成员详情', 'read', '3', '54', '1');
INSERT INTO `oa_admin_rule` VALUES ('57', '删除成员', 'delete', '3', '54', '1');
INSERT INTO `oa_admin_rule` VALUES ('59', '管理菜单', 'Adminstrative', '2', '10', '1');
INSERT INTO `oa_admin_rule` VALUES ('61', '系统管理二级菜单', 'systemConfig', '1', '59', '1');
INSERT INTO `oa_admin_rule` VALUES ('62', '账户管理二级菜单', 'personnel', '3', '59', '1');
INSERT INTO `oa_admin_rule` VALUES ('63', '组织架构二级菜单', 'structures', '3', '59', '1');

-- ----------------------------
-- Table structure for oa_admin_structure
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_structure`;
CREATE TABLE `oa_admin_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT '',
  `pid` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_admin_structure
-- ----------------------------
INSERT INTO `oa_admin_structure` VALUES ('1', '广东洪睿信息科技有限公司', '0', '1');
INSERT INTO `oa_admin_structure` VALUES ('5', '设计部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('6', '职能部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('37', '总经办', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('52', '项目部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('53', '测试部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('54', '开发部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('55', '市场部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('56', '研发部', '1', '1');
INSERT INTO `oa_admin_structure` VALUES ('57', '企业微信', '0', '1');

-- ----------------------------
-- Table structure for oa_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `oa_admin_user`;
CREATE TABLE `oa_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(100) DEFAULT NULL COMMENT '管理后台账号',
  `password` varchar(100) DEFAULT NULL COMMENT '管理后台密码',
  `remark` varchar(100) DEFAULT NULL COMMENT '用户备注',
  `create_time` int(11) DEFAULT NULL,
  `realname` varchar(100) DEFAULT NULL COMMENT '真实姓名',
  `structure_id` int(11) DEFAULT NULL COMMENT '部门',
  `post_id` int(11) DEFAULT NULL COMMENT '岗位',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态,1启用0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_admin_user
-- ----------------------------
INSERT INTO `oa_admin_user` VALUES ('1', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '', null, '超级管理员', '1', '5', '1');
INSERT INTO `oa_admin_user` VALUES ('3', '用户AAAA', 'c78b6663d47cfbdb4d65ea51c104044e', '', '1487217060', '用户A', '5', '20', '1');

-- ----------------------------
-- Table structure for oa_system_config
-- ----------------------------
DROP TABLE IF EXISTS `oa_system_config`;
CREATE TABLE `oa_system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(50) DEFAULT '',
  `value` varchar(100) DEFAULT '' COMMENT '配置值',
  `group` tinyint(4) unsigned DEFAULT '0' COMMENT '配置分组',
  `need_auth` tinyint(4) DEFAULT '1' COMMENT '1需要登录后才能获取，0不需要登录即可获取',
  PRIMARY KEY (`id`),
  UNIQUE KEY `参数名` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='【配置】系统配置表';

-- ----------------------------
-- Records of oa_system_config
-- ----------------------------
INSERT INTO `oa_system_config` VALUES ('1', 'SYSTEM_NAME', 'VueThink通用后台登录', '0', '1');
INSERT INTO `oa_system_config` VALUES ('2', 'SYSTEM_LOGO', 'uploads\\20170219\\d9fe7b784e1b1f406234b7b301e627e8.png', '0', '1');
INSERT INTO `oa_system_config` VALUES ('3', 'LOGIN_SESSION_VALID', '1644', '0', '1');
INSERT INTO `oa_system_config` VALUES ('4', 'IDENTIFYING_CODE', '0', '0', '1');
