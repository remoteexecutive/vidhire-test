<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="robots" value="noindex,nofollow" />

    <title><?php echo isset($this->kga['user']) ? $this->escape($this->kga['user']['name']) : $this->escape($this->kga['customer']['name'])?> - Kimai</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- Default Stylesheets -->
    <link rel="stylesheet" href="../skins/<?php echo $this->escape($this->kga['conf']['skin']); ?>/styles.css" type="text/css" media="screen" title="no title" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../skins/<?php echo $this->escape($this->kga['conf']['skin']); ?>/jquery.jqplot.css" />
    <!-- /Default Stylesheets -->
    
    <!-- Extension Stylesheets -->
<?php foreach ($this->css_extension_files as $object): ?>
    <link rel="stylesheet" href="<?php echo $this->escape($object)?>" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php endforeach; ?>
    <!-- /Extension Stylesheets -->

    <!-- Libs -->
    <script src="../libraries/jQuery/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../libraries/jQuery/jquery.hoverIntent.minified.js" type="text/javascript" charset="utf-8"></script>
    <script src="../libraries/jQuery/jquery.form.js" type="text/javascript" charset="utf-8"></script>
    <script src="../libraries/jQuery/jquery.newsticker.pack.js" type="text/javascript" charset="utf-8"></script>
    <script src="../libraries/jQuery/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
    <script src="../libraries/jQuery/jquery-ui-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
    <!--[if IE]><script src="../libraries/jQuery/excanvas.min.js" type="text/javascript"></script><![endif]-->
    <script src="../libraries/jQuery/jquery.jqplot.min.js" type="text/javascript"></script>
    <script src="../libraries/jQuery/jqplot.pieRenderer.min.js" type="text/javascript" ></script>
    <script src="../libraries/jQuery/jquery-ui-timepicker/jquery.ui.timepicker.js" type="text/javascript" ></script>
    <script src="../libraries/phpjs/strftime.min.js" type="text/javascript" ></script>
	<script src="../libraries/jQuery/jquery.selectboxes.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- /Libs -->

    <!-- Default JavaScripts -->
    <script src="../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="../js/init.js" type="text/javascript" charset="utf-8"></script>
    <!-- /Default JavaScripts -->

    <!-- Extension JavaScripts -->
<?php foreach ($this->js_extension_files as $object): ?>
    <script src="<?php echo $this->escape($object);?>" type="text/javascript" charset="utf-8"></script>
