<?php

include 'lib/core.inc.php';

$wedding = new core();
$wedding->smarty->assign('daysuntil', $wedding->daysUntil());
$wedding->smarty->assign('rsvp_comment_txt_limit', $wedding->rsvp_comment_txt_limit);

$error = null;
switch(strtolower(@$_POST['step']))
{
    case "enterguests":
        $attending = filter_input(INPUT_POST, 'attending', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $firstname = ucwords(strtolower(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
        $lastname = ucwords(strtolower(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $song_name = filter_input(INPUT_POST, 'song_name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $song_artist = filter_input(INPUT_POST, 'song_artist', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $norequest = filter_input(INPUT_POST, 'norequest', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

        if( empty($attending) )
        {
            $reload = 1;
            $error[] = "You did not specify if you were accepting or declining.";
        }

        if( ( empty($firstname) or empty($lastname) ))
        {
            $reload = 1;
            $error[] = "You did not enter a First or Last Name";
        }

        if($reload)
        {

            $wedding->SentRSVPAlert($step_values, $_SERVER['REMOTE_ADDR'] . "  X-Forward: " . @$_SERVER['HTTP_X_FORWARDED_FOR']);
            $wedding->smarty->assign("error_array", $wedding->WordWrapArray($error));
            $wedding->smarty->assign("firstname", $firstname);
            $wedding->smarty->assign("lastname", $lastname);
            $wedding->smarty->assign("comment", $comment);

            if($norequest == 1)
            {
                $wedding->smarty->assign("norequest", 'checked');
                $wedding->smarty->assign("song_artist", "");
                $wedding->smarty->assign("song_name", "");
            }else
            {
                $wedding->smarty->assign("norequest", '');
                $wedding->smarty->assign("song_artist", $song_artist);
                $wedding->smarty->assign("song_name", $song_name);
            }
            $wedding->smarty->display("rsvp.tpl");
            break;
        }

        $num_allowed_guests = $wedding->getAllowedGuestsForAttendee($firstname, $lastname);
        $guest_form_array = array();
        if ( $num_allowed_guests > 0 )
        {
            $GuestData = $wedding->getRsvpGuestData($firstname, $lastname);
            #var_dump($firstname, $lastname, $GuestData);

            if($GuestData[1] != "")
            {
                $wedding->smarty->assign("title", $GuestData[0]);
                $wedding->smarty->assign("partnerfirstname", $GuestData[1]);
                $wedding->smarty->assign("partnerlastname", $GuestData[2]);
            }
            $loop = $num_allowed_guests + 1;
            for ($i = 1; ; $i++) {
                if ($i == $loop) {
                    break;
                }
                $guest_form_array[$i]['number'] = $i;
            }
        }else
        {
            $GuestData = $wedding->getRsvpGuestData($firstname, $lastname);
            #var_dump($firstname, $lastname, $GuestData);

            $wedding->smarty->assign("title", $GuestData[0]);
            $wedding->smarty->assign("partnerfirstname", $GuestData[1]);
            $wedding->smarty->assign("partnerlastname", $GuestData[2]);
            #exit(1);
        }
        $wedding->smarty->assign("error_array", $wedding->WordWrapArray($error));
        $wedding->smarty->assign("attending", $attending);
        $wedding->smarty->assign("firstname", $firstname);
        $wedding->smarty->assign("lastname", $lastname);
        $wedding->smarty->assign("comment", $comment);
        $wedding->smarty->assign("song_name", $song_name);
        $wedding->smarty->assign("song_artist", $song_artist);

        $wedding->smarty->assign("number_allowed_guest_form_array", $guest_form_array);
        $wedding->smarty->assign("number_allowed_guests", $num_allowed_guests);
        $wedding->smarty->display("rsvp_step2.tpl");

        break;

    case "submit":
        $error = array();
        $reload = 0;
        $step_values = array();

        $step_values['attending'] = filter_input(INPUT_POST, 'attending', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['firstname'] = ucwords(strtolower(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
        $step_values['lastname'] = ucwords(strtolower(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
        $step_values['comment'] = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $step_values['foodallergies'] = filter_input(INPUT_POST, 'foodallergies', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $step_values['norequest'] = (int) filter_input(INPUT_POST, 'norequest', FILTER_SANITIZE_NUMBER_INT);
        $step_values['song_name'] = filter_input(INPUT_POST, 'song_name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $step_values['song_artist'] = filter_input(INPUT_POST, 'song_artist', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

        $step_values['noguest'] = (int) filter_input(INPUT_POST, 'noguest', FILTER_SANITIZE_NUMBER_INT);
        #var_dump($step_values['noguest']);

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

        $num_allowed_guests = $wedding->getAllowedGuestsForAttendee($step_values['firstname'], $step_values['lastname']);
        $step_values['num_allowed_guests'] = $num_allowed_guests;

        if($num_allowed_guests > 1)
        {
            for($i = 1; $i <= $num_allowed_guests; $i++) {
                $step_values['guest_firstname_' . $i] = ucwords(strtolower(filter_input(INPUT_POST, 'guest_firstname_' . $i, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
                $step_values['guest_lastname_' . $i] = ucwords(strtolower(filter_input(INPUT_POST, 'guest_lastname_' . $i, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));

                if( (empty($step_values['guest_lastname_' . $i]) && !$step_values['noguest']) or (empty($step_values['guest_firstname_' . $i]) && !$step_values['noguest']) )
                {
                    $reload = 1;
                    $error[] = "You indicated you were inviting a guest, but did not enter a First or Last Name for Guest#".$i;
                }

                if( (!empty($step_values['guest_firstname_' . $i]) && $step_values['noguest']) or ( (!empty($step_values['guest_lastname_' . $i]) && $step_values['noguest']) ) )
                {
                    $reload = 1;
                    $error[] = "You indicated you were not inviting a guest, but entered a name for Guest #".$i;
                }
            }
        }else
        {
            $step_values['guest_firstname'] = ucwords(strtolower(filter_input(INPUT_POST, 'guest_firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));
            $step_values['guest_lastname'] = ucwords(strtolower(filter_input(INPUT_POST, 'guest_lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)));

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
        }

        if( (empty($step_values['norequest']) && empty($step_values['song_name'])) or (empty($step_values['norequest']) && empty($step_values['song_artist'])) )
        {
            $reload = 1;
            $error[] = "You indicated you had a song request, but did not enter all the information.";
        }
        if($reload)
        {
            $step_values['error_msg_array'] = $error;
            $wedding->SentRSVPAlert($step_values, $_SERVER['REMOTE_ADDR'] . "  X-Forward: " . @$_SERVER['HTTP_X_FORWARDED_FOR'], true);
            $wedding->smarty->assign("error_array", $wedding->WordWrapArray($error));
            $wedding->smarty->assign("firstname", $step_values['firstname']);
            $wedding->smarty->assign("lastname", $step_values['lastname']);
            $wedding->smarty->assign("comment", $step_values['comment']);
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

            $wedding->smarty->display("rsvp_step2.tpl");
            break;
        }
        $val_ret = $wedding->validateRsvpData($step_values);
        if(!is_numeric($val_ret))
        {
            $step_values['__NotValidated'] = $val_ret;
            $error[] = $val_ret;
            $wedding->SentRSVPAlert($step_values, $_SERVER['REMOTE_ADDR'] . "  X-Forward: " . @$_SERVER['HTTP_X_FORWARDED_FOR'], true);
            $wedding->smarty->assign('error_array', $wedding->WordWrapArray($error));
            $wedding->smarty->display("rsvp_error.tpl");
            break;
        }else
        {
            $step_values['validate_id'] = (int) $val_ret;
            #var_dump($step_values);
            #exit();
            $return = $wedding->insertRsvpData($step_values);
            $step_values['insert_return'] = $return;
            if (!is_numeric($return)) {
                $error[] = $return;
                $wedding->SentRSVPAlert($step_values, $_SERVER['REMOTE_ADDR'] . "  X-Forward: " . @$_SERVER['HTTP_X_FORWARDED_FOR'], true);
                $wedding->smarty->assign('error_array', $wedding->WordWrapArray($error));
                $wedding->smarty->display("rsvp_error.tpl");
            }
            $wedding->SentRSVPAlert($step_values, $_SERVER['REMOTE_ADDR'] . "  X-Forward: " . @$_SERVER['HTTP_X_FORWARDED_FOR']);
            $wedding->smarty->display("rsvp_final.tpl");
        }
        break;

    default:
		$wedding->smarty->assign("error_array", $wedding->WordWrapArray($error));
        $wedding->smarty->display("rsvp.tpl");
        break;
}