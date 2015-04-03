<?php
global $wpdb, $wp_version;
?>
<div class='wrap'>
<div class="head" style="width: auto;display: block;border-bottom: 2px solid black;height: 36px;"><span style="float:left;font-size: 22px;padding-top:9px;">Calendar Preview</span>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo motorsport_plugin_url('calendar/widget.css'); ?> " />
<span style="float:right;padding-right: 25px;padding-top: 8px;"><form name="form_msrcalendar" method="post" action="">
<input type="hidden" value="1" name="msr_calendar_cache"/>
<input type="submit" value="Flush Cache" name="msr_calendar_submit_cache" style="font-weight: bold;"/>
</form><span>
</div>
<?php

if (@$_POST['msr_calendar_submit_cache']) 
{
$cache=true;
$req_url=get_option('msr_calendar_url');
$cache_update_after_time=get_option('msr_calendar_cache_time') * 60 * 60;

$field_eventname=get_option('msr_calendar_display_field_eventname');
$field_organization=get_option('msr_calendar_display_field_organization');
$field_venue=get_option('msr_calendar_display_field_venue');
$field_venuecity=get_option('msr_calendar_display_field_venuecity');
$field_eventtype=get_option('msr_calendar_display_field_eventtype');
$field_eventdate=get_option('msr_calendar_display_field_eventdate');   
$title=get_option('msr_calendar_title');

$xml = request_cache($req_url,$cache_update_after_time,$cache);
   echo msr_calendar_view($xml);
}else{
msr_calendar();
}

?>
</div>