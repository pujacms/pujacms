{% extends master.tpl %}
{% block css %}
<style>
    {% if datagrid.enabledDnd %}
    .datagrid-btable .datagrid-cell{ cursor: move; }
    {% endif %}
</style>
{% endblock %}
{% block body %}
{% if breadcrumb_categories %}
<div>
    <a class="easyui-linkbutton" data-options="plain:true,iconCls:'tree-folder'" href="./?module={{ request.module }}&typeid={{ request.typeid }}">Root</a>
    {% for breadcrumb_category in breadcrumb_categories %}
       &gt; <a class="easyui-linkbutton" data-options="plain:true" href="./?module={{ request.module }}&parentid={{ breadcrumb_category.pkid }}&typeid={{ request.typeid }}">{{ breadcrumb_category.name }}</a>
    {% endfor %}
</div>
{% endif %}

<form method="post" id="GridContentForm">
{% include components/easyui/datagrid.tpl %}
</form>
<style>
    .tree-node {
        margin-left: 10px;;}
</style>

<div id="Easyui-Window" class="easyui-window" style="width:350px;height:400px;padding:10px;" data-options="modal:true,closed:true,iconCls:'icon-save'"></div>
<div style="height: 300px;"></div>
{% endblock %}
{% block javascript %}
<script type="text/javascript" src="{{ cfg.static_server }}/js/easyui/datagrid.dnd.js"></script>
<script type="application/javascript" src="{{ cfg.static_server }}/js/{{ JsHandlerFile }}.js"></script>
<script>{{ JsHandler }}.init();</script>
{% endblock %}