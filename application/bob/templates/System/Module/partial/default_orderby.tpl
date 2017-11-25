<select class="easyui-select textbox" name="{{ InputFieldName }}[default_orderby]" data-options="panelHeight:false">
    {% for orderField in entity.tbl.orderFields %}
    <option value="{{ orderField }}" {% if orderField==cfg_data.default_orderby %}selected{% endif %}>{{ orderField }}</option>
    {% endfor %}
    {% for orderField in entity.ln_tbl.orderFields %}
    <option value="{{ orderField }}" {% if orderField==cfg_data.default_orderby %}selected{% endif %}>{{ orderField }}</option>
    {% endfor %}
</select>