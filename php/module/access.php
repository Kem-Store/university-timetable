<script>
$(function(){
	$('#login').click(function() { loginProcess(); });
	$("#username, #password").keypress(function(event) { if(event.which==13) loginProcess(); });
	
	$('#yes_logout').click(function() {
		$.ajax({ url: 'index.php?ajax=user_access',
			data: ({ user:'logout' }),
			error: function() {	$('#login_welcome').html("Error: Ajax User Login"); },
			success: function(data) {	
				window.location.href = "?component=access&mode=in";
			},
		});
	});	
	
	$('#no_logout').click(function() {
		window.location.href = "?component=access";
	});	
	
});

function loginProcess() {
	$.ajax({ url: 'index.php?ajax=user_access',
		data: ({ user:'login', username: $('#username').val(), password: $('#password').val() }),
		error: function() {	$('#login_error').html("Error: Ajax User Login"); },
		success: function(data) {
			if(!data.error) {
				window.location.href = "?component=access"
			} else {
				$('#login_error').show();
				$('#login_error').html(data.error);					
			}
		},
	});
}
</script><?php
if(isset($_REQUEST['mode'])): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php 
		if($_REQUEST['mode']=='out' ) {
			echo _LOGIN_LOGOUT;
		} else {
			echo _LOGIN_LOGIN;
		} ?>
        </div>
        <div class="main_subtitle"><?php
		if($_REQUEST['mode']=='out' ) {
       		echo _LOGIN_ERROR_PLEASE.' <span class="main_color">'._LOGOUT_SUBTITLE.'</span>';			
		} else {
       		echo _LOGIN_ERROR_PLEASE.' <span class="main_color">'._LOGIN_ERROR_ENTER.'</span>';			
		} ?></div>
      </div></td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table><?php
if($_REQUEST['mode']=='in'): ?>
<div class="main_details"><?php
if(!$session->Value('USER')): ?>
  <table width="80%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="200"><div class="box_username">
          <input type="text" id="username" value="" maxlength="19"/>
        </div>
        <div class="box_password">
          <input type="password" id="password" value="" maxlength="19" />
        </div></td>
       <td><input type="button" id="login" value="Login" /></td>
    </tr>
    <tr>
     <td colspan="2"><span id="login_error" style="display:none;"></span></td>
    </tr>
  </table><?php
  else:
  
  endif; ?>  
</div><?php
elseif($_REQUEST['mode']=='out'): ?>
<div class="main_details">
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2" style="margin-top:20px;">
  <tr>
    <td colspan="3" align="center"><strong><?php echo _LOGOUT_QUESTION; ?></strong></td>
  </tr>
  <tr>
    <td width="200" align="right"><input type="button" id="yes_logout" value="Yes" /></td>
    <td width="110" align="right">&nbsp;</td>
    <td width="200" align="left"><input type="button" id="no_logout" value="No" /></td>
  </tr>
</table>
</div><?php
endif; ?>
<?php
else: ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php
		if($session->Value('USER')) {
			$user_id = $session->Value('USER');
			$user = $database->Query("SELECT * FROM user WHERE user_id=$user_id LIMIT 1;");
			$level = $database->Query("SELECT * FROM user_level WHERE level_id='$user[level_id]' LIMIT 1;");
			echo _LOGIN_TITLE.'<strong>'.$user['fullname'].'</strong>';
		} ?>
        </div>
        <div class="main_subtitle"><?php
		if($session->Value('USER')) {
			echo _LOGIN_LEVEL.' <span class="main_color">'.$level['level'].'</span>';
		} ?></div>
      </div></td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table><?php
endif; ?>

