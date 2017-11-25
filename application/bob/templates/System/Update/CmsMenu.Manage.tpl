{% extends master.tpl %}
{% block body %}

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first" valign="top">
            <div class="easyui-accordion">
                <div class="configure_cmsmenu" title="Unassigned modules" data-options="collapsed:false">
                    {% for module in configure_modules %}
                    {% if module.menu_available %}
                    <div data-pkid="{{ module.id_configure_module }}" class="configure_cmsmenu_item">{{ module.name }}<span class="input"></span></div>
                    {% endif %}
                    {% endfor %}
                </div>
            </div>

        </td>
        <td valign="top">
            <form method="post" id="form-cmsmenu" onsubmit="Puja.System.CmsMenu.Update.updateChild(this);return false;">
                <div class="easyui-accordion" data-options="multiple:true">
                    {% for menu in cms_menus %}
                    <div class="configure_cmsmenu" data-pkid="{{ menu.id_configure_cmsmenu }}" title="{{ menu.name }}" data-options="collapsed:false">
                        {% for child in menu.child %}
                        <div data-pkid="{{ child.id_configure_module }}" class="configure_cmsmenu_item">
                            {{ child.name }}
                            <span class="input"><input type="hidden" name="child[{{ menu.id_configure_cmsmenu }}][]" value="{{ child.id_configure_module }}" /></span>
                        </div>

                        {% endfor %}
                    </div>
                    {% endfor %}
                </div>
                <p><input class="l-btn easyui-btn" type="submit" value="Save" /> <input class="l-btn easyui-btn" type="button" value="Back" onclick="location.href='./?module=system&ctrl=cmsmenu';" /></p>
            </form>
        </td>
    </tr>
</table>
{% endblock %}
{% block javascript %}
<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/System/CmsMenu.js"></script>
<script>Puja.System.CmsMenu.init();</script>
{% endblock %}