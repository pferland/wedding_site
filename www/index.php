<?php

include 'lib/core.inc.php';

$wedding = new core();

$story = $wedding->getStoryData();
$wedding_town = $wedding->getWeddingTown();
$wedding_date = $wedding->getWeddingDate();

$wedding->smarty->assign('wedding_story', $story['story']);
$wedding->smarty->assign('wedding_town', $wedding_town['wedding_town']);
$wedding->smarty->assign('wedding_date', $wedding_date['wedding_date']);

$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->display("index.tpl");