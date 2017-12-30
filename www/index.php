<?php

include 'lib/core.inc.php';

$wedding = new core();

$story = $wedding->getStoryData();
$wedding->smarty->assign('wedding_story', $story['wedding_story']);
$wedding->smarty->assign('wedding_location', $story['wedding_location']);
$wedding->smarty->assign('wedding_date', $story['wedding_date']);

$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->display("index.tpl");