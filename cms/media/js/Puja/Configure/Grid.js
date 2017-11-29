Puja.Configure = {};
Puja.Configure.Grid = {
    ElementId: '#EasyUI-DataGrid',
    WindowId: '#Easyui-Window',
    moduleId: null,
    controllerId: null,
    init: function () {
        this.controllerId = jsonStore.controllerId;
        this.moduleId = jsonStore.moduldeId;

        this.overwrite = function (ControllerGrid, attritbute) {
            if (!ControllerGrid.hasOwnProperty(attritbute)) {
                return null;
            }

            for (var fn in ControllerGrid[attritbute]) {
                Puja.Configure.Grid[attritbute][fn] = ControllerGrid[attritbute][fn];
            }
        }

        var controller = jsonStore.controllerId[0].toUpperCase() + jsonStore.controllerId.slice(1);
        if (Puja.Configure.Grid.hasOwnProperty(controller)) {
            var ControllerGrid = Puja.Configure.Grid[controller];


            //overwrite
            this.overwrite(ControllerGrid, 'formatter');
            this.overwrite(ControllerGrid, 'toolbars');
            this.overwrite(ControllerGrid, 'actions');

        }
    },
    actions: {
        executeActions: {
            closeWindow: function () {
                $(Puja.Configure.Grid.WindowId).window('close');
            },
            update: function (doc) {
                $.post('./?module=' + Puja.Configure.Grid.moduleId + '&ctrl=' + Puja.Configure.Grid.controllerId + '&act=update', $(doc).serialize(), function (resp) {
                    $.messager.show({
                        title: 'Success',
                        msg: 'Update success!'
                    });
                    $(Puja.Configure.Grid.WindowId).window('close');
                    $(Puja.Configure.Grid.ElementId).datagrid('reload');
                }, 'json');
                return false;
            }
        }
    },
    formatter: {
        actions: function (i, row) {
            var icons = {
                'update': {'title': 'Update', 'icon': 'icon-edit'},
                'delete': {'title': 'Update', 'icon': 'icon-cancel'},
            };
            var actions = [];
            for (var idx in jsonStore.DataGrid.actions) {
                var act = jsonStore.DataGrid.actions[idx];
                var pkId = row[jsonStore.pkField];
                actions.push(
                    '<a href="./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=' + act + '&pkid=' + pkId + '" ' +
                    'onclick="return Puja.Configure.Grid.toolbars.' + act + '(this);" class="easyui-icon ' + icons[act].icon+ '"></a>');
            }
            return actions.join(' ');
        }
    },
    toolbars: {
        create: function () {
            location.href = './?module=' + Puja.Configure.Grid.moduleId + '&ctrl=' + Puja.Configure.Grid.controllerId + '&act=update';
        },
        update: function (obj) {
            return true;
        },

        delete: function (obj) {
            $.messager.confirm('Confirm', 'Are you sure you want to delete ?', function (result) {
                if (!result) {
                    return false;
                }
                $.post($(obj).attr('href'), function (resp) {
                    $(Puja.Configure.Grid.ElementId).datagrid('reload');
                });
            });
            return false;
        }
    },

    Webtranslate: {
        toolbars : {
            create: function () {
                this.update(null);
            },
            update: function (obj) {
                var href = './?module=' + Puja.Configure.Grid.moduleId + '&ctrl=' + Puja.Configure.Grid.controllerId + '&act=update';
                if (null !== obj) {
                    href = $(obj).attr('href');
                }
                $.get(href, function (respHtml) {
                    $(Puja.Configure.Grid.WindowId).window({
                        width: '600px',
                        height: '300px',
                        title: 'Update webtranslate',
                        content: respHtml
                    }).window('open');
                });

                return false;
            },
            importAlice: function () {
                $.messager.progress({
                    title: 'Waiting...'
                });
                $.post('./?module=' + Puja.Configure.Grid.moduleId + '&ctrl=' + Puja.Configure.Grid.controllerId + '&act=import-alice', {}, function (resp) {
                    $.messager.progress('close');
                    if (resp.status) {
                        $.messager.show({
                            title: 'Success',
                            msg: 'Import successful!'
                        });
                    } else {
                        $.messager.show({
                            title: 'Failed',
                            msg: 'Import failed!'
                        });
                    }
                }, 'json');
            }
        },
        formatter: {
            name: function (i, row) {
                return '<a href="./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=update&pkid=' + row[jsonStore.pkField] + '" ' +
                'onclick="return Puja.Configure.Grid.toolbars.update(this);" class="easyui-link">' + row.translate_key + '</a>';
            }
        }
    }
}