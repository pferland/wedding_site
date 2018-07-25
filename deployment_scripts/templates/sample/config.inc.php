<?php

// SQL Server values for the RSVP and Guest Book info.
$sql_host = 'localhost';
$sql_user = 'sqluser';
$sql_pwd  = 'sqlpswd';
$db       = 'wedding';
$srvc     = 'mysql';

// Template Information
$http_folder = "/var/www/html/";
$template_folder = "templates/path_to_templates_for_site/";
$site_url = "http://www.yourdomain.com/";

// Date of the wedding, used for the count down timer.
$end_date = '10/27/2018';

//Max number of chars that can be written in a guestbook message
$guestbook_txt_limit = 2048;

//Max number of chars that can be written in a rsvp comment message
$rsvp_comment_txt_limit = 2048;


//GuestBook Alert
//Guest Book Alerts will send an email with the Guests Name, Message,
//SQL Row ID, and the IP it was sent from.

//Enable or Disable Email Alerts for the GuestBook
$GuestBookAlertSendFlag = false;

//Email addresses to send the GuestBook alerts too.
$GuestBookAlertSendToEmail = "wedding_site_admin@domain.com";

//Email addresses to use to send the GuestBook alerts
$GuestBookAlertSendFromEmail = "wedding_guestbook_alerts@domain.com";
$GuestBookAlertSendFromEmail_PWD = "password";

// An array of values that will be searched for to detect spam. Most guests are not going to be entering these phrases.
$GuestbookSpamList = array(
    '<a ',
    'href=',
    'href =',
    'href = ',
    'http://',
    'https://',
    'loans'
);


//RSVP Attempt and Success Alerts
//Data is just an array of the inputted data from the user including the IP address of the user.

$RSVPAlertSendFlag = true;

//Email address to send RSVP attempts and successes to.
$RSVPAlertSendToEmail = "wedding_coordinator@domain.com";

//Email address that will send the RSVP Alerts.
$RSVPAlertSendFromEmail = "wedding_RSVP_alerts@domain.com";
$RSVPAlertSendFromEmail_PWD = "password";