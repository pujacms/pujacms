Puja.Configure = {};
Puja.Configure.Grid = {
    init: function () {

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
                    'onclick="return Puja.Cofigure.Grid.toolbars.' + act + '(' + pkId + ');" class="easyui-icon ' + icons[act].icon+ '"></a>');
            }
            return actions.join(' ');
        }
    }
}