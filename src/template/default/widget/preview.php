{include common/header@psrphp/admin}

<div class="my-4">
    <div class="h1">挂件预览</div>
    <div class="text-muted fw-light">根据挂件放置的位置及样式不同，实际显示效果可能不同~</div>
</div>

<div class="fw-bold my-2">挂件：</div>
<div>
    <code>{$request->get('name')}</code>
</div>

<div class="fw-bold my-2">预览：</div>
<div>{echo $code}</div>

<div class="fw-bold my-2">原始代码：</div>
<code>
    <pre>{$code}</pre>
</code>
{include common/footer@psrphp/admin}