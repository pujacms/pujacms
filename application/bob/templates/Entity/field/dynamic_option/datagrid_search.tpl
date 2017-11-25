<input class="easyui-combobox" data-selectmulti="{{ field.setting.select_multi|default:"0" }}"
       data-inputfieldname="{{ field.InputFieldName|classNameNormalize:"" }}"
       data-url="./?module={{ request.module }}&ctrl={{ request.ctrl }}&act=dynamic-option-data&options[field]={{ field.Field }}&options[type]={{ field.setting.dynamic_option_type }}&options[contentid]={{ request.pkid }}&typeid={{ field.setting.dynamic_option_type_id }}"
       data-options="
    loader: Puja.Entity.Update.FieldType.DynamicOption.events.loader,
    mode: 'remote',
    valueField: 'pkid',
    textField: 'name',
    onSelect: Puja.Entity.Update.FieldType.DynamicOption.events.onSelect,
    panelHeight: null,
    minPanelHeight: 20,
    prompt: 'Enter a search keyword'"/>
<div class="{{ field.InputFieldName|classNameNormalize:"" }}-block {% if field.value %}{% else %}hidden{% endif %}">
    <br />
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Selected items</div>
        </div>
        <div class="panel-body">
            <div class="sample hidden">
                <p><input type="checkbox" id="{{ field.InputFieldName }}-{id}-label" {checked}  value="{id}" name="{{ field.InputFieldName }}[]"> <label for="{{ field.InputFieldName }}-{id}-label">{text}</label></p>
            </div>
            <div class="list">
                {% for rs in field.value %}
                <p><input type="checkbox" id="{{ field.InputFieldName }}-{{ rs.pkid }}-label" checked name="{{ field.InputFieldName }}[]" value="{{ rs.pkid }}"> <label for="{{ field.InputFieldName }}-{{ rs.pkid }}-label">{{ rs.name }}</label></p>
                {% endfor %}
            </div>
        </div>
    </div>
</div>