<?php endforeach; ?>
    <!-- /Extension JavaScripts -->


    <script type="text/javascript"> 
    
        var skin ="<?php echo $this->escape($this->kga['conf']['skin']); ?>";

        var lang_checkUsername    = "<?php echo $this->escape($this->kga['lang']['checkUsername']); ?>";
        var lang_checkGroupname   = "<?php echo $this->escape($this->kga['lang']['checkGroupname']); ?>";
        var lang_checkStatusname   = "<?php echo $this->escape($this->kga['lang']['checkStatusname']); ?>";
        var lang_passwordsDontMatch   = "<?php echo $this->escape($this->kga['lang']['passwordsDontMatch']); ?>";
        var lang_passwordTooShort = "<?php echo $this->escape($this->kga['lang']['passwordTooShort']); ?>";
        var lang_sure = "<?php echo $this->escape($this->kga['lang']['sure']); ?>";

        var currentRecording      = <?php echo $this->currentRecording?>;

        var openAfterRecorded      = <?php echo json_encode($this->openAfterRecorded) ?>;

        <?php if ($this->kga['conf']['quickdelete'] == 2): ?>
        var confirmText           = "<?php echo $this->escape($this->kga['lang']['sure']) ?>";
        <?php else: ?>
        var confirmText           = undefined;
        <?php endif; ?>
        
        <?php if (isset($this->kga['user'])): ?>
        var userID                = <?php echo $this->kga['user']['userID']; ?>;
        <?php else: ?>
        var userID                = null;
        <?php endif; ?>


        <?php if ($this->kga['conf']['noFading']): ?>
        fading_enabled = false;
        <?php endif; ?>
       
        var timeoutTicktack       = 0;
        
        var hour                  = <?php echo $this->current_timer_hour ?>;
        var min                   = <?php echo $this->current_timer_min ?>;
        var sec                   = <?php echo $this->current_timer_sec ?>;
        var startsec              = <?php echo $this->current_timer_start ?>;
        var now                   = <?php echo $this->current_time ?>;
        var offset                = Math.floor(((new Date()).getTime())/1000)-now;
        

        var default_title         = "<?php echo isset($this->kga['user']) ? $this->escape($this->kga['user']['name']) : $this->escape($this->kga['customer']['name'])?> - Kimai";
        var revision              = <?php echo $this->kga['revision'] ?>;
        var timeframeDateFormat   = "<?php echo $this->escape($this->kga['date_format'][2]) ?>";

        var selected_customer  = '<?php echo $this->customerData['customerID']?>';
        var selected_project   = '<?php echo $this->projectData['projectID']?>';
        var selected_activity  = '<?php echo $this->activityData['activityID']?>';

        var pickerClicked = '';
        
        var weekdayNames = <?php echo $this->weekdays_short_array?>;

        $.datepicker.setDefaults({
            showOtherMonths :true,
            selectOtherMonths : true,
            nextText: '',
            prevText: '',
            <?php if ($this->kga['conf']['noFading']): ?>
              showAnim: '',
            <?php endif; ?>
            dateFormat : 'dd.mm.yy', // TODO use correct format depending on admin panel setting
            dayNames: <?php echo $this->weekdays_array ?>,
            dayNamesMin: <?php echo $this->weekdays_short_array ?>,
            dayNamesShort: <?php echo $this->weekdays_short_array ?>,
            monthNames: <?php echo $this->months_array ?>,
            monthNamesShort: <?php echo $this->months_short_array ?>,
            firstDay:1 //TODO should also be depending on user setting
          });

        
        // HOOKS
        function hook_timeframe_changed() { <?php echo $this->hook_timeframe_changed?> }
        function hook_buzzer_record(){ <?php echo $this->hook_buzzer_record?> }
        function hook_buzzer_stopped(){ <?php echo $this->hook_buzzer_stopped?> }
        function hook_users_changed(){lists_reload("user");<?php echo $this->hook_users_changed?> }
        function hook_customers_changed(){lists_reload("customer");lists_reload("project");<?php echo $this->hook_customers_changed?> }
        function hook_projects_changed(){lists_reload("project");<?php echo $this->hook_projects_changed?> }
        function hook_activities_changed(){lists_reload("activity");<?php echo $this->hook_activities_changed?> }
        function hook_filter(){<?php echo $this->hook_filter?> }
        function hook_resize(){<?php echo $this->hook_resize?> }
        function kill_reg_timeouts(){<?php echo $this->timeoutlist?> }

        function kimai_onload() {
    $('#extensionShrink').hover(lists_extensionShrinkShow,lists_extensionShrinkHide);
    $('#extensionShrink').click(lists_shrinkExtToggle);
    $('#customersShrink').hover(lists_customerShrinkShow,lists_customerShrinkHide);
    $('#customersShrink').click(lists_shrinkCustomerToggle);
  <?php if (count($this->users) > 0): ?>
    $('#usersShrink').hover(lists_userShrinkShow,lists_userShrinkHide);
    $('#usersShrink').click(lists_shrinkUserToggle);
  <?php else: ?>
    $('#usersShrink').hide();
  <?php endif; ?>

  <?php if ($this->kga['conf']['user_list_hidden'] or count($this->users) <= 1): ?>
    lists_shrinkUserToggle();
  <?php endif; ?>
    $('#projects>table>tbody>tr>td>a.preselect#ps'+selected_project+'>img').attr('src','../skins/'+skin+'/grfx/preselect_on.png');
    $('#activities>table>tbody>tr>td>a.preselect#ps'+selected_activity+'>img').attr('src','../skins/'+skin+'/grfx/preselect_on.png');

    $('#floater').draggable({  
        zIndex:20,
        ghosting:false,
        opacity:0.7,
        cursor:'move',
        handle: '#floater_handle'
      });   

    $('#n_date').html(weekdayNames[Jetzt.getDay()] + " " +strftime(timeframeDateFormat,new Date()));
    
    // give browser time to render page. afterwards make sure lists are resized correctly
    setTimeout(lists_resize,500);
    clearTimeout(lists_resize);


        if ($('#row_activity[data-id="'+selected_activity+'"]').length == 0) {
          $('#buzzer').addClass('disabled');
        }

	resize_menu();

        <?php if ($this->showInstallWarning): ?>
        floaterShow("floaters.php","securityWarning","installer",0,450);
        <?php endif; ?>
    }

    </script>

    <link href="../favicon.ico" rel="shortcut icon" />
    
  </head>

