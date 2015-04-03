MotorsportReg Wordpress Calendar Plugin
===========================================

Display a listing of motorsport events from MotorsportReg.com on any Wordpress website.  	

MotorsportReg.com is an online event registration service for motorsport driving and social events.  It is used by hundreds of car clubs, sanctioning bodies and race tracks
across North America to organize driving schools, autocross, club and pro races, rally, rallycross, motorcycle, karting and social events.  Organizers can use the service
for free to streamline their event registration and membership management tools.

The only requirement for using our free plugin is to leave our link unedited at the bottom of the calendar listings that points back to MotorsportReg.com.  Thank you!


## Description

There are two ways of embedding the MotorsportReg.com calendar in your Wordpress site: 

1. Embed it in any Post or Page using the Short Code:

  Just put the following (including [ and ]) into a post or page on its own line and preview it:

  ```
  [msr_calendar]
  ```

2. Use the PHP function in any theme template file: 

  For developers or hackers, you can also use the msr_calendar() function to embed the calendar into your theme with one simple function call.

  ```
  <?php if(function_exists('msr_calendar'))
  {
      msr_calendar();
  }?>
  ```
  
3. Configure in the WP Admin
  Once installed, you need to provide a URL to fetch your events from.  Webmasters wishing to add an organization-specific list of events can use a URL to our API that looks like:
  ```
  https://api.motorsportreg.com/rest/calendars/organization/{organization-id}
  ```
  You can obtain your Organization-Id from your [admin here](https://www.motorsportreg.com/em360/index.cfm/event/profile.api).

Tested as far back as Wordpress ~2.5 or so.  Should be compatible with the latest and greatest.  Please report an issue if you encounter issues: https://github.com/MotorsportReg/calendar-wordpress/issues 
