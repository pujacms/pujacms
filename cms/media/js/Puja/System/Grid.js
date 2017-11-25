Puja.System = {};
Puja.System.Grid = {
    ElementId: '#EasyUI-DataGrid',
    WindowId: '#Easyui-Window',
    init: function () {
        this.overwrite = function (ControllerGrid, attritbute) {
            if (!ControllerGrid.hasOwnProperty(attritbute)) {
                return null;
            }

            for (var fn in ControllerGrid[attritbute]) {
                Puja.System.Grid[attritbute][fn] = ControllerGrid[attritbute][fn];
            }
        }

        var controller = jsonStore.controllerId[0].toUpperCase() + jsonStore.controllerId.slice(1);
        if (Puja.System.Grid.hasOwnProperty(controller)) {
            var ControllerGrid = Puja.System.Grid[controller];


            //overwrite
            this.overwrite(ControllerGrid, 'formatter');
            this.overwrite(ControllerGrid, 'toolbars');
            this.overwrite(ControllerGrid, 'actions');

        }
    },

    formatter: {
        actions: function (i, row) {
            var icons = {
                'update': {'title': 'Update', 'icon': 'icon-edit'},
                'delete': {'title': 'Delete', 'icon': 'icon-cancel'},
            };
            var actions = [];
            for (var idx in jsonStore.DataGrid.actions) {
                var act = jsonStore.DataGrid.actions[idx];
                var pkId = row[jsonStore.pkField];
                actions.push(
                    '<a href="./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=' + act + '&pkid=' + pkId + '" ' +
                    'onclick="return Puja.System.Grid.toolbars.' + act + '(this);" class="easyui-icon ' + icons[act].icon+ '"></a>');
            }
            return actions.join(' ');
        },
        name: function (i, row) {
            return '<span class="easyui-icon tree-file"></span> ' + row.name;
        },
        status:  function (i, row) {
            var statuses = {
                '0': {title: 'Status: Inactivate, Click to Activate', 'icon': 'icon-no'},
                '1': {title: 'Status: Active, Click to Inactivate', 'icon': 'icon-ok'}
            }

            return '<a onclick="return Puja.System.Grid.actions.toggleStatus(this);" title="' + statuses[row.status].title + '" href="./?module=' + jsonStore.moduldeId + '&ctrl=' +
                jsonStore.controllerId + '&act=toggle-status&pkid=' + row[jsonStore.pkField] + '" class="easyui-icon ' + statuses[row.status].icon + '"></a>';
        },
        moduleTypeId: function (i, row) {
            return jsonStore.module_types[row.fk_module_type].name;
        }
    },

    actions: {
        update: function (doc) {
            $.post('./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=update', $(doc).serialize(), function (resp) {
                $(Puja.System.Grid.WindowId).window('close');
                $(Puja.System.Grid.ElementId).datagrid('reload');
            });
        },

        toggleStatus: function (obj) {
            $.post($(obj).attr('href'), function (resp) {
                $(Puja.System.Grid.ElementId).datagrid('reload');
            });
            return false;
        },
        delete: function (obj) {
            $.post($(obj).attr('href'), function (resp) {
                $(Puja.System.Grid.ElementId).datagrid('reload');
            });
        },
        closeWindow: function () {
            $(Puja.System.Grid.WindowId).window('close');
        }
    },

    toolbars: {
        update: function (obj) {
            location.href = $(obj).attr('href');
            //location.href = './?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=update';
        },
        manageGroup: function () {
            return Puja.System.Grid.Index.toolbars.manageGroup();
        },
        delete: function (obj) {
            $.messager.confirm('Confirm', 'Are you sure to delete this item?', function(ok){
                if (!ok) {
                    return;
                }
                Puja.System.Grid.actions.delete(obj);
            });
            return false;
        }
    },

    events: {
        onDrop: function (targetRow, sourceRow, point) {

            var options = $(this).datagrid('options');

            if (options.sortName === null) {
                options.sortName = 'order_id';
            }

            if (options.sortOrder != 'asc' || options.sortName != 'order_id') {
                $.messager.alert('Error', 'The sort function only work when the list sort by default. Refresh page or click button "Sort Default" to make the list sort by default');
                return;
            }

            var rows = $(this).datagrid('getRows');
            var orders = [];
            for (var i in rows) {
                orders.push(rows[i][jsonStore.pkField]);
            }
            var $this = $(this);
            $.post('./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=update-order&page=' + options.pageNumber + '&rows=' + options.pageSize, {orders: orders}, function() {
                $this.datagrid('reload');
            });
        },
        onLoadSuccess: function() {
            $(this).datagrid('enableDnd');
        }
    },

    Configure: {
        formatter: {
            group: function (i, row) {
                if (jsonStore.categories.hasOwnProperty(row.fk_configure_group)) {
                    return '<a class="easyui-link" href="./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&parentid=' + row.id_configure_group + '"><span class="easyui-icon tree-folder"></span> ' + jsonStore.categories[row.fk_configure_group].name + '</a>';
                }

                return 'Unknown';
            }
        },

        toolbars: {
            manageGroup: function () {
                location.href = './?module=' + jsonStore.moduldeId + '&ctrl=configuregroup';
            },
            clearGroup: function () {
                location.href = './?module=' + jsonStore.moduldeId + '&ctrl=configure';
            }
        }
    },
    Configuregroup:{
        formatter: {
            name: function (i, row) {
                return '<span class="easyui-icon tree-folder"></span> ' + row.name;
            }
        },
        toolbars: {
            manageConfigure: function () {
                location.href = './?module=' + jsonStore.moduldeId + '&ctrl=configure';
            },
            update: function (obj) {

                $.get($(obj).attr('href'), function (respHtml) {
                    $(Puja.System.Grid.WindowId).window({
                        title: 'Create Configure Group',
                        width: '60%',
                        height: 80,
                        modal: true,
                        content: respHtml
                    });
                });

                return false;
            }
        }
    },
    Cmsmenu: {
        toolbars: {
            manageMenu: function () {
                location.href = './?module=' + jsonStore.moduldeId + '&ctrl=cmsmenu&act=manage';
            },
            create: function () {
                this.update(null);
            },
            update: function (obj) {
                var href = './?module=' + jsonStore.moduldeId + '&ctrl=cmsmenu&act=update';
                if (null !== obj) {
                    href = $(obj).attr('href');
                }

                console.log('href' + href)
                $.get(href, function (respHtml) {
                    $(Puja.System.Grid.WindowId).window({
                        title: 'Create CmsMenu',
                        width: '60%',
                        height: 80,
                        modal: true,
                        content: respHtml
                    });
                });

                return false;
            }
        }
    },
    Language: {
        toolbars: {
            update: function (obj) {
                $.get($(obj).attr('href'), function (respHtml) {
                    $(Puja.System.Grid.WindowId).window({
                        title: 'Create Language',
                        width: '60%',
                        height: 150,
                        modal: true,
                        content: respHtml
                    });
                });

                return false;
            }
        }
    },
    Module: {
        toolbars: {
            create:  function () {
                $.get('./?module=' + jsonStore.moduldeId + '&ctrl=module&act=create', {}, function (respHtml) {
                    $(Puja.System.Grid.WindowId).window({
                        title: 'Create Configure Module',
                        width: '60%',
                        height: 280,
                        modal: true,
                        content: respHtml
                    });
                });
            },
            changeModuleType: function (newValue) {
                $('.ChangeModuleType').hide();
                if (newValue == 'customize') {
                    $('#ChangeModuleType_Custom').show();
                }

                if (newValue == 'system') {
                    $('#ChangeModuleType_System').show();
                }
            },
        },
        actions: {
            create: function (doc) {
                $.post('./?module=system&ctrl=module&act=create', $(doc).serialize(), function(resp){
                    $(Puja.System.Grid.ElementId).datagrid('reload');
                    $(Puja.System.Grid.WindowId).window('close');

                }, 'json');
            }
        }
    },
    Pagemeta: {
        formatter: {
            actions: function (i, row) {
                var icons = {
                    'update': {'title': 'Update', 'icon': 'icon-edit'},
                    'delete': {'title': 'Delete', 'icon': 'icon-cancel'},
                };
                var actions = [];
                for (var idx in jsonStore.DataGrid.actions) {
                    var act = jsonStore.DataGrid.actions[idx];
                    var pkId = row[jsonStore.pkField];
                    if (act == 'delete' && row.fk_configure_module > 0) {
                        continue;
                    }
                    actions.push(
                        '<a href="./?module=' + jsonStore.moduldeId + '&ctrl=' + jsonStore.controllerId + '&act=' + act + '&pkid=' + pkId + '" ' +
                        'onclick="return Puja.System.Grid.toolbars.' + act + '(this);" class="easyui-icon ' + icons[act].icon+ '"></a>');
                }
                return actions.join(' ');
            },
            configure_module: function (i, row) {
                return row.fk_configure_module > 0 ? 'ConfigureModule' : 'StaticPage';
            }
        }
    }

};