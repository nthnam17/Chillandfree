
CKEDITOR.editorConfig = function( config )
{
        // Define changes to default configuration here. For example:
    config.language = 'vi';
    config.extraPlugins = 'lineheight';
    config.line_height = "20px;21px;22px;23px;24px;25px;26px;";
        // config.uiColor = '#AADC6E';

        // config.toolbar_Full = [
        //     ['Source','-','Save','NewPage','Preview','-','Templates'],
        //     ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
        //     ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        //     '/',
        //     ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        //     ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        //     ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        //     ['BidiLtr', 'BidiRtl' ],
        //     ['Link','Unlink','Anchor'],
        //     ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
        //     '/',
        //     ['Styles','Format','Font','FontSize'],
        //     ['TextColor','BGColor'],
        //     ['Maximize', 'ShowBlocks','-','About']
        //     ];

        config.entities = false;
        //config.entities_latin = false;

        config.contentsCss = '/frontend/font/SVN-Gilroy-Regular.otf';
        config.font_names = 'WebFont-Regular;' + config.font_names;

        config.filebrowserBrowseUrl = '/admin/ckfinder/ckfinder.html';

        config.filebrowserImageBrowseUrl = '/admin/ckfinder/ckfinder.html?type=Images';

        config.filebrowserFlashBrowseUrl = '/admin/ckfinder/ckfinder.html?type=Flash';

        config.filebrowserUploadUrl = '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

        config.filebrowserImageUploadUrl = '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

        config.filebrowserFlashUploadUrl = 'admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};
