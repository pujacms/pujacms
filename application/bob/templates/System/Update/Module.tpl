{% extends master.tpl %}
{% block body %}
<form method="post">
    <div class="easyui-accordion" data-options="multiple:true">

        <div class="easyui-padding" title="Core data" data-options="collapsed:false">
            {% if ConfigureModule %}
                {% include System/Module/partial/core_update.tpl %}
            {% else %}
                {% include System/Module/partial/core_create.tpl %}
            {% endif %}
        </div>

        <div class="easyui-padding" title="Configure Generation" data-options="collapsed:false">
            {% include System/Module/partial/general.tpl %}
        </div>

        {% if ConfigureModule && ConfigureModule.module_type != 'system' %}
            <div class="easyui-padding" title="Configure Content" data-options="collapsed:false">
                {% include System/Module/partial/content.tpl %}
            </div>

            {% if ConfigureModule.core_data.category %}
            <div class="easyui-padding" title="Configure Category" data-options="collapsed:false">
                {% include System/Module/partial/category.tpl %}
            </div>
            {% endif %}
        {% endif %}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
            <tr>
                <td class="first"></td>
                <td>
                    <input class="l-btn easyui-btn" type="submit" value="Save" />
                    <input class="l-btn easyui-btn" type="button" value="Back" onclick="location.href='./?module=system&ctrl=module'" />
                </td>
            </tr>
        </table>
    </div>
</form>
<div id="EasyUi-Window"></div>
{% endblock %}
{% block javascript %}
<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/System/Module.js"></script>
<script>Puja.System.Module.Update.init();</script>
{% endblock %}