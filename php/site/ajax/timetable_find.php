<?php
$database = new SyncDatabase();
$session = new Session();
$lineTime = array();
$isBlock = NULL;
$widthTabletime = 940;
if(isset($_REQUEST['view_lern']) || isset($_REQUEST['view_edit'])) $idWhere = "class_id=$_REQUEST[class]";
if(isset($_REQUEST['view_teach'])) $idWhere = "teacher_id=$_REQUEST[teacher]";

foreach($database->Query("SELECT * FROM table_timetable WHERE ".$idWhere." AND term=$_REQUEST[term] AND year=$_REQUEST[year]") as $table) {
	$blockWidth = ($widthTabletime-60)/10; // 88
	$blockHeight = 50;
	
	$yPosition = $table['wday'] * $blockHeight;	
	$xPosition = $table['period'] * $blockWidth;	
	$xWidth = $table['range'] * $blockWidth;
	$redLine = false;	
	foreach($database->Query("SELECT * FROM table_timetable WHERE ".$idWhere." AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$table[wday];") as $time) {
		if($table['table_id']!=$time['table_id']) {
			$block1_l = $table['period'];
			$block1_r = $table['period']+$table['range'];
			$block2_l = $time['period'];
			$block2_r = $time['period']+$time['range'];
			if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) $redLine = true;
		}
	}
	
	// Query Data
	$teacher = $database->Query("SELECT * FROM user WHERE user_id=(SELECT user_id FROM user_teacher WHERE teacher_id=$table[teacher_id]) LIMIT 1;");
	list($firstName) = explode(' ', $teacher['fullname']);
	if($table['range']>1) $firstName = $teacher['fullname'];
	$science = $database->Query("SELECT * FROM science WHERE science_id=$table[science_id] LIMIT 1;");
	$room = $database->Query("SELECT * FROM class_room WHERE room_id=$table[room_id] LIMIT 1;");
	$class = $database->Query("SELECT * FROM class WHERE class_id=$table[class_id] LIMIT 1;");
	
	// View HTML
	$isBlock .= '<div tableid="'.$table['table_id'].'" day="'.$table['wday'].'" range="'.$table['range'].'" period="'.$table['period'].'" ';
	if(isset($_REQUEST['view_edit'])) $isBlock .= 'class="edit_block"'; else $isBlock .= 'class="block"';
	if(!isset($_REQUEST['view_edit'])) $xStart = 1;
	$isBlock .= ' style="width:'.($xWidth-$xStart).'px;';
	if($table['science_id']==0 && $table['teacher_id']==0 && $table['room_id']==0) $isBlock .= 'background-color:#09E !important;';
	if($redLine) $isBlock .= 'background-color:#F00 !important;';
	if(!isset($_REQUEST['view_edit'])) $isBlock .= 'position:absolute;margin-left:'.($xPosition-1).'px;margin-top:'.$yPosition.'px';
	//$backPosition = count($lineTime[$table['wday']])*$blockWidth;
	if(isset($_REQUEST['view_edit'])) $isBlock .= 'left:'.($xPosition).'px;top:'.($yPosition).'px';
	
	
	// Teacher Check Warning.
	$vaildTeacher = false;
	foreach($database->Query("SELECT * FROM table_timetable WHERE teacher_id=$table[teacher_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$table[wday];") as $found) {	
		if($table['table_id']!=$found['table_id']) {
			$block1_l = $table['period'];
			$block1_r = $table['period']+$table['range'];
			$block2_l = $found['period'];
			$block2_r = $found['period']+$found['range'];
			if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r)) $vaildTeacher = $found['class_id'];
		}
	}
	
	// Room Check Warning.
	$vaildRoom = false;
	foreach($database->Query("SELECT * FROM table_timetable WHERE room_id=$table[room_id] AND term=$_REQUEST[term] AND year=$_REQUEST[year] AND wday=$table[wday];") as $found) {		
		if($table['table_id']!=$found['table_id']) {
			$block1_l = $table['period'];
			$block1_r = $table['period']+$table['range'];
			$block2_l = $found['period'];
			$block2_r = $found['period']+$found['range'];
			if(($block1_l>=$block2_l && $block1_l<$block2_r) || ($block1_r<=$block2_r && $block1_r>$block2_l) || ($block2_l>=$block1_l && $block2_r<=$block1_r))  $vaildRoom = $found['class_id'];
		}
	}
		
	if($session->Value('USER')) {
		$isBlock .= '" ondblclick="partStudy('.$table['table_id'].','.$table['class_id'].','.$table['science_id'].','.$table['room_id'].',';
		$isBlock .= $table['teacher_id'].','.$table['wday'].','.$table['period'].','.$table['range'].','.$table['term'].','.$table['year'].')">';
	} else {	
		$isBlock .= '">';
	}
	if($table['science_id']!=0 || $table['teacher_id']!=0 || $table['room_id']!=0) {		
		$isBlock .= '<div class="text_science">'.$science['science'].'</div>';		
		if(isset($_REQUEST['view_teach'])) {
			$isBlock .= '<div class="text_teacher">'._TABLE_CL.$class['school_id'].'/'.$class['class'].'</div>';
		} else {			
			$isBlock .= '<div class="text_teacher" ';
			if($vaildTeacher) {
				$inClass = $database->Query("SELECT * FROM class WHERE class_id=$vaildTeacher LIMIT 1");
				$isBlock .= 'title="'._STUDY_DIFIN.$inClass['school_id'].'/'.$inClass['class'].'" ';			
			}
			if($vaildTeacher) $isBlock .= 'style="background-color:#F00 !important;"';
			$isBlock .= '>'._TABLE_TE.$firstName.'</div>';
		}
		$isBlock .= '<div class="text_room" ';
		if($vaildRoom) {
			$inClass = $database->Query("SELECT * FROM class WHERE class_id=$vaildRoom LIMIT 1");
			$isBlock .= 'title="'._STUDY_DIFIN.$inClass['school_id'].'/'.$inClass['class'].'" ';			
		}
		if($vaildRoom) $isBlock .= 'style="background-color:#F00 !important;"';
		$isBlock .= '>'.$room['room'].'</div>';
	} else {
		
	}
	$isBlock .= '</div>';
}
echo json_encode(array(
	'block'=>$isBlock,
	));
?>
