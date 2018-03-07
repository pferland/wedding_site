<?php

include 'lib/core.inc.php';

$wedding = new core();
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->assign('guestbook_txt_limit', $wedding->guestbook_txt_limit);

$error = null;
switch(strtolower(@$_REQUEST['step']))
{
    case "submit":
        $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $data['message'] = nl2br(htmlentities($_REQUEST['message'])); // Encode to HTML Entities first, then covert /n to <br>

        $ret = $wedding->insertGuestBookPost($data);
        if($ret === 0)
        {
            $message = "Thank you for signing our Guest Book!";
        }else{
            $message = "There was an error with submitting your message " . $ret ;
        }
        $wedding->smarty->assign('message', $message);
        $wedding->smarty->assign("guests", $wedding->getGuestBookPosts());
        $wedding->smarty->display('guestbook_submit.tpl');
        break;

    case "view":
        $entry = filter_input(INPUT_GET, 'entry', FILTER_SANITIZE_NUMBER_INT);
        $entry_data = $wedding->getGuestBookEntry($entry);
        $wedding->smarty->assign('guestname', $entry_data['name']);
        $wedding->smarty->assign('guesttime', $entry_data['time']);
        $wedding->smarty->assign('guestmessage', $entry_data['message']);
        $wedding->smarty->display('guestbook_view.tpl');
        break;

    default:
        $guests = $wedding->getGuestBookPosts();
        $wedding->smarty->assign("guests", $guests);
        $wedding->smarty->display("guestbook.tpl");
        break;
}
