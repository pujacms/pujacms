<select class="easyui-combobox" name="{{ field.name }}" data-options="panelHeight:false">
    {% for option in field.options %}
    <option value="{{ option.value }}">{{ option.name }}</option>
    {% endfor %}
</select>