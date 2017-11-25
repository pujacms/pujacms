<input type="hidden"  name="{{ field.InputFieldName }}" value="0" />
<input class="easyui-switchbutton" name="{{ field.InputFieldName }}" {% if field.value %}checked{% endif %} value="1">