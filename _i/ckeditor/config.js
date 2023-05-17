/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.toolbar = 'TadToolbar';
    // config.templates_files = ['/assets/ckeditor_4.13.0/plugins/templates/templates/mytemplate.js']; // taiwansemi
    config.toolbar_TadToolbar = [
        ['Source', '-', 'Templates', '-', 'Maximize', '-', 'Cut', 'Copy', 'Paste'],
        ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
        ['Link', 'Unlink', 'Anchor'],
        ['Image', 'Flash', 'Youtube', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
        '/', ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Format', 'Font', 'FontSize', '-', 'TextColor', 'BGColor', 'Iframe'],
        [{ name: 'insert', items: ['Image', 'Youtube'] }]
    ];


    //開啟圖片上傳功能
    config.filebrowserBrowseUrl = 'ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = 'ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = 'ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'; //可上傳一般檔案
    config.filebrowserImageUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'; //可上傳圖檔
    // config.filebrowserFlashUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'; //可上傳Flash檔案 

    //加入youtube plug-in 2016/4/12 http://ckeditor.com/addon/youtube
    //加入image2 plug-in 2021/05/17 https://ckeditor.com/cke4/addon/image2
    // config.extraPlugins = 'youtube,image2,imageresponsive,widget,lineutils'; //image2 為 可以讓圖片至中，但不能設定寬度100% | imageresponsive研究中 by 2021/06/09 lota
    config.extraPlugins = 'youtube,liststyle';


    // 為加入額外字體 2015-05-29
    config.font_names = 'Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif;新細明體;標楷體;微軟正黑體';

    //2016/4/12 使用插件支援
    config.allowedContent = true;

    //2021-04-15 預設就先載入CSS by lota
    // config.contentsCss =['/css_v4/style.css','/css_v4/template.css','/css_v4/style_cowboy.css','/css_v4/external.css','https://image.buyersline.com.tw/contenvuilder/contentbuilder/contentbuilder.css','https://image.buyersline.com.tw/contenvuilder/assets/minimalist-blocks/content.css'];
    config.contentsCss = ['/fonts/fontawesome.line/css/font-awesome.min.css', 'https://image.buyersline.com.tw/contenvuilder/contentbuilder/contentbuilder.css', 'https://image.buyersline.com.tw/contenvuilder/assets/minimalist-blocks/content.css', '/css_v4/style.css', '/css_v4/style_cowboy.css', '/css_v4/external.css', '/css/theme.css', '/css/bootstrap-grid.css'];

    // 2019-02-23 HYC
    // ALLOW <i></i>
    config.protectedSource.push(/<i[^>]*><\/i>/g);

};

//https://ithelp.ithome.com.tw/questions/10195197
CKEDITOR.on('instanceReady', function(ev) {
    with(ev.editor.dataProcessor.writer) {
        setRules("p", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: false });
        setRules("h1", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("h2", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("h3", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("h4", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("h5", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("div", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: false });
        setRules("table", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("tr", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("td", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("iframe", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("li", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("ul", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("ol", { indent: true, breakBeforeOpen: true, breakAfterOpen: true, breakBeforeClose: true, breakAfterClose: true });
        setRules("a", { indent: true, breakBeforeOpen: true, breakAfterOpen: false, breakBeforeClose: true, breakAfterClose: false });
        setRules("img", { indent: true, breakBeforeOpen: true, breakAfterOpen: false, breakBeforeClose: true, breakAfterClose: false });
    }
})