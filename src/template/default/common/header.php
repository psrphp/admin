<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{$config->get('copyright.name@psrphp.admin', '后台管理系统')}</title>
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function request(url, data, method, notice, datatype) {
            if (notice && !confirm(notice)) {
                return;
            }
            $.ajax({
                type: method ? method : 'POST',
                url: url,
                data: data,
                dataType: datatype ? datatype : 'JSON',
                success: (response) => {
                    if (response.errcode) {
                        alert(response.message);
                    } else {
                        location.reload();
                    }
                },
                error: (XMLHttpRequest, textStatus, errorThrown) => {
                    alert('错误：' + XMLHttpRequest.status + ' ' + textStatus);
                }
            });
        }
    </script>
</head>

<body>
    <div class="container">