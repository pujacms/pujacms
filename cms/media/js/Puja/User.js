Puja.User = {
    ResetPassword: {
        submit: function (doc) {
            var validate =  $(doc).form('enableValidation').form('validate');
            if (!validate) {
                return false;
            }
            $.messager.progress({
                title: 'Processing ...'
            });

            $.post('./?module=user&act=reset-password', $(doc).serialize(), function (resp) {
                $.messager.progress('close');
                if (resp.status) {
                    location.href = './';
                } else {

                    $.messager.show({
                        title: 'Error',
                        msg: resp.msg
                    });
                    $(doc).form('disableValidation').form('reset');
                }
            }, 'json');

            return;
        }
    }
};