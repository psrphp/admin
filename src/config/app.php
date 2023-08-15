<?php

use PsrPHP\Framework\Script;

return [
    'install' => function () {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_admin_department`;
CREATE TABLE `prefix_psrphp_admin_department` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `pid` int(10) unsigned COMMENT '上级部门',
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '部门名称',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='部门表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_role`;
CREATE TABLE `prefix_psrphp_admin_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `department_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '所属部门',
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '职位名称',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='职位表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_account`;
CREATE TABLE `prefix_psrphp_admin_account` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '账户',
    `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
    `state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1可以登录',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `name` (`name`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户表';
INSERT INTO `prefix_psrphp_admin_account` (`id`, `name`, `password`, `state`) VALUES
(1, 'admin', '74e072086a6fa61008709943da24b82e', 1);
DROP TABLE IF EXISTS `prefix_psrphp_admin_info`;
CREATE TABLE `prefix_psrphp_admin_info` (
    `account_id` int(10) unsigned NOT NULL,
    `key` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
    `value` text NOT NULL DEFAULT '' COMMENT '值',
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户信息表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_account_role`;
CREATE TABLE `prefix_psrphp_admin_account_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户id',
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '职位id',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户职位表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_auth`;
CREATE TABLE `prefix_psrphp_admin_auth` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '职位id',
    `node` varchar(255) NOT NULL DEFAULT '' COMMENT '节点',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='职位权限表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_log`;
CREATE TABLE `prefix_psrphp_admin_log` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户id',
    `node` varchar(255) NOT NULL DEFAULT '' COMMENT '节点',
    `method` varchar(255) NOT NULL DEFAULT '' COMMENT '请求方法',
    `data` text NOT NULL DEFAULT '' COMMENT '数据',
    `ip` char(15) NOT NULL DEFAULT '' COMMENT 'IP',
    `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
    `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `node` (`node`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='日志表';
str;
        Script::execSql($sql);
    },
    'unInstall' => function () {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_admin_department`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_account`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_account_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_info`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_auth`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_log`;
str;
        Script::execSql($sql);
    },
    'update' => function () {
    },
];
