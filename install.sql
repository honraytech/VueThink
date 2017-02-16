/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-02-13 09:30:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oa_group
-- ----------------------------
DROP TABLE IF EXISTS `oa_group`;
CREATE TABLE `oa_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `rules` varchar(4000) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_group
-- ----------------------------
INSERT INTO `oa_group` VALUES ('15', '普通会员', '1,2,3', '0', '厉害', '1');

-- ----------------------------
-- Table structure for oa_menu
-- ----------------------------
DROP TABLE IF EXISTS `oa_menu`;
CREATE TABLE `oa_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='【配置】后台菜单表';

-- ----------------------------
-- Records of oa_menu
-- ----------------------------
INSERT INTO `oa_menu` VALUES ('52', '0', '测试测试菜单', 'index.html', '', '1', '0', '1', '59', 'Administrative', '');
INSERT INTO `oa_menu` VALUES ('53', '52', '系统配置', '', '', '1', '0', '1', '61', 'Administrative', '');
INSERT INTO `oa_menu` VALUES ('54', '53', '菜单管理', '/menu/list', '', '1', '0', '1', '21', 'Administrative', 'menu');
INSERT INTO `oa_menu` VALUES ('55', '53', '系统参数', '/config/add', '', '1', '0', '1', '29', 'Administrative', 'systemConfig');
INSERT INTO `oa_menu` VALUES ('56', '53', '权限规则', '/rule/list', '', '1', '0', '1', '13', 'Administrative', 'rule');
INSERT INTO `oa_menu` VALUES ('57', '52', '组织架构', '', '', '1', '0', '1', '63', 'Administrative', '');
INSERT INTO `oa_menu` VALUES ('58', '57', '岗位管理', '/position/list', '', '1', '0', '1', '31', 'Administrative', 'position');
INSERT INTO `oa_menu` VALUES ('59', '57', '部门管理', '/structures/list', '', '1', '0', '1', '39', 'Administrative', 'structures');
INSERT INTO `oa_menu` VALUES ('60', '57', '用户组管理', '/groups/list', '', '1', '0', '1', '47', 'Administrative', 'groups');
INSERT INTO `oa_menu` VALUES ('61', '52', '人事管理', '', '', '1', '0', '1', '62', 'Administrative', '');
INSERT INTO `oa_menu` VALUES ('62', '61', '成员管理', '/users/list', '', '1', '0', '1', '55', 'Administrative', 'users');

-- ----------------------------
-- Table structure for oa_post
-- ----------------------------
DROP TABLE IF EXISTS `oa_post`;
CREATE TABLE `oa_post` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(200) DEFAULT '' COMMENT '岗位名称',
  `p_remark` varchar(200) DEFAULT '' COMMENT '岗位备注',
  `create_time` int(11) DEFAULT NULL COMMENT '数据创建时间',
  `status` tinyint(5) DEFAULT '1' COMMENT '状态1启用,0禁用',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='岗位表';

