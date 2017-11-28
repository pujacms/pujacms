{% extends master.tpl %}
{% block body %}
<div class="easyui-panel" title="Reset password" style="padding: 10px;" >
    <form method="post" onsubmit="Puja.User.ResetPassword.submit(this); return false;" class="easyui-form" method="post" data-options="novalidate:true">
        <table cellpadding="1" cellspacing="1" width="100%">
            <tr>
                <td width="150">Current password</td>
                <td><input class="easyui-passwordbox" name="current_password" data-options="required:true"></td>
            </tr>
            <tr>
                <td>New password</td>
                <td><input class="easyui-passwordbox" name="password" data-options="required:true"></td>
            </tr>
            <tr>
                <td>New password</td>
                <td><input class="easyui-passwordbox" name="repeated_password" data-options="required:true"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input class="l-btn easyui-btn" type="submit" value="Save" /> <input class="l-btn easyui-btn" type="button" value="Cancel" onclick="location.href='./';" /></td>
            </tr>
        </table>
    </form>
</div>
{% endblock %}
{% block javascript %}
<script type="text/javascript" src="{{ cfg.static_server }}/js/Puja/User.js"></script>
{% endblock %}