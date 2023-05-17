<?php
  
  // 取得資料
  $data = array(
    'action'  => isset($_REQUEST['action'])? $_REQUEST['action'] : false ,
    'name'    => isset($_REQUEST['name'])? $_REQUEST['name'] : false ,
    'path'    => isset($_REQUEST['path'])? $_REQUEST['path'] : false ,
    'content' => isset($_REQUEST['content'])? $_REQUEST['content'] : false ,
  );

  // 判斷是否執行動作
  $isAction = (!$data['action'])?false:true;

  // -----------
  // 存成檔案
  // -----------
  if($data['action'] == 'save'){
    $content = $data['content'];
    $fp = fopen($data['path'].$data['name'],"wb");
    fwrite($fp,$content);
    fclose($fp);
  }

  // -----------
  // 取得檔案列表 
  // -----------
  if($data['action'] == 'getFileList'){
    // $path = './scss/css';
    $path = $data['path'];
    $fileList = '';
    if($path!=false){
      list_all_file($path);
      echo $fileList;
    }
  }
  function list_all_file($dir_path,$base='') {
    $base = ($base!='') ? $base : $dir_path;

    if(is_dir($dir_path)){
      foreach(scandir($dir_path) as $file){
        if($file != '.' && $file != '..'){
          list_all_file($dir_path . '/' . $file,$base);
        }
      }// end foreach
    }

    if(is_file($dir_path)) {
      $GLOBALS['fileList'] .= str_replace($base.'/','', (string)$dir_path).',';
    }    
  }//end function

?>


<?php if(!$isAction):?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Compile</title>
    <style>
      html,body{padding:0;margin:0;}
      .loading{position: fixed;width: 100%;height: 100%;text-align: center;background:rgba(0,0,0,.8);z-index: 100;top:0;left:0;color:#fff;display: none;}
    </style>
  </head>
  <body>
    <div class="loading">編譯中...</div>
    <div class="Bbox_view">
      <p>
        <span class="cis1">cis1</span><br>
        <span class="cis2">cis2</span><br>
        <span class="cis3">cis3</span>
      </p>
      <p> <button type="button" data-act="clear" class="btn-cis1">clear localStorage</button> </p>
      <p> <button type="button" data-act="compileFile" class="btn-cis2">編譯</button> </p>
    </div>
    
    <script> var themeNum=<?php echo (isset($_GET['t'])) ? ('"'.$_GET['t'].'"') : '""'; ?></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/sassjs/sass.js"></script>    
    <script src="css_config.js"></script>
    <script>

      // 執行
      var goCompile = false;
      if(viewMode==1){        
        goCompile = (localStorage.getItem('local_resuleCSS')==null)?true:false;
        if(!goCompile){
          removeBodyStyle();
          addStyle2Body(localStorage.getItem('local_resuleCSS'),'localStorage');
        }
      }else{
        goCompile = true;
      }
      if(goCompile){
        letsGO();
      }


      // 編譯
      function letsGO(){        
        beforeCompile();
        // base config
        var sass = new Sass();
        var base = configData['cssbase']; //設定來源資料夾(scss)
        var directory = '';        
        var files = (localStorage.getItem('local_fileList')==null)
                    ? getFileList(configData['cssroot']).split(",")
                    : localStorage.getItem('local_fileList').split(","); // get files 

        // sass options
        sass.options({
          style: Sass.style.compressed,
          comments: false,
        });

        // register the files to be loaded when required
        sass.preloadFiles(base, directory, files, function() {            
          console.log('files loaded : success');
          $.each(configData['items'],function(index,item){
            sass.compileFile(item['source_file'], function(result) {                  
                afterCompile(result,configData['cssroot']+item['output_path'],item['output_name']);  
            });
          });
        });
      }


      // 編譯前要執行的事
      function beforeCompile(result,path,filename){
        clearlocalStorage();
        $('.loading').show();
      }


      // 編譯後要執行的事
      function afterCompile(result,path,filename){
        addStyle2Body(result.text,filename);// 將樣式加到body
        save2local(result.text,filename,'resuleCSS'); // 存到localStorage
        save2file(result.text,path,filename);// 存到檔案
        console.log(filename + " compiled : done");        
        console.log(result);        
        $('.loading').hide();
      }

      // 將樣式加入到body
      function addStyle2Body(txt,filename=''){
        $('body').append('<style data-filename="'+filename+'">'+txt+'</style>');
      }

      // body樣式清除
      function removeBodyStyle(){
        $('style[data-filename]').remove();        
      }

      // 儲存在localStorage
      function save2local(txt,filename,name){
        var saveContent = (localStorage.getItem('local_'+name)==null)?txt:localStorage.getItem('local_'+name)+txt
        localStorage.setItem('local_'+name,saveContent);
        console.log(filename + ' save2local ： success');
      }

      // 清除 localStorage
      function clearlocalStorage(name=false){
        // show localStorage content
        // console.log(localStorage.getItem('local_resuleCSS'));
        
        // clear
        if(!name){
          window.localStorage.clear();
          console.log('clear localStorage');
        }
        else{
          window.localStorage.removeItem(name);
          console.log('localStorage:'+name+' remove');
        }

        // clear body style
        removeBodyStyle();
      }

      // ajax to save file
      function save2file(txt,path,name){
        // 設定送出資料
        var data = {
          action:'save',
          name: name ,
          path: path ,
          content:txt ,
        }

        // 設定url(取得目前檔案)
        var url = window.location.pathname;
            url = url.substring(url.lastIndexOf('/')+1);

        // 執行ajax    
        $.ajax({  
            url: url,  
            type: "POST",
            data: data,
            async:false,
            success:function(result){
              console.log(data['name'] + ' save2file ： success');
            },
            error:function(result){
              console.log(data['name'] + ' save2file ： error');
            },
        });
      }

      //ajax to php get file list
      function getFileList(path){

        // 設定送出資料
        var data = {
          action:'getFileList',
          path: path,
        }
        // 設定url(取得目前檔案)
        var url = window.location.pathname;
            url = url.substring(url.lastIndexOf('/')+1);

        // 執行ajax 
        $.ajax({  
            url: url,  
            type: "POST",
            data: data,
            async:false,
            success:function(data){
              console.log('get file list : success');
              result = data;
            },
            error:function(data){
              console.log('get file list : error');
            },
        });

        save2local(result,'filelist','fileList');
        // 回傳
        return result;
      }

    </script>
    <script>
      // clear localStorage
      $('button[data-act="clear"]').click(function(){
        // clear console.log
        console.clear();
        // clear localStorage
        clearlocalStorage();
      });
      // run comile
      $('button[data-act="compileFile"]').click(function(){
          // clear console.log
          console.clear();
          // clear body style
          removeBodyStyle();
          // go compiler
          letsGO();
      });
    </script>
  </body>
</html>
<?php endif;?>