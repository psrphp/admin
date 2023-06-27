{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">{$department.name}</div>
    <div class="text-muted fw-light">管理该部门的职位、成员、权限等</div>
</div>

<div class="my-3">
    <a href="{:$router->build('/psrphp/admin/role/create', ['department_id'=>$department['id']])}" class="btn btn-primary">添加职位</a>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">分配账户</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <script>
                    function searchx(q) {
                        $.ajax({
                            type: "POST",
                            url: "{:$router->build('/psrphp/admin/role/account')}",
                            data: {
                                role_id: document.getElementById('search_role_id').value,
                                q: document.getElementById('search_accountq').value,
                            },
                            dataType: "JSON",
                            success: function(response) {
                                if (response.errcode) {
                                    $("#search_role_reslt").html(response.message);
                                } else {
                                    $("#search_role_reslt").html(response.data);
                                }
                            },
                            error: function() {
                                $("#search_role_reslt").html('错误，请稍后再试~');
                            }
                        });
                    }
                </script>
                <input type="hidden" id="search_role_id">
                <input type="search" id="search_accountq" class="form-control" placeholder="搜索.." onchange="searchx()">
                <div id="search_role_reslt"></div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive my-3">
    <table class="table table-bordered table-striped">
        <tbody>
            {foreach $roles as $role}
            <tr>
                <td>
                    {if $role['director']==1}
                    <span class="text-danger" title="主管">[主管]</span>
                    {elseif $role['director']==2}
                    <span class="text-info" title="副主管">[副主管]</span>
                    {else}
                    {/if}
                    <span class="text-secondary">{$role.name}</span>
                    <a href="{:$router->build('/psrphp/admin/role/update', ['id'=>$role['id']])}" class="link-primary text-decoration-none">编辑</a>
                    <a href="{:$router->build('/psrphp/admin/role/delete', ['id'=>$role['id']])}" class="link-primary text-decoration-none" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                    <a href="{:$router->build('/psrphp/admin/role/auth', ['id'=>$role['id']])}" class="link-primary text-decoration-none">权限设置</a>
                </td>
            </tr>
            <tr>
                <td>
                    {foreach $role['accounts'] as $acc}
                    {$acc.name}
                    <a href="{:$router->build('/psrphp/admin/role/account', ['role_id'=>$role['id'], 'account_id'=>$acc['id']])}" class="link-primary text-decoration-none" onclick="return confirm('确定移除吗？');">移除</a>
                    {/foreach}
                    <a href="#" onclick="document.getElementById('search_role_id').value='{$role.id}';document.getElementById('search_accountq').value='';searchx();" data-bs-toggle="modal" data-bs-target="#exampleModal" class="link-primary text-decoration-none">添加成员</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
{include common/footer@psrphp/admin}