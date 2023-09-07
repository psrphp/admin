{include common/header@psrphp/admin}
<style>
    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    .top {
        position: absolute;
        top: 0;
        left: 0;
        height: 50px;
        width: 100%;
        overflow: auto;
        background: #000;
        display: flex;
        align-items: center;
        box-shadow: 0px 1px 20px 0px;
        z-index: 111;
        border-bottom: 1px solid #252525;
    }

    .left {
        position: absolute;
        left: 0;
        top: 50px;
        bottom: 0;
        width: 200px;
        overflow: auto;
        background: #000;
        color: gray;
    }

    .right {
        position: absolute;
        right: 0;
        top: 50px;
        bottom: 0;
        z-index: 100;
        overflow: auto;
        background: #fff;
    }

    a {
        text-decoration: none;
        color: #202020;
    }
</style>
<div class="top">
    <div style="color: #ddd;font-size: 1.5em;margin-left: 10px;" onclick="this.parentNode.nextElementSibling.nextElementSibling.style.left=this.parentNode.nextElementSibling.nextElementSibling.style.left=='200px'?'0':'200px'"><span style="margin-right:5px">≡</span>{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</div>
</div>
<div class="left">
    <div style="margin: 15px 10px 0 10px;padding: 7px;border: 1px solid #878787;background: #827717;color: #202020;">
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
    <style>
        .menu>div>a {
            color: #aaa;
        }

        .menu>div>a:hover {
            color: #ffffff;
        }
    </style>
    <div class="menu" style="display: flex;flex-direction: column;gap:5px;padding: 10px;">
        <div>
            <a href="{echo $router->build('/psrphp/admin/widget/index')}" target="main">主页</a>
        </div>
        {foreach $sticks as $vo}
        <div>
            <a href="{echo $vo['url']}" target="main">{$vo.title}</a>
        </div>
        {/foreach}
        <div>
            <a href="{echo $router->build('/psrphp/admin/menu/index')}" target="main">更多...</a>
        </div>
    </div>
</div>
<div class="right" style="left: 200px;">
    <iframe src="{echo $router->build('/psrphp/admin/widget/index')}" name="main" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
</div>
{include common/footer@psrphp/admin}