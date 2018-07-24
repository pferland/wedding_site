<?php

include 'lib/core.inc.php';

$wedding = new core();

$wedding_details = $wedding->getWeddingDetails();

$wedding->smarty->assign('wedding_location_name', $wedding_details['wedding_location_name'] );
$wedding->smarty->assign('wedding_town', $wedding_details['wedding_town']);
$wedding->smarty->assign('wedding_date', $wedding_details['wedding_date']);
$wedding->smarty->assign('wedding_time', $wedding_details['wedding_time']);
$wedding->smarty->assign('wedding_gmaps_link', $wedding_details['wedding_gmaps_link']);
$wedding->smarty->assign('wedding_attire', $wedding_details['wedding_attire']);

$wedding->smarty->assign('hotel_name', $wedding_details['hotel_name']);
$wedding->smarty->assign('hotel_location', $wedding_details['hotel_location']);
$wedding->smarty->assign('hotel_gmaps_link', $wedding_details['hotel_gmaps_link']);
$wedding->smarty->assign('hotel_room_link', $wedding_details['hotel_room_link']);

$wedding->smarty->assign('meet_greet_gmaps_link', $wedding_details['meet_greet_gmaps_link']);

$wedding->smarty->assign('brunch_gmaps_link', $wedding_details['brunch_gmaps_link']);

$wedding->smarty->assign('daysuntil', $wedding->daysUntil());

if( (int)$wedding_details['wedding_reception_same_location'] === 0)
{
    $wedding->smarty->assign('reception_attire', $wedding_details['reception_attire']);
    $wedding->smarty->assign('reception_name', $wedding_details['reception_name']);
    $wedding->smarty->assign('reception_town', $wedding_details['reception_town']);
    $wedding->smarty->assign('reception_date', $wedding_details['reception_date']);
    $wedding->smarty->assign('reception_time', $wedding_details['reception_time']);
    $wedding->smarty->assign('reception_gmaps_link', $wedding_details['reception_gmaps_link']);

    $wedding->smarty->display("details_wedding_and_reception.tpl");
}else
{
    $wedding->smarty->display("details_wedding.tpl");
}

