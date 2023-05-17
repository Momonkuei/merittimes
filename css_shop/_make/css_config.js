// 自動設定版本
var themeNum = ((themeNum == undefined) || (themeNum == ''))? '' : '.w'+themeNum; 

// 強制設定版本 .w01 ~ .w17 (會蓋掉自動設定)
// var themeNum = '';
// var themeNum = '.w01';
// var themeNum = '.w16';

// 路徑/檔名 設定
var configData = {
  // 指定來源css資料夾  js/sassjs/sass.js 的相對路徑
  cssbase : '../../../',

  // 指定output css的資料夾 css.php 的相對路徑
  cssroot : '../',

  // 設定要編譯的檔案
  items:[
    {
      source_file:'theme'+themeNum+'.scss', // 來源檔案 via cssbase => ../../../theme.scss 
      output_path:'/',                      // 輸出路徑 via cssroot => ../ 
      output_name:'theme'+themeNum+'.css',  // 輸出檔名
    },
  ],
};


// 設定模式
// 1 = 判斷localStorage  0=自動編輯 
var viewMode  = 0;