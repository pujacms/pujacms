{% extends master.tpl %}
{% block body %}
<div class="easyui-panel" title="User profile" style="padding: 10px;" >
    <table cellpadding="1" cellspacing="1" width="100%">
        <tr>
            <td width="100">Email</td>
            <td>: {{ current_user.email }}</td>
        </tr>
        <tr>
            <td>Role</td>
            <td>: {{ current_user.fk_acl_role }}</td>
        </tr>
        <tr>
            <td>Created at</td>
            <td>: {{ current_user.created_at }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" data-options="iconCls:'icon-edit'" href="./?module=user&act=reset-password">Reset password</a></td>
        </tr>
    </table>
</div>
{% endblock %}