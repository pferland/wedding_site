<?php

include 'lib/core.inc.php';

$wedding = new core();
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());

$error = null;
switch(strtolower(@$_POST['step']))
{
    case "submit":
        $error = array();
        $reload = 0;
        $step_values = array();

        $step_values['attending'] = filter_input(INPUT_POST, 'attending', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['firstname'] = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['lastname'] = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['comment'] = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        if( empty($step_values['attending']) )
        {
            $reload = 1;
            $error[] = "You did not specify if you were accepting or declining.";
        }

        if( ( empty($step_values['firstname']) or empty($step_values['lastname']) ) && ( strtolower($step_values['attending']) === 'yes'))
        {
            $reload = 1;
            $error[] = "You said you are attending, but did not enter a First or Last Name";
        }

        $step_values['noguest'] = (int) filter_input(INPUT_POST, 'noguest', FILTER_SANITIZE_NUMBER_INT);
        $step_values['guest_firstname'] = filter_input(INPUT_POST, 'guest_firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['guest_lastname'] = filter_input(INPUT_POST, 'guest_lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['foodallergies'] = filter_input(INPUT_POST, 'foodallergies', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        if( (empty($step_values['guest_lastname']) && !$step_values['noguest']) or (empty($step_values['guest_firstname']) && !$step_values['noguest']) )
        {
            $reload = 1;
            $error[] = "You indicated you were inviting a guest, but did not enter a First or Last Name.";
        }

        if( (!empty($step_values['guest_firstname']) && $step_values['noguest']) or ( (!empty($step_values['guest_lastname']) && $step_values['noguest']) ) )
        {
            $reload = 1;
            $error[] = "You indicated you were not inviting a guest, but entered a name.";
        }

        $step_values['norequest'] = (int) filter_input(INPUT_POST, 'norequest', FILTER_SANITIZE_NUMBER_INT);
        $step_values['song_name'] = filter_input(INPUT_POST, 'song_name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['song_artist'] = filter_input(INPUT_POST, 'song_artist', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

        if( (empty($step_values['norequest']) && empty($step_values['song_name'])) or (empty($step_values['norequest']) && empty($step_values['song_artist'])) )
        {
            $reload = 1;
            $error[] = "You indicated you had a song request, but did not enter all the information.";
        }

        if($reload)
        {
            $wedding->smarty->assign("error_array", $error);
            $wedding->smarty->assign("firstname", $step_values['firstname']);
            $wedding->smarty->assign("lastname", $step_values['lastname']);
            $wedding->smarty->assign("comment", $step_values['comment']);
            $wedding->smarty->assign("error_array", $error);
            $wedding->smarty->assign("guest_firstname", $step_values['guest_firstname']);
            $wedding->smarty->assign("guest_lastname", $step_values['guest_lastname']);
            $wedding->smarty->assign("foodallergies", $step_values['foodallergies']);

            $wedding->smarty->assign("song_artist", $step_values['song_artist']);
            $wedding->smarty->assign("song_name", $step_values['song_name']);

            if($step_values['noguest'] == 1)
            {
                $wedding->smarty->assign("noguest", 'checked');
            }else
            {
                $wedding->smarty->assign("noguest", '');
            }
            if($step_values['norequest'] == 1)
            {
                $wedding->smarty->assign("norequest", 'checked');
            }else
            {
                $wedding->smarty->assign("norequest", '');
            }

            $wedding->smarty->display("rsvp.tpl");
            break;
        }

        $val_ret = $wedding->validateRsvpData($step_values);
        if($val_ret !== 0)
        {
            $wedding->smarty->assign('error_array', $val_ret);
            $wedding->smarty->display("rsvp_error.tpl");
            break;
        }else
        {
            #var_dump($step_values);
            $return = $wedding->insertRsvpData($step_values);
            if ($return !== 0) {
                $wedding->smarty->assign('error_array', $return);
                $wedding->smarty->display("rsvp_error.tpl");
            }
            $wedding->smarty->display("rsvp_final.tpl");
        }
        break;

    default:
		$wedding->smarty->assign("error_array", $error);
        $wedding->smarty->display("rsvp.tpl");
        break;
}