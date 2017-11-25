<select class="easyui-select textbox" name="{{ field.InputFieldName }}">
    {% for option in field.setting.static_options %}
    <option value="{{ option.key }}"  {% if option.key==field.value %}selected{% endif %}>{{ option.value }}</option>
    {% endfor %}
</select>