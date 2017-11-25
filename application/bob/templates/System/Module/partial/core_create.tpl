<form method="post" onsubmit="Puja.System.Grid.Module.actions.create(this);return false;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
        <tr>
            <td class="first">Module Name</td>
            <td><input type="text" class="easyui-input textbox" name="ConfigureModule[name]" /></td>
        </tr>
        <tr>
            <td>Module Type</td>
            <td><select class="easyui-select textbox" name="ConfigureModule[core_data][module_type]" onchange="Puja.System.Grid.Module.toolbars.changeModuleType(this.value);">
                    {% for ModuleType in ModuleTypes %}
                    <option value="{{ ModuleType.module_type }}">{{ ModuleType.name }}</option>
                    {% endfor %}
                </select>
            </td>
        </tr>
    </table>

    <table id="ChangeModuleType_Custom" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form ChangeModuleType hidden">
        <tr>
            <td class="first">Primary Table Name</td>
            <td><input class="easyui-input textbox" name="ConfigureModule[core_data][content][tbl]" placeholder="Primary Table Name" />
                <input type="checkbox" class="no_width" name="ConfigureModule[core_data][content][has_category]" value="1" /> With category
            </td>
        </tr>
    </table>

    <table id="ChangeModuleType_System" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form ChangeModuleType  hidden">
        <tr>
            <td class="first">Url</td>
            <td><input class="easyui-input textbox" name="ConfigureModule[url]" placeholder="Ex: ./?module=configure&ctrl=index" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
        <tr>
            <td class="first"></td>
            <td>
                <input type="submit" class="easyui-btn l-btn" value="Save">
                <input type="reset" class="easyui-btn l-btn" value="Reset">
            </td>
        </tr>
    </table>
</form>