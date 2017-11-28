Puja.Entity = {};
Puja.Entity.Grid = {
    moduleType: null,
    moduldeId: null,
    isGridSearching: false,
    typeId: 0,
    parentId: 0,
    ElementId: '#EasyUI-DataGrid',
    WindowId: '#Easyui-Window',
    init: function () {
        this.moduleType = jsonStore.moduleType;
        this.moduldeId = jsonStore.moduldeId;
        this.typeId = jsonStore.typeId;
        this.parentId = jsonStore.parentId;
        this.overwrite = function (partial, attribute) {
            if (!Puja.Entity.Grid.hasOwnProperty(partial)) {
                return null;
            }

            var PartialGrid = Puja.Entity.Grid[partial];
            if (!PartialGrid.hasOwnProperty(attribute)) {
                return null;
            }

            for (var fn in PartialGrid[attritbute]) {
                Puja.Entity.Grid[attribute][fn] = PartialGrid[attritbute][fn];
            }
        }

        this.overwrite('Content', 'formatter');
        this.overwrite('Content', 'toolbars');
        this.overwrite('Content', 'actions');
    },
    formatter: {
        actions: function (i, row) {
            if (!row.actions) {
                return;
            }
            var actions = [];
            for (var act in row.actions) {
                if (!Puja.Entity.Grid.actions.hasOwnProperty(act)) {
                    continue;
                }
                actions.push(Puja.Entity.Grid.actions[act](i, row));
            }
            return actions.join(' ');

        },
        name: function (i, row) {

            if (row.recordType == 'category') {
                return '<input type="hidden" name="orderrecord[category][]" value="' + row.pkid + '" /><a class="easyui-link" href="./?module=' + Puja.Entity.Grid.moduldeId + '&parentid=' + row.pkid + '&typeid=' + Puja.Entity.Grid.typeId + '">' +
                    '<span class="easyui-icon tree-folder"></span>  ' + row.name + '</a>';
            }

            return '<input type="hidden" name="orderrecord[content][]" value="' + row.pkid + '" /><a class="easyui-link" href="./?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=' + row.recordType + '&act=update&pkid=' + row.pkid + '&parentid=' + row.parentId + '&typeid=' + Puja.Entity.Grid.typeId  + '">' +
                '<span class="easyui-icon tree-file"></span>  ' + row.name + '</a>';

        },
        status: function (i, row) {
            var statuses = {
                '0': {title: 'Status: Inactivate, Click to Activate', 'icon': 'icon-no'},
                '1': {title: 'Status: Active, Click to Inactivate', 'icon': 'icon-ok'}
            }

            return '<a onclick="return Puja.Entity.Grid.actions.executeActions.toggleStatus(this);" title="' + statuses[row.status].title + '" href="./?module=' + jsonStore.moduldeId + '&ctrl=' +
                row.recordType + '&act=toggle-status&pkid=' + row.pkid + '&recordType=' + row.recordType + '&typeid=' + row.fk_configure_module + '" class="easyui-icon ' + statuses[row.status].icon + '"></a>';
        }
    },
    toolbars: {
        addContent: function() {
            location.href = './?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=content&act=update&parentid=' +  Puja.Entity.Grid.parentId + '&typeid=' + Puja.Entity.Grid.typeId;
        },
        addCategory: function() {
            location.href = './?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=category&act=update&parentid=' +  Puja.Entity.Grid.parentId + '&typeid=' + Puja.Entity.Grid.typeId;
        },
        search: function (value, name) {
            Puja.Entity.Grid.isGridSearching = value != '';
            $(Puja.Entity.Grid.ElementId).datagrid('load', {
                query: value,
                filtertype: name
            });
        },
        clearSearch: function(e){
            Puja.Entity.Grid.isGridSearching = false;
            $(e.data.target).textbox('clear');
            $(Puja.Entity.Grid.ElementId).datagrid('load', {query: '', filtertype: 'index'});
        }
    },
    actions: {
        update: function (i, row) {
            return '<a title="Edit" href="./?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=' + row.recordType + '&act=update&pkid=' + row.pkid + '&typeid=' + Puja.Entity.Grid.typeId + '" class="easyui-icon icon-edit"></a>';
        },
        delete: function (i, row) {
            return '<a title="Delete" onclick="return Puja.Entity.Grid.actions.executeActions.delete(this);" href="./?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=' + row.recordType + '&act=delete&pkid=' + row.pkid + '&typeid=' + Puja.Entity.Grid.typeId + '" class="easyui-icon icon-cancel"></a>';
        },
        move: function (i, row) {
            return '<a title="Move" onclick="return Puja.Entity.Grid.actions.executeActions.move(this);" href="./?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=' + row.recordType + '&act=move&pkid=' + row.pkid + '&typeid=' + Puja.Entity.Grid.typeId + '" class="easyui-icon icon-redo"></a>';
        },
        executeActions: {
            toggleStatus: function (obj) {
                $.post($(obj).attr('href'), function (resp) {
                    $(Puja.Entity.Grid.ElementId).datagrid('reload');
                });
                return false;
            },
            delete: function (obj) {
                $.messager.confirm('Confirm', 'Are you sure you want to delete ?', function (result) {
                    if (!result) {
                        return false;
                    }
                    $.post($(obj).attr('href'), function (resp) {
                        $(Puja.Entity.Grid.ElementId).datagrid('reload');
                    });
                });
                return false;
            },
            move: function (obj) {
                $(Puja.Entity.Grid.WindowId).window({
                    title: 'Update category',
                    content: '<form method="post" action="' + $(obj).attr('href') + '" onsubmit="Puja.Entity.Grid.actions.executeActions.moveSubmit(this);return false;"><ul id="Easyui-Tree"></ul><div style="position: absolute;bottom: 10px;"><input type="hidden" name="savechange" value="1" /><input type="submit" class="l-btn easyui-btn"  value="Save change"><input onclick="Puja.Entity.Grid.actions.executeActions.moveClose();" type="button" class="l-btn easyui-btn" value="Cancel"></div></form>'
                }).window('open');
                $('#Easyui-Tree').tree({
                    url: $(obj).attr('href'),
                    formatter: function (node) {
                        return '<input id="parentcategory_' + node.id + '" type="radio" name="catid" value="' + node.id + '" ' + (node.current ? 'checked' : '')+ ' /><label for="parentcategory_' + node.id + '"> ' + node.text + '</label>';
                    }
                });
                return false;
            },
            moveSubmit: function (obj) {
                $(Puja.Entity.Grid.WindowId).window('close');
                $.messager.progress({title:'Waiting...'});
                $.post($(obj).attr('action'), $(obj).serialize(), function (resp) {
                    $.messager.progress('close');

                    if (resp.status) {
                        $(Puja.Entity.Grid.ElementId).datagrid('reload');
                        $.messager.show({
                            title: 'Success',
                            msg: 'Update successful!'
                        });
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: 'Update failed!'
                        });
                    }
                }, 'json');
                return false;
            },
            moveClose: function () {
                $(Puja.Entity.Grid.WindowId).window('close');
            }
        }

    },
    events: {
        onDrop: function (targetRow, sourceRow, point) {

            if (Puja.Entity.Grid.isGridSearching) {
                $.messager.alert('Info', 'Sort function dont work when youre searching something');
                return false;
            }

            var options = $(this).datagrid('options');
            if (options.sortName === null) {
                options.sortName = 'order_id';
            }

            if (options.sortOrder == 'desc' || options.sortName != 'order_id') {
                $.messager.alert('Info', 'The sort function only work when the list sort by default. Refresh page or click button "Sort Default" to make the list sort by default');
                return false;
            }

            $.post('./?module=' + Puja.Entity.Grid.moduldeId + '&ctrl=' + sourceRow.recordType + '&act=update-orders&page=' + options.pageNumber + '&rows=' + options.pageSize + '&parentid=' + Puja.Entity.Grid.parentId + '&typeid=' + Puja.Entity.Grid.typeId, $('#GridContentForm').serialize(), function() {
                $('.easyui-datagrid').datagrid('reload');
            });
        },
        onLoadSuccess: function() {
            $(this).datagrid('enableDnd');
        }
    },
    Content: {},
    Category: {}
};