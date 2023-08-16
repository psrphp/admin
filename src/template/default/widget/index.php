{include common/header@psrphp/admin}

<h1>挂件管理</h1>

<div>管理系统挂件，在模板中的调用方式为：<code>{literal}{widget '挂件名称'}{/literal}</code></div>

<div>
    <a href="{:$router->build('/psrphp/admin/widget/create')}">添加挂件</a>
</div>

{foreach $widgets as $name => $list}
{if $list}
<fieldset>
    <legend>{$name}</legend>
    <table>
        {foreach $list as $key => $vo}
        <tr>
            <td>{$vo.fullname}</td>
            <td>{$vo['title']??''}</td>
            <td>
                <a href="{echo $router->build('/psrphp/admin/widget/preview', ['name'=>$vo['fullname']])}">预览</a>
                {if $name=='自定义'}
                <a href="{echo $router->build('/psrphp/admin/widget/update', ['name'=>$vo['name']])}">编辑</a>
                <a href="{echo $router->build('/psrphp/admin/widget/delete', ['name'=>$vo['name']])}">删除</a>
                {/if}
            </td>
        </tr>
        {/foreach}
    </table>
</fieldset>
{/if}
{/foreach}

{include common/footer@psrphp/admin}