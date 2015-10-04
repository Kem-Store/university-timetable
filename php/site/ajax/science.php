<?php
$database = new SyncDatabase();
if(isset($_REQUEST['del'])) {
	$database->Query("DELETE FROM science WHERE science_id=$_REQUEST[scienceid];");
}
if(isset($_REQUEST['add'])) {
	$database->Query("INSERT INTO science (group_id, science) VALUES ($_REQUEST[group], '$_REQUEST[science]');");
}
if(isset($_REQUEST['edit'])) {
	$database->Query("UPDATE science SET group_id=$_REQUEST[group], science='$_REQUEST[science]' WHERE science_id=$_REQUEST[scienceid];");
}
?>