<body onload="kimai_onload();">

    <div id="top">
        
        <div id="logo">
            <img src="../skins/<?php echo $this->escape($this->kga['conf']['skin'])?>/grfx/g3_logo.png" width="151" height="52" alt="Logo" />
        </div>
        
        <div id="menu">
            <a id="main_logout_button" href="../index.php?a=logout"><img src="../skins/<?php echo $this->escape($this->kga['conf']['skin'])?>/grfx/g3_menu_logout.png" width="36" height="27" alt="Logout" /></a>
            <a id="main_tools_button" href="#" ><img src="../skins/<?php echo $this->escape($this->kga['conf']['skin'])?>/grfx/g3_menu_dropdown.png" width="44" height="27" alt="Menu Dropdown" /></a>
            <br/><?php echo $this->kga['lang']['logged_in_as']?> <b><?php echo isset($this->kga['user']) ? $this->escape($this->kga['user']['name']) : $this->escape($this->kga['customer']['name'])?></b>
        </div>
        
        <div id="main_tools_menu">
            <div class="slider">
                <a href="#" id="main_credits_button"><?php echo $this->kga['lang']['about'] ?> Kimai</a> |
                <a href="#" id="main_prefs_button"><?php echo $this->kga['lang']['preferences'] ?></a>
            </div>
            <div class="end"></div>
        </div>
        
        <div id="display">
          <script type="text/javascript" charset="utf-8">
              $(function()
              {
                  $('.date-pick').datepicker(
                    {dateFormat:'mm/dd/yy',
                    onSelect: function(dateText, instance) {
                      if (this == $('#pick_in')[0]) {
                        setTimeframe(new Date(dateText),undefined);
                      }
                      if (this == $('#pick_out')[0]) {
                        setTimeframe(undefined,new Date(dateText));
                      }
                    }
                  });
                  
                  setTimeframeStart(new Date(<?php echo $this->timeframe_in*1000?>));
                  setTimeframeEnd(new Date(<?php echo $this->timeframe_out*1000?>));
                  updateTimeframeWarning();
                      
              });
          </script>


          <div id="dates">
                  <input type="hidden" id="pick_in" class="date-pick"/>
                  <a href="#" id="ts_in" onClick="$('#pick_in').datepicker('show');return false"></a> - 
                  <input type="hidden" id="pick_out" class="date-pick"/>
                  <a href="#" id="ts_out" onClick="$('#pick_out').datepicker('show');return false"></a>
          </div>


          <div id="infos">
              <span id="n_date"></span> &nbsp; 
              <img src="../skins/<?php echo $this->escape($this->kga['conf']['skin'])?>/grfx/g3_display_smallclock.png" width="13" height="13" alt="Display Smallclock" />
              <span id="n_uhr">00:00</span> &nbsp; 
              <img src="../skins/<?php echo $this->escape($this->kga['conf']['skin'])?>/grfx/g3_display_eye.png" width="15" height="12" alt="Display Eye" /> 
              <strong id="display_total"><?php echo $this->total?></strong> 
          </div>
        </div> 
        
        <?php if (isset($this->kga['user'])): ?>
        
        <div id="selector">
          <div class="preselection">
              
              <strong><?php echo $this->kga['lang']['selectedForRecording']?></strong><br />

              <strong class="short"><?php echo $this->kga['lang']['selectedCustomerLabel']?></strong><span class="selection" id="selected_customer"><?php echo $this->escape($this->customerData['name'])?></span><br/>
              <strong class="short"><?php echo $this->kga['lang']['selectedProjectLabel']?></strong><span class="selection" id="selected_project"><?php echo $this->escape($this->projectData['name'])?></span><br/>    
              <strong class="short"><?php echo $this->kga['lang']['selectedActivityLabel']?></strong><span class="selection" id="selected_activity"><?php echo $this->escape($this->activityData['name'])?></span><br/>    
          </div>
        </div> 
   
        <div id="stopwatch">
            <span class="watch"><span id="h">00</span>:<span id="m">00</span>:<span id="s">00</span></span>
        </div>
        
        <div id="stopwatch_ticker">
            <ul id="ticker"><li id="ticker_customer">&nbsp;</li><li id="ticker_project">&nbsp;</li><li id="ticker_activity">&nbsp;</li></ul>
        </div>
        
        <div id="buzzer" class="disabled">
            <div>&nbsp;</div>
        </div>
        <?php endif; ?>
        
    </div>

    <div id="fliptabs" class="menuBackground">
        <ul class="menu">
            
           	<li class="tab act" id="exttab_0">
           	    <a href="javascript:void(0);" onclick="changeTab(0,'ki_timesheets/init.php'); timesheet_extension_tab_changed();">
           	        <span class="aa">&nbsp;</span>
           	        <span class="bb">
                    <?php if (isset($this->kga['lang']['extensions']['ki_timesheet']))
                      echo $this->kga['lang']['extensions']['ki_timesheet'];
                    else
                      echo "Timesheet";
                    ?></span>
           	        <span class="cc">&nbsp;</span>
           	    </a>
           	</li>
           	        
<?php for($i = 0; $i < count($this->extensions); $i++): 
  $extension = $this->extensions[$i];
  if (!$extension['name'] OR $extension['key'] == "ki_timesheet") continue; ?>
            <li class="tab norm" id="exttab_<?php echo $i+1;?>">
                <a href="javascript:void(0);" onclick="changeTab(<?php echo $i+1?>, '<?php echo $extension['initFile']?>'); <?php echo $extension['tabChangeTrigger']?>;">
                    <span class="aa">&nbsp;</span>
                    <span class="bb">
                    <?php if (isset($this->kga['lang']['extensions'][$extension['key']]))
                      echo $this->kga['lang']['extensions'][$extension['key']];
                    else
                      echo $this->escape($extension['name']);
                    ?></span>
                    <span class="cc">&nbsp;</span>
                </a>
            </li>
