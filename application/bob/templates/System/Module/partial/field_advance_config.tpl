<!-- Config General -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first">Validator</td>
        <td><input class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][validator]" value="{{ field.setting.validator }}"  /></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><textarea class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][description]">{{ field.setting.description }}</textarea></td>
    </tr>
</table>

<!-- Config File -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type!='file' && field.field_type!='file_img' %}hidden{% endif %} field-advance-config-item field-advance-config-item__file field-advance-config-item__file_img" width="100%">
    <tr>
        <td class="first">Ext allows: <a href="#" title="Exp: .mp4,.flv,....">?</a></td>
        <td><input class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][allowed_fileext]" value="{{ field.setting.allowed_fileext }}" /> </td>
    </tr>
    <tr>
        <td>Max file size: <a href="#" title="Maximum file size (Kb),0: unlimit">?</a></td>
        <td><input class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][max_filesize]" value="{{ field.setting.max_filesize }}" /> KB </td>
    </tr>
    <tr>
        <td>Multiple upload: <a href="#" title="Allow user upload multi files">?</a></td>
        <td>
            <input type="checkbox" id="{{ InputFieldName }}[{{ field.Field }}][setting][mutiple]" name="{{ InputFieldName }}[{{ field.Field }}][setting][mutiple]" value="1" {% if field.setting.mutiple %}checked{% endif %} />
            <label for="{{ InputFieldName }}[{{ field.Field }}][setting][mutiple]">Upload multi files</label>
        </td>
    </tr>
</table>

<!-- Config image file_img -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type != 'file_img' %}hidden{% endif %} field-advance-config-item field-advance-config-item__file_img" width="100%">
    <tr>
        <td class="first">
            <input type="checkbox" id="{{ InputFieldName }}[{{ field.Field }}][setting][resize]" name="{{ InputFieldName }}[{{ field.Field }}][setting][resize]" value="1" {% if field.setting.resize %}checked{% endif %} />
            <label for="{{ InputFieldName }}[{{ field.Field }}][setting][resize]">Resize Image (width x height)</label>
        </td>
        <td><input placeholder="Resize width" name="{{ InputFieldName }}[{{ field.Field }}][setting][resize_w]" type="text" class="nowidth"  size="4" maxlength="3" value="{{ field.setting.resize_w|default:"0" }}">
            x
            <input placeholder="Resize height" name="{{ InputFieldName }}[{{ field.Field }}][setting][resize_h]" type="text" class="nowidth"  size="4" maxlength="3" value="{{ field.setting.resize_h|default:"0" }}">

            <input type="checkbox" id="{{ InputFieldName }}[{{ field.Field }}][setting][original]" name="{{ InputFieldName }}[{{ field.Field }}][setting][original]" value="1" {% if field.setting.original %}checked{% endif %} />
            <label for="{{ InputFieldName }}[{{ field.Field }}][setting][original]">Keep original image</label>
        </td>
    </tr>
    <tr>
        <td><input type="checkbox" id="{{ InputFieldName }}[{{ field.Field }}][setting][thumb]" name="{{ InputFieldName }}[{{ field.Field }}][setting][thumb]" value="1" {% if field.setting.thumb %}checked{% endif %} />
            <label for="{{ InputFieldName }}[{{ field.Field }}][setting][thumb]">Create thumb (width x height)</label>
        </td>
        <td>
            <input placeholder="Thumb width" name="{{ InputFieldName }}[{{ field.Field }}][setting][thumb_w]" type="text" class="nowidth"  size="4"  maxlength="3" value="{{ field.setting.thumb_w|default:"0" }}" />
            x <input placeholder="Thumb Height" name="{{ InputFieldName }}[{{ field.Field }}][setting][thumb_h]" type="text" class="nowidth"  size="4" maxlength="3"  value="{{ field.setting.thumb_h|default:"0" }}" />
        </td>
    </tr>
</table>


<!-- Config Multi input & Mutil textarea -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type != 'multi_input' && field.field_type != 'multi_textarea' %}hidden{% endif %} field-advance-config-item field-advance-config-item__multi_input field-advance-config-item__multi_textarea" width="100%">
    <tr>
        <td class="first">Max item allows</td>
        <td><input class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][max_allowed_item]" value="{{ field.setting.max_allowed_item|default:"0" }}" /> </td>
    </tr>
