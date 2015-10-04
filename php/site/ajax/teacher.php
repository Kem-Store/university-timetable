<?php
$database = new SyncDatabase();
if(isset($_REQUEST['del'])) {
	$database->Query("DELETE FROM user_teacher WHERE user_id=$_REQUEST[userid];");
	$database->Query("DELETE FROM user WHERE user_id=$_REQUEST[userid];");
}
if(isset($_REQUEST['add'])) {
	$userId = $database->Query("INSERT INTO user (level_id, username, password, fullname, sex) VALUES (3, '$_REQUEST[username]', '$_REQUEST[password]', '$_REQUEST[fullname]', '$_REQUEST[sex]');");
	$database->Query("INSERT INTO user_teacher (user_id, group_id, type_id) VALUES ($userId, $_REQUEST[group], $_REQUEST[type]);");
}
if(isset($_REQUEST['edit'])) {
	$database->Query("UPDATE user SET fullname='$_REQUEST[fullname]', sex='$_REQUEST[sex]' WHERE user_id=$_REQUEST[userid];");
	$database->Query("UPDATE user_teacher SET group_id=$_REQUEST[group], type_id=$_REQUEST[type] WHERE user_id=$_REQUEST[userid];");
}
?>
