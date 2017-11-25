Puja.Configure = {
    moduleType: null,
    typeId: 0,
    init: function () {

    },
    
    Grid: {
        formatter: {
            actions: function (i, row) {
                if (!row.actions) {
                    return;
                }
                var actions = [];
                for (var act in row.actions) {
                    if (!Puja.Configure.Grid.actions.hasOwnProperty(act)) {
                        continue;
                    }
                    actions.push(Puja.Configure.Grid.actions[act](i, row));
                }
                return actions.join(' ');

            }
        },
        toolbars: {
            addContent: function() {
                location.href = './?module=' + Puja.Configure.moduleType + '&ctrl=content&act=update&typeid=' + Puja.Configure.typeId;
            },
            addCategory: function() {
                location.href = './?module=' + Puja.Configure.moduleType + '&ctrl=category&act=update&typeid=' + Puja.Configure.typeId;
            }
        },
        actions: {
            update: function (i, row) {
                return '<a href="./?module=' + Puja.Configure.moduleType + '&ctrl=' + row.recordType + '&act=update&pkid=' + row.pkid + '&typeid=' + Puja.Configure.typeId + '" class="easyui-icon icon-edit"></a>';
            },
            delete: function (i, row) {
                return '<a href="./?module=' + Puja.Configure.moduleType + '&ctrl=' + row.recordType + '&act=delete&pkid=' + row.pkid + '&typeid=' + Puja.Configure.typeId + '" class="easyui-icon icon-cancel"></a>';
            }
        },
        events: {
            onDrop: function (targetRow, sourceRow, point) {

                //
                var options = $(this).datagrid('options');
                console.log(options);
                return;

                if (options.sortName === null) {
                    options.sortName = 'order_id';
                }

                if (options.sortOrder == 'desc' || options.sortName != 'order_id') {
                    CaoboxUI.alert('The sort function only work when the list sort by default. Refresh page or click button "Sort Default" to make the list sort by default');
                    return;
                }
                //return ;
                $.post('./?ctrl=' + store.controller + '&act=order-record&page=' + options.pageNumber + '&rows=' + options.pageSize, $('#GridContentForm').serialize(), function() {
                    $('.easyui-datagrid').datagrid('reload');
                });
            },
            onLoadSuccess: function() {
                $(this).datagrid('enableDnd');
            }
        }

    }
};