<form method="post" onsubmit="Puja.System.Grid.actions.update(this);return false;">
    <input type="hidden" name="pkid" value="{{ entity.configure_language_id }}" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
        <tr>
            <td class="first">Name</td>
            <td><input type="text" name="entity[name]" class="textbox easyui-input" placeholder="Please enter the Language name" value="{{ entity.name }}" />

            </td>
        </tr>
        <tr>
            <td>Locale</td>
            <td><input type="text" name="entity[locale]" class="textbox easyui-input" placeholder="Please enter the Locale code" value="{{ entity.locale }}" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="l-btn easyui-btn" value="Save" />
                <input type="button" class="l-btn easyui-btn" value="Cancel" onclick="Puja.System.Grid.actions.closeWindow();" />
            </td>
        </tr>
    </table>
</form>
