{% if field.field_type == 'input' %}
    {% include Entity/field/input.tpl %}
{% elseif field.field_type == 'multi_input' %}
    {% include Entity/field/multi_input.tpl %}
{% elseif field.field_type == 'textarea' %}
    {% include Entity/field/textarea.tpl %}
{% elseif field.field_type == 'multi_textarea' %}
    {% include Entity/field/multi_textarea.tpl %}
{% elseif field.field_type == 'bbcode' %}
    {% include Entity/field/bbcode.tpl %}
{% elseif field.field_type == 'wysiwyg' %}
    {% include Entity/field/wysiwyg.tpl %}
{% elseif field.field_type == 'wysiwyg_simple' %}
    {% include Entity/field/wysiwyg_simple.tpl %}
{% elseif field.field_type == 'file' %}
    {% include Entity/field/file.tpl %}
{% elseif field.field_type == 'file_img' %}
    {% include Entity/field/file_img.tpl %}
{% elseif field.field_type == 'date' %}
    {% include Entity/field/date.tpl %}
{% elseif field.field_type == 'datetime' %}
    {% include Entity/field/datetime.tpl %}
{% elseif field.field_type == 'time' %}
    {% include Entity/field/time.tpl %}
{% elseif field.field_type == 'password' %}
    {% include Entity/field/password.tpl %}
{% elseif field.field_type == 'switch_button' %}
    {% include Entity/field/switch_button.tpl %}
{% elseif field.field_type == 'static_option' %}
    {% if field.setting.static_option_type == 'radio' %}
    {% include Entity/field/static_option/radio.tpl %}
    {% elseif field.setting.static_option_type == 'checkbox' %}
    {% include Entity/field/static_option/checkbox.tpl %}
    {% elseif field.setting.static_option_type == 'select' %}
    {% include Entity/field/static_option/select.tpl %}
    {% elseif field.setting.static_option_type == 'select_multi' %}
    {% include Entity/field/static_option/select_multi.tpl %}
    {% endif %}
{% elseif field.field_type == 'dynamic_option' %}
    {% if field.setting.dynamic_option_type == 'datagrid_list' %}
    {% include Entity/field/dynamic_option/datagrid_list.tpl %}
    {% elseif field.setting.dynamic_option_type == 'datagrid_search' %}
    {% include Entity/field/dynamic_option/datagrid_search.tpl %}
    {% endif %}
{% elseif field.field_type == 'password' %}
{% include Entity/field/password.tpl %}
{% elseif field.field_type == 'password' %}
{% include Entity/field/password.tpl %}
{% elseif field.field_type == 'password' %}
{% include Entity/field/password.tpl %}
{%  endif %}
<p><i>{{ field.setting.description }}</i></p>