<?php
$database = new SyncDatabase();
if(isset($_REQUEST['teacher'])):
	if($_REQUEST['science_id']==0) $_REQUEST['science_id'] = 1;
	$science = $database->Query("SELECT * FROM science WHERE science_id=$_REQUEST[science_id] LIMIT 1;");
    if($science['group_id']!=9) { ?>
    <select name="teacher" id="teacher"><?php		
		$type =  $database->Query("SELECT * FROM class_school WHERE school_id=(SELECT school_id FROM class WHERE class_id=$_REQUEST[class_id]) LIMIT 1;");				
		foreach($database->Query("SELECT * FROM user_teacher WHERE group_id=$science[group_id] AND type_id=$type[type_id];") as $teacher):
			$user = $database->Query("SELECT * FROM user WHERE user_id=$teacher[user_id] LIMIT 1;");
			$vaildFound = true;	
			foreach($database->Query("SELECT * FROM table_timetable WHERE teacher_id=$teacher[teacher_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$_REQUEST[wday];") as $found) {	
				if($_REQUEST['table_id']!=$found['table_id']) {
					$block1_l = $_REQUEST['period'];
					$block1_r = $_REQUEST['period']+$_REQUEST['range'];
					$block2_l = $found['period'];
					$block2_r = $found['period']+$found['range'];
					if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) $vaildFound = false;
				}
			}
			if($vaildFound) echo '<option value="'.$teacher['teacher_id'].'">'.$user['fullname'].'</option>';
		endforeach;?>
    </select><?php
	}  else { ?>
    <select name="teacher" id="teacher"><?php
		foreach($database->Query("SELECT * FROM user_teacher;") as $teacher):
			$user = $database->Query("SELECT * FROM user WHERE user_id=$teacher[user_id] LIMIT 1;");
			$vaildFound = true;
			foreach($database->Query("SELECT * FROM table_timetable WHERE teacher_id=$teacher[teacher_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$_REQUEST[wday];") as $found) {	
				$vaildFound = true;	
				if($_REQUEST['table_id']!=$found['table_id']) {
					$block1_l = $_REQUEST['period'];
					$block1_r = $_REQUEST['period']+$_REQUEST['range'];
					$block2_l = $found['period'];
					$block2_r = $found['period']+$found['range'];
					if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) $vaildFound = false;
				}
			}
			if($vaildFound) echo '<option value="'.$teacher['teacher_id'].'">'.$user['fullname'].'</option>';
		endforeach; ?>
    </select><?php
	}
endif; ?><?php
// table_id, class_id, science_id, room_id, teacher_id, wday, period, range, term, year
if(isset($_REQUEST['science'])): ?>
	<select name="science" id="science" onchange="changeTeacher(<?php echo $_REQUEST['table_id']; ?>,<?php echo $_REQUEST['class_id']; ?>,$(this).val(),<?php echo $_REQUEST['room_id']; ?>,<?php echo $_REQUEST['teacher_id']; ?>,<?php echo $_REQUEST['wday']; ?>,<?php echo $_REQUEST['period']; ?>,<?php echo $_REQUEST['range']; ?>,<?php echo $_REQUEST['term']; ?>,<?php echo $_REQUEST['year']; ?>)"><?php
	$table = $database->Query("SELECT * FROM table_timetable WHERE table_id=$_REQUEST[table_id] LIMIT 1;");		
	foreach($database->Query("SELECT * FROM science;") as $science):
		$vaildFound = 0;
		$type =  $database->Query("SELECT * FROM class_school WHERE school_id=(SELECT school_id FROM class WHERE class_id=$_REQUEST[class_id]) LIMIT 1;");
		$countFound = $database->Query("SELECT COUNT(*) FROM user_teacher WHERE group_id=$science[group_id] AND type_id=$type[type_id];");
		foreach($database->Query("SELECT * FROM user_teacher WHERE group_id=$science[group_id] AND type_id=$type[type_id];") as $teacher):
			$user = $database->Query("SELECT * FROM user WHERE user_id=$teacher[user_id] LIMIT 1;");
			foreach($database->Query("SELECT * FROM table_timetable WHERE teacher_id=$teacher[teacher_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$_REQUEST[wday];") as $found) {	
				if($_REQUEST['table_id']!=$found['table_id']) {
					$block1_l = $_REQUEST['period'];
					$block1_r = $_REQUEST['period']+$_REQUEST['range'];
					$block2_l = $found['period'];
					$block2_r = $found['period']+$found['range'];
					if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) { $vaildFound++; };
				}
			}
		endforeach;
		if($vaildFound<$countFound) echo '<option value="'.$science['science_id'].'">'.$science['science'].'</option>';
	endforeach; ?>
	</select>
<?php
endif; ?><?php

if(isset($_REQUEST['room'])): ?>
	<select name="room" id="room"><?php
	foreach($database->Query("SELECT * FROM class_room;") as $room):
		$vaildFound = true;
		foreach($database->Query("SELECT * FROM table_timetable WHERE room_id=$room[room_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$_REQUEST[wday];") as $found) {	
			$vaildFound = true;			
			if($_REQUEST['id']!=$found['table_id']) {
				$block1_l = $_REQUEST['period'];
				$block1_r = $_REQUEST['period']+$_REQUEST['range'];
				$block2_l = $found['period'];
				$block2_r = $found['period']+$found['range'];
				if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) $vaildFound = false;
			}
		} 
		if($vaildFound) echo '<option value="'.$room['room_id'].'">'.$room['room'].'</option>';
	endforeach; ?>
	</select>
<?php
endif; ?>

            