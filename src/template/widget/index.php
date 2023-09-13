{include common/header@psrphp/admin}
<h1>信息看板</h1>
<div>
    {if $request->has('get.diy')}
    <a href="{echo $router->build('/psrphp/admin/widget/index')}" target="main">退出DIY</a>
    {else}
    <a href="{echo $router->build('/psrphp/admin/widget/diy')}" target="main">自定义本页</a>
    {/if}
</div>
<div style="display: flex;flex-direction: row;gap: 10px;flex-wrap: wrap;margin-top: 20px;">
    {foreach $widgets as $key => $vo}
    <div>
        <fieldset>
            <legend>
                <div style="display: flex;gap: 5px;align-items: center;justify-content: center;">
                    <span>{echo $widgetWarpper->getTitle($vo)}</span>
                    {if $request->get('diy')}
                    {if $key}
                    <form action="{echo $router->build('/psrphp/admin/widget/left')}" method="POST">
                        <input type="hidden" name="index" value="{$key}">
                        <button type="submit">左移</button>
                    </form>
                    {/if}
                    {if count($widgets)-$key-1}
                    <form action="{echo $router->build('/psrphp/admin/widget/right')}" method="POST">
                        <input type="hidden" name="index" value="{$key}">
                        <button type="submit">右移</button>
                    </form>
                    {/if}
                    <form action="{echo $router->build('/psrphp/admin/widget/remove')}" method="POST">
                        <input type="hidden" name="index" value="{$key}">
                        <button type="submit">移除</button>
                    </form>
                    {/if}
                </div>
            </legend>
            {echo $widgetWarpper->getContent($vo)}
        </fieldset>
    </div>
    {/foreach}
</div>
{include common/footer@psrphp/admin}