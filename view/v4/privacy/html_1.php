<?
  $row=$this->cidb->where('is_enable',1)->where('id','4539')->get('html')->row_array();
?>
<section class="sectionBlock" data-about="1">
  <div class="container">

    <div class="innerBlock">
      <div>
        <span><?php echo $row['detail']?></span>
      </div>
    </div><!-- .innerBlock -->
  </div><!-- .container -->
</section><!-- .sectionBlock -->
