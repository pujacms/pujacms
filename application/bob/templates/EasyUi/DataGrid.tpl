{% extends master.tpl %}
{% block body %}
{% include components/easyui/datagrid.tpl %}
<div id="Easyui-Window"></div>
<div style="height: 300px;"></div>
{% endblock %}
{% block javascript %}
<script type="text/javascript" src="{{ cfg.static_server }}/js/easyui/datagrid.dnd.js"></script>
<script type="application/javascript" src="{{ cfg.static_server }}/js/{{ JsHandlerFile }}.js"></script>
<script>{{ JsHandler }}.init();</script>
{% endblock %}