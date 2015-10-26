<?php
$database = new SyncDatabase();
if(isset($_REQUEST['del'])) {
	$database->Query("DELETE FROM table_timetable WHERE `table_id`=$_REQUEST[table];");
}
if(isset($_REQUEST['delall'])) {
	$database->Query("DELETE FROM table_timetable WHERE `class_id`=$_REQUEST[class] AND `term`=$_REQUEST[term] AND `year`=$_REQUEST[year];");
}
if(isset($_REQUEST['add'])) {
	$database->Query("INSERT INTO table_timetable (`class_id`, `science_id`, `room_id`, `teacher_id`, `wday`, `period`, `range`, `term`, `year`) VALUES ($_REQUEST[class], 0, 0, 0, 5, 0, 4, $_REQUEST[term], $_REQUEST[year]);");
}
if(isset($_REQUEST['time'])) {
	$database->Query("UPDATE table_timetable SET `wday`=$_REQUEST[day], `period`=$_REQUEST[period], `range`=$_REQUEST[range] WHERE `table_id`=$_REQUEST[table];");
}
if(isset($_REQUEST['edit'])) {
	$database->Query("UPDATE table_timetable SET `science_id`=$_REQUEST[science], `room_id`=$_REQUEST[room], `teacher_id`=$_REQUEST[teacher] WHERE `table_id`=$_REQUEST[table];");
}
?>
