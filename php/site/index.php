<script>
$(function(){
	$('#main_image').fadeOut(0);
	$('#main_download').fadeOut(0);
	$(document).widthSiteChange();
    $(window).resize(function(){
		$(document).widthSiteChange();		
    });
});

</script>
</head>
<body>
<div id="manga_background">
  <div style="background-color:#5b5b5b;">
    <div id="manga_bar"></div>
  </div>
  <table id="manga_body" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td id="manga_menu"><div id="manga_logo"><?php
      		$session = new Session();
      		$database = new SyncDatabase(); ?>
        </div>
        <span <?php if($session->Value('USER')) echo 'style="display:none;"'; ?>><a href="?component=access&mode=in"><span class="step_list"><?php echo _LOGIN_LOGIN; ?></span></a></span>  
        <div id="level1">
            <h4><?php echo _MENU_FIND; ?></h4>
            <a href="?component=timetable_student_find"><span class="step_list"><?php echo _MENU_STABLE; ?></span></a>
            <a href="?component=timetable_teacher_find"><span class="step_list"><?php echo _MENU_TTABLE; ?></span></a>
        </div>        
        <div id="level3" <?php if($session->Value('LEVEL')<4) echo 'style="display:none;"'; ?>>
        	<h4><?php echo _MENU_TABLE; ?></h4>
            <a href="?component=timetable_add"><span class="step_list"><?php echo _MENU_TABLE_ADD; ?></span></a>
        </div>
        <div id="level4" <?php if($session->Value('LEVEL')<4) echo 'style="display:none;"'; ?>>
        	<h4><?php echo _MENU_MANAGER; ?></h4>
            <a href="?component=list_science"><span class="step_list"><?php echo _MENU_SCIENCE; ?></span></a>
            <a href="?component=list_teacher"><span class="step_list"><?php echo _MENU_TEACHER; ?></span></a>
        	<a href="?component=access&mode=out"><span class="step_list" style="color:#900;"><?php echo _LOGIN_LOGOUT; ?></span></a>
        </div>        
        <div id="level4" <?php if($session->Value('LEVEL')<4) echo 'style="display:none;"'; ?>>
        	<h4><?php echo _MENU_HELP; ?></h4>
            <a href="?component=help_table_add"><span class="step_list"><?php echo _MENU_HELP_ADD; ?></span></a>
        </div>        
      </td>
      <td id="manga_main"><div class="main_head"><span class="main_color"> <?php echo _MAIN_SYSTEM; ?> </span> <?php echo _MAIN_TITLE; ?></div>
        <div class="main_line"><span class="main_subhead"><?php echo _MAIN_SUBSYSTEM; ?></div><?php
		  if(!isset($_GET['component'])) $_GET['component'] = 'timetable_student_find';
		  if(file_exists('module/'.$_GET['component'].'.php')) {
			  include_once('module/'.$_GET['component'].'.php');
		  } else {
			  echo '<div id="exception">'._SITE_NONE_MODULE.'</div>';
		  }
		  ?>          
       </td>
    </tr>
  </table>
</div>
