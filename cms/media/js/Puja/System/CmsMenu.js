Puja.System = {};
Puja.System.CmsMenu = {
    Update: {
        updateChild: function (obj) {
            $.post('./?module=system&ctrl=cmsmenu&act=update-child', $(obj).serialize(), function (resp) {

            }, 'json');
        }
    },
    init: function () {

        // drag n drop menu
        $('.configure_cmsmenu_item').draggable({
            proxy:'clone',
            revert:true,
            cursor:'auto',
            onStartDrag:function(){
                $(this).draggable('options').cursor='not-allowed';
                $(this).draggable('proxy').addClass('over');
            },
            onStopDrag:function(){
                $(this).draggable('options').cursor='auto';
            }
        });
        $('.configure_cmsmenu').droppable({
            accept:'.configure_cmsmenu_item',
            onDragEnter:function(e,source){
                $(source).draggable('options').cursor='auto';
                $(this).addClass('over');
            },
            onDragLeave:function(e,source){
                $(source).draggable('options').cursor='not-allowed';
                $(this).removeClass('over');
            },
            onDrop:function(e, source){
                var menuId = $(this).data('pkid');
                var moduleId = $(source).data('pkid');
                $(source).find('input').remove();
                $(source).append('<input type="hidden" name="child[' + menuId + '][]" value="' + moduleId + '" />');
                $(this).append(source);
                $(this).removeClass('over');
            }
        });

    }
}