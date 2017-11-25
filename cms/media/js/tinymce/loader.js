var ajaxFileUpload = function(file, successFn, failedFn) {
    var $this = this;
    var formData = new FormData();
    formData.append('file', file);
    formData.append('params', 'tinymce_upload');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './?module=media&act=upload-normal');
    xhr.responseType = 'json';
    xhr.onreadystatechange = function() {
        this.uploadFail = function () {
            if(typeof(failedFn) == 'function') {
                return failedFn();
            }
        }

        if (xhr.readyState == 4) {
            if (xhr.status != 200) {
                return this.uploadFail();
            }

            if (null === xhr.response) {
                return this.uploadFail();
            }

            if(xhr.response.status && typeof(successFn) == 'function') {
                return successFn(xhr.response);
            }

            return this.uploadFail();
        }
        return false;
    };

    xhr.upload.onprogress = function (event) {
        /*if (event.lengthComputable) {
         var complete = (event.loaded / event.total * 70 | 0);
         $mmt.window.selector.find('.progress-bar-' + idx).css('width', complete + '%');
         }*/
    };
    xhr.send(formData);
}
//$('body').append('<div class="hidden"><input type="file" id="tinymce_upload_image" /></div>');

tinyMCE.init({
    // General options
    mode : "specific_textareas",
    editor_selector : "wysiwyg",

    height: 330,
    plugins: [
        "advlist autolink autosave link lists",
        "wordcount code fullscreen media image imagetools",
        "table contextmenu directionality textcolor textcolor colorpicker textpattern"
    ],

    toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote link unlink | image media | table | forecolor backcolor | code fullscreen",

    // enable title field in the Image dialog
    //image_title: true,
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,
    // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
    // images_upload_url: 'postAcceptor.php',
    // here we add custom filepicker only to Image dialog
    file_picker_types: 'image',
    // without images_upload_url set, Upload tab won't show up
    images_upload_url: './?module=media&act=upload-normal',
    /*
    // we override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        new ajaxFileUpload(blobInfo.blob(), function (resp) {
            success('../data/upload/' + resp.src);
        }, function () {
            failure('Upload failed!!');
        });
        return;

    },*/

    imagetools_proxy: 'proxy.php'
    /*
    // and here's our custom image picker
    file_picker_callback: function(cb, value, meta) {
        var input = document.getElementById('tinymce_upload_image');
        input.click();

        $('body').on('change', '#tinymce_upload_image',  function(){
            console.log(this.files[0])
            new ajaxFileUpload(this.files[0], function (resp) {
                cb('../data/upload/' + resp.src, { title: resp.src });
            });
            return;
        });


    }*/
});

//BBCode
tinyMCE.init({
    // General options
    mode : "specific_textareas",
    editor_selector : "wysiwyg_bbcode",
    height: 100,
    plugins: "bbcode",

    bbcode_dialect: "punbb",
    menubar: false
});