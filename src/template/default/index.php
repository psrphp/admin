<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</title>
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .top {
            height: 50px;
            width: 100%;
        }

        .left {
            height: calc(100% - 50px);
            width: 250px;
            float: left;
        }

        .main {
            height: calc(100% - 50px);
            width: calc(100% - 250px);
            float: left;
        }
    </style>
    <div class="top bg-dark bg-gradient shadow position-sticky d-flex align-items-center px-3 text-white">
        <a href="{echo $router->build('/psrphp/admin/index')}" class="d-flex align-items-center text-decoration-none link-light">
            <span class="fs-4 fw-semibold">{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</span>
        </a>
    </div>
    <div class="left bg-light p-2">
        <div class="rounded border bg-white p-2 mb-2">
            <div>
                <span>欢迎您</span>
                <span>:</span>
                <span>
                    <a href="{echo $router->build('/psrphp/admin/my/name')}" target="main">{$account->getName($auth->getId())}</a>
                </span>
            </div>
            <div>
                <a href="{echo $router->build('/psrphp/admin/my/password')}" class="link-secondary text-decoration-none small" target="main">[修改密码]</a>
                <a href="{echo $router->build('/psrphp/admin/auth/logout')}" class="link-secondary text-decoration-none small">[退出]</a>
            </div>
        </div>
        <ul class="nav flex-column nav-pills" id="menus">
            <li class="nav-item">
                <a class="nav-link active" href="{echo $router->build('/psrphp/admin/index?t=home')}" target="main">主页</a>
            </li>
            {if $stick_menus}
            {foreach $stick_menus as $menu}
            <li class="nav-item">
                <a class="nav-link" href="{echo $menu['url']}" target="main">{$menu.title}</a>
            </li>
            {/foreach}
            <li class="nav-item">
                <a class="nav-link" href="{echo $router->build('/psrphp/admin/menu/index')}" target="main">更多...</a>
            </li>
            {else}
            <li class="nav-item">
                <a class="nav-link" href="{echo $router->build('/psrphp/admin/menu/index')}" target="main">自定义菜单...</a>
            </li>
            {/if}
        </ul>
        <script>
            $(function() {
                $("#menus li a").click(function() {
                    $(this).parent().siblings().children('a').removeClass('active');
                    $(this).addClass("active");
                });
                $("#menus li:eq(0) a").trigger('click')
            });
        </script>
    </div>
    <div class="main bg-white">
        <iframe src="{echo $router->build('/psrphp/admin/index?t=home')}" name="main" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
    </div>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>

</html>