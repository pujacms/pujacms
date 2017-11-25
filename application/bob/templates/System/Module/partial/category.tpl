{% set entity=category  cfg_data=ConfigureModule.cfg_data.category InputFieldName="ConfigureModule[cfg_data][category]" %}
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">

        <tr>
            <td  class="first">Actions</td>
            <td>
                {% include System/Module/partial/actions.tpl %}

            </td>


        </tr>
        <tr class="nohover">
            <td>Action tool buttons</td>
            <td>

            </td>
        </tr>
        <tr class="nohover">
            <td>CustomProcess Model</td>
            <td>
                <input name="{{ InputFieldName }}[custom_process_model]" class="easyui-input textbox" value="{{ cfg_data.custom_process_model }}" />
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="{{ InputFieldName }}[url_preview]">URL Preview</label></td>
            <td><input name="{{ InputFieldName }}[url_preview]" class="easyui-input textbox" type="text" id="{{ InputFieldName }}[url_preview]" value="{{ cfg_data.url_preview }}" />
                <br/>Example:
                <br/> product/$id
                <br/>product/$catid/$id
            </td>
        </tr>
        <tr>
            <td valign="top">Languages</td>
            <td>

            </td>
        </tr>
        {% for key,limitation in category.limitation %}
        <tr>
            <td valign="top">{{ limitation.name }}</td>
            <td>
                <input name="{{ InputFieldName }}[limitation][{{ key }}]" class="easyui-input textbox" value="{{ limitation.value|default:"-1" }}" ><br />
                <i>{{ limitation.description }}</i>
            </td>
        </tr>
        {% endfor %}

        <tr>
            <td valign="top">Default sort</td>
            <td>
                {% include System/Module/partial/default_orderby.tpl %}
            </td>
        </tr>
    </table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first" valign="top">Main Fields</td>
        <td>{% include System/Module/partial/field.tpl  moduleList=moduleList table=category.tbl CfgFieldType=CfgFieldType InputFieldName="ConfigureModule[cfg_data][category][main_fields]" %}</td>
    </tr>
    {% if category.ln_tbl.fields %}
    <tr>
        <td class="first" valign="top">Ln Fields</td>
        <td>{% include System/Module/partial/field.tpl moduleList=moduleList table=category.ln_tbl CfgFieldType=CfgFieldType InputFieldName="ConfigureModule[cfg_data][category][ln_fields]" %}</td>
    </tr>
    {% endif %}
</table>