<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ cfg.company_name }}</title>
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/jinnguyen/easyui/themes/{{ cfg.theme_data.login_theme_id }}/easyui.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/jinnguyen/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/css/reset.css">
    <link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/css/login.css">
    {% block css %}{% endblock %}
</head>
<body class="panel-footer">

{% block body %}{% endblock %}

<script type="text/javascript" src="{{ cfg.static_server }}/libs/components/jquery/jquery.js"></script>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/jinnguyen/easyui/jquery.easyui.min.js"></script>
</body>
</html>