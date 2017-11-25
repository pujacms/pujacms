<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-form">
    <tr>
        <td class="first">Module Type</td>
        <td><strong>{{ ConfigureModule.module_type }}</strong></td>
    </tr>
    <tr>
        <td>Type Id</td>
        <td><strong>{{ ConfigureModule.type_id }}</strong></td>
    </tr>

    <tr>
        <td>Primary Table Name </td>
        <td>
            <strong>{{ ConfigureModule.core_data.content.tbl.name|default:"--" }}</strong>
            <i>( PKField: <strong>{{ ConfigureModule.core_data.content.tbl.pk_field|default:"--" }}</strong>
                - ParentField: <strong>{{ ConfigureModule.core_data.content.tbl.parent_field|default:"--" }} )</strong>
            </i>
        </td>
    </tr>
    {% if ConfigureModule.core_data.content.ln_tbl %}
    <tr>
        <td>Primary Ln Table Name </td>
        <td>
            <strong>{{ ConfigureModule.core_data.content.ln_tbl.name|default:"--" }}</strong>
        </td>
    </tr>
    {% endif %}
    {% if ConfigureModule.core_data.category.tbl %}
    <tr>
        <td>Category Primary Table Name </td>
        <td><strong>{{ ConfigureModule.core_data.category.tbl.name|default:"--" }}</strong>
            <i>( PKField: <strong>{{ ConfigureModule.core_data.category.tbl.pk_field|default:"--" }}</strong>
            - ParentField: <strong>{{ ConfigureModule.core_data.category.tbl.parent_field|default:"--" }}</strong> )</i>
        </td>
    </tr>
    {% endif %}
    {% if ConfigureModule.core_data.category.ln_tbl %}
    <tr>
        <td>Category Primary Ln Table Name</td>
        <td><strong>{{ ConfigureModule.core_data.category.ln_tbl.name|default:"--" }}</strong></td>
    </tr>
    {% endif %}
</table>