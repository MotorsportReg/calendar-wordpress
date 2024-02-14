<div class='wrap'>
	<div class="head" style="width: auto;display: block;border-bottom: 2px solid black;height: 36px;">
		<span style="width:250px;float:left;font-size: 22px;padding-top:9px;">Calendar Settings</span>
		<span style="float:none;"><form name="form_msrcalendar" method="post" action="">
			<input type="hidden" value="1" name="msr_calendar_cache"/>
			<input type="submit" value="Flush Cache &amp; Reload Events" name="msr_calendar_submit_cache" class="button-secondary" />
		</form>
	</div>
<?php
global $wpdb;

// $cache_time_option=array('24','12','6','4');
$cache_time_option=array('24');

$msr_calendar_title=get_option('msr_calendar_title');
$msr_calendar_url=get_option('msr_calendar_url');
$msr_calendar_cache_time=get_option('msr_calendar_cache_time');
$msr_calendar_display_field_eventname=get_option('msr_calendar_display_field_eventname');
$msr_calendar_display_field_organization=get_option('msr_calendar_display_field_organization');
$msr_calendar_display_field_venue=get_option('msr_calendar_display_field_venue');
$msr_calendar_display_field_venuecity=get_option('msr_calendar_display_field_venuecity');
$msr_calendar_display_field_eventtype=get_option('msr_calendar_display_field_eventtype');
$msr_calendar_display_field_eventdate=get_option('msr_calendar_display_field_eventdate');   


if (@$_POST['msr_calendar_submit_cache']) 
{
	$cache=true;
	$req_url=get_option('msr_calendar_url');
	$cache_update_after_time=get_option('msr_calendar_cache_time') * 60 * 60;
	$xml = request_cache($req_url,$cache_update_after_time,$cache);
	if($xml)
		echo"<span style='color:green;'>Cache flushed successfully</span>";
}
else if (@$_POST['msr_calendar_submit']) 
{
	$msr_calendar_title = stripslashes($_POST['msr_calendar_title']);
       	if($_POST['msr_calendar_url'] =='')
	$msr_calendar_url='';
	else
	$msr_calendar_url = stripslashes($_POST['msr_calendar_url']);
	$msr_calendar_cache_time = stripslashes($_POST['msr_calendar_cache_time']);
	$msr_calendar_display_field_eventname = stripslashes($_POST['msr_calendar_display_field_eventname']);
	$msr_calendar_display_field_organization = stripslashes($_POST['msr_calendar_display_field_organization']);
	$msr_calendar_display_field_venue = stripslashes($_POST['msr_calendar_display_field_venue']);
	$msr_calendar_display_field_venuecity = stripslashes($_POST['msr_calendar_display_field_venuecity']);
	$msr_calendar_display_field_eventtype = stripslashes($_POST['msr_calendar_display_field_eventtype']);
	$msr_calendar_display_field_eventdate = stripslashes($_POST['msr_calendar_display_field_eventdate']);

	update_option('msr_calendar_title', $msr_calendar_title );
  	update_option('msr_calendar_url', $msr_calendar_url );
	update_option('msr_calendar_cache_time', $msr_calendar_cache_time );
	update_option('msr_calendar_display_field_eventname', $msr_calendar_display_field_eventname );
	update_option('msr_calendar_display_field_organization', $msr_calendar_display_field_organization );
	update_option('msr_calendar_display_field_venue', $msr_calendar_display_field_venue );
	update_option('msr_calendar_display_field_venuecity', $msr_calendar_display_field_venuecity );
	update_option('msr_calendar_display_field_eventtype', $msr_calendar_display_field_eventtype );
    update_option('msr_calendar_display_field_eventdate', $msr_calendar_display_field_eventdate );
}


echo '<form name="form_msrcalendar" method="post" action="">';
echo '<table border="0" cellspacing="5" cellpadding="0" width="100%">';
echo '<tr><td align="left"><h3>General</h3></td></tr>';

echo '<tr><td align="left">Title</td></tr>';
echo '<tr><td><input style="width: 100%; max-width: 400px;" type="text" value="';
echo $msr_calendar_title . '" name="msr_calendar_title" id="msr_calendar_title" /></td></tr>';
echo '<tr><td align="left">API URL</td></tr>';
echo '<tr><td><input style="width: 100%; max-width: 1024px;" type="text" value="';
echo $msr_calendar_url . '" name="msr_calendar_url" id="msr_calendar_url" placeholder="URL like https://api.motorsportreg.com/rest/calendars/organization/..." /></td></tr>';

echo '<tr><td>Update cache every</td></tr>';
echo '<tr><td><select name="msr_calendar_cache_time" id="msr_calendar_cache_time">';
foreach($cache_time_option as $cache_time){
	if($cache_time == $msr_calendar_cache_time)
		echo'<option value="'.$cache_time.'" selected="selected">'.$cache_time.' hours</option>';
	else
		echo'<option value="'.$cache_time.'">'.$cache_time.' hours</option>';
}
echo'</select></td></tr>';

echo '<tr><td align="left"><h3>Select Fields to Display</h3></td></tr>';
echo '<tr><td><label><input type="checkbox" ';
if($msr_calendar_display_field_eventname){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_eventname" id="msr_calendar_display_field_eventname" style="margin-right: 1em;" /> Event Name</label></td></tr>';
echo '<tr><td><label><input type="checkbox" ';
if($msr_calendar_display_field_organization){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_organization" id="msr_calendar_display_field_organization" style="margin-right: 1em;" /> Organization</label></td></tr>';
echo '<tr><td><label><input type="checkbox"';
if($msr_calendar_display_field_venue){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_venue" id="msr_calendar_display_field_venue" style="margin-right: 1em;" /> Venue</label></td></tr>';
echo '<tr><td><label><input type="checkbox"';
if($msr_calendar_display_field_venuecity){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_venuecity" id="msr_calendar_display_field_venuecity" style="margin-right: 1em;" /> Venue City/State</label></td></tr>';
echo '<tr><td><label><input type="checkbox"';
if($msr_calendar_display_field_eventtype){
    echo'checked="checked" ';
}
echo  'value="1" name="msr_calendar_display_field_eventtype" id="msr_calendar_display_field_eventtype" style="margin-right: 1em;" /> Event Type</label></td></tr>';
echo '<tr><td><label><input type="checkbox"';
if($msr_calendar_display_field_eventdate){
    echo'checked="checked" ';
}
echo ' value="1" name="msr_calendar_display_field_eventdate" id="msr_calendar_display_field_eventdate" style="margin-right: 1em;" /> Date</label></td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
echo '<tr><td><input type="submit" id="msr_calendar_submit" name="msr_calendar_submit" lang="publish" class="button-primary" value="Update" value="1" /></td></tr>';

echo '<tr><td>&nbsp;</td></tr>';
echo '<tr><td>You can obtain your default URL from <a href="https://www.motorsportreg.com/em360/index.cfm/event/profile.api">your Developer API page</a> on MotorsportReg.com</td></tr>';
echo '<tr><td>For more details, view the API documentation at <a href="http://api.motorsportreg.com" target="_blank">http://api.motorsportreg.com</a></td></tr>'; 
echo '<tr><td><strong>PLEASE subscribe</strong> to our developer group at <a href="https://groups.google.com/forum/#!forum/motorsportreg-api-developers" target="_blank">https://groups.google.com/forum/#!forum/motorsportreg-api-developers</a></td></tr>'; 
echo '</form>';
echo '</table>';
?>
</div><!-- end of div.wrap -->