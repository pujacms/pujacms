<input class="easyui-combobox" data-selectmulti="{{ field.setting.select_multi|default:"0" }}"
       data-inputfieldname="{{ field.InputFieldName|classNameNormalize:"" }}"
       data-url="./?module={{ request.module }}&ctrl={{ request.ctrl }}&act=dynamic-option-query&typeid={{ field.setting.dynamic_option }}"
       data-options="
    loader: Puja.Entity.Update.FieldType.DynamicOption.events.loader,
    mode: 'remote',
    valueField: 'pkid',
    textField: 'name',
    onSelect: Puja.Entity.Update.FieldType.DynamicOption.events.onSelect,
    panelHeight: null,
    minPanelHeight: 20,
    prompt: 'Enter a search keyword'" />
<br />
<br />
<div id="Block_{{ field.InputFieldName|classNameNormalize:"" }}" class="easyui-datalist" data-options="
            url: './?module={{ request.module }}&ctrl={{ request.ctrl }}&act=dynamic-option-data&options[field]={{ field.Field }}&options[type]={{ field.setting.dynamic_option_type }}&options[contentid]={{ request.pkid|default:0 }}&typeid={{ field.setting.dynamic_option }}',
            method: 'get',
            textFormatter: Puja.Entity.Update.FieldType.DynamicOption.formatter.datagrid,
            selectMulti: {{ field.setting.select_multi|default:"0" }},
            InputFieldName: '{{ field.InputFieldName }}',
            emptyMsg: 'No item assigned yet'
            ">
</div>