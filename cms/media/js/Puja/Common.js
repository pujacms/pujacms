var Puja = {};
Puja.Common = {
    init: function () {
        this.setTableFormHover();
    },

    setTableFormHover: function () {
        $('.table-form tr').hover(function () {
            $(this).addClass('datagrid-row-over');
        }, function () {
            $(this).removeClass('datagrid-row-over');
        });

        $('.navsub .easyui-link').hover(function () {
            $(this).addClass('menu-active');
        }, function () {
            if (!$(this).hasClass('selected')) {
                $(this).removeClass('menu-active');
            }

        });
    }
};