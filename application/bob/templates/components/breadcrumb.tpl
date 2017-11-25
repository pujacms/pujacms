{% if breadcrumb|length %}

    <a href="./" class="easyui-linkbutton" data-options="plain:true,iconCls:'tree-folder'">Root</a>
    {% for bread in breadcrumb %}
    &gt;<a class="easyui-linkbutton" data-options="plain:true" href="{{ bread.url }}">{{ bread.title }}</a>
    {% endfor %}

{% endif %}

