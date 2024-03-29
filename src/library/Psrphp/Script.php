<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Psrphp;

use PsrPHP\Framework\Script as FrameworkScript;

class Script
{
    public static function onInstall()
    {
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
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色表';
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
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户角色表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_auth`;
CREATE TABLE `prefix_psrphp_admin_auth` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    `node` varchar(255) NOT NULL DEFAULT '' COMMENT '节点',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色权限表';
str;
        FrameworkScript::execSql($sql);
    }

    public static function onUnInstall()
    {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_admin_department`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_account`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_account_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_info`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_auth`;
str;
        FrameworkScript::execSql($sql);
    }
}
