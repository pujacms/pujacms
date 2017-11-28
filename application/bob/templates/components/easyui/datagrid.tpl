<table id="EasyUI-DataGrid" class="easyui-datagrid" title="{{ datagrid.title }}" data-options="
    {% if datagrid.toolbars %}
    toolbar:'#easyui-datagrid-toolbar',
    {% endif %}
    {% if datagrid.events %}
    {% for event,eventFn in datagrid.events %}
    {{ event }}: {{ datagrid.JsGrid }}.events.{{ eventFn}},
    {% endfor %}
    {% endif %}
    singleSelect: true,
    emptyMsg: 'No items',
    pagination:true,
    url: '{{ datagrid.url }}',
    method: 'get',
    onLoadError: function() {},
    rowStyler: {{ datagrid.JsGrid }}.formatter.rowStyler
    ">
    <thead>
    <tr>
        {% for key,field in datagrid.fields %}
        <th data-options="
            {% for option, optionValue in field.options %}
                {% if option == 'formatter' %}
                {{ option }}: {{ optionValue }},
                {% else  %}
                {{ option }}: '{{ optionValue }}',
                {% endif %}
            {% endfor %}
            field:'{{ key }}'" width="{{ field.options.width }}">{{ field.title }}</th>
        {% endfor %}
        <th data-options="field:'action',align:'center',resizable:false,formatter:{{ datagrid.JsGrid }}.formatter.actions" width="20%">Actions</th>
    </tr>
    </thead>
</table>
{% if datagrid.toolbars %}
<div id="easyui-datagrid-toolbar">
    {% for toolbar in datagrid.toolbars %}
    <a href="#" onclick="{{ datagrid.JsGrid }}.toolbars.{{ toolbar.fn }}();return false;" class="easyui-linkbutton {% if datagrid.IsCustomToolbarIcons %}custom-{{ toolbar.icon }}{% endif %}" iconCls="{{ toolbar.icon }}" plain="true">
        {{ toolbar.name }}
        <span class="custom-icon"></span>
    </a>
    {% endfor %}

    {% if datagrid.searchbox.enabled %}

        <div class="datagrid_search_box">
            <input class="easyui-searchbox" style="width:300px" data-options="
        searcher:{{ datagrid.JsGrid }}.toolbars.search,
        prompt:'Please enter keywords, press ENTER',
        menu:'#datagrid_search_box_menu',
        icons: [{
            iconCls:'icon-clear',
            handler: {{ datagrid.JsGrid }}.toolbars.clearSearch
        }]
        " />
            <div id="datagrid_search_box_menu" style="width:120px">
                <div data-options="name:'index'">All</div>
            </div>
        </div>

    {% endif %}
</div>
{% endif %}
<div id="datagrid_error_message" class="error_message"></div>