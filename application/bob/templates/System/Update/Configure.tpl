{% extends master.tpl %}
{% block body %}

<div class="easyui-panel" title="Configure Theme">
    <form method="post">
        <input type="hidden" name="pkid" value="{{ request.pkid }}">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
            <tr>
                <td class="first">Configure Group</td>
                <td><select class="textbox easyui-select" name="entity[configure][fk_configure_group]">
                        <option value="0">No Group</option>
                        {% for group in ConfigureGroup %}
                        <option value="{{ group.id_configure_group }}" {% if group.id_configure_group == field.fk_configure_group %}selected{% endif %}>{{ group.name }}</option>
                        {% endfor %}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td>
                    <input type="text" class="textbox easyui-input" value="{{ field.name }}" name="entity[configure][name]" />

                </td>
            </tr>
            <tr>
                <td>Code</td>
                <td>
                    <input type="text" class="textbox easyui-input" value="{{ field.code }}" name="entity[configure][code]" />

                </td>
            </tr>

            <tr>
                <td>Default value</td>
                <td>
                    <input type="text" class="textbox easyui-input" value="{{ field.value }}" name="entity[configure][value]" />

                </td>
            </tr>

            <tr>
                <td class="first">Field Type</td>
                <td><select class="textbox easyui-select" name="entity[configure][field_type]" onchange="Puja.System.Module.Update.changeFieldType('configure', this.value);">
                        {% for key,value in CfgFieldType.general %}
                        <option value="{{ key }}" {% if field.field_type == key %}selected{% endif %}>{{ value }}</option>
                        {% endfor %}
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="top">Advance configuration</td>
                <td>
                    <div class="field-advance-config-block field-advance-config__configure">
                        {% include System/Module/partial/field_advance_config.tpl %}
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="l-btn easyui-btn" value="Save" />
                    <input type="reset" class="l-btn easyui-btn" value="Clear" />
                    <a class="easyui-link" href="./?module=system&ctrl=configure">Back to list</a>

                </td>
            </tr>
        </table>
    </form>
</div>

{% endblock %}
{% block javascript %}
<script type="application/javascript" src="{{ cfg.static_server }}/js/Puja/System/Module.js"></script>
{% endblock %}
