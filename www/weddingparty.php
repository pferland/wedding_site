<?php

include 'lib/core.inc.php';

$wedding = new core();

$filepaths = $wedding->getWeddingPartyPhotos();

$wedding->smarty->assign('filepaths', $filepaths);
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->display("weddingparty.tpl");
