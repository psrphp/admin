{include common/header@psrphp/admin}
<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div style="display: flex;flex-wrap:nowrap;height: 100%;">
    <div style="width: 400px;overflow-y:auto;height:100%;">
        <div>
            <a href="{echo $router->build('/psrphp/admin/index', ['t'=>'home'])}">退出DIY</a>
        </div>
        {foreach $widgets as $name => $list}
        {if $list}
        <!-- <fieldset> -->
        <!-- <legend>{$name}</legend> -->
        <div style="display: flex;flex-direction: column;gap: 20px;margin-top: 20px;">
            {foreach $list as $vo}
            <div>
                <fieldset>
                    <legend>{$vo['title']??$vo['fullname']}</legend>
                    <div>
                        {echo $widget->get($vo['fullname'])}
                    </div>
                </fieldset>
                <form style="display: inline-block;margin-top: 5px;" action="{echo $router->build('/psrphp/admin/diy/index')}" method="post" target="diy">
                    <input type="hidden" name="t" value="add">
                    <input type="hidden" name="widget" value="{$vo.fullname}">
                    <button type="submit">添加</button>
                </form>
            </div>
            {/foreach}
        </div>
        <!-- </fieldset> -->
        {/if}
        {/foreach}
    </div>
    <div style="flex-grow: 1;">
        <iframe src="{echo $router->build('/psrphp/admin/index?t=home&diy=1')}" name="diy" id="diy" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
    </div>
</div>
{include common/footer@psrphp/admin}