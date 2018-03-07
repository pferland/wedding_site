<?php
// You may need to change the path for the core library.
// Change /var/www/html to the path that you put the site in.
include "/var/www/html/lib/core.inc.php";

$wedding = new core();

$message = "HELLO!!!!!!!!!!!!!!!!!!!";
$guestname = "Phillip Ferland";
$id = 42;
$ip = "127.0.0.1";

$wedding->SendGuestBookAlert($guestname, $message, $id, $ip);
