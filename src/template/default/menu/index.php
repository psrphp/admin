{include common/header@psrphp/admin}
<h1>功能地图</h1>

<div style="margin-top: 20px;">
    <div>已收藏</div>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;margin-top: 10px;">
        {foreach $sticks as $vo}
        <div>
            <a href="{$vo.url}">{$vo.title}</a>
            <a href="{echo $router->build('/psrphp/admin/menu/stick', $vo)}" title="取消收藏">★</a>
        </div>
        {/foreach}
    </div>
</div>

<div style="margin-top: 20px;">
    <div>功能地图</div>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;margin-top: 10px;">
        {foreach $menus as $appname => $items}
        <fieldset>
            <legend>{$appname}</legend>
            {foreach $items as $vo}
            <div>
                <a href="{$vo.url}">{$vo.title}</a>
                {if in_array(array_intersect_key($vo, ['url'=>'', 'title'=>'']), $sticks)}
                <a href="{echo $router->build('/psrphp/admin/menu/stick', $vo)}" title="取消收藏">★</a>
                {else}
                <a href="{echo $router->build('/psrphp/admin/menu/stick', $vo)}" title="点击收藏">✰</a>
                {/if}
            </div>
            {/foreach}
        </fieldset>
        {/foreach}
    </div>
</div>
{include common/footer@psrphp/admin}