<script>
$(function(){
	//$(".block").draggable({ grid:[80,80] });
	$('#find_timetable').click(function(){
		$('#mon, #tue, #wed, #thu, #fri, #sat').empty();
		//$('#sdasd').html('<div align="center"><br /><img src="images/proload-min.gif" border="0" /></div>');
		$.ajax({ url: 'index.php?ajax=timetable_find&view_lern',
			data: ({
				class: $('#class').val(),
				term: $('#term').val(),
				year: $('#year').val(),
			}),
			dataType: "json",
			error: function() {	alert("Error: Timetable View Class Room."); },
			success: function(data) {
				if((data.mon+data.tue+data.wed+data.thu+data.sat)!=0) {	
					$('.tableline').css('background','url(../images/TableTime_bg.jpg) -1px 0px no-repeat');
					$('#main_table').html(data.block);	
				} else {
					$('.tableline').css('background','url(../images/TableTime_none.jpg) 50% 0px no-repeat');
				}
			}
		});		
	});
});	
function classChange(id) {
	$.ajax({ url: 'index.php?ajax=timetable_view&class',
		data: ({ id: id }),
		dataType: "html",
		error: function() {	alert("Error: Timetable View Class Room."); },
		success: function(data) { $('#class_view').html(data) }
	});		
}

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php echo _MENU_FIND._MENU_STABLE; ?></div>
        <div class="main_subtitle"><?php echo _LIST_SUBTITLE; ?> <span class="main_color"><?php echo _USER_LIST; ?></span></div>
      </div>
      <div class="main_details">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td align="center"><?php echo _TABLE_CLASS; ?><span id="school_view">
              <select class="view_table" id="school" onchange="classChange($(this).val())"><?php
              foreach($database->Query("SELECT * FROM class_school;") as $school): ?>
                <option value="<?php echo $school['school_id']; ?>"><?php echo $school['highschool'] ?></option><?php
              endforeach; ?>
              </select></span>
              <?php echo _TABLE_ROOM; ?><span id="class_view">
              <select class="view_table" id="class"><?php
              foreach($database->Query("SELECT * FROM class WHERE school_id=1;") as $class): ?>
                <option value="<?php echo $class['class_id']; ?>"><?php echo $class['class'] ?></option><?php
              endforeach; ?>
              </select></span>
              <?php echo _TABLE_TERM; ?><span id="term_view">
              <select class="view_table" id="term"><?php
			  $listTerm = array(1,2);
              foreach($listTerm as $term): ?>
                <option value="<?php echo $term; ?>"><?php echo $term ?></option><?php
              endforeach; ?>
              </select></span>
              <?php echo _TABLE_YEAR; ?><span id="year_view">
              <select class="view_table" id="year"><?php
			  $nowDate = getdate(time());
			  $between = 18;
			  $nowYear = $nowDate['year']+543;
              for($iloop=($nowYear-$between);$iloop<=$nowYear+1;$iloop++): ?>
                <option value="<?php echo ($iloop-543); ?>" <?php if($nowYear==$iloop) echo 'selected="selected"'; ?>><?php echo $iloop ?></option><?php
              endfor; ?>
              </select></span>
            </td>
            <td><input type="button" id="find_timetable" value="<?php echo _LIST_FIND; ?>" /></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>      
      </div>
    </td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table>
<div  style="padding-right:10px; font-size: 14px;" id="tabletime">
<table border="0" cellspacing="0" cellpadding="0" style="border:#EEE solid 1px;background:url(../images/TableTime_bg.jpg) -1px 0px no-repeat;" class="tableline">
  <tr>
    <td width="60" height="40" align="center" bgcolor="#FCFCFC"><strong><?php echo _TABLE_DATE; ?></strong></td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 1</strong></div>
      <div style="margin-top:3px;">8:30-9:20</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 2</strong></div>
      <div style="margin-top:3px;">9:20-10:10</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 3</strong></div>
      <div style="margin-top:3px;">10:10-11:00</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 4</strong></div>
      <div style="margin-top:3px;">11:00-11:50</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 5</strong></div>
      <div style="margin-top:3px;">11:50-12:40</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 6</strong></div>
      <div style="margin-top:3px;">12:40-13:30</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 7</strong></div>
      <div style="margin-top:3px;">13:30-14:20</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 8</strong></div>
      <div style="margin-top:3px;">14:20-15:10</div>
    </td>
    <td width="87" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 9</strong></div>
      <div style="margin-top:3px;">15:10-16:00</div>
    </td>
    <td width="89" align="center" bgcolor="#FCFCFC" style="border-left:#f1f1f1 solid 1px;">
      <div><strong><?php echo _TABLE_PART; ?> 10</strong></div>
      <div style="margin-top:3px;">16:00-16:50</div>
    </td>
  </tr>
  <tr>
    <td align="center" height="49" style="border-bottom:#f1f1f1 dashed 1px;"><strong><?php echo _Mon; ?></strong></td>
    <td colspan="10" rowspan="6"><div id="main_table"></div></td>
  </tr>
  <tr>
    <td align="center" height="49" style="border-bottom:#f1f1f1 dashed 1px;"><strong><?php echo _Tue; ?></strong></td>
    </tr>
  <tr>
    <td align="center" height="49" style="border-bottom:#f1f1f1 dashed 1px;"><strong><?php echo _Wed; ?></strong></td>
    </tr>
  <tr>
    <td align="center" height="49" style="border-bottom:#f1f1f1 dashed 1px;"><strong><?php echo _Thu; ?></strong></td>
    </tr>
  <tr>
    <td align="center" height="49" style="border-bottom:#f1f1f1 dashed 1px;"><strong><?php echo _Fri; ?></strong></td>
    </tr>
  <tr>
    <td align="center" height="50"><strong><?php echo _Sat; ?></strong></td>
    </tr>
</table>
</div>
