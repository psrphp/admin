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
    <script>
        $(function() {
            $("#captcha").trigger('click');
            $("#loginform").bind('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        alert(response.message);
                        if (response.errcode) {
                            $("#captcha").trigger('click');
                        } else {
                            location.href = "{echo $router->build('/psrphp/admin/index')}";
                        }
                    }
                });
            });
        });
    </script>
    <style>
        html {
            background: radial-gradient(at center top, #707070, #000000) repeat center fixed;
            height: 100%;
        }

        body {
            background: none;
        }
    </style>
    <div class="mx-auto p-3" style="max-width: 400px;margin-top:100px;">
        <div class="bg-light overflow-hidden border border-bottom border-5 border-muted shadow" style="border-radius: 15px;">
            <div class="py-4 text-center border-bottom border-1 fs-1 fw-bold text-success">登&nbsp;&nbsp;录</div>
            <form action="{echo $router->build('/psrphp/admin/auth/login')}" id="loginform" method="POST" style="padding: 35px 35px 35px 35px;">
                <div class="mb-4">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="账户" autocomplete="off" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="密码" autocomplete="off" required>
                </div>
                <div class="mb-4">
                    <div class="input-group input-group-lg mb-2 mr-sm-2">
                        <input type="text" name="captcha" id="captcha_input" class="form-control" placeholder="验证码" autocomplete="off" autocomplete="off" required>
                        <div class="input-group-append">
                            <img id="captcha" style="vertical-align: middle;cursor: pointer;height: 48px;" src="{echo $router->build('/psrphp/admin/tool/captcha')}" class="rounded-end">
                            <script>
                                $(function() {
                                    $("#captcha").bind("click", function() {
                                        $(this).attr("src", "<?php echo $router->build('/psrphp/admin/tool/captcha'); ?>?time=" + (new Date()).getTime());
                                        $("#captcha_input").val('');
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="pb-2 pt-3">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg btn-success">提交</button>
                    </div>
                </div>
            </form>
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