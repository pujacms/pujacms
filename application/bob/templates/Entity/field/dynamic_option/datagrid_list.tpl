<div class="easyui-datalist" data-options="
            url: './?module={{ request.module }}&ctrl={{ request.ctrl }}&act=dynamic-option-data&options[field]={{ field.Field }}&options[type]={{ field.setting.dynamic_option_type }}&options[contentid]={{ request.pkid|default:0 }}&typeid={{ field.setting.dynamic_option }}',
            method: 'get',
            textFormatter: Puja.Entity.Update.FieldType.DynamicOption.formatter.datagrid,
            selectMulti: {{ field.setting.select_multi|default:"0" }},
            InputFieldName: '{{ field.InputFieldName }}'
            ">
</div>
