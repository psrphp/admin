{include common/header@psrphp/admin}
<h1>功能地图</h1>

<div style="margin-top: 20px;">
    <div>已收藏</div>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;">
        {foreach $stick_menus as $menu}
        <div>
            <a href="{$menu.url}">{$menu.title}</a>
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="取消收藏">★</a>
        </div>
        {/foreach}
    </div>
</div>

<div style="margin-top: 20px;">
    <div>功能地图</div>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;">
        {foreach $menus as $menu}
        {if $menu['auth'] && $menu['core']}
        <div>
            <a href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="取消收藏">★</a>
            {else}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="点击收藏">✰</a>
            {/if}
        </div>
        {/if}
        {/foreach}
        {foreach $menus as $menu}
        {if $menu['auth'] && !$menu['core'] && !$menu['plugin']}
        <div>
            <a href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="取消收藏">★</a>
            {else}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="点击收藏">✰</a>
            {/if}
        </div>
        {/if}
        {/foreach}
        {foreach $menus as $menu}
        {if $menu['auth'] && $menu['plugin']}
        <div>
            <a href="{$menu.url}">{$menu.title}</a>
            {if in_array(array_intersect_key($menu, ['url'=>'', 'title'=>'']), $stick_menus)}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="取消收藏">★</a>
            {else}
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $menu)}" title="点击收藏">✰</a>
            {/if}
        </div>
        {/if}
        {/foreach}
    </div>
</div>
{include common/footer@psrphp/admin}