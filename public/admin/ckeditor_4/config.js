/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.language = 'vi';

    config.entities = false;
    //config.entities_latin = false;

    // config.contentsCss = '/frontend/font/SVN-Gilroy-Regular.otf';
    config.font_names = 'WebFont-Regular;' + config.font_names;

    config.extraPlugins = 'btgrid';


    config.filebrowserBrowseUrl = '/admin/ckfinder/ckfinder.html';

    config.filebrowserImageBrowseUrl = '/admin/ckfinder/ckfinder.html?type=Images';

    config.filebrowserFlashBrowseUrl = '/admin/ckfinder/ckfinder.html?type=Flash';

    config.filebrowserUploadUrl = '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    config.filebrowserImageUploadUrl = '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    config.filebrowserFlashUploadUrl = 'admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
