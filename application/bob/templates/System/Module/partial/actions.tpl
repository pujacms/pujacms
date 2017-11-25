{% for action in entity.actions %}
<input id="{{ InputFieldName }}[actions][{{ action }}]" name="{{ InputFieldName }}[actions][{{ action }}]" type="checkbox" class="no_width" value="{{ action }}" {% if action in cfg_data.actions %}checked{% endif %}  />
<label for="{{ InputFieldName }}[actions][{{ action }}]">{{ action|capfirst }}</label><br />
{% endfor %}