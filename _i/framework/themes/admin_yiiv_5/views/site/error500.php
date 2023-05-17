<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/pages/error.css" rel="stylesheet" type="text/css"/>
<div class="row">
   <div class="col-md-12 page-500">
      <div class="number" style="position:static;font-family: 'Open Sans',sans-serif;">500</div>
      <div class=" details">
			<h3>內部的伺服器錯誤</h3>
			<p>
				當網頁伺服器正在處理您的請求時, 發生了一個內部錯誤.<br>
				請回報此一問題給mis2@buyersline.com.tw<br>
			</p>
			<p class="text-error"><?php echo $error['message']; ?></p>
      </div>
   </div>
</div>
