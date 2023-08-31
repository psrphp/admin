{include common/header@psrphp/admin}
<style>
    html,
    body {
        height: 100%;
        margin-top: 0;
        margin-bottom: 0;
        padding: 0;
    }
</style>
<div style="display: flex;flex-wrap:nowrap;height: 100%;">
    <div style="width: 400px;overflow-y:auto;height:100%;">
        <h1>挂件列表</h1>
        <div style="display: flex;flex-direction: column;gap: 20px;margin: 0px auto;">
            {foreach $widgetProvider->all() as $vo}
            <div>
                <fieldset>
                    <legend>
                        <div style="display: flex;gap: 5px;align-items: center;justify-content: center;">
                            <span>{echo $widgetWarpper->getTitle($vo)}</span>
                            <form action="{echo $router->build('/psrphp/admin/widget/add')}" method="post" target="diy">
                                <input type="hidden" name="name" value="{:get_class($vo)}">
                                <button type="submit">添加</button>
                            </form>
                        </div>
                    </legend>
                    <div>
                        {echo $widgetWarpper->getContent($vo)}
                    </div>
                </fieldset>
            </div>
            {/foreach}
        </div>
    </div>
    <div style="flex-grow: 1;">
        <iframe src="{echo $router->build('/psrphp/admin/widget/index?diy=1')}" name="diy" id="diy" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
    </div>
</div>
{include common/footer@psrphp/admin}