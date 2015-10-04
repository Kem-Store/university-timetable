<?php
$database = new SyncDatabase();
if(isset($_REQUEST['class'])): ?>

<select class="view_table" id="class" onChange="tableChange()"><?php
foreach($database->Query("SELECT * FROM class WHERE school_id=$_REQUEST[id];") as $class): ?>
	<option value="<?php echo $class['class_id']; ?>"><?php echo $class['class'] ?></option><?php
endforeach; ?>
</select><?php
endif;
if(isset($_REQUEST['teacher'])): ?>

<select class="view_table" id="teacher"><?php
foreach($database->Query("SELECT * FROM user_teacher WHERE group_id=$_REQUEST[id];") as $teacher):
	$idUser = $database->Query("SELECT * FROM user WHERE user_id=$teacher[user_id] LIMIT 1;"); ?>
	<option value="<?php echo $teacher['teacher_id']; ?>"><?php echo $idUser['fullname'] ?></option><?php
endforeach; ?>
</select><?php
endif; ?>