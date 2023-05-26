<?php

use Composer\InstalledVersions;

$_root = InstalledVersions::getRootPackage();
$_infos = [[
    'title' => '软件版本',
    'body' => $_root['name'] . ' ' . $_root['pretty_version']
], [
    'title' => 'PHP版本',
    'body' => phpversion()
], [
    'title' => '服务器引擎',
    'body' => $_SERVER['SERVER_SOFTWARE']
], [
    'title' => '文件上传限制',
    'body' => get_cfg_var('upload_max_filesize')
], [
    'title' => '操作系统',
    'body' => php_uname()
]];
?>
<div class="fs-3 fw-light mt-4 mb-3 text-muted">系统信息</div>
<div class="d-flex flex-wrap align-items-stretch gap-3">
    {foreach $_infos?:[] as $vo}
    <div class="bg-light rounded border p-3 position-relative item">
        <div class="fs-4 fw-light">{$vo.title}</div>
        <div class="text-muted fw-light">{echo strip_tags($vo['body'], '<a><span>')}</div>
    </div>
    {/foreach}
</div>