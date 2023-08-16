{include common/header@psrphp/admin}
<h1>挂件预览</h1>
<dl>
    <dt>名称：</dt>
    <dd><code>{$request->get('name')}</code></dd>
    <dt>标题：</dt>
    <dd>{$title??''}</dd>
    <dt>代码：</dt>
    <dd>
        <code>
            <pre>{$code}</pre>
        </code>
    </dd>
    <dt>渲染结果：</dt>
    <dd>
        <code>
            <pre>{$res}</pre>
        </code>
    </dd>
    <dt>预览：</dt>
    <dd>
        <fieldset>
            <legend>{$title??''}</legend>
            {echo $res}
        </fieldset>
    </dd>
</dl>
{include common/footer@psrphp/admin}