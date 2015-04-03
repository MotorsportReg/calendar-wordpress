=== MotorsportReg.com Calendar Plugin ===
Tags: MotorsportReg.com calendar,motorsport calendar,event calendar motorsport, motorsport, HPDE, solo, autocross, driving school, club race, rally, rallycross

This plugin will display a calendar listing of motorsport events from MotorsportReg.com on any Wordpress website.  	

MotorsportReg.com is an online event registration service for motorsport driving and social events.  It is used by hundreds of car clubs, sanctioning bodies and race tracks
across North America to organize driving schools, autocross, club and pro races, rally, rallycross, motorcycle, karting and social events.  Organizers can use the service
for free to streamline their event registration and membership management tools.

The only requirement for using our free plugin is to leave our link unedited at the bottom of the calendar listings that points back to motorsportreg.com.  Thank you!

== Description ==

There are two ways of embedding the MotorsportReg.com calendar in your Wordpress site: 

1. Embed it in any Post or Page using the Short Code:

Just put the following (including [ and ]) into a post or page on its own line and preview it:

[msr_calendar]

2. Use the PHP function in any Theme Template file: 

For developers or hackers, you can also use the msr_calendar() function to embed the calendar into your theme with one simple function call.

<?php if(function_exists('msr_calendar'))
{
    msr_calendar();
}?>