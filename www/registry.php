<?php

include 'lib/core.inc.php';

$wedding = new core();

$wedding->smarty->assign('registry_links', $wedding->getRegistryLinks());
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->display("registry.tpl");