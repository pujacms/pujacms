Puja.System = {};
Puja.System.CmsTheme = {
    preview: function () {
        this.setHeaderBackground = function (color) {
            $('.header').css('background', color);
        };
        this.setHeaderColor = function (color) {
            $('.header').css('color', color);
            $('.header ').css('color', color);
        };
        this.setBodyBackground = function (color) {
            $('body').css('background', color);
        };
        this.setEasyUITheme = function (themeId) {
            $('#theme_loading').html('Loading new theme');
            var cssFile = './media/libs/jinnguyen/easyui/themes/' + themeId + '/easyui.css';
            $.get(cssFile, function () {
                $('#easyui-theme').attr({href : cssFile});
                $('#theme_loading').html('');
            });
        };
        
        var form = $('#CmsThemForm').serializeArray();
        for (var i in form) {
            if (form[i].name == 'theme[header][background]') {
                this.setHeaderBackground(form[i].value);
            }

            if (form[i].name == 'theme[header][color]') {
                this.setHeaderColor(form[i].value);
            }

            if (form[i].name == 'theme[body][background]') {
                this.setBodyBackground(form[i].value);
            }

            if (form[i].name == 'theme[theme_id]') {
                this.setEasyUITheme(form[i].value);
            }
        }
    },
    save: function (doc) {
        console.log('ddd')
        $.post('./?module=system&ctrl=cmstheme&act=update', $(doc).serialize(), function (resp) {
            if (resp.status) {
                location.href = './?module=system&ctrl=cmstheme';
            } else {
                $.messager.alert('Error', resp.msg);
            }
        }, 'json');
    }

};