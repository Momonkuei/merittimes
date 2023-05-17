<section>
        <div class="text-center">
            <span>
			<?php if(isset($this->data['sys_configs']['footer_contact_'.$this->data['ml_key']])) echo $this->data['sys_configs']['footer_contact_'.$this->data['ml_key']]; else {?>
            客服專線：0912-345678 / 
            服務時間：週一至週五 09:00-17:00 / 
            週六：09:00-12:00 /
            傳真：04-12345678
			<?php } ?>
            </span>
        </div>
        <div>
          <p class="copyright text-center"><?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']])) echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]; else '© YOURNAME. All rights reserved.';?>　<a href="http://buyersline.com.tw">網頁設計</a> 百邇來</p>
        </div>
</section>