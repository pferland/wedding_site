<?php

include 'lib/core.inc.php';

$wedding = new core();

$filepaths = $wedding->getCouplePhotos();
$wedding->smarty->assign('row_count', 0);
$wedding->smarty->assign('filepaths', $filepaths);
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->display("photos.tpl");