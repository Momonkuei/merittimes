<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>

    <?php $this->data['HEAD'] .= <<<'XXX'
    <link rel="stylesheet" type="text/css" href="common/zabuto_calendar/zabuto_calendar.min.css">
    <style>
        div.zabuto_calendar *                                                             {font-size:13px}
        div.zabuto_calendar .table tr.calendar-dow-header th                              {background:none;border:1px solid #2495F1;border-width:1px 0;color:#666}
        div.zabuto_calendar .table tr.calendar-month-header th                            {background:none;border-top:0}
        div.zabuto_calendar .table tr.calendar-month-header th span                       {color:#2495F1;}
        div.zabuto_calendar .badge-event, div.zabuto_calendar div.legend span.badge-event {background:#2495F1}    
    </style>

XXX;
?>




<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
    <?php $this->data['BODY_END'] .= <<<'XXX'
    <script src="common/zabuto_calendar/zabuto_calendar.min.js"></script>
    <script type="text/javascript">
        $(function(){    
             $("#zabuto_calendar").zabuto_calendar({
              ajax: {
                  url: "common/zabuto_calendar/zabuto_calendar_data.json",
                  modal: true
              }
            });  
        });
    </script>
XXX;
?>


<div id="zabuto_calendar"></div>