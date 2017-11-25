<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first">Name</td>
        <td><input name="ConfigureModule[name]" class="easyui-input textbox" type="text" value="{{ ConfigureModule.name }}"/></td>
    </tr>
    <tr class="only_for_system {% if ConfigureModule && ConfigureModule.module_type != 'system' %}hidden{% endif %}">
        <td>URL</td>
        <td><input name="ConfigureModule[url]" class="easyui-input textbox" type="text" value="{{ ConfigureModule.url }}"/> <i>ONLY FOR MODULE TYPE = SYSTEM</i></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><textarea name="ConfigureModule[description]" class="easyui-input textbox">{{ ConfigureModule.description }}</textarea></td>
    </tr>
    <tr>
        <td>Alice Module</td>
        <td>/<input name="ConfigureModule[alice_module]" class="easyui-input textbox" type="text" value="{{ ConfigureModule.alice_module }}" />/</td>
    </tr>
    <tr>
        <td>Enable drag/drop sort records</td>
        <td><input name="ConfigureModule[cfg_data][dragdrop]"  type="checkbox" value="1" {% if ConfigureModule.cfg_data.dragdrop %}checked{% endif %} /></td>
    </tr>
    <tr>
        <td>Enable searchbox on datagrid</td>
        <td><input name="ConfigureModule[cfg_data][searchbox]"  type="checkbox" value="1" {% if ConfigureModule.cfg_data.searchbox %}checked{% endif %} /></td>
    </tr>
</table>