<script>
var idScience = null;
var isScience = null;
$(function(){
	$('#form_edit_science').popupBox(350,200);
	$('#edit_science').click(function(){
		if(idScience!=0) {
			// Edit Science Form.
			if($('#science').val()!=='') {
				$.ajax({ url: 'index.php?ajax=science&edit',
					data: ({
						scienceid: idScience,
						science: $('#science').val(),
						group: $('#group').val(),
					}),
					error: function() {	alert("Error: Edit Science Form."); },
					success: function(data) { window.location.reload(); }
				});	
			} else {
				alert('<?php echo _LOGIN_ERROR_NULL; ?>');
			}
		} else {
			// Add Science Form.		
			if($('#science').val()!=='') {
				$.ajax({ url: 'index.php?ajax=science&add',
					data: ({
						science: $('#science').val(),
						group: $('#group').val(),
					}),
					error: function() {	alert("Error: Add Science Form."); },
					success: function(data) { window.location.reload(); }
				});		
			} else {
				alert('<?php echo _LOGIN_ERROR_NULL; ?>');
			}
		}
	});	
	$('#del_science').click(function(){
		if(idScience!=0) {
			// Delete Science Form.
			if(confirm('<?php echo _LIST_DEL_QUESTION; ?>')) {
				$.ajax({ url: 'index.php?ajax=science&del',
					data: ({ scienceid: idScience }),
					error: function() {	alert("Error: Delete Science Form."); },
					success: function(data) { window.location.reload(); }
				});
			}
		} else {
			// Cancel Science Form.			
			$('#form_edit_science').popupClose();
		}
	});
});

function boxScience(id, science, group) {
	idScience = id;
	if(idScience!=0) {
		$('#head_science').html('<?php echo _LIST_EDIT._MENU_SCIENCE; ?>');
		$('#edit_science').val('<?php echo _LIST_EDIT; ?>');
		$('#del_science').val('<?php echo _LIST_DEL; ?>');
		$('#science').val(science);
		$('#group option:selected').removeAttr('selected');
		$('#group option[value='+group+']').attr('selected','selected');
	} else {
		$('#head_science').html('<?php echo _LIST_ADD._MENU_SCIENCE; ?>');
		$('#edit_science').val('<?php echo _LIST_ADD; ?>');
		$('#del_science').val('<?php echo _LIST_CANCEL; ?>');		
		$('#science').val('');
	}
	$('#form_edit_science').popupOpen();
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" valign="top"><div id="main_verify">
        <div class="main_title"><?php echo _MENU_SCIENCE; ?></div>
        <div class="main_subtitle"><?php echo _LIST_SUBTITLE; ?> <span class="main_color"><?php echo _USER_LIST; ?></span></div>
      </div>
      <div id="main_menu">|
        <a onclick="boxScience(0,null,0);"><strong><?php echo _LIST_ADD; ?></strong></a>
      |</div>
      <div class="main_details">
        <table align="center" width="800" border="0" cellspacing="0" cellpadding="3" class="main_color" style="font-weight:bold;">
          <tr>
            <td width="100" align="center"><?php echo _USER_LIST; ?></td>
            <td width="520" align="left"><?php echo _USER_SCIENCE; ?></td>
            <td width="180" align="center"><?php echo _USER_GROUP; ?></td>
          </tr>
        </table>
        <?php
      $listID = 0;
      foreach($database->Query("SELECT * FROM science;") as $science):
      $listID++;
      $group = $database->Query("SELECT * FROM science_group WHERE group_id=$science[group_id] LIMIT 1;");
      ?>
      <div <?php if($listID%2==1) echo 'style="background-color:#FCFCFC;"'; ?>>
        <table align="center" width="800" border="0" cellspacing="0" cellpadding="3" class="teacher_edit"
        onclick="boxScience(<?php echo $science['science_id']; ?>,'<?php echo $science['science']; ?>',<?php echo $science['group_id']; ?>);">
          <tr>
            <td width="100" align="center"><?php echo $listID; ?></td>
            <td width="520" align="left"><?php echo $science['science']; ?></td>
            <td width="180" align="left"><?php if(isset($group['group'])) echo $group['group']; ?></td>
          </tr>
        </table>
      </div>
        <?php
      endforeach;
	  if(!$database->Query("SELECT * FROM science;")): ?>
	    <table align="center" width="500" border="0" cellspacing="0" cellpadding="3" style="background-color:#FCFCFC;">
          <tr>
            <td colspan="3" width="50" align="center"><strong><?php echo _LIST_NONE; ?></strong></td>
          </tr>
        </table>
	  <?php
	  endif;?>      
      </div></td>
    <td width="15%" valign="top"><div class="main_date">30.09.88</div></td>
  </tr>
</table>
<div id="form_edit_science">
  <div style="padding:8px;">
    <h3 id="head_science"><?php echo _LIST_ADD._MENU_SCIENCE; ?></h3>
    <div>    
      <table align="center" width="350" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="100" align="right"><strong><?php echo _USER_SCIENCE; ?>: </strong></td>
          <td><input type="text" id="science" size="30" value="" /></td>
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
      </table>
      <table align="center" width="350" border="0" cellspacing="0" cellpadding="3" style="margin-left:10px;">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="150" align="right"><input type="button" id="edit_science" value="<?php echo _LIST_ADD; ?>" /></td>
          <td width="100" align="right">&nbsp;</td>
          <td width="150" align="left"><input type="button" id="del_science" value="<?php echo _LIST_CANCEL; ?>" /></td>
        </tr>
      </table>
    </div>
    </div>
</div>
