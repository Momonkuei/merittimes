<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
    <?php $this->data['BODY_END'] .= <<<'XXX'
XXX;
?>
    <div class="col-sm-12 col-md-4">
        <div class="title"><?php if(isset($this->data['sys_configs']['companyother_title_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_title_'.$this->data['ml_key']]?></div>
    </div>
    <div class="col-sm-12 col-md-8 col-md-offset-4">
        <div class="text"><?php if(isset($this->data['sys_configs']['companyother_text_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_text_'.$this->data['ml_key']]?>
        </div>
    </div>

<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>

    <?php $this->data['BODY_END'] .= <<<'XXX'
    <script type="text/javascript">

    </script>
XXX;

?>