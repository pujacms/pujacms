{% for option in field.options %}
<input id="entity_act_{{ option.value }}" name="{{ field.name }}[]" type="checkbox" class="no_width" value="{{ option.value }}" {% if option.checked %}checked{% endif %} />
<label for="entity_act_{{ option.value }}">{{ option.name }}</label>{{ field.sep }}
{% endfor %}