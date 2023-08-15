{include common/header@psrphp/admin}
<style>
    input {
        padding: 5px;
    }
</style>
<form method="POST">
    <div style="margin: 50px auto;width: 200px;">
        <div style="display:flex;flex-direction: column;gap: 10px;">
            <h1 style="text-align:center;">登录</h1>
            <div>
                <input type="text" name="name" placeholder="账户" autocomplete="off" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="密码" autocomplete="off" required>
            </div>
            <div>
                <img style="vertical-align: middle;cursor: pointer;margin-bottom:5px;border:1px solid gray;" src="{echo $router->build('/psrphp/admin/tool/captcha')}" data-src="{echo $router->build('/psrphp/admin/tool/captcha')}" onclick="event.target.setAttribute('src', event.target.dataset.src + '?time='+(new Date()).getTime())">
                <input type="text" name="captcha" placeholder="验证码" autocomplete="off" autocomplete="off" required>
            </div>
            <div>
                <button type="submit" style="padding: 5px 10px;">登录</button>
            </div>
        </div>
    </div>
</form>
{include common/footer@psrphp/admin}