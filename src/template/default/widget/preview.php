{include common/header@psrphp/admin}
<h1>挂件预览</h1>
<dl>
    <dt>名称：</dt>
    <dd><code>{$request->get('name')}</code></dd>
    <dt>预览：</dt>
    <dd>{echo $code}</dd>
    <dt>代码：</dt>
    <dd>
        <code>
            <pre>{$code}</pre>
        </code>
    </dd>
</dl>
{include common/footer@psrphp/admin}