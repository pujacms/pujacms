{% extends master.tpl %}
{% block body %}

<div class="easyui-panel" title="Configure Theme">
    <form method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
            <tr>
                <td class="first">Theme</td>
                <td><select class="easyui-combobox" name="theme[theme_id]" data-options="panelHeight:false">
                        {% for theme,name in CmsThemes %}
                        <option value="{{ theme }}">{{ name }}</option>
                        {% endfor %}
                    </select> <a href="#" class="easyui-linkbutton">Preview</a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="l-btn easyui-btn" value="Save" />
                    <input type="reset" class="l-btn easyui-btn" value="Clear" />

                </td>
            </tr>
        </table>
    </form>
</div>

{% endblock %}
{% block javascript %}
<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/Configure.js"></script>
{% endblock %}
