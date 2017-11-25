{% set entity=content cfg_data=ConfigureModule.cfg_data.content InputFieldName="ConfigureModule[cfg_data][content]" %}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first" valign="top">Actions</td>
        <td>
            {% include System/Module/partial/actions.tpl %}
        </td>
    </tr>

    <tr class="nohover">
        <td  class="first">Action tool buttons</td>
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
        <td valign="top">Default sort</td>
        <td>
            {% include System/Module/partial/default_orderby.tpl %}
        </td>
    </tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first" valign="top">Main Fields</td>
        <td>{% include System/Module/partial/field.tpl moduleList=moduleList table=content.tbl CfgFieldType=CfgFieldType InputFieldName="ConfigureModule[cfg_data][content][main_fields]" %}</td>
    </tr>
    {% if content.ln_tbl.fields %}
    <tr>
        <td class="first" valign="top">Ln Fields</td>
        <td>{% include System/Module/partial/field.tpl moduleList=moduleList table=content.ln_tbl CfgFieldType=CfgFieldType InputFieldName="ConfigureModule[cfg_data][content][ln_fields]" %}</td>
    </tr>
    {% endif %}
</table>