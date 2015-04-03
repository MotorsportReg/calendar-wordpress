<div class='wrap'>
<div class="head" style="width: auto;display: block;border-bottom: 2px solid black;height: 36px;"><span style="width:700px;float:left;font-size: 22px;padding-top:9px;">Calendar Settings</span>
<span style="float:none;"><form name="form_msrcalendar" method="post" action="">
<input type="hidden" value="1" name="msr_calendar_cache"/>
<input type="submit" value="Flush Cache" name="msr_calendar_submit_cache" style="font-weight: bold;"/>
</form><span>
</div>
<?php
global $wpdb;

if (@$_POST['msr_calendar_submit_cache']) 
{
$cache=true;
$req_url=get_option('msr_calendar_url');
$cache_update_after_time=get_option('msr_calendar_cache_time') * 60 * 60;
$xml = request_cache($req_url,$cache_update_after_time,$cache);
if($xml)
echo"<span style='color:green;'>Cache flushed successfully</span>";

}

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


if (@$_POST['msr_calendar_submit']) 
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
echo '<table border="0" cellspacing="5" cellpadding="0" width="100%" style="display:inline">';
echo '<tr><td align="left" colspan="2"><h3>General:</h3></td></tr>';
echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';

echo '<tr><td align="left">';
echo 'Title:</td><td><input  style="width: 350px;" type="text" value="';
echo $msr_calendar_title . '" name="msr_calendar_title" id="msr_calendar_title" /></td></tr>';
echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';
echo '<tr><td align="left">';
echo 'Calendar URL:</td><td><input  style="width: 400px;" type="text" value="';
echo $msr_calendar_url . '" name="msr_calendar_url" id="msr_calendar_url" /> (must use https://)</td></tr>';

echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';
echo '<tr><td>Update cache after:</td><td>';
echo '<select name="msr_calendar_cache_time" id="msr_calendar_cache_time">';
foreach($cache_time_option as $cache_time){
if($cache_time == $msr_calendar_cache_time)
echo'<option value="'.$cache_time.'" selected="selected">'.$cache_time.' Hour</option>';
else
echo'<option value="'.$cache_time.'">'.$cache_time.' Hour</option>';
}
echo'</select></td></tr>';

echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';
echo '<tr><td align="left" colspan="2"><h3>Select Fields to Display:</h3></td></tr>';
echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';
echo '<tr><td>Event Name:&nbsp;</td><td>&nbsp;<input  type="checkbox" ';
if($msr_calendar_display_field_eventname){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_eventname" id="msr_calendar_display_field_eventname" maxlength="3" /></td></tr>';
echo '<tr><td>Organization:&nbsp;</td><td>&nbsp;<input type="checkbox" ';
if($msr_calendar_display_field_organization){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_organization" id="msr_calendar_display_field_organization" maxlength="3" /></td></tr>';
echo '<tr><td>Venue:&nbsp;</td><td>&nbsp;<input type="checkbox"';
if($msr_calendar_display_field_venue){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_venue" id="msr_calendar_display_field_venue" maxlength="300" /></td></tr>';
echo '<tr><td>Venue City/State:&nbsp;</td><td>&nbsp;<input  type="checkbox"';
if($msr_calendar_display_field_venuecity){
    echo'checked="checked" ';
}
echo 'value="1" name="msr_calendar_display_field_venuecity" id="msr_calendar_display_field_venuecity" /></td></tr>';
echo '<tr><td>Event Type:&nbsp;</td><td>&nbsp;<input type="checkbox"';
if($msr_calendar_display_field_eventtype){
    echo'checked="checked" ';
}
echo  'value="1" name="msr_calendar_display_field_eventtype" id="msr_calendar_display_field_eventtype" /></td></tr>';
echo '<tr><td>Event Date:&nbsp;</td><td>&nbsp;<input  type="checkbox"';
if($msr_calendar_display_field_eventdate){
    echo'checked="checked" ';
}
echo  'value="1" name="msr_calendar_display_field_eventdate" id="msr_calendar_display_field_eventdate" /></td></tr>';
echo '<tr><td align="left" colspan="2">&nbsp;</td></tr>';
echo '<tr><td><input type="submit" id="msr_calendar_submit" name="msr_calendar_submit" lang="publish" class="button-primary" value="Update" value="1" />';

echo '</td>';
echo '<td align="center">&nbsp;</td></tr>';
echo '<tr><td colspan="2">For more details, view the API documentation at <a href="http://api.motorsportreg.com" target="_blank">http://api.motorsportreg.com</a></td></tr>'; 
echo '<tr><td colspan="2"><strong>PLEASE subscribe</strong> to our developer group at <a href="https://groups.google.com/forum/#!forum/motorsportreg-api-developers" target="_blank">https://groups.google.com/forum/#!forum/motorsportreg-api-developers</a></td></tr>'; 
echo '</form>';
echo '</table>';
?>
</div>