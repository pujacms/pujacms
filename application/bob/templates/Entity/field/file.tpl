<div class="puja-ajaxupload" data-inputfieldname="{{ field.InputFieldName }}">
    <button type="button" class="easyui-linkbutton choose_file_btn" data-options="iconCls:'icon-search'">Choose image</button>
    <input type="file" data-params="{{ field.Field }}" {% if field.setting.mutiple %}multiple{% endif %}>
    {% for fileimg in field.value %}
    <p class="puja-ajaxupload-progress">
        <input type="hidden" name="{{ field.InputFieldName }}[]" value="{{ fileimg.id_media }}" />
        <a class="easyui-link" target="puja-window" href="{{ cfg.upload_server }}/{{ fileimg.src }}">{{ fileimg.src }}</a>
        <span class="delete-btn">x</span>
    </p>
    {% endfor %}
</div>