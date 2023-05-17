<?php 

// var_dump($this->data);die;
?>

<!-- END BEGIN STYLE CUSTOMIZER -->   
    <h3 class="page-title">
      <?php echo $main_content_title?>
    </h3>

    <div class="breadcrumb">
      <i class="icon-home"></i>
      <a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a> 
      <span class="icon-angle-right"></span>

      <?php if($default_menu_title != ''):?>
        <a href="#"><?php echo $default_menu_title?></a> 
        <span class="icon-angle-right"></span>
      <?php endif?>

      <a href="#"><?php echo $main_content_title?></a> 
      <?php if(isset($main_content_title_action) && $main_content_title_action != ''):?>
        <span class="icon-angle-right"></span>
      <?php endif?>

      <?php if(isset($main_content_title_action) && $main_content_title_action != ''):?>
        <a href="#"><?php echo $main_content_title_action?></a> 
      <?php endif?>
    </div>   

<!-- 資料 -->

<!-- <div class="container"> -->

<?php
    // 只有 設計/資訊 ，看得到功能按鈕
    if(preg_match('/^(999994|999995)/', $this->data['admin_type'])):
?>
    <a href="backend.php?r=<?php echo $this->data['router_class']?>/update">欄位設定</a>
<?php endif?>
  
  <button class="btn btn-primary" id="addbutton" title="Add"><span class="fa fa-plus-square"></span></button>
  <?php 
  if(isset($this->data['select_class_html']) && $this->data['select_class_html']!=''){
      echo $this->data['select_class_html'];
  }
  ?> 
  <table cellpadding="0" cellspacing="0" border="0" class="dataTable table table-striped" id="example" ></table>
  


<script type="text/javascript">
  $(document).ready(function() {



  var url_ws_mock_get = '<?php echo $this->data['url_ws_mock_get']?>';

  var columns_url = '<?php echo $this->data['columns_url']?>';

  var data_insert_url = '<?php echo $this->data['data_insert_url']?>';

  var data_delete_url = '<?php echo $this->data['data_delete_url']?>';

  var data_edit_url = '<?php echo $this->data['data_edit_url']?>';

  var sort_url = '<?php echo $this->data['sort_url']?>';

  var url_columns_get = null;

  $.ajax({
     url: columns_url,
     type: 'get',
     dataType: 'text',
     async: false,
     success: function(data) {
         eval(data);
     } 
  }); 
    
// console.log(url_columns_get);  

  var myTable;

  myTable = $('#example').DataTable({
    "sPaginationType": "full_numbers",
    aLengthMenu: [10,20,30,40,50,100,200,300],//分頁數量下拉
    iDisplayLength: 10,//分頁預設數量
    // data: dataSet,
    ajax: {
            url : url_ws_mock_get,
            // our data is an array of objects, in the root node instead of /data node, so we need 'dataSrc' parameter
            dataSrc : ''
        },    
    columns: url_columns_get, // AJAX columns
    dom: 'Blfrtip',        // Needs button container
    select: {
        style: 'single',
        toggleable: false
    }, 
    //全域設定  
    columnDefs: [
        { orderable: true, className: 'reorder', targets: 0 },
        { orderable: false, targets: '_all' }
        // { orderable: false, targets: [3] }
    ],
    //拖拉排序
    // rowReorder: true,
    rowReorder: {
        dataSrc: 'id',
        // selector: 'td:nth-child(1)',
        selector: 'tr',
        // snapX: true,
    },
    // columnDefs: [
    //     { targets: 0, visible: false }
    // ],
    responsive: true,
    altEditor: true,     // Enable altEditor
    //buttons: [],          // no buttons, however this seems compulsory
    buttons: [
        // {
        //     text: 'Add',
        //     name: 'add'        // do not change name
        // },
        // {
        //     extend: 'selected', // Bind to Selected row
        //     text: 'Edit',
        //     name: 'edit'        // do not change name
        // },
        // {
        //     extend: 'selected', // Bind to Selected row
        //     text: 'Delete',
        //     name: 'delete'      // do not change name
        // },
        // {
        //     text: 'Refresh',
        //     name: 'refresh'      // do not change name
        // }
    ],
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Chinese-traditional.json',
        altEditorUrl: 'backend/views/datatablealteditor/src/tw.json'
    },
    onAddRow: function(datatable, rowdata, success, error) {
        // console.log(rowdata);        
            $.ajax({
                // a tipycal url would be / with type='PUT'
                url: data_insert_url,
                type: 'POST',
                data: rowdata,
                success:function(){
                    myTable.ajax.reload();
                },
                error: error
            });
            success();          
        },
    onEditRow: function(datatable, rowdata, success, error) {        
        console.log(rowdata);
            $.ajax({
                // a tipycal url would be /{id} with type='POST'
                url: data_edit_url,
                type: 'POST',
                data: rowdata,
                success: success,
                error: error
            });
            success(rowdata);
        },
    onDeleteRow: function(datatable, rowdata, success, error) {
        // console.log(rowdata);
            $.ajax({
                // a tipycal url would be /{id} with type='DELETE'
                url: data_delete_url,
                type: 'GET',
                data: rowdata,
                success: function(){
                    myTable.ajax.reload();
                },
                error: error
            });
            success();
        },
  });

  //RowReorder Event
  myTable.on( 'row-reorder', function ( e, diff, edit ) {
        // var result = 'Reorder started on row: '+edit.triggerRow.data()['name']+"\r\n";

        var parameterString = '';
 
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            // var rowData = myTable.row( diff[i].node ).data();
 
            // result += rowData['id']+' updated to be in position '+
            //     diff[i].newData+' (was '+diff[i].oldData+")\r\n";

             parameterString += (i > 0 ? "&" : "")
              + "old_"+diff[i].oldData + "="
              + diff[i].newData;
        }
        
        // console.log(parameterString);

        $.ajax({
           url: sort_url,
           type: 'post',          
           data: parameterString,           
        });
    } );

  // Edit
  $(document).on('click', "[id^='example'] .editbutton ", 'tr', function () {
    var tableID = $(this).closest('table').attr('id');    // id of the table
    var that = $( '#'+tableID )[0].altEditor;
    that._openEditModal();
    $('#altEditor-edit-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._editRowData();
                });
  });

  // Delete
  $(document).on('click', "[id^='example'] .delbutton", 'tr', function (x) {
    var tableID = $(this).closest('table').attr('id');    // id of the table
    var that = $( '#'+tableID )[0].altEditor;
    that._openDeleteModal();
    $('#altEditor-delete-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._deleteRow();
                });
    x.stopPropagation(); //avoid open "Edit" dialog
  });

  // Add row
  $('#addbutton').on('click', function () {
    var that = $( '#example' )[0].altEditor;
    that._openAddModal();
    $('#altEditor-add-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._addRowData();
                });
  });

  <?php 
  if(isset($this->data['select_class_js']) && $this->data['select_class_js']!=''){
      echo $this->data['select_class_js'];
  }
  ?> 
    
  });
</script>