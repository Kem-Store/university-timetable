<script>
var isFullName = null;
var isSex = null;
var idUser = null;
var idGroup = null;
var idType = null;
$(function(){
	$('#form_edit_teacher').popupBox(400,260);
	$('#edit_teacher').click(function(){
		if(idUser!=0) {
			// Edit Teacher Form.
			if($('#fullname').val()!=='') {
				$.ajax({ url: 'index.php?ajax=teacher&edit',
					data: ({
						userid: idUser,
						fullname: $('#fullname').val(),
						sex: $('input:radio[name=sex]:checked').val(),
						group: $('#group').val(),
						type: $('#type').val(),
					}),
					error: function() {	alert("Error: Edit Teacher Form."); },
					success: function(data) { window.location.reload(); }
				});		
			} else {
				alert('<?php echo _LOGIN_ERROR_NULL; ?>');
			}
		} else {
			// Add Teacher Form.
			if($('#fullname').val()!=='') {
				$.ajax({ url: 'index.php?ajax=teacher&add',
					data: ({
						username: $('#username').val(),
						password: $('#password').val(),
						fullname: $('#fullname').val(),
						sex: $('input:radio[name=sex]:checked').val(),
						group: $('#group').val(),
						type: $('#type').val(),
					}),
					error: function() {	alert("Error: Add Teacher Form."); },
					success: function(data) { window.location.reload(); }
				});		
			} else {
				alert('<?php echo _LOGIN_ERROR_NULL; ?>');
			}
		}
	});	
	$('#del_teacher').click(function(){
		if(idUser!=0) {
			// Delete Teacher Form.
			if(confirm('<?php echo _LIST_DEL_QUESTION; ?>')) {
				$.ajax({ url: 'index.php?ajax=teacher&del',
					data: ({ userid: idUser }),
					error: function() {	alert("Error: Delete Teacher Form."); },
					success: function(data) { window.location.reload(); }
				});
			}
		} else {
			// Cancel Teacher Form.			
			$('#form_edit_teacher').popupClose();
		}
	});
});

