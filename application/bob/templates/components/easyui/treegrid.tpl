<table  title="{{ treegrid.title }}" class="easyui-treegrid" data-options="
    url: '{{ treegrid.url }}',
    method: 'get',
    idField: '{{ treegrid.idField }}',
    treeField: '{{ treegrid.treeField }}'
">
    <thead>
    <tr>
        {% for field,fieldName in treegrid.fields %}
        <th data-options="field:'{{ field }}'" width="220">{{ fieldName }}</th>
        {% endfor %}
        <th data-options="field:'action',align:'center',resizable:false,formatter:{{ treegrid.JsGrid }}.formatActions" width="20%">Actions</th>
    </tr>
    </thead>
</table>