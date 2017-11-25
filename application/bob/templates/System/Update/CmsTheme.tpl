{% extends master.tpl %}
{% block body %}
<div class="easyui-panel" title="Configure Theme">
    <form method="post" id="CmsThemForm"  onsubmit="Puja.System.CmsTheme.save(this);return false;">
        <input type="hidden" name="pkid" value="{{ request.pkid|default:"0" }}" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
        <tr>
            <td class="first">Name</td>
            <td><input class="easyui-textbox" name="theme[name]" value="{{ CmsTheme.name }}" /></td>
        </tr>
        <tr>
            <td class="first">Header background</td>
            <td><input class="easyui-textbox" name="theme[theme_data][header][background]" value="{{ CmsTheme.theme_data.header.background|default:"darkred" }}" /></td>
        </tr>
        <tr>
            <td>Header Text Color</td>
            <td><input class="easyui-textbox" name="theme[theme_data][header][color]" value="{{ CmsTheme.theme_data.header.color|default:"white" }}" /></td>
        </tr>
        <tr>
            <td>Navigation Theme</td>
            <td><select class="easyui-combobox" name="theme[theme_data][navigation_id]" data-options="panelHeight:false">
                    {% for theme,name in NavigationTheme %}
                    <option value="{{ theme }}" {% if theme == CmsTheme.theme_data.navigation_id %}selected{% endif %}>{{ name }}</option>
                    {% endfor %}
                </select>
                <div id="theme_loading"></div>
            </td>
        </tr>

        <tr>
            <td>EasyUI Theme</td>
            <td><select class="easyui-combobox" name="theme[theme_data][theme_id]" data-options="panelHeight:false">
                    {% for theme,name in EasyUITheme %}
                    <option value="{{ theme }}" {% if theme == CmsTheme.theme_data.theme_id %}selected{% endif %}>{{ name }}</option>
                    {% endfor %}
                </select>
                <div id="theme_loading"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" class="l-btn easyui-btn" value="Save" />
                <input type="button" class="l-btn easyui-btn" value="Preview" onclick="Puja.System.CmsTheme.preview();" />
                <a class="easyui-link" href="./?module=system&ctrl=cmstheme">Back to list</a>

            </td>
        </tr>
    </table>
    </form>
</div>

{% endblock %}
{% block javascript %}
<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/System/CmsTheme.js"></script>
{% endblock %}
