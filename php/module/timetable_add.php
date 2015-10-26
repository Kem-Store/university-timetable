<script>
$(function(){
	tableChange();
	$('#form_part_study').popupBox(350,200);
	$('#edit_study').click(function(){
		$.ajax({ url: 'index.php?ajax=timetable&edit',
			data: ({
				table: $('#tableid').val(),
				science: $('#science').val(),
				teacher: $('#teacher').val(),
				room: $('#room').val(),
			}),
			dataType: "html",
			error: function() {	alert("Error: Timetable Add Study"); },
			success: function(data) { $('#form_part_study').popupClose(); tableChange(); }
		});
	});
	$('#del_study').click(function(){
		if(confirm('<?php echo _LIST_DEL_QUESTION; ?>')) {
			$.ajax({ url: 'index.php?ajax=timetable&del',
				data: ({ table: $('#tableid').val() }),
				dataType: "html",
				error: function() {	alert("Error: Timetable Add Study"); },
				success: function(data) { $('#form_part_study').popupClose(); tableChange(); }
			});
		}
	});
});

function tableChange() {
	$.ajax({ url: 'index.php?ajax=timetable_find&view_edit',
		data: ({
			class: $('#class').val(),
			term: $('#term').val(),
			year: $('#year').val(),
		}),
		dataType: "json",
		error: function() {	alert("Error: Timetable View Class Room."); },
		success: function(data) {			
			$('.tableline').css('background','url(../images/TableTime_bg.jpg) 0px 0px no-repeat');			
			$('#main_table').html(data.block);		
			$( ".edit_block" ).css('position','absolute');
			$("#main_table").draggable({ containment: "parent", grid: [200, 200], });
			$(".edit_block").draggable({ 
				zIndex: 1,
				cursor: "move",
				grid: [88, 50],
				containment: "parent",
				drag: function() {
					$(this).css('cursor','move');			
					//$('#debug').html('Day: ' + (($(this).css('top').replace(/\px/,''))/50) + ' Period: ' + (($(this).css('left').replace(/\px/,''))/88));
				},
				stop: function() {
					$.ajax({ url: 'index.php?ajax=timetable&time',
						data: ({
							table: $(this).attr('tableid'),
							day: ($(this).css('top').replace(/\px/,''))/50,
							period: ($(this).css('left').replace(/\px/,''))/88,
							range: $(this).attr('range'),
						}),
						dataType: "json",
						error: function() {	alert("Error: Move Study Part."); },
						success: function(data) { tableChange(); }
					});
				},
			});
			$( ".edit_block" ).resizable({
				grid: 88,
				minWidth: 88,
				minHeight: 40,
				maxWidth: 440,
				maxHeight: 40,
				stop: function() {
					$.ajax({ url: 'index.php?ajax=timetable&time',
						data: ({
							table: $(this).attr('tableid'),
							day:  $(this).attr('day'),
							period: $(this).attr('period'),
							range: ($(this).width()/88),
						}),
						dataType: "json",
						error: function() {	alert("Error: Resize Study Part."); },
						success: function(data) { tableChange(); }
					});	
				},
			});
		}
	});	
}

function classChange(id) {
	$.ajax({ url: 'index.php?ajax=timetable_view&class',
		data: ({ id: id }),
		dataType: "html",
		error: function() {	alert("Error: Timetable View Class Room."); },
		success: function(data) { $('#class_view').html(data); tableChange(); }
	});		
}

function partClear() {
	if(confirm('<?php echo _LIST_DELALL_QUESTION; ?>')) {
		$.ajax({ url: 'index.php?ajax=timetable&delall',
			data: ({ 
				class: $('#class').val(),
				term: $('#term').val(),
				year: $('#year').val(),
			}),
			dataType: "html",
			error: function() {	alert("Error: Timetable Add Study"); },
			success: function(data) { tableChange(); }
		});
	}
}

function partAdd() {
	if(confirm('<?php echo _LIST_ADD_QUESTION; ?>')) {
		$.ajax({ url: 'index.php?ajax=timetable&add',
			data: ({ 
				class: $('#class').val(),
				term: $('#term').val(),
				year: $('#year').val(),
			}),
			dataType: "html",
			error: function() {	alert("Error: Timetable Add Study"); },
			success: function(data) { console.log(data); tableChange(); }
		});
	}
}

		
function partStudy(table_id, class_id, science_id, room_id, teacher_id, wday, period, range, term, year) {
	$('#tableid').val(table_id);
	
	// Timetable Filter Science
	$.ajax({ url: 'index.php?ajax=timetable_filter&science',
		data: ({ 
			table_id: table_id,
			class_id:class_id,
			science_id: science_id,
			room_id: room_id,
			teacher_id: teacher_id,
			wday: wday,
			period: period,
			range: range,
			term: term,
			year: year,
		}),
		dataType: "html",
		error: function() {	alert("Error: Timetable Filter Science."); },
		success: function(data) {
			$('#view_science').html(data);
			$('#science option:selected').removeAttr('selected');
			$('#science option[value='+science_id+']').attr('selected','selected');
			$('#form_part_study').popupOpen();
			var idScience = science_id;
			if($('#science option[value='+science_id+']').html()==null) idScience = $('#science option:selected').val();
			
			// Timetable Filter Teacher
			$.ajax({ url: 'index.php?ajax=timetable_filter&teacher',
				data: ({
					table_id: table_id,
					class_id:class_id,
					science_id: idScience,
					room_id: room_id,
					teacher_id: teacher_id,
					wday: wday,
					period: period,
					range: range,
					term: term,
					year: year,
				}),
				dataType: "html",
				error: function() {	alert("Error: Timetable Filter Teacher."); },
				success: function(data) {
					$('#view_teacher').html(data);
					$('#teacher option:selected').removeAttr('selected');
					$('#teacher option[value='+teacher_id+']').attr('selected','selected');
					// Open Popup						
				}
			});
			
			// Timetable Filter Room
			$.ajax({ url: 'index.php?ajax=timetable_filter&room',
				data: ({
					table_id: table_id,
					class_id:class_id,
					science_id: idScience,
					room_id: room_id,
					teacher_id: teacher_id,
					wday: wday,
					period: period,
					range: range,
					term: term,
					year: year,
				  }),
				dataType: "html",
				error: function() {	alert("Error: Timetable Filter Room."); },
				success: function(data) {
					$('#view_room').html(data);
					$('#room option:selected').removeAttr('selected');
					$('#room option[value='+room_id+']').attr('selected','selected');
				}
			});
		}
		
	});
}

