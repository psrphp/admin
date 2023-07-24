{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">功能地图</div>
    <div class="text-muted fw-light">系统的所有功能列表</div>
</div>

<script>
    $(function() {
        $(".item").hover(function() {
            $(this).addClass("shadow-sm");
        }, function() {
            $(this).removeClass("shadow-sm");
        })
    });
</script>

<div class="fs-5 fw-light mb-3 mt-4 text-muted">已收藏</div>
<div class="d-flex flex-wrap align-items-stretch gap-3">
    {foreach $stick_menus as $menu}
    <div class="bg-light px-2 py-1 item">
        <div class="fs-6 fw-bold">
            <a class="text-decoration-none" href="{$menu.url}">{$menu.title}</a>
            <a class="text-danger" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="取消收藏">★</a>
        </div>
    </div>
    {/foreach}
</div>

<div class="fs-5 fw-light mb-3 mt-4 text-muted">功能地图</div>
<div class="d-flex flex-wrap align-items-stretch gap-3 mb-3">
    {foreach $menus as $menu}
    {if $menu['auth'] && $menu['core']}
    <div class="bg-light px-2 py-1 item">
        <div class="fs-6 fw-bold">
            <a class="text-decoration-none" href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a class="text-danger" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="取消收藏">★</a>
            {else}
            <a class="text-secondary" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="点击收藏">✰</a>
            {/if}
        </div>
    </div>
    {/if}
    {/foreach}
</div>
<div class="d-flex flex-wrap align-items-stretch gap-3 mb-3">
    {foreach $menus as $menu}
    {if $menu['auth'] && !$menu['core'] && !$menu['plugin']}
    <div class="bg-light px-2 py-1 item">
        <div class="fs-6 fw-bold">
            <a class="text-decoration-none" href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a class="text-danger" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="取消收藏">★</a>
            {else}
            <a class="text-secondary" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="点击收藏">✰</a>
            {/if}
        </div>
    </div>
    {/if}
    {/foreach}
</div>
<div class="d-flex flex-wrap align-items-stretch gap-3 mb-3">
    {foreach $menus as $menu}
    {if $menu['auth'] && $menu['plugin']}
    <div class="bg-light px-2 py-1 item">
        <div class="fs-6 fw-bold">
            <a class="text-decoration-none" href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a class="text-danger" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="取消收藏">★</a>
            {else}
            <a class="text-secondary" href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" data-bs-toggle="tooltip" title="点击收藏">✰</a>
            {/if}
        </div>
    </div>
    {/if}
    {/foreach}
</div>

{include common/footer@psrphp/admin}