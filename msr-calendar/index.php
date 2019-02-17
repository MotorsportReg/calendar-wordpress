<?php

/*
Plugin Name: MotorsportReg.com Calendar
Plugin URI: http://api.motorsportreg.com/wordpress/ 
Description: Display upcoming events from MotorsportReg.com calendar
Author: Pukka Software
Version: 1.2
Author URI: http://api.motorsportreg.com
*/

// handle automatic updates without using wordpress.org
// using code from http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker(
		'http://api.motorsportreg.com/wordpress/metadata.json',
		__FILE__,
		'msr-calendar'
);


// msr-calendar plugin:
global $wpdb;

if ( ! defined( 'MSR_CALENDAR_PLUGIN_BASENAME' ) )
	define( 'MSR_CALENDAR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'MSR_CALENDAR_PLUGIN_NAME' ) )
	define( 'MSR_CALENDAR_PLUGIN_NAME', trim( dirname( MSR_CALENDAR_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'MSR_CALENDAR_PLUGIN_DIR' ) )
	define( 'MSR_CALENDAR_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MSR_CALENDAR_PLUGIN_NAME );

if ( ! defined( 'MOTORSPORT_PLUGIN_URL' ) )
	define( 'MSR_CALENDAR_PLUGIN_URL', WP_PLUGIN_URL . '/' . MSR_CALENDAR_PLUGIN_NAME );


function motorsport_plugin_path( $path = '' ) {
	return path_join( FIFO_PLUGIN_DIR, trim( $path, '/' ) );
}

function motorsport_plugin_url( $path = '' ) {
	return plugins_url( $path, MSR_CALENDAR_PLUGIN_BASENAME );
}

function msr_calendar_install() 
{
	global $wpdb;
	
		add_option('msr_calendar_title', "MotorsportReg.com Calendar");
		add_option('msr_calendar_url',"");
		add_option('msr_calendar_cache_time', "24");
		add_option('msr_calendar_display_field_eventname', "1");
		add_option('msr_calendar_display_field_organization', "1");
		add_option('msr_calendar_display_field_venue', "1");
		add_option('msr_calendar_display_field_venuecity',"1");
		add_option('msr_calendar_display_field_eventtype',"1");
		add_option('msr_calendar_display_field_eventdate',"1");        
	
}

function msr_calendar_deactivation() 
{

}

function msr_calendar_style(){
	wp_register_style( 'msr-calendar-prefix-style', plugins_url('calendar/widget.css', __FILE__), array(), '20121003');
	wp_enqueue_style( 'msr-calendar-prefix-style' );
}


function msr_calendar_control() 
{
	//echo "Motor Sports";
}



function request_cache($url, $timeout, $flush = false) 
{
global $wpdb;
$resource_url=$url;
$expirey_time=$timeout;
$flush_now=$flush;
$key=generate_msr_unique_key($resource_url);

if($flush_now){
   delete_transient($key);
}
if ( false === ( $special_query_results = get_transient($key) ) || $flush_now === true)
 {
   $data=fetch_data($url);
   set_transient($key,$data,$expirey_time);
    return $data;
 }else{
    $special_query_results = get_transient($key);
    return $special_query_results;
 }
}


function fetch_data($url)
{
     global $wpdb, $wp_version;
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt ($ch,CURLOPT_FOLLOWLOCATION, 1); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
                curl_setopt($ch, CURLOPT_TIMEOUT, 90);
                // set content-type and authorization headers
                $headers = array(
                        "Accept: application/vnd.pukkasoft+xml",
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $data = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if($http_status == '200' )
		        {
                $data1=simplexml_load_string($data);
                $arr = json_encode($data1);
                return $arr;
                }elseif($http_status == '404' || $http_status == '405' || $http_status == '415' || $http_status == '500')
                {
                    echo "No Record Found.  The URL may be incorrect.";
                    exit;
                }
}



function generate_msr_unique_key($url){
     global $wpdb;
    $key=md5($url);
return $key;
}

function date_display_formate($start_date,$end_date='')
{
	$start=strtotime($start_date);
	$start_year=date('y',$start);
	$start_month=date('M',$start);
	$start_day=date('j',$start);

	if($end_date){
		$end=strtotime($end_date);
		$end_year=date('y',$end);
		$end_month=date('M',$end);
		$end_day=date('j',$end);
	}

	if($end_date){
		if($start_month == $end_month)
		{
			if($start_day == $end_day)
				$date_display=$start_month.' '.$start_day;
			else
				$date_display= $start_month.' '.$start_day.'-'.$end_day;

		}else{
			$date_display= $start_month.' '.$start_day.' - '.$end_month.' '.$end_day;
		}
	}else{
		$date_display=$start_month.' '.$start_day;
	}

	return $date_display;
}

function registr_display_formate($start_date,$end_date)
{
    $start=strtotime($start_date);
    $end=strtotime($end_date);
    $current_date=strtotime(date('Y-m-d h:s'));
    if(($current_date >=$start) AND ($current_date<=$end) )
    {
    $flag=true; 
    }else{
    $flag=false;
    }

return $flag;
}

function msr_calendar_shortcode($atts) 
{
	global $wpdb;
        extract( shortcode_atts( array(
		'url' => get_option('msr_calendar_url'),
                ), $atts ) );
        $cache_update_after_time=get_option('msr_calendar_cache_time') * 60 * 60;
        $xml = request_cache($url,$cache_update_after_time);
        $out=msr_calendar_view($xml);
        return $out;
}
function msr_calendar() 
{
	global $wpdb, $wp_version;  
	include_once("calendar/widget.php");
}

function msr_calendar_widget($args) 
{
               extract($args);
		echo $before_widget;
		echo $before_title;
		echo get_option('msr_calendar_title');
		echo $after_title;
		msr_calendar();
		echo $after_widget;
}


function msr_calendar_view($xml)
{
$field_eventname=get_option('msr_calendar_display_field_eventname');
$field_organization=get_option('msr_calendar_display_field_organization');
$field_venue=get_option('msr_calendar_display_field_venue');
$field_venuecity=get_option('msr_calendar_display_field_venuecity');
$field_eventtype=get_option('msr_calendar_display_field_eventtype');
$field_eventdate=get_option('msr_calendar_display_field_eventdate');   
$title=get_option('msr_calendar_title');
$data1 = json_decode($xml, true);
$event_tot=$data1["recordset"]["total"];
if ($event_tot == 0){
$events= array();	
}else if($event_tot == 1){
$events= $data1["events"]; 
}else{
$events= $data1["events"]["event"]; 
}

$out = '<div class="msrcalendar"><h2>' . $title .'</h2>';
$out .='<table><thead><tr>';
$show=false;

if($field_eventdate){
	$out .='<th>Date</th>';
	$show=true;
}

if($field_eventname){
	$out .='<th>Name</th>';
	$show=true;
}

if($field_organization){
	$out .='<th>Organization</th>';
	$show=true;
}

if($field_venue){
	$out .='<th>Venue</th>';
	$show=true;
}

if($field_venuecity){
	$out .='<th>Location</th>';
	$show=true;
}

if($field_eventtype){
	$out .='<th>Type</th>';
	$show=true;
}

$out .='<th>&nbsp;</th>';
$out .='</tr></thead><tbody>';

if(count($events)){

	foreach($events as $event)
	{
		$out .='<tr>';
	
		if($field_eventdate){
			$start=$event[start];
			$end=$event[end];
			if(!$end)
				$out .='<td>'.date_display_formate($start).'</td>';
			else
				$out .='<td>'.date_display_formate($start,$end).'</td>';
		}
	
		if($field_eventname)
			$out .='<td>'.$event[name].'</td>';
	
		if($field_organization)
			$out .='<td>'.$event[organization][name].'</td>';
	
		if($field_venue)
			$out .='<td>'.$event[venue][name].'</td>';
	
		if($field_venuecity)
			$out .='<td>'.$event[venue][city].', '.$event[venue][region].'</td>';
	
		if($field_eventtype)
			$out .='<td>'.$event[type].'</td>';
	
		$r_start=$event[registration][start];
		$r_end=$event[registration][end];
		$flag=registr_display_formate($r_start,$r_end);
		if($show){
			if($flag)
				$out .='<td><a href="'.$event[detailuri].'" class="imglink"><img src="' . plugins_url('calendar/images/register.gif', __FILE__) . '" height="17" width="85" alt="Register now on MotorsportReg.com" /></a></td>';
			else
				$out .='<td><a href="'.$event[detailuri].'" class="txtlink">More Details</a></td>';
		}

$out .='</tr>';
}
}else{
	$out .='<tr><td colspan="7">No upcoming coming events for this organization.</td></tr>';
}

// please do not remove the link to motorsportreg.com - the only requirement for using our otherwise-free plugin is to retain an unedited link back to our site, thanks!
$out .='</tbody></table><div class="morelink">Use MotorsportReg.com for <a href="http://www.motorsportreg.com/index.cfm/event/event-management">online driving event registration</a>.  Register for thousands of <a href="http://www.motorsportreg.com/calendar/">autocross, HPDE, race &amp; social events</a>.</div></div>';

return $out;
}



function msr_calendar_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget("MSR Calendar", "MSR Calendar", 'msr_calendar_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control("MSR Calendar", array("MSR Calendar", 'widgets'), 'msr_calendar_control');
	} 
}

function add_admin_menu_msr_calendar_option() {
	global $wpdb;

	include_once("option-msrcalendar.php");
   
}
function add_admin_menu_msr_calendar_cache_flush() {
	global $wpdb;
	include_once("msr_calendar_cache_flush.php");
}

function add_admin_menu_option_msr_calendar() 
{
    
    add_menu_page( __( 'MSR Calendar', 'msr_calendar' ), __( 'MSR.com Calendar', 'msr_calendar' ), 'administrator', 'msr_calendar', 'add_admin_menu_msr_calendar_option' );
    add_submenu_page('msr_calendar', 'Preview', 'Preview', 'administrator', 'msr_calendar_cache_flush', 'add_admin_menu_msr_calendar_cache_flush');

    
}

add_action('admin_menu', 'add_admin_menu_option_msr_calendar');
register_activation_hook(__FILE__, 'msr_calendar_install');
register_deactivation_hook(__FILE__, 'msr_calendar_deactivation');
add_shortcode( 'msr_calendar', 'msr_calendar_shortcode');
add_action( 'wp_enqueue_scripts', 'msr_calendar_style' );
