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
            width: 100%;
            height: 100%;
        }
    </style>

    <div class="container-fluid" style="height:100%;">

        <div class="position-relative" style="width:100%;height:100%;">
            <div class="position-absolute top-0" style="z-index:100;">
                <div class="py-3">
                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        挂件列表
                    </button>
                    <a class="btn btn-sm btn-danger text-decoration-none" href="{echo $router->build('/psrphp/admin/index', ['t'=>'home'])}">
                        退出编辑
                    </a>
                </div>
            </div>
            <iframe src="{echo $router->build('/psrphp/admin/index?t=home&diy=1')}" name="diy" id="_diy" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
        </div>
        <script>
            function diyx(data) {
                $.ajax({
                    type: "POST",
                    url: "{echo $router->build('/psrphp/admin/diy/index')}",
                    data: data,
                    dataType: "JSON",
                    success: function() {
                        document.getElementById('_diy').contentWindow.location.reload();
                    }
                });
            }
        </script>

        <div class="offcanvas offcanvas-start show" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">挂件列表</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {foreach $widgets as $name => $list}
                {if $list}
                <div class="fs-5 my-2">{$name}</div>
                <div class="row">
                    {foreach $list as $vo}
                    <div class="col position-relative my-2" style="min-height:100px;">
                        <div class="position-absolute top-0 end-0 bg-warning bg-opacity-10 border" style="width:100%;height:100%;z-index:100;">
                            <div class="p-2">
                                <button type="button" class="btn btn-sm btn-primary" onclick="diyx({t:'add', widget: '{$vo.fullname}', size: 's'})" data-bs-toggle="tooltip" data-bs-title="点击插入">小</button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="diyx({t:'add', widget: '{$vo.fullname}', size: 'm'})" data-bs-toggle="tooltip" data-bs-title="点击插入">中</button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="diyx({t:'add', widget: '{$vo.fullname}', size: 'l'})" data-bs-toggle="tooltip" data-bs-title="点击插入">大</button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="diyx({t:'add', widget: '{$vo.fullname}', size: 'xl'})" data-bs-toggle="tooltip" data-bs-title="点击插入">特大</button>
                            </div>
                        </div>
                        <div>
                            {echo $widget->get($vo['fullname'])}
                        </div>
                    </div>
                    {/foreach}
                </div>
                {/if}
                {/foreach}
            </div>
        </div>

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