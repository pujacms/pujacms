Puja.System = {};
Puja.System.Module = {
    WindowId: '#EasyUi-Window',
    Update: {
        totalStaticOption: 0,
        init: function () {

        },

        changeFieldType: function (fieldName, val) {
            $('.field-advance-config__' + fieldName).show();
            $('.field-advance-config-item').hide();
            $('.field-advance-config-item__' + val).show();
            console.log('Val: ' + val)
        },

        showAdvanceSetting: function (fieldName) {
            $('.field-advance-config__' + fieldName).show();
        },

        addStaticOption: function(obj, fieldName, offset) {
            if (!this.totalStaticOption) {
                this.totalStaticOption = $(obj).data('count');
            }
            var html = $('.static-option-item__' + $(obj).data('field')).html().replace(/\$key\$/g, this.totalStaticOption).replace(/disabled/g, '');
            $(obj).parent().append('<p>' + html + '</p>');
            this.totalStaticOption++;
        },

        removeStaticOption: function(obj) {
            $(obj).parent().remove();
        }
    },
    TableField: {
        addNew: function(tableName) {
            $.get('./?module=system&ctrl=module&act=add-field', {tableName: tableName}, function (respHtml) {
                $(Puja.System.Module.WindowId).window({
                    title: 'Add Field',
                    width: '60%',
                    height: 160,
                    modal: true,
                    content: respHtml
                });
            });
            return;
        },

        saveSubmit: function (obj) {
            $.post('./?module=system&ctrl=module&act=add-field', $(obj).serialize(), function(resp){
                $('.table_addfield_msg').html(resp.msg);

            }, 'json');
        }
    }

}