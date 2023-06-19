{include common/header@psrphp/admin}
<script>
    function change(name) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/admin/theme/change')}",
            data: {
                name: name
            },
            dataType: "JSON",
            success: function(response) {
                if (response.errcode) {
                    alert(response.message);
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('发生错误~');
            }
        });
    }

    function up(name) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/admin/theme/up')}",
            data: {
                name: name
            },
            dataType: "JSON",
            success: function(response) {
                if (response.errcode) {
                    alert(response.message);
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('发生错误~');
            }
        });
    }

    function down(name) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/admin/theme/down')}",
            data: {
                name: name
            },
            dataType: "JSON",
            success: function(response) {
                if (response.errcode) {
                    alert(response.message);
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('发生错误~');
            }
        });
    }

    function del(name) {
        if (confirm('确定删除该主题吗？删除后无法恢复！')) {
            $.ajax({
                type: "POST",
                url: "{echo $router->build('/psrphp/admin/theme/delete')}",
                data: {
                    name: name
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.errcode) {
                        alert(response.message);
                    } else {
                        location.reload();
                    }
                },
                error: function() {
                    alert('发生错误~');
                }
            });
        }
    }
</script>
<div class="container">
    <div class="my-4">
        <div class="h1">主题管理</div>
        <div class="text-muted fw-light">
            <span>主题位于 <code>/theme</code> 目录</span>
        </div>
    </div>
    <div class="my-4">
        <div class="fs-4 mb-3">已启用</div>
        <div class="d-flex flex-column gap-4">
            {foreach $config->get('theme', []) as $k => $vo}
            {if isset($themes[$vo])}
            {php $theme = $themes[$vo]}
            <div class="d-flex gap-3">
                <div>
                    <img src="{echo $theme['thumb']}" class="img-thumbnail" width="130" alt="">
                </div>
                <div class="d-flex flex-column gap-2 flex-grow-1 bg-light p-3">
                    <div><span class="fs-6 fw-bold">{$theme['title']??'-'}</span><sup class="ms-1 text-secondary">{$theme['version']??''}</sup></div>
                    <div>{$theme['description']??''}</div>
                    <div><code>/theme/{$theme['name']}</code> </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-danger" type="button" onclick="change('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击停用该主题">使用中</button>
                        {if $k}
                        <button class="btn btn-sm btn-danger" type="button" onclick="up('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击上移该主题">上移</button>
                        {/if}
                        {if $k+1 != count($config->get('theme', []))}
                        <button class="btn btn-sm btn-danger" type="button" onclick="down('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击下移该主题">下移</button>
                        {/if}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </div>
    <div class="my-4">
        <div class="fs-4 mb-3">未启用</div>
        <div class="d-flex flex-column gap-4">
            {foreach $themes as $theme}
            {if !in_array($theme['name'], $config->get('theme', []))}
            <div class="d-flex gap-3">
                <div>
                    <img src="{echo $theme['thumb']}" class="img-thumbnail" width="130" alt="">
                </div>
                <div class="d-flex flex-column gap-2 flex-grow-1 bg-light p-3">
                    <div><span class="fs-6 fw-bold">{$theme['title']??'-'}</span><sup class="ms-1 text-secondary">{$theme['version']??''}</sup></div>
                    <div>{$theme['description']??''}</div>
                    <div><code>/theme/{$theme.name}</code> </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" type="button" onclick="change('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击使用该主题">使用该主题</button>
                        <button class="btn btn-sm btn-warning" type="button" onclick="del('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="删除该主题">删除</button>
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </div>
</div>
{include common/footer@psrphp/admin}