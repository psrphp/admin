{include common/header@psrphp/admin}

<div class="my-4">
    <div class="h1">欢迎使用</div>
    <div class="text-muted fw-light">系统的所有功能列表</div>
</div>

<?php
$getclass = function ($size) {
    switch ($size) {
        case 's':
            return 'col-md-3';
            break;
        case 'm':
            return 'col-md-6';
            break;
        case 'l':
            return 'col-md-9';
            break;
        case 'xl':
            return 'col-md-12';
            break;
        default:
            return 'col-12';
            break;
    }
}
?>
<script>
    function diy(data) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/admin/diy/index')}",
            data: data,
            dataType: "JSON",
            success: function() {
                location.reload();
            }
        });
    }
</script>
<div class="my-3">
    <div class="row">
        {foreach $config->get('diy@psrphp/admin', []) as $key => $vo}
        <div class="{echo $getclass($vo['size'])} position-relative" style="min-height:100px;">
            {if $request->get('diy')}
            <div class="position-absolute top-0 end-0 bg-warning bg-opacity-10 border" style="width:100%;height:100%;z-index:100;">
                <div class="p-2">
                    {if $key}
                    <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'left', index:'{$key}'})">左移</button>
                    {/if}
                    {if $key+1 < count($config->get('diy@psrphp/admin', []))}
                        <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'right', index:'{$key}'})">右移</button>
                        {/if}
                        <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'remove', index:'{$key}'})">删除</button>
                </div>
            </div>
            {/if}
            <div>
                {echo $widget->get($vo['widget'])}
            </div>
        </div>
        {/foreach}
    </div>
</div>

{include common/footer@psrphp/admin}