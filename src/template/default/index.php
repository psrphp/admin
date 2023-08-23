{include common/header@psrphp/admin}
<style>
    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    #top {
        height: 50px;
        width: 100%;
        background: #000;
        display: flex;
        align-items: center;
    }

    #left {
        height: calc(100% - 50px);
        float: left;
        background: #eee;
    }

    #right {
        height: calc(100% - 50px);
        float: left;
        background: #fff;
    }
</style>
<script>
    function togglemenu() {
        if (document.getElementById("left").style.width == "200px") {
            document.getElementById("left").style.width = '0px';
            document.getElementById("right").style.width = '100%';
        } else {
            document.getElementById("left").style.width = '200px';
            document.getElementById("right").style.width = 'calc(100% - 200px)';
        }
    }
</script>
<div id="top">
    <div style="color: #ddd;font-size: 1.5em;margin-left: 10px;" onclick="togglemenu()"><span style="margin-right:5px">≡</span>{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</div>
</div>
<div id="left" style="width: 200px;">
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
<div id="right" style="width: calc(100% - 200px);">
    <iframe src="{echo $router->build('/psrphp/admin/widget/index')}" name="main" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
</div>
{include common/footer@psrphp/admin}