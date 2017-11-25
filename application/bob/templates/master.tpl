<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ cfg.company_name }}</title>
    <link id="easyui-theme" rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/jinnguyen/easyui/themes/{{ CmsTheme.theme_data.theme_id|default:"default" }}/easyui.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/jinnguyen/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/css/reset.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/css/themes/{{ CmsTheme.theme_data.navigation_id|default:"horizontal-top" }}.css">
    {% block css %}{% endblock %}
    {% if CmsTheme.theme_data.header.background %}
    <style>.header{background: {{ CmsTheme.theme_data.header.background }};}</style>
    {% endif %}
    {% if CmsTheme.theme_data.header.color %}
    <style>.header, .header a{color: {{ CmsTheme.theme_data.header.color }};}</style>
    {% endif %}
</head>
<body class="panel-footer">
<div class="wrapper-body">
    <div class="header">{% include components/header.tpl %}</div>
    <div class="navigation panel-header">{% include components/navigation/{$ navigation_type $}.tpl %}</div>

    <div class="main-view">
        <div class="main-breadcrumb">{% include components/breadcrumb.tpl %}</div>
        {% block body %}{% endblock %}
    </div>
</div>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/components/jquery/jquery.js"></script>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/jinnguyen/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">var jsonStore = {{ jsonStore }};</script>
<script type="text/javascript" src="{{ cfg.static_server }}/js/Puja/Common.js"></script>
<script type="text/javascript">Puja.Common.init();</script>
{% block javascript %}{% endblock %}
</body>
</html>
