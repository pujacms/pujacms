 <form method="post" onsubmit="Puja.System.Module.TableField.saveSubmit(this);return false;">
    <input type="hidden" name="table" value="{{ request.tableName }}" />
    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table-form">
        <tr>
            <td width="12%">Field name</td>
            <td width="10%">Type </td>
            <td width="8%">Length</td>
            <td>Default</td>
        </tr>
        <tr>
            <td>

                <input class="easyui-input textbox" type="text" name="field[name]" /></td>
            <td>
                <select class="easyui-select textbox" name="field[type]">
                    <option value="VARCHAR">VARCHAR</option>
                    <option value="TEXT">TEXT</option>
                    <option value="INT">INT</option>
                    <option value="DATE">DATE</option>
                    <option value="DATETIME">DATETIME</option>
                </select>
            </td>
            <td><input class="easyui-input textbox" type="text" name="field[length]" /></td>
            <td><input class="easyui-input textbox" type="text" name="field[default]" />

            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input class="easyui-btn l-btn" type="submit" name="Submit" value="Save">
                <input class="l-btn easyui-btn" type="reset"  value="Reset"/></td>
        </tr>
    </table>
    <div class="table_addfield_msg"></div>
</form>