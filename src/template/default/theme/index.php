{include common/header@psrphp/admin}
<h1>主题管理</h1>

<div>
    <span>主题位于 <code>/theme</code> 目录</span>
</div>

<div style="display: flex;flex-direction: column;gap: 20px;margin-top: 20px;">
    <fieldset>
        <legend>已启用</legend>
        <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">
            {foreach $config->get('theme', []) as $k => $vo}
            {if isset($themes[$vo])}
            {php $theme = $themes[$vo]}
            <div>
                <div>
                    <img src="{echo $theme['thumb']}" width="130" alt="">
                </div>
                <div>
                    <div>
                        <span>{$theme['title']??'-'}</span><sup>{$theme['version']??''}</sup>
                    </div>
                    <div>{$theme['description']??''}</div>
                    <div><code>/theme/{$theme['name']}</code></div>
                    <div style="display: flex;flex-direction: row;gap: 5px;">
                        <form action="{echo $router->build('/psrphp/admin/theme/change')}" method="post">
                            <input type="hidden" name="name" value="{$theme.name}">
                            <button type="submit">停用该主题</button>
                        </form>
                        {if $k}
                        <form action="{echo $router->build('/psrphp/admin/theme/up')}" method="post">
                            <input type="hidden" name="name" value="{$theme.name}">
                            <button type="submit">左移</button>
                        </form>
                        {/if}
                        {if $k+1 != count($config->get('theme', []))}
                        <form action="{echo $router->build('/psrphp/admin/theme/down')}" method="post">
                            <input type="hidden" name="name" value="{$theme.name}">
                            <button type="submit">右移</button>
                        </form>
                        {/if}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </fieldset>

    <fieldset>
        <legend>未启用</legend>
        <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">
            {foreach $themes as $theme}
            {if !in_array($theme['name'], $config->get('theme', []))}
            <div>
                <div>
                    <img src="{echo $theme['thumb']}" width="130" alt="">
                </div>
                <div>
                    <div><span>{$theme['title']??'-'}</span><sup>{$theme['version']??''}</sup></div>
                    <div>{$theme['description']??''}</div>
                    <div><code>/theme/{$theme.name}</code> </div>
                    <div style="display: flex;flex-direction: row;gap: 5px;">
                        <form action="{echo $router->build('/psrphp/admin/theme/change')}" method="post">
                            <input type="hidden" name="name" value="{$theme.name}">
                            <button type="submit">使用该主题</button>
                        </form>
                        <form action="{echo $router->build('/psrphp/admin/theme/delete')}" method="post">
                            <input type="hidden" name="name" value="{$theme.name}">
                            <button type="submit" onclick="return confirm('确定删除吗？')">删除该主题</button>
                        </form>
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </fieldset>
</div>
{include common/footer@psrphp/admin}