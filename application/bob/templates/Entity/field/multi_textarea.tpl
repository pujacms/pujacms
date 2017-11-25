<div class="multi-input-handle-block">
    <a class="easyui-link" href="#" data-field="{{ field.Field }}" data-max_allowed_item="{{ field.setting.max_allowed_item|default:0 }}" onclick="Puja.Entity.Update.FieldType.Multi.addNew(this);return false;"><span class="easyui-icon icon-add"></span> New</a>
    <div class="source-core hidden">
        <p class="multi-input-item">
            <textarea disabled class="textbox easyui-input" name="{{ field.InputFieldName }}[]"></textarea>
            <a class="easyui-link" href="#" onclick="Puja.Entity.Update.FieldType.Multi.remove(this);return false;"><span class="easyui-icon icon-cancel"></span></a>
        </p>
    </div>
    {% for val in field.value %}
        <p class="multi-input-item">
            <textarea class="textbox easyui-input" name="{{ field.InputFieldName }}[]">{{ val }}</textarea>
            <a class="easyui-link" href="#" onclick="Puja.Entity.Update.FieldType.Multi.remove(this);return false;"><span class="easyui-icon icon-cancel"></span></a>
        </p>
    {% empty %}
        <p class="multi-input-item">
            <textarea class="textbox easyui-input" name="{{ field.InputFieldName }}[]"></textarea>
            <a class="easyui-link" href="#" onclick="Puja.Entity.Update.FieldType.Multi.remove(this);return false;"><span class="easyui-icon icon-cancel"></span></a>
        </p>
    {% endfor %}
</div>