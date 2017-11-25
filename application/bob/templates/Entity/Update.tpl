{% extends master.tpl %}
{% block css %}
<link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/pujacms/ajaxupload/src/ajaxupload.css">
<link rel="stylesheet" type="text/css" href="{{ cfg.static_server }}/libs/jinnguyen/divbox/css/divbox.css">
{% endblock %}
{% block body %}
<iframe name="iframe_content_save" class="hidden" id="iframe_content_save"></iframe>
<form class="EntityUpdateForm" action="" method="post" target="iframe_content_save" onsubmit="return Puja.Entity.Update.Form.submit(this);">
    {% if IsMultiLang %}
        <div class="easyui-tabs" data-options="border:false,plain:true">
            {% for LnEntity in LnEntities %}
            <div title="{{ LnEntity.name }}">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
                    {% for field in LnEntity.fields %}
                    <tr>
                        <td class="first">{{ field.name }}</td>
                        <td>
                            {% include Entity/field/__init.tpl %}
                        </td>
                    </tr>
                    {% endfor %}
                </table>
            </div>
            {% endfor %}
        </div><hr />
    {% endif %}
<div class="easyui-panel" data-options="border:false">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
        {% for field in MainEntity.fields %}
        <tr>
            <td class="first">{{ field.name }}</td>
            <td>
                {% include Entity/field/__init.tpl %}
            </td>
        </tr>
        {% endfor %}
        <tr>
            <td></td>
            <td><input type="submit" class="l-btn easyui-btn"  value="Save" />
                {% if BackUrl %}
                <input type="button" class="l-btn easyui-btn" value="Cancel" onclick="location.href='{{ BackUrl }}';" />
                {% endif %}
            </td>
        </tr>
    </table>
</div>
</form>

{% endblock %}
{% block javascript %}

<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/Entity/Update.js"></script>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/tinymce/tinymce/tinymce.min.js"></script>
<script type="application/javascript" src="{{ cfg.static_server }}/js/tinymce/loader.js"></script>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/pujacms/ajaxupload/src/ajaxupload.js"></script>
<script type="text/javascript" src="{{ cfg.static_server }}/libs/jinnguyen/divbox/divbox.js"></script>
<script>Puja.Entity.Update.init();</script>
{% endblock %}