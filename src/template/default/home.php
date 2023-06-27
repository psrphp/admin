{include common/header@psrphp/admin}
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
    <div class="row gy-3">
        {if $diys}
        {foreach $diys as $key => $vo}
        <div class="{echo $getclass($vo['size'])} position-relative" style="min-height:100px;">
            {if $request->get('diy')}
            <div class="position-absolute top-0 end-0 bg-warning bg-opacity-10 border" style="width:100%;height:100%;z-index:100;">
                <div class="p-2">
                    {if $key}
                    <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'left', index:'{$key}'})">左移</button>
                    {/if}
                    {if count($diys)-$key-1}
                    <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'right', index:'{$key}'})">右移</button>
                    {/if}
                    <button type="button" class="btn btn-sm btn-primary" onclick="diy({t:'remove', index:'{$key}'})">移除</button>
                </div>
            </div>
            {/if}
            <div>
                {echo $widget->get($vo['widget'])}
            </div>
        </div>
        {/foreach}
        {else}
        <div class="col">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">欢迎!</h4>
                <hr>
                <p>当前页面没有内容，您可以通过挂件，定义您关心的内容哦~</p>
                <a href="{echo $router->build('/psrphp/admin/diy/index')}" class="btn btn-primary">开始自定义本页面</a>
            </div>
        </div>
        {/if}
    </div>
</div>

{include common/footer@psrphp/admin}