-- ----------------------------
-- Records of oa_post
-- ----------------------------
INSERT INTO `oa_post` VALUES ('5', '后端开发工程师', '', '1484706862', '1');
INSERT INTO `oa_post` VALUES ('6', '前端开发工程师', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('7', '设计师', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('11', '文案策划', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('12', '产品助理', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('15', '总经理', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('20', '项目经理', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('25', '职能', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('26', '项目助理', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('27', '测试工程师', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('28', '人事经理', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('29', 'CEO', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('30', '品牌策划', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('31', '前端研发工程师', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('32', '后端研发工程师', '', '1484706863', '1');
INSERT INTO `oa_post` VALUES ('33', '11111', '1111', '1486735803', '1');

-- ----------------------------
-- Table structure for oa_rule
-- ----------------------------
DROP TABLE IF EXISTS `oa_rule`;
CREATE TABLE `oa_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '' COMMENT '名称',
  `name` varchar(100) DEFAULT '' COMMENT '定义',
  `level` tinyint(5) DEFAULT NULL COMMENT '级别。1模块,2控制器,3操作',
  `pid` int(11) DEFAULT '0' COMMENT '父id，默认0',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态，1启用，0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_rule
-- ----------------------------
INSERT INTO `oa_rule` VALUES ('10', '操作Admin-Auth（权限配置模块）', 'Admin-Auth', '1', '0', '1');
INSERT INTO `oa_rule` VALUES ('11', '权限规则', 'rules', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('13', '规则列表', 'index', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('14', '权限详情', 'read', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('15', '编辑权限', 'update', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('16', '删除权限', 'delete', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('17', '添加权限', 'save', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('18', '批量删除权限', 'deletes', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('19', '批量启用/禁用权限', 'enables', '3', '11', '1');
INSERT INTO `oa_rule` VALUES ('20', '菜单管理', 'menus', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('21', '菜单列表', 'index', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('22', '添加菜单', 'save', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('23', '菜单详情', 'read', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('24', '编辑菜单', 'update', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('25', '删除菜单', 'delete', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('26', '批量删除菜单', 'deletes', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('27', '批量启用/禁用菜单', 'enables', '3', '20', '1');
INSERT INTO `oa_rule` VALUES ('28', '系统管理', 'systemConfigs', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('29', '修改系统配置', 'save', '3', '28', '1');
INSERT INTO `oa_rule` VALUES ('30', '岗位管理', 'posts', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('31', '岗位列表', 'index', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('32', '岗位详情', 'read', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('33', '编辑岗位', 'update', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('34', '删除岗位', 'delete', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('35', '添加岗位', 'save', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('36', '批量删除岗位', 'deletes', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('37', '批量启用/禁用岗位', 'enables', '3', '30', '1');
INSERT INTO `oa_rule` VALUES ('38', '部门管理', 'structures', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('39', '部门列表', 'index', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('40', '部门详情', 'read', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('41', '编辑部门', 'update', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('42', '删除部门', 'delete', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('43', '添加部门', 'save', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('44', '批量删除部门', 'deletes', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('45', '批量启用/禁用部门', 'enables', '3', '38', '1');
INSERT INTO `oa_rule` VALUES ('46', '用户组管理', 'groups', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('47', '用户组列表', 'index', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('48', '用户组详情', 'read', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('49', '编辑用户组', 'update', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('50', '删除用户组', 'delete', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('51', '添加用户组', 'save', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('52', '批量删除用户组', 'deletes', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('53', '批量启用/禁用用户组', 'enables', '3', '46', '1');
INSERT INTO `oa_rule` VALUES ('54', '成员管理', 'users', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('55', '成员列表', 'index', '3', '54', '1');
INSERT INTO `oa_rule` VALUES ('56', '成员详情', 'read', '3', '54', '1');
INSERT INTO `oa_rule` VALUES ('57', '删除成员', 'delete', '3', '54', '1');
INSERT INTO `oa_rule` VALUES ('59', '职能菜单', 'Adminstrative', '2', '10', '1');
INSERT INTO `oa_rule` VALUES ('61', '系统管理二级菜单', 'systemConfig', '1', '59', '1');
INSERT INTO `oa_rule` VALUES ('62', '人事管理二级菜单', 'personnel', '3', '59', '1');
INSERT INTO `oa_rule` VALUES ('63', '组织架构二级菜单', 'structures', '3', '59', '1');

-- ----------------------------
-- Table structure for oa_structure
-- ----------------------------
DROP TABLE IF EXISTS `oa_structure`;
CREATE TABLE `oa_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT '',
  `pid` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_structure
-- ----------------------------
INSERT INTO `oa_structure` VALUES ('1', '二级部门', '0', '1');
INSERT INTO `oa_structure` VALUES ('5', '设计部', '1', '1');
INSERT INTO `oa_structure` VALUES ('6', '职能部', '1', '1');
INSERT INTO `oa_structure` VALUES ('37', '总经办', '1', '1');
INSERT INTO `oa_structure` VALUES ('52', '项目部', '1', '1');
INSERT INTO `oa_structure` VALUES ('53', '测试部', '1', '1');
INSERT INTO `oa_structure` VALUES ('54', '开发部', '1', '1');
INSERT INTO `oa_structure` VALUES ('55', '市场部', '1', '1');
INSERT INTO `oa_structure` VALUES ('56', '研发部', '1', '1');
INSERT INTO `oa_structure` VALUES ('57', '企业微信', '0', '1');
INSERT INTO `oa_structure` VALUES ('58', 'test', '53', '1');
INSERT INTO `oa_structure` VALUES ('59', '三级部门', '2', '1');

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
INSERT INTO `oa_system_config` VALUES ('1', 'SYSTEM_NAME', 'tp5-bsf', '0', '1');
INSERT INTO `oa_system_config` VALUES ('2', 'SYSTEM_LOGO', '12321', '0', '1');
INSERT INTO `oa_system_config` VALUES ('3', 'LOGIN_SESSION_VALID', '1644', '0', '1');
INSERT INTO `oa_system_config` VALUES ('4', 'IDENTIFYING_CODE', '0', '0', '1');
INSERT INTO `oa_system_config` VALUES ('4', 'LOGO_TYPE', '0', '0', '1');
-- ----------------------------
-- Table structure for oa_user
-- ----------------------------
DROP TABLE IF EXISTS `oa_user`;
CREATE TABLE `oa_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `u_username` varchar(100) DEFAULT '' COMMENT '管理后台账号',
  `u_pwd` varchar(100) DEFAULT '' COMMENT '管理后台密码',
  `u_remark` varchar(100) DEFAULT '' COMMENT '用户备注',
  `create_time` int(11) DEFAULT NULL,
  `u_realname` varchar(100) DEFAULT '' COMMENT '真实姓名',
  `s_id` int(11) DEFAULT NULL COMMENT '部门',
  `p_id` int(11) DEFAULT NULL COMMENT '岗位',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态,1启用0禁用',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_user
-- ----------------------------
INSERT INTO `oa_user` VALUES ('1', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '', null, '超级管理员', '1', '5', '1');

-- ----------------------------
-- Table structure for oa_user_group
-- ----------------------------
DROP TABLE IF EXISTS `oa_user_group`;
CREATE TABLE `oa_user_group` (
  `u_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_user_group
-- ----------------------------
