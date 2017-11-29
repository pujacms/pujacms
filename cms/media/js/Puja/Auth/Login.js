var Puja = {};
Puja.Auth = {
    Login: {
        submit: function (doc) {
            var validate =  $(doc).form('enableValidation').form('validate');
            if (!validate) {
                return false;
            }
            $.messager.progress({
                title: 'Login Processing'
            });
            $.post('./?ctrl=auth&act=login', $(doc).serialize(), function (resp) {
                if (resp.status) {
                    location.href = './';
                } else {
                    $.messager.progress('close');
                    $.messager.show({
                        title: 'Login Failed',
                        msg: resp.msg,
                        timeout: 2000,
                    });
                }
            }, 'json');

            return false;
        }
    }
};