function changeTeacher(table_id, class_id, science_id, room_id, teacher_id, wday, period, range, term, year) {
	$.ajax({ url: 'index.php?ajax=timetable_filter&teacher',
		data: ({ 
			table_id: table_id,
			class_id: class_id,
			science_id: science_id,
			room_id: room_id,
			teacher_id: teacher_id,
			wday: wday,
			period: period,
			range: range,
			term: term,
			year: year,
		}),
		dataType: "html",
		error: function() {	alert("Error: Timetable Filter Teacher."); },
		success: function(data) {
			$('#view_teacher').html(data);			
		}
	});
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php echo _MENU_TABLE_ADD; ?></div>
        <div class="main_subtitle"><?php echo _LIST_SUBTITLE; ?> <span class="main_color"><?php echo _USER_LIST; ?></span></div>
      </div>
      <div id="main_menu">|
        <a onclick="partAdd();"><strong><?php echo _LIST_ADD; ?></strong></a> |
        <a onclick="partClear();"><strong><?php echo _LIST_CLEAR; ?></strong></a> |
      </div>
      <div class="main_details">
      <?php echo _TABLE_CLASS; ?><span id="school_view">
      <select class="view_table" id="school" onchange="classChange($(this).val())"><?php
      foreach($database->Query("SELECT * FROM class_school;") as $school): ?>
        <option value="<?php echo $school['school_id']; ?>"><?php echo $school['highschool'] ?></option><?php
      endforeach; ?>
      </select></span>
      <?php echo _TABLE_ROOM; ?><span id="class_view">
      <select class="view_table" id="class" onChange="tableChange()"><?php
      foreach($database->Query("SELECT * FROM class WHERE school_id=1;") as $class): ?>
        <option value="<?php echo $class['class_id']; ?>"><?php echo $class['class'] ?></option><?php
      endforeach; ?>
      </select></span>
      <?php echo _TABLE_TERM; ?><span id="term_view">
      <select class="view_table" id="term" onChange="tableChange()"><?php
      $listTerm = array(1,2);
      foreach($listTerm as $term): ?>
        <option value="<?php echo $term; ?>"><?php echo $term ?></option><?php
      endforeach; ?>
      </select></span>
      <?php echo _TABLE_YEAR; ?><span id="year_view">
      <select class="view_table" id="year" onChange="tableChange()"><?php
      $nowDate = getdate(time());
      $between = 10;
      $nowYear = $nowDate['year']+543;
      for($iloop=($nowYear-2);$iloop<=($nowYear+$between);$iloop++): ?>
        <option value="<?php echo ($iloop-543); ?>" <?php if($nowYear==$iloop) echo 'selected="selected"'; ?>><?php echo $iloop ?></option><?php
      endfor; ?>
      </select></span>
      </div>
    </td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table>
<div style="padding-right:10px; font-size: 14px;" id="tabletime">
<table border="0" cellspacing="0" cellpadding="0" style="border:#EEE solid 1px;background:url(../images/TableTime_bg.jpg) 0px 0px no-repeat;" class="tableline">
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
<div id="debug">&nbsp;</div>
<div id="form_part_study">
  <div style="padding:8px;">
    <h3 id="head_study"><?php echo _LIST_EDIT._TABLE_STUDY; ?></h3>
    <div>    
      <table align="center" width="350" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="2"><input type="hidden" id="tableid" value="" /></td>
        </tr>
        <tr>
          <td align="right" width="100"><strong><?php echo _USER_SCIENCE; ?>: </strong></td>
          <td><span id="view_science">&nbsp;</span>
          </td>
        </tr>
        <tr>
          <td align="right"><strong><?php echo _USER_TEACHER; ?>: </strong></td>
          <td><span id="view_teacher">&nbsp;</span>
          </td>
        </tr>
        <tr>
          <td align="right"><strong><?php echo _TABLE_ROOM; ?>: </strong></td>
          <td><span id="view_room">&nbsp;</span>
          </td>
        </tr>
      </table>
      <table align="center" width="350" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="150" align="right"><input type="button" id="edit_study" value="<?php echo _LIST_EDIT; ?>" /></td>
          <td width="100" align="right">&nbsp;</td>
          <td width="150" align="left"><input type="button" id="del_study" value="<?php echo _LIST_DEL; ?>" /></td>
        </tr>
      </table>
    </div>
    </div>
</div>