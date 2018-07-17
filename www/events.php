<?php

include 'lib/core.inc.php';

$wedding = new core();
$wedding->smarty->assign('daysuntil', 0);


$wedding->smarty->display("EventSign.tpl");