function boxTeacher(userid, fullname, sex, group, type) {
	idUser = userid;
	if(idUser!=0) {
		$('#head_teacher').html('<?php echo _LIST_EDIT._MENU_TEACHER; ?>');
		$('#edit_teacher').val('<?php echo _LIST_EDIT; ?>');
		$('#del_teacher').val('<?php echo _LIST_DEL; ?>');
		$('#fullname').val(fullname);
		$('#sex').removeAttr('checked');
		$('#sex[value='+sex+']').attr('checked','checked');
		$('#group option:selected').removeAttr('selected');
		$('#group option[value='+group+']').attr('selected','selected');
		$('#type option:selected').removeAttr('selected');
		$('#type option[value='+type+']').attr('selected','selected');
	} else {
		$('#head_teacher').html('<?php echo _LIST_ADD._MENU_TEACHER; ?>');
		$('#edit_teacher').val('<?php echo _LIST_ADD; ?>');
		$('#del_teacher').val('<?php echo _LIST_CANCEL; ?>');		
		$('#fullname').val('');
	}
	$('#form_edit_teacher').popupOpen();
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php echo _MENU_TEACHER; ?></div>
        <div class="main_subtitle"><?php echo _LIST_SUBTITLE; ?> <span class="main_color"><?php echo _USER_LIST; ?></span></div>
      </div>
      <div id="main_menu">|
        <a onclick="boxTeacher(0,null,0,0,0);"><strong><?php echo _LIST_ADD; ?></strong></a>
      |</div>
      <div class="main_details">
        <table align="center" width="800" border="0" cellspacing="0" cellpadding="3" class="main_color" style="font-weight:bold;">
          <tr>
            <td width="50" align="center"><?php echo _USER_LIST; ?></td>
            <td width="300" align="left"><?php echo _USER_FULLNAME; ?></td>
            <td width="80" align="center"><?php echo _USER_SEX; ?></td>
            <td width="200" align="center"><?php echo _USER_GROUP; ?></td>
            <td width="120" align="center"><?php echo _USER_TYPE; ?></td>
          </tr>
        </table>
        <?php
      $listID = 0;
      foreach($database->Query("SELECT * FROM user WHERE level_id=3;") as $user):
      $listID++;
      $group = $database->Query("SELECT * FROM science_group WHERE group_id=(SELECT group_id FROM user_teacher WHERE user_id=$user[user_id]) LIMIT 1;");
      $type = $database->Query("SELECT * FROM class_type WHERE type_id=(SELECT type_id FROM user_teacher WHERE user_id=$user[user_id]) LIMIT 1;");
      ?>
      <div <?php if($listID%2==1) echo 'style="background-color:#FCFCFC;"'; ?>>
        <table align="center" width="800" border="0" cellspacing="0" cellpadding="3" class="teacher_edit"
        onclick="boxTeacher(<?php echo $user['user_id']; ?>,'<?php echo $user['fullname']; ?>','<?php echo $user['sex']; ?>',<?php echo $group['group_id']; ?>,<?php echo $type['type_id']; ?>);">
          <tr>
            <td width="50" align="center"><?php echo $listID; ?></td>
            <td width="300" align="left"><?php echo $user['fullname']; ?></td>
            <td width="80" align="center"><?php if($user['sex']=='M') echo _MALE; else echo _FEMALE; ?></td>
            <td width="200" align="left"><?php echo $group['group']; ?></td>
            <td width="120" align="center"><?php echo $type['type']; ?></td>
          </tr>
        </table>
      </div>
        <?php
      endforeach;
	  if(!$database->Query("SELECT * FROM user WHERE level_id=3;")): ?>
	    <table align="center" width="800" border="0" cellspacing="0" cellpadding="3" style="background-color:#FCFCFC;">
          <tr>
            <td colspan="5" width="50" align="center"><strong><?php echo _LIST_NONE; ?></strong></td>
          </tr>
        </table>
	  <?php
	  endif;?>      
      </div></td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table>
<div id="form_edit_teacher">
  <div style="padding:8px;">
    <h3 id="head_teacher"><?php echo _LIST_ADD._MENU_TEACHER; ?></h3>
    <div>    
      <table align="center" width="400" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="100" align="right"><strong><?php echo _USER_FULLNAME; ?>: </strong></td>
          <td><input type="text" id="fullname" size="30" value="" /></td>
        </tr>
        <tr>
          <td align="right"><strong><?php echo _USER_SEX; ?>: </strong></td>
          <td colspan="2">
          <label><input type="radio" name="sex" id="sex" value="M" checked="checked" /><?php echo _MALE; ?></label>
          <input type="radio" name="sex" id="sex" value="F" /><?php echo _FEMALE; ?></label>
          </td>
        </tr>
        <tr>
          <td align="right"><strong><?php echo _USER_GROUP; ?>: </strong></td>
          <td>
            <select name="group" id="group"><?php
            foreach($database->Query("SELECT * FROM science_group;") as $group): ?>
			  <option value="<?php echo $group['group_id']; ?>"><?php echo $group['group']; ?></option><?php
            endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td align="right"><strong><?php echo _USER_TYPE; ?>: </strong></td>
          <td>
            <select name="type" id="type"><?php
            foreach($database->Query("SELECT * FROM class_type;") as $type): ?>
			  <option value="<?php echo $type['type_id']; ?>"><?php echo $type['type']; ?></option><?php
            endforeach; ?>
            </select>
          </td>
        </tr>
      </table>
      <table align="center" width="400" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="150" align="right"><input type="button" id="edit_teacher" value="<?php echo _LIST_ADD; ?>" /></td>
          <td width="100" align="right">&nbsp;</td>
          <td width="150" align="left"><input type="button" id="del_teacher" value="<?php echo _LIST_CANCEL; ?>" /></td>
        </tr>
      </table>
    </div>
    </div>
</div>
