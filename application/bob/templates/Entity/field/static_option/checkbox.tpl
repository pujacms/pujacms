{% for option in field.setting.static_options %}
<input id="{{ field.InputFieldName }}-{{ option.key }}" type="checkbox" name="{{ field.InputFieldName }}[]" value="{{ option.key }}" {% if option.key in field.value %}checked{% endif %} /> <label for="{{ field.InputFieldName }}-{{ option.key }}">{{ option.value }}</label>
{% endfor %}