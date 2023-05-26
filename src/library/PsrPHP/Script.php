<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\PsrPHP;

use PDO;

class Script
{

    public static function onInstall()
    {
        $sql = self::getInstallSql();
        self::execSql($sql);
    }

    public static function onUninstall()
    {
        $sql = '';
        $sql .= PHP_EOL . self::getUninstallSql();
        self::execSql($sql);
    }

    private static function execSql(string $sql)
    {
        $sqls = array_filter(explode(";" . PHP_EOL, $sql));

        $prefix = 'prefix_';
        $cfg_file = getcwd() . '/config/database.php';
        $cfg = (array)include $cfg_file;
        if (isset($cfg['master']['prefix'])) {
            $prefix = $cfg['master']['prefix'];
        }

        $dbh = new PDO("{$cfg['master']['database_type']}:host={$cfg['master']['server']};dbname={$cfg['master']['database_name']}", $cfg['master']['username'], $cfg['master']['password'], $cfg['master']['option']);

        $dbh->exec('SET SQL_MODE=ANSI_QUOTES');
        $dbh->exec('SET NAMES utf8mb4 COLLATE utf8mb4_general_ci');

        foreach ($sqls as $sql) {
            $dbh->exec(str_replace('prefix_', $prefix, $sql . ';'));
        }
    }

    private static function getInstallSql(): string
    {
        return <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_admin_account`;
CREATE TABLE `prefix_psrphp_admin_account` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '账户',
    `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
    `state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1可以登录',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `name` (`name`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_account_role`;
CREATE TABLE `prefix_psrphp_admin_account_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户id',
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户角色表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_role`;
CREATE TABLE `prefix_psrphp_admin_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色表';
DROP TABLE IF EXISTS `prefix_psrphp_admin_role_node`;
CREATE TABLE `prefix_psrphp_admin_role_node` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    `node` varchar(255) NOT NULL DEFAULT '' COMMENT '节点',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色权限表';
INSERT INTO `prefix_psrphp_admin_account` (`id`, `name`, `password`, `state`) VALUES
(1, 'admin', '78484391a066bf212fc9694789c7a5a2', 1);
str;
    }

    private static function getUninstallSql(): string
    {
        return <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_admin_account`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_account_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_role`;
DROP TABLE IF EXISTS `prefix_psrphp_admin_role_node`;
str;
    }
}
