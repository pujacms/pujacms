<div class="easyui-panel" title="{{ table.name }}'s Fields" data-options="footer: '#{{ table.name }}_field_tool'">
    <div class="datagrid-view">
        <div class="datagrid-header">
            <table class="datagrid-htable" border="0" cellspacing="0" cellpadding="0">
                <tr class="datagrid-header-row">
                    <td class="field">Field</td>
                    <td class="name">Name</td>
                    <td class="field_type">Field Type</td>
                    <td class="is_require">Required</td>
                    <td class="on_search">OnSearch</td>
                    <td class="indexed">Field Indexed</td>
                    <td class="indexed"></td>
                </tr>
            </table>
        </div>
        <div class="datagrid-body">
            {% for field in table.fields %}
            <table class="datagrid-btable" cellspacing="0" cellpadding="0" border="0">
                <tr class="datagrid-row">
                    <td class="field"><input type="checkbox" id="{{ InputFieldName }}[{{ field.Field }}][checked]" name="{{ InputFieldName }}[{{ field.Field }}][checked]" value="1" {% if field.checked %}checked{% endif %} />
                        <label for="{{ InputFieldName }}[{{ field.Field }}][checked]">{{ field.Field }}</label> <a href="#" title="{{ field.FieldType }}" class="easyui-link easyui-tooltip">[?]</a>
                    </td>
                    <td class="name"><input class="easyui-input textbox" name="{{ InputFieldName }}[{{ field.Field }}][name]" value="{{ field.name }}" /></td>
                    <td class="field_type">
                        <select class="easyui-select textbox" name="{{ InputFieldName }}[{{ field.Field }}][field_type]" onchange="Puja.System.Module.Update.changeFieldType('{{ field.Field }}', this.value);">
                            {% for key,value in CfgFieldType.general %}
                            <option value="{{ key }}" {% if field.field_type == key %}selected{% endif %}>{{ value }}</option>
                            {% endfor %}
                        </select>
                    </td>
                    <td class="is_require"><input class="easyui-input textbox" type="checkbox" name="{{ InputFieldName }}[{{ field.Field }}][is_require]" value="1" {% if field.is_require %}checked{% endif %} /></td>
                    <td class="on_search"><input class="easyui-input textbox" type="checkbox" name="{{ InputFieldName }}[{{ field.Field }}][is_search]" value="1" {% if field.is_search %}checked{% endif %} /></td>
                    <td class="indexed"><input class="easyui-input textbox" name="{{ InputFieldName }}[{{ field.Field }}][indexed]" value="{{ field.indexed|default:"0" }}" /></td>
                    <td class="indexed"><a href="#" class="easyui-link" onclick="Puja.System.Module.Update.showAdvanceSetting('{{ field.Field }}');return false;">Advance setting</a></td>
                </tr>
            </table>
            <div class="field-advance-config-block hidden field-advance-config__{{ field.Field }}">
                {% include System/Module/partial/field_advance_config.tpl %}
            </div>
            {% endfor %}

        </div>
    </div>
</div>

<div id="{{ table.name }}_field_tool">
    <a href="#" class="easyui-linkbutton" data-options="width: 100,iconCls:'icon-add',plain:true"  onclick="Puja.System.Module.TableField.addNew('{{ table.name }}');return false;">New Field</a>
</div>
<style type="text/css">
    .datagrid-row td.field,.datagrid-header-row td.field { width: 150px; }
    .datagrid-row td.name,.datagrid-header-row td.name { width: 140px; }
    .datagrid-row td.field_type,.datagrid-header-row td.field_type { width: 220px; }
    .datagrid-row td.is_require,.datagrid-header-row td.is_require { width: 50px; text-align: center; }
    .datagrid-row td.on_search,.datagrid-header-row td.on_search { width: 50px; text-align: center; }
    .datagrid-row td.indexed,.datagrid-header-row td.indexed { width: 140px; }
</style>