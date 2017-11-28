Puja.Grid = {
    namespace: 'Puja.Grid',
    moduleType: null,
    moduldeId: null,
    controllerId: null,
    pkField: null,
    ElementId: '#EasyUI-DataGrid',
    WindowId: '#Easyui-Window',
    statuses: null,
    initialize: function () {
        this.moduleType = jsonStore.moduleType;
        this.moduldeId = jsonStore.moduldeId;
        this.controllerId = jsonStore.controllerId;
        this.pkField = jsonStore.pkField;
        this.statuses = {
            '0': {title: 'Status: Inactivate, Click to Activate', 'icon': 'icon-no'},
            '1': {title: 'Status: Active, Click to Inactivate', 'icon': 'icon-ok'}
        };

        this.overwrite = function (ControllerGrid, attritbute) {
            if (!ControllerGrid.hasOwnProperty(attritbute)) {
                return null;
            }

            for (var fn in ControllerGrid[attritbute]) {
                this[attritbute][fn] = ControllerGrid[attritbute][fn];
            }
        }

        var controller = this.controllerId[0].toUpperCase() + this.controllerId.slice(1);
        if (this.hasOwnProperty(controller)) {
            var ControllerGrid = this[controller];
            this.overwrite(ControllerGrid, 'formatter');
            this.overwrite(ControllerGrid, 'renderer');
            this.overwrite(ControllerGrid, 'executor');
            this.overwrite(ControllerGrid, 'events');
            this.overwrite(ControllerGrid, 'toolbars');
        }
    },
    init: function () {
        this.initialize();
    },

    getRowActions: function (row) {
        if (row.hasOwnProperty('actions')) {
            return row.actions;
        }

        return [];
    },
    renderer: {
        update: function (row, Grid) {
            return '<a title="Edit" onclick="return ' + Grid.namespace + '.RunToolbar(\'update\', this);" href="./?module=' + Grid.moduldeId + '&ctrl=' + Grid.controllerId + '&act=update&pkid=' + row[Grid.pkField] + '" class="easyui-icon icon-edit"></a>';
        },
        delete: function (row, Grid) {
            return '<a title="Delete" onclick="return ' + Grid.namespace + '.RunToolbar(\'delete\', this);" href="./?module=' + Grid.moduldeId + '&ctrl=' + Grid.controllerId + '&act=delete&pkid=' + row[Grid.pkField] + '" class="easyui-icon icon-cancel"></a>';
        },
        status:  function (row, Grid) {
            return '<a onclick="return ' + Grid.namespace + '.RunToolbar(\'toggleStatus\', this);" title="' + Grid.statuses[row.status].title + '" href="./?module=' + Grid.moduldeId + '&ctrl=' +
                Grid.controllerId + '&act=toggle-status&pkid=' + row[Grid.pkField] + '" class="easyui-icon ' + Grid.statuses[row.status].icon + '"></a>';
        },
        name: function (row, Grid) {
            return '<span class="easyui-icon tree-file"></span> ' + row.name;
        }
    },
    executor: {
        delete: function (obj, Grid) {
            $.post($(obj).attr('href'), function (resp) {
                $(Grid.ElementId).datagrid('reload');
            });
        },
        toggleStatus: function (obj, Grid) {
            $.post($(obj).attr('href'), function (resp) {
                $(Grid.ElementId).datagrid('reload');
            });
        }
    },
    formatter: {
        action: function (row, Grid) {

            var actions = [];
            var rowActions = Grid.getRowActions(row);
            for (var idx in rowActions) {
                var act = rowActions[idx];
                if (!Grid.renderer.hasOwnProperty(act)) {
                    continue;
                }
                actions.push(Grid.renderer[act](row, Grid));
            }
            return actions.join(' ');
        },

        name: function (row, Grid) {
            return Grid.renderer.name(row, Grid);
        },

        status:  function (row, Grid) {
            return Grid.renderer.status(row, Grid);
        }
    },
    events: {

    },
    toolbars: {
        create: function(obj, Grid) {
            location.href='./?module=' + Grid.moduldeId + '&ctrl=' + Grid.controllerId + '&act=update';
        },
        update: function (obj, Grid) {
            location.href = $(obj).attr('href');
            return true;
        },
        delete: function (obj, Grid) {
            $.messager.confirm('Confirm', 'Are you sure you want to delete ?', function (result) {
                if (!result) {
                    return false;
                }
                Grid.executor.delete(obj, Grid);
            });
            return false;
        },
        toggleStatus: function (obj, Grid) {
            Grid.executor.toggleStatus(obj, Grid);
            return false;
        },
        closeWindow: function (obj, Grid) {
            $(Grid.WindowId).window('close');
        }
    },
    RunFormatter: function (field, row) {
        if (!this.formatter.hasOwnProperty(field)) {
            console.log('RunFormatter: ' + field + ' dont exist');
            return;
        }
        return this.formatter[field](row, this);
    },
    RunExecutor: function (act, obj) {
        if (!this.executor.hasOwnProperty(act)) {
            console.log('RunExecutor: ' + act + ' dont exist');
            return;
        }
        this.executor[act](obj, this);
        return false;
    },
    RunToolbar: function (act, obj) {
        if (!this.toolbars.hasOwnProperty(act)) {
            console.log('RunToolbar: ' + act + ' dont exist');
            return;
        }
        return this.toolbars[act](obj, this);
    }
};