<?php endfor; ?>

        </ul>
    </div>
    
    <div id="gui">
    	<div id="extdiv_0" class="ext ki_timesheet"></div>
        <?php
            for ($i = 0; $i < count($this->extensions); $i++)
            {
                if ($this->extensions[$i] != "ki_timesheet")
                {
                    ?>
                    <div id="extdiv_<?php echo $i+1; ?>" class="ext <?php echo $this->extensions[$i]['key']?>" style="display:none;"></div>
                    <?php
                }
            }
        ?>
    </div>

<div class="lists" style="display:none">
<div id="users_head">
        <input class="livefilterfield" onkeyup="lists_live_filter('users', this.value);" type="text" id="filt_user" name="filt_user"/>
    <?php echo $this->kga['lang']['users'] ?>
</div>

<div id="customers_head">
        <input class="livefilterfield" onkeyup="lists_live_filter('customers', this.value);" type="text" id="filter_customer" name="filter_customer"/>
    <?php echo $this->kga['lang']['customers'] ?>
</div>

<div id="projects_head">
        <input class="livefilterfield" onkeyup="lists_live_filter('projects', this.value);" type="text" id="filter_project" name="filter_project"/>
    <?php echo $this->kga['lang']['projects'] ?>
</div>

<div id="activities_head">
        <input class="livefilterfield" onkeyup="lists_live_filter('activities', this.value);" type="text" id="filter_activity" name="filter_activity"/>
    <?php echo $this->kga['lang']['activities']?>
</div>

<div id="users"><?php echo $this->user_display?></div>
<div id="customers"><?php echo $this->customer_display?></div>
<div id="projects"><?php echo $this->project_display?></div>
<div id="activities"><?php echo $this->activity_display?></div>

<div id="users_foot">
<a href="#" class="selectAllLink" onClick="lists_filter_select_all('users'); $(this).blur(); return false;"></a>
<a href="#" class="deselectAllLink" onClick="lists_filter_deselect_all('users'); $(this).blur(); return false;"></a>
<a href="#" class="selectInvertLink" onClick="lists_filter_select_invert('users'); $(this).blur(); return false;"></a>
<div style="clear:both"></div>
</div>

<div id="customers_foot">    
<?php if ($this->show_customer_add_button): ?>
        <a href="#" class="addLink" onClick="floaterShow('floaters.php','add_edit_customer',0,0,450); $(this).blur(); return false;"></a>
<?php endif; ?>
<a href="#" class="selectAllLink" onClick="lists_filter_select_all('customers'); $(this).blur(); return false;"></a>
<a href="#" class="deselectAllLink" onClick="lists_filter_deselect_all('customers'); $(this).blur(); return false;"></a>
<a href="#" class="selectInvertLink" onClick="lists_filter_select_invert('customers'); $(this).blur(); return false;"></a>
<div style="clear:both"></div>
</div>

<div id="projects_foot">
<?php if ($this->show_project_add_button): ?>
        <a href="#" class="addLink" onClick="floaterShow('floaters.php','add_edit_project',0,0,650); $(this).blur(); return false;"></a>
<?php endif; ?>
<a href="#" class="selectAllLink" onClick="lists_filter_select_all('projects'); $(this).blur(); return false;"></a>
<a href="#" class="deselectAllLink" onClick="lists_filter_deselect_all('projects'); $(this).blur(); return false;"></a>
<a href="#" class="selectInvertLink" onClick="lists_filter_select_invert('projects'); $(this).blur(); return false;"></a>
<div style="clear:both"></div>
</div>

<div id="activities_foot">
<?php if ($this->show_activity_add_button): ?>
        <a href="#" class="addLink" onClick="floaterShow('floaters.php','add_edit_activity',0,0,450); $(this).blur(); return false;"></a>
<?php endif; ?>
<a href="#" class="selectAllLink" onClick="lists_filter_select_all('activities'); $(this).blur(); return false;"></a>
<a href="#" class="deselectAllLink" onClick="lists_filter_deselect_all('activities'); $(this).blur(); return false;"></a>
<a href="#" class="selectInvertLink" onClick="lists_filter_select_invert('activities'); $(this).blur(); return false;"></a>
<div style="clear:both"></div>
</div>

<div id="extensionShrink">&nbsp;</div>
<div id="usersShrink">&nbsp;</div>
<div id="customersShrink">&nbsp;</div>
</div>
    
    <div id="loader">&nbsp;</div>
    
	<div id="floater">floater</div>

</body>
</html>
