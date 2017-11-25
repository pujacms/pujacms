Puja.Entity = {};
Puja.Entity.Update = {
    EntityUpdateFormId: '#EntityUpdateForm',
    moduleType: null,
    moduleId: null,
    recordType: null,
    typeId: 0,
    parentId: 0,
    pkId: 0,
    init: function () {
        this.moduleType = jsonStore.moduleType;
        this.moduleId = jsonStore.moduleId;
        this.typeId = jsonStore.typeId;
        this.recordType = jsonStore.recordType;
        this.parentId = jsonStore.parentId;
        this.pkId = jsonStore.pkId;

        // custom choose file
        $('.choose_file_btn').click(function () {
            $(this).parents('.puja-ajaxupload').find('input[type="file"]').trigger('click');
        });

        // Ajax Upload
        $('.puja-ajaxupload').AjaxUpload({
            Upload_Url: './?module=media&act=upload&recordType=' + this.recordType + '&typeid=' + this.typeId,
            Api: {
                processSucceed: function (el, repsonse) {
                    el.append('<input type="hidden" name="' + el.parents('.puja-ajaxupload').data('inputfieldname') + '[]" value="' + repsonse.media_id + '" />');
                }
            }
        });

        $('.puja-ajaxupload-progress .delete-btn').click(function () {
            $(this).parents('.puja-ajaxupload-progress').html('<i>This file has been temporary deleted, will be permanently deleted after item saved</i>')
        });

        $('.divbox').divbox();
        /*$('.mmt-upload-file-image').MMT({
            MediaLibraries_Enabled: true,
            MediaLibraries_GridUrl: './?module=media&ctrl=mmt&act=list&pkid=' + this.pkId + '&typeid=' + this.typeId,
            MediaLibraries_GridMultiSelect: true,
            MediaLibraries_GridField: {
                Id: 'media_id',
                Name: 'name',
                Alt: 'alt',
                Description: 'description',
                Src: 'src',
                ImageSize: 'image_size',
                ThumbSize: 'thumb_size'
            },
            MediaLibraries_UpdateUrl: null,
            MediaLibraries_Cols: [],
            MediaLibraries_InsertFn: null,

            MediaLibraries_FilterBox_Enabled: true,
            MediaLibraries_FilterBox_Url: null,

            MediaUpload_Enabled: true,
            MediaUpload_Url: './?module=media&ctrl=mmt&act=upload&typeid=' + this.typeId,

            FromUrl_Enabled: true,
            FromUrl_InsertFn: null,
            ButtonInsertLabel: 'Insert Image',
            ButtonUpdateToGridLabel: 'Update to Grid',

            width: '80%',
            height: 400

        });*/

    },
    Form: {
        submit: function (doc) {
            $.messager.progress({
                title:'Please waiting',
                msg:'Saving ...'
            });
            $('#iframe_content_save').on('load', function() {
                var jsonStr = $(this).contents().find('body').html();
                var jsonData = JSON.parse(jsonStr);
                if (jsonData.status) {
                    if (Puja.Entity.Update.moduleId == 'html') {
                        location.href = './?module=' + Puja.Entity.Update.moduleId + '&ctrl=content&act=update&pkid=' + Puja.Entity.Update.typeId + '&typeid=' + Puja.Entity.Update.typeId;
                    } else {
                        location.href = './?module=' + Puja.Entity.Update.moduleId + '&parentid=' + Puja.Entity.Update.parentId + '&typeid=' + Puja.Entity.Update.typeId;
                    }
                } else {
                    alert(jsonData.msg);
                    $.messager.progress('close');
                }

            });
        }
    },
    formatmd: function (val) {
        return val < 10 ? '0' + val : val;
    },
    FieldType: {
        Multi: {
            addNew: function (obj) {
                var maxAllowedItem = parseInt($(obj).data('max_allowed_item'));
                var parent = $(obj).parents('.multi-input-handle-block');
                if (maxAllowedItem > 0 && maxAllowedItem <= parent.find('.multi-input-item').length - 1) {
                    $.messager.alert('Alert', 'Allow maximum ' + maxAllowedItem + ' items')
                    return false;
                }
                parent.append(parent.find('.source-core').html().replace(/disabled/g, ''));
            },
            remove: function (obj) {
                $(obj).parent().remove();
            }
        },
        Date: {
            formatter: function (date) {
                return 'y-m-d'.replace('y', date.getFullYear())
                        .replace('m', Puja.Entity.Update.formatmd(date.getMonth() + 1))
                        .replace('d', Puja.Entity.Update.formatmd(date.getDate()));
            },
            parser: function(s){
                var t = Date.parse(s);
                if (!isNaN(t)){
                    return new Date(t);
                } else {
                    return new Date();
                }
            }
        },
        DateTime: {
            formatter: function (date) {
                //console.log(date)
                var y = date.getFullYear();
                var m = date.getMonth() + 1;
                var d = date.getDate();

                return 'y-m-d H:i:s'.replace('y', date.getFullYear())
                    .replace('m', Puja.Entity.Update.formatmd(date.getMonth() + 1))
                    .replace('d', Puja.Entity.Update.formatmd(date.getDate()))
                    .replace('H', Puja.Entity.Update.formatmd(date.getHours()))
                    .replace('i', Puja.Entity.Update.formatmd(date.getMinutes()))
                    .replace('s', Puja.Entity.Update.formatmd(date.getSeconds()));
            },
            parser: function(s){
                var t = Date.parse(s);
                if (!isNaN(t)){
                    return new Date(t);
                } else {
                    return new Date();
                }
            }
        },
        DynamicOption: {
            events: {
                loader: function(param, success, error){
                    var q = param.q || '';
                    if (q.length <= 0) {
                        return false;
                    }

                    var ClassName = '.' + $(this).data('inputfieldname');

                    var selectedIds = [];
                    $(ClassName + '-block .list input:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    $.post($(this).data('url'), {q: q, excludeIds: selectedIds.join(',')}, function (resp) {
                        success(resp);
                    }, 'json');
                },
                onSelect: function (record) {
                    var ClassName = '.' + $(this).data('inputfieldname') + '-block';
                    $(ClassName).show();
                    var html = $(ClassName + ' .sample').html().replace('{checked}', 'checked').replace(/{id}/g, record.pkid).replace('{text}', record.name);
                    if ($(this).data('selectmulti') > 0) {
                        $(ClassName + ' .list').append(html);
                    } else {
                        $(ClassName + ' .list').html(html);
                    }
                }
            },
            formatter: {
                datagrid: function (value, row, index) {
                    var InputFieldName = this.InputFieldName + '[]';
                    var InputType = 'radio';
                    if (this.selectMulti == '1') {
                        InputType = 'checkbox';
                    }
                    return '<input name="' + InputFieldName + '" id="' + InputFieldName + '-' + row.pkid + '" type="' + InputType + '" value="' + row.pkid + '" ' + (row.checked ? ' checked': '') + ' />' +
                        '<label for="' + InputFieldName + '-' + row.pkid + '">' + row.name + '</label>';
                }
            }
        }
    }
}