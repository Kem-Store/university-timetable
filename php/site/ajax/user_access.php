<?php
$session = new Session();
$database = new SyncDatabase();
if($_REQUEST['user']=='login') {
	if(trim($_REQUEST['username'])!='' && trim($_REQUEST['password'])!='') {
		if($database->Query("SELECT COUNT(*) FROM user WHERE username='$_REQUEST[username]';")) {
			if($database->Query("SELECT COUNT(*) FROM user WHERE username='$_REQUEST[username]' AND password='$_REQUEST[password]';")) {
				$error = NULL;
				$user = $database->Query("SELECT * FROM user WHERE username='$_REQUEST[username]' AND password='$_REQUEST[password]' LIMIT 1;");
				$level = $database->Query("SELECT * FROM user_level WHERE level_id='$user[level_id]' LIMIT 1;");
				$text = _LOGIN_TITLE.'<strong>'.$user['fullname'].'</strong> | '._LOGIN_LEVEL.$level['level'];
				$timeCookie = 0;
				if($user['level_id']==4) $timeCookie = 0;
				$session->setCookie('USER', $user['user_id'], $timeCookie);
				$session->setCookie('LEVEL', $user['level_id'], $timeCookie);
			} else {
				$error .= _LOGIN_ERROR_PASSWORD;
			}
		} else {
			$error .= _LOGIN_ERROR_USERNAME;
		}
	} else {
		$error .= _LOGIN_ERROR_NULL;
	}
	echo json_encode(array('error'=>$error,'text'=>$text));
} elseif($_REQUEST['user']=='logout') {
	$session->Delete('USER');
	$session->Delete('LEVEL');
	echo json_encode(array(''));
} elseif($_REQUEST['user']=='register') {

	echo json_encode(array(''));
}
?>