</table>


<!-- Config Static Options -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type != 'static_option' %}hidden{% endif %} field-advance-config-item field-advance-config-item__static_option" width="100%">
    <tr>
        <td class="first">Option Type</td>
        <td>
            <select class="textbox easyui-select" name="{{ InputFieldName }}[{{ field.Field }}][setting][static_option_type]">
                {% for key,value in CfgFieldType.static_options %}
                <option value="{{ key }}" {% if field.setting.static_option_type == key %}selected{% endif %}>{{ value }}</option>
                {% endfor %}
            </select>
        </td>
    </tr>
    <tr>
        <td valign="top">Init Data</td>
        <td>
            <a class="easyui-link" href="#" data-field="{{ field.Field }}" data-count="{{ field.setting.count_options|default:0 }}" onclick="Puja.System.Module.Update.addStaticOption(this);return false;"><span class="easyui-icon icon-add"></span>New option</a>
            <p class="hidden static-option-item__{{ field.Field }}">
                Key: <input class="textbox  easyui-input" disabled name="{{ InputFieldName }}[{{ field.Field }}][setting][static_options][$key$][key]" value="" />
                Value: <input class="textbox  easyui-input" disabled name="{{ InputFieldName }}[{{ field.Field }}][setting][static_options][$key$][value]" value="" />
                <a class="easyui-link" href="#" onclick="Puja.System.Module.Update.removeStaticOption(this);return false;"><span class="easyui-icon icon-cancel"></span></a>
            </p>
            {% for key,option in field.setting.static_options %}
                <p>
                    Key: <input class="textbox  easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][static_options][{{ key }}][key]" value="{{ option.key }}" />
                    Value: <input class="textbox  easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][static_options][{{ key }}][value]" value="{{ option.value }}" />
                    <a class="easyui-link" href="#" onclick="Puja.System.Module.Update.removeStaticOption(this);return false;"><span class="easyui-icon icon-cancel"></span></a>
                </p>
            {% endfor %}

        </td>
    </tr>
</table>


<!-- Config Dynamic Options -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type != 'dynamic_option' %}hidden{% endif %} field-advance-config-item field-advance-config-item__dynamic_option" width="100%">
    <tr>
        <td class="first">Option Type</td>
        <td>
            <select class="textbox easyui-select" name="{{ InputFieldName }}[{{ field.Field }}][setting][dynamic_option_type]">
                {% for key,value in CfgFieldType.dynamic_options %}
                <option value="{{ key }}" {% if field.setting.dynamic_option_type == key %}selected{% endif %}>{{ value }}</option>
                {% endfor %}
            </select>

            <input type="checkbox" class="textbox easyui-checkbox" name="{{ InputFieldName }}[{{ field.Field }}][setting][select_multi]" value="1" {% if field.setting.select_multi %}checked{% endif %} />
            Multi select
        </td>
    </tr>
    <tr>
        <td>Data Source</td>
        <td>
            <select class="textbox easyui-select" name="{{ InputFieldName }}[{{ field.Field }}][setting][dynamic_option]">
                {% for module in moduleList %}
                <option value="{{ module.id_configure_module }}" {% if field.setting.dynamic_option == module.id_configure_module %}selected{% endif %}>[{{ module.fk_module_type }}:{{ module.id_configure_module }}] {{ module.name }}</option>
                {% endfor %}
            </select>

        </td>
    </tr>
</table>


<!-- Config Time -->
<table cellspacing="0" cellpadding="0" class="table-form {% if field.field_type!='time' %}hidden{% endif %} field-advance-config-item field-advance-config-item__time" width="100%">
    <tr>
        <td class="first">Show seconds</td>
        <td><input type="checkbox" class="textbox easyui-input" name="{{ InputFieldName }}[{{ field.Field }}][setting][show_second]" value="1" {% if field.setting.show_second %}checked{% endif %} /> </td>
    </tr>
</table>

