{include common/header@psrphp/admin}
<script>
    function change(name, disabled) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/admin/plugin/disable')}",
            data: {
                name: name,
                disabled: disabled
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
        if (confirm('确定彻底删除该插件吗？删除后无法恢复！')) {
            $.ajax({
                type: "POST",
                url: "{echo $router->build('/psrphp/admin/plugin/delete')}",
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

    function install(name) {
        if (confirm('确定安装该插件吗？')) {
            $.ajax({
                type: "POST",
                url: "{echo $router->build('/psrphp/admin/plugin/install')}",
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

    function uninstall(name) {
        if (confirm('确定卸载该插件吗？')) {
            $.ajax({
                type: "POST",
                url: "{echo $router->build('/psrphp/admin/plugin/un-install')}",
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
        <div class="h1">插件管理</div>
        <div class="text-muted fw-light">
            <span>插件位于<code>/plugin</code>目录</span>
        </div>
    </div>
    <div class="my-4">
        <div class="fs-4 mb-3">已启用</div>
        <div class="d-flex flex-column gap-4">
            {foreach $plugins as $plugin}
            {if $plugin['install'] && !$plugin['disabled']}
            <div class="d-flex gap-3">
                <div>
                    <img src="{echo $plugin['logo']}" width="100" alt="">
                </div>
                <div class="d-flex flex-column gap-2 flex-grow-1 bg-light p-3">
                    <div><span class="fs-6 fw-bold">{$plugin['title']??'-'}</span><sup class="ms-1 text-secondary">{$plugin['version']??''}</sup></div>
                    <div>{$plugin['description']??''}</div>
                    <div><code>{$plugin.name}</code> </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" type="button" onclick="change('{$plugin.name}', 1);" data-bs-toggle="tooltip" data-bs-placement="right" title="插件已启用，点此切换">已启用</button>
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
            {foreach $plugins as $plugin}
            {if !$plugin['install'] || $plugin['disabled']}
            <div class="d-flex gap-3">
                <div>
                    <img src="{echo $plugin['logo']}" width="100" alt="">
                </div>
                <div class="d-flex flex-column gap-2 flex-grow-1 bg-light p-3">
                    <div><span class="fs-6 fw-bold">{$plugin['title']??'-'}</span><sup class="ms-1 text-secondary">{$plugin['version']??''}</sup></div>
                    <div>{$plugin['description']??''}</div>
                    <div><code>{$plugin.name}</code> </div>
                    <div class="d-flex gap-2">
                        {if $plugin['install']}
                        {if $plugin['disabled']}
                        <button class="btn btn-sm btn-warning" type="button" onclick="change('{$plugin.name}', 0);" data-bs-toggle="tooltip" data-bs-placement="right" title="插件已停用，点此切换">已停用</button>
                        <button class="btn btn-sm btn-warning" type="button" onclick="uninstall('{$plugin.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点此卸载此插件">卸载</button>
                        {else}
                        <button class="btn btn-sm btn-primary" type="button" onclick="change('{$plugin.name}', 1);" data-bs-toggle="tooltip" data-bs-placement="right" title="插件已启用，点此切换">已启用</button>
                        {/if}
                        {else}
                        <button class="btn btn-sm btn-primary" type="button" onclick="install('{$plugin.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="该插件未安装，点此安装">安装</button>
                        <button class="btn btn-sm btn-warning" type="button" onclick="del('{$plugin.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="彻底删除该插件">删除</button>
                        {/if}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </div>
</div>
{include common/footer@psrphp/admin}