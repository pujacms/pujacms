{% extends master_nonuser.tpl %}
{% block body %}
<form method="post" action="./?ctrl=auth&act=login" onsubmit="Puja.Auth.Login.submit(this);return false;" class="easyui-form" method="post" data-options="novalidate:true">
    <div class="easyui-panel" data-options="iconCls:'icon-man'" title="{{ cfg.company_name }} Login">
        <div>
            <input class="easyui-textbox" prompt="Username" data-options="required:true" iconWidth="28" name="username" />
        </div>
        <div>
            <input class="easyui-passwordbox" prompt="Password" data-options="required:true" iconWidth="28" name="password" />
        </div>
        <div>
            <input type="submit" class="l-btn easyui-btn" value="Login" />
        </div>
    </div>
</form>
{% endblock %}