{include common/header@psrphp/admin}
<h1>信息看板</h1>
<div>
    <a href="{echo $router->build('/psrphp/admin/diy/index')}">自定义本页</a>
</div>
{if $diys}
<div style="display: flex;flex-direction: row;gap: 10px;flex-wrap: wrap;margin-top: 20px;">
    {foreach $diys as $key => $vo}
    <div>
        <fieldset>
            <legend>{$vo['title']??$vo['widget']}</legend>
            {echo $widget->get($vo['widget'])}
        </fieldset>
        {if $request->get('diy')}
        <div style="display: flex;flex-direction: row;gap: 10px;flex-wrap: wrap;margin-top: 5px;">
            {if $key}
            <form action="{echo $router->build('/psrphp/admin/diy/index')}" method="POST">
                <input type="hidden" name="index" value="{$key}">
                <input type="hidden" name="t" value="left">
                <button type="submit">左移</button>
            </form>
            {/if}
            {if count($diys)-$key-1}
            <form action="{echo $router->build('/psrphp/admin/diy/index')}" method="POST">
                <input type="hidden" name="index" value="{$key}">
                <input type="hidden" name="t" value="right">
                <button type="submit">右移</button>
            </form>
            {/if}
            <form action="{echo $router->build('/psrphp/admin/diy/index')}" method="POST">
                <input type="hidden" name="index" value="{$key}">
                <input type="hidden" name="t" value="remove">
                <button type="submit">移除</button>
            </form>
        </div>
        {/if}
    </div>
    {/foreach}
</div>
{/if}

{include common/footer@psrphp/admin}