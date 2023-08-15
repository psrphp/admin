{include common/header@psrphp/admin}
<style>
    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #2196F3;
    }

    .top {
        height: 50px;
        width: 100%;
        background: #000;
        display: flex;
        align-items: center;
    }

    .left {
        height: calc(100% - 50px);
        width: 200px;
        float: left;
        background: #eee;
    }

    .main {
        height: calc(100% - 50px);
        width: calc(100% - 200px);
        float: left;
        background: #fff;
    }
</style>
<div class="top">
    <div style="color: #ddd;font-size: 1.5em;margin-left: 10px;">{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</div>
</div>
<div class="left">
    <div style="padding: 10px;">
        <div>
            <span>欢迎您: {$account->getName($auth->getId())}</span>
            <span>
                <a href="{echo $router->build('/psrphp/admin/auth/logout')}">退出</a>
            </span>
        </div>
        <div style="margin-top: 5px;">
            <a href="{echo $router->build('/psrphp/admin/my/name')}" target="main">[修改账户]</a>
            <a href="{echo $router->build('/psrphp/admin/my/password')}" target="main">[修改密码]</a>
        </div>
    </div>
    <hr>
    <div style="display: flex;flex-direction: column;gap:10px;padding: 10px;">
        <div>
            <a href="{echo $router->build('/psrphp/admin/index?t=home')}" target="main">主页</a>
        </div>
        {if $stick_menus}
        {foreach $stick_menus as $menu}
        <div>
            <a href="{echo $menu['url']}" target="main">{$menu.title}</a>
        </div>
        {/foreach}
        <div>
            <a href="{echo $router->build('/psrphp/admin/menu/index')}" target="main">更多...</a>
        </div>
        {else}
        <div>
            <a href="{echo $router->build('/psrphp/admin/menu/index')}" target="main">自定义菜单...</a>
        </div>
        {/if}
    </div>
</div>
<div class="main">
    <iframe src="{echo $router->build('/psrphp/admin/index?t=home')}" name="main" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
</div>
{include common/footer@psrphp/admin}