<?php
error_reporting(E_ALL);
class core
{
    private $GuestBookAlertSendToEmail;
    private $GuestBookAlertSendFromEmail;
    private $GuestBookAlertSendFromEmail_PWD;
    public $GuestBookAlertSendFlag;
    private $RSVPAlertSendToEmail;
    private $RSVPAlertSendFromEmail;
    private $RSVPAlertSendFromEmail_PWD;
    public $RSVPAlertSendEmailFlag;
    public $guestbook_txt_limit;
    public $rsvp_comment_txt_limit;
    private $SpamArray;
    public $http_folder;
    public $template_folder;
    public $endDate;
    public $smarty;
    private $SQL;
    private $db;
    public $env;

    function __construct()
    {
        include 'config.inc.php';
        include 'SQL.php';
        require 'smarty/Smarty.class.php';

        $this->env = @$env;

        $this->GuestBookAlertSendToEmail = $GuestBookAlertSendToEmail;
        $this->GuestBookAlertSendFromEmail = $GuestBookAlertSendFromEmail;
        $this->GuestBookAlertSendFromEmail_PWD = $GuestBookAlertSendFromEmail_PWD;
        $this->GuestBookAlertSendFlag = $GuestBookAlertSendFlag;
        $this->RSVPAlertSendToEmail = $RSVPAlertSendToEmail;
        $this->RSVPAlertSendFromEmail = $RSVPAlertSendFromEmail;
        $this->RSVPAlertSendFromEmail_PWD = $RSVPAlertSendFromEmail_PWD;
        $this->RSVPAlertSendEmailFlag = $RSVPAlertSendEmailFlag;
        $this->RSVPAlertSendTextFlag = $RSVPAlertSendTextFlag;
        $this->RSVPAlertSendTextEmail = $RSVPAlertSendTextEmail;
        $this->guestbook_txt_limit = $guestbook_txt_limit;
        $this->rsvp_comment_txt_limit = $rsvp_comment_txt_limit;

        $this->SpamArray = $GuestbookSpamList;

        $this->http_folder = $http_folder;
        $this->template_folder = $template_folder;

        $this->smarty = new smarty();
        $this->smarty->setCompileDir($http_folder."templates_c");
        $this->smarty->setTemplateDir($http_folder.$template_folder);
        $this->smarty->assign('site_url', $site_url);
        $this->smarty->assign('template_url', $site_url.$template_folder);

        $this->db = $db;
        $this->SQL = new SQL( array('host'=> $sql_host, 'srvc'=> $srvc, 'db'=> $this->db,'db_user'=> $sql_user,'db_pwd'=> $sql_pwd,'collate'=> 'utf8') );

        $this->endDate = $this->getWeddingDate()["wedding_date"];  // $end_date is defined in the config.inc.php file.
    }

    function daysUntil()
    {
        $now = time();
        $your_date = strtotime($this->endDate);
        $datediff = $now - $your_date;

        return (floor($datediff / (60 * 60 * 24))/ (-1));
    }

    function SendGuestBookAlert($guestname, $message, $id, $ip, $spam = false)
    {
        if($this->GuestBookAlertSendFlag)
        {
            if($spam)
            {
                $subject = 'There was an attempt to add a new entry the '.$this->env.'GuestBook ID: '.$id.'  ( '.date("Y-m-d H:i:s").' )';
            }else
            {
                $subject = 'There was a new entry added to the '.$this->env.'GuestBook ID: '.$id.'  ( '.date("Y-m-d H:i:s").' )';
            }

            $template = file_get_contents($this->http_folder.$this->template_folder."/guestbook_alert.tpl");

            // Message
            $compiled = str_replace('{$message}', $message, $template);

            $compiled = str_replace('{$guestname}', $guestname, $compiled);

            $compiled = str_replace('{$guesttime}', date("Y-m-d H:i:s"), $compiled);

            $compiled = str_replace('{$guestIP}', $ip, $compiled);

            $compiled = str_replace('{$guestID}', $id, $compiled);

            $compiled = str_replace('{$guestmessage}', $message, $compiled);

            $this->SendEmail( $this->GuestBookAlertSendToEmail, $this->GuestBookAlertSendFromEmail, $this->GuestBookAlertSendFromEmail_PWD, $subject, $compiled);
        }
        if($this->RSVPAlertSendTextFlag)
        {
            $this->SendEmail($this->RSVPAlertSendTextEmail, $this->RSVPAlertSendFromEmail, $this->RSVPAlertSendFromEmail_PWD, $subject, $data_string);
        }
    }

    function SentRSVPAlert($data, $ip, $error_flag = false)
    {
        if($this->RSVPAlertSendEmailFlag)
        {
            $data['Remote_IP'] = $ip;
            $data_string = "<p>" . var_export($data, true) . "</p>";

            if($error_flag)
            {
                $subject = "New Attempt At Registering For '.$this->env.'RSVP ( " . date("Y-m-d H:i:s") . "  )";
            }else
            {
                $subject = "New Successful Registration For '.$this->env.'RSVP ( " . date("Y-m-d H:i:s") . "  )";
            }
            $this->SendEmail($this->RSVPAlertSendToEmail, $this->RSVPAlertSendFromEmail, $this->RSVPAlertSendFromEmail_PWD, $subject, $data_string);
        }
        if($this->RSVPAlertSendTextFlag)
        {
            $this->SendEmail($this->RSVPAlertSendTextEmail, $this->RSVPAlertSendFromEmail, $this->RSVPAlertSendFromEmail_PWD, $subject, $data_string);
        }
    }

    function SendEmail($to, $from, $from_pwd, $subject = 'There was a new entry added to the GuestBook', $message)
    {
        require_once 'Mail.php';
        require_once 'Mail/mime.php';

        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );

        // Creating the Mime message
        $mime = new Mail_mime("\n");

        // Setting the body of the email
        $mime->setHTMLBody($message);

        $body = $mime->get();
        $headers = $mime->headers($headers);

        // Sending the email
        $mail =& Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => $from,
            'password' => $from_pwd
        ));
        $sent = $mail->send($this->GuestBookAlertSendToEmail, $headers, $body);
        if (PEAR::isError($sent)) {
            echo($sent->getMessage());
            return 1;
        } else {
            #echo('Message successfully sent!');
            return 0;
        }
    }

    function getAllowedGuestsForAttendee($firstname = "", $lastname = "")
    {
        $firstname_like = substr($firstname, 0, 4).'%';
        $lastname_like = substr($lastname, 0, 4).'%';
        $prep_c = $this->SQL->conn->prepare("SELECT guest FROM `$this->db`.rsvp_validate WHERE firstname like ? AND lastname LIKE ? OR partnerfirstname like ? AND partnerlastname LIKE ?");
        $prep_c->bindparam(1, $firstname_like, PDO::PARAM_STR);
        $prep_c->bindparam(2, $lastname_like, PDO::PARAM_STR);
        $prep_c->bindparam(3, $firstname_like, PDO::PARAM_STR);
        $prep_c->bindparam(4, $lastname_like, PDO::PARAM_STR);

        $prep_c->execute();

        $err = $prep_c->errorInfo();

        if($err[0] !== "00000")
        {
            return $err[2];
        }

        $ret = $prep_c->fetchAll(2);
        if(is_null(@$ret[0]))
        {
            return 0;
        }else
        {
            return (int) $ret[0]['guest'];
        }
    }

    function getGuestBookEntry($entry = 0)
    {
        if($entry === 0)
        {
            return "Invalid Entry Record supplied";
        }
        $prep = $this->SQL->conn->prepare("SELECT * FROM `$this->db`.guestbook WHERE id = ?");
        $prep->bindParam(1, $entry, PDO::PARAM_INT);
        $prep->execute();
        $err = $prep->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }

        return $prep->fetchAll(2)[0];
    }

    function getGuestBookPosts()
    {
        $query = $this->SQL->conn->query("SELECT * FROM `$this->db`.guestbook ORDER BY id ASC");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        #var_dump($query->fetchAll(2));
        return $query->fetchAll(2);
    }

    function getCouplePhotos()
    {
        $query = $this->SQL->conn->query("SELECT `photo_path`, `subtext` FROM `$this->db`.couple_photos ORDER BY id ASC");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2);
    }

    function getWeddingPartyPhotos()
    {
        $query = $this->SQL->conn->query("SELECT `photo_path`, `name`, `title` FROM `$this->db`.wedding_party_photos ORDER BY id ASC");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2);
    }

    function getStoryData()
    {
        $query = $this->SQL->conn->query("SELECT story FROM `$this->db`.wedding_story WHERE id = 1");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2)[0];
    }

    function getRegistryLinks()
    {
        $query = $this->SQL->conn->query("SELECT url, img_url FROM `$this->db`.registry_links");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2);
    }

    function getRsvpGuestData($firstname_in, $lastname_in)
    {
        $firstname = substr($firstname_in, 0, 4);
        $lastname = substr($lastname_in, 0, 4);


        $firstname_alt = $firstname.'%';
        $lastname_alt = $lastname.'%';

        $prep_c = $this->SQL->conn->prepare("SELECT `title`, `firstname`, `lastname`, `partnertitle`, `partnerfirstname`, `partnerlastname` FROM `$this->db`.rsvp_validate WHERE firstname like ? AND lastname LIKE ? OR partnerfirstname like ? AND partnerlastname LIKE ?");
        $prep_c->bindparam(1, $firstname_alt, PDO::PARAM_STR);
        $prep_c->bindparam(2, $lastname_alt, PDO::PARAM_STR);
        $prep_c->bindparam(3, $firstname_alt, PDO::PARAM_STR);
        $prep_c->bindparam(4, $lastname_alt, PDO::PARAM_STR);

        $prep_c->execute();

        $err = $prep_c->errorInfo();

        if($err[0] !== "00000")
        {
            return $err[2];
        }
        $fetch = @$prep_c->fetchAll(2)[0];
        #var_dump($fetch);
        if( ($fetch['partnerfirstname'] == "") OR ($fetch['partnerlastname'] == ""))
        {
            //They have no partner and are not allowed a guest.
            return 0;
        }

        if( $firstname == substr($fetch['partnerfirstname'], 0, 4) AND  $lastname == substr($fetch['partnerlastname'], 0, 4))
        {
            return array($fetch['title'], $fetch['firstname'], $fetch['lastname']);

        }elseif($firstname == substr($fetch['firstname'], 0, 4) AND  $lastname == substr($fetch['lastname'], 0, 4))
        {
            return array($fetch['partnertitle'], $fetch['partnerfirstname'], $fetch['partnerlastname']);
        }else
        {
            return 1;
        }
    }

    function getWeddingDate()
    {
        $query = $this->SQL->conn->query("SELECT `wedding_date` FROM `$this->db`.details_page_info WHERE id = 1");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            #var_dump($err);
            return array();
        }
        #var_dump($query->fetch(2));
        return $query->fetch(2);
    }

    function getWeddingDetails()
    {
        $query = $this->SQL->conn->query("SELECT wedding_location_name, wedding_town, wedding_date, wedding_time, wedding_gmaps_link, wedding_reception_same_location, 
            hotel_name, hotel_location, hotel_gmaps_link, meet_greet_gmaps_link, meet_greet_text, brunch_gmaps_link, brunch_text, reception_name, reception_town, reception_date, reception_time, reception_gmaps_link, wedding_attire, reception_attire, hotel_room_link, other_info
            FROM `$this->db`.details_page_info WHERE id = 1");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2)[0];
    }

    function getWeddingTown()
    {
        $query = $this->SQL->conn->query("SELECT wedding_town, wedding_location_name FROM `$this->db`.details_page_info WHERE id = 1");
        $err = $this->SQL->conn->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }
        return $query->fetchAll(2)[0];
    }

    function insertGuestBookPost($data)
    {
        if(strlen($data['message']) > $this->guestbook_txt_limit)
        {
            return "Your message is longer than the maximum defined allowed. Please remove some text.";
        }
        if($this->CheckMessageForSpam($data['message']))
        {
            //ret=0 = failed check, we think there is spam in this message.
            // return 0 to make the spammer think that the message was submitted.
            return 0;
        }

        // Insert the message as it has passed all tests.
        $prep_s = $this->SQL->conn->prepare("INSERT INTO `$this->db`.guestbook (`name`, `message`, `time`)  VALUES (?, ?, ?)");
        $prep_s->bindparam(1, $data['name'], PDO::PARAM_STR);
        $prep_s->bindparam(2, $data['message'], PDO::PARAM_STR);
        $prep_s->bindparam(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $prep_s->execute();
        $id = $this->SQL->conn->lastInsertId();

        $err = $prep_s->errorInfo();
        if($err[0] !== "00000")
        {
            return $err;
        }else{
            return $id;
        }
    }

    function CheckMessageForSpam($message = "")
    {
        #var_dump($message);
        foreach($this->SpamArray as $spam)
        {
            #var_dump($spam);
            #var_dump(strpos(strtolower($message), $spam));
            if (strpos(strtolower($message), $spam) !== false)
            {
                #var_dump("spam message found");
                return 1;
            }
        }
        return 0;
    }

    function insertRsvpData($data = array())
    {
        if(empty($data))
        {
            return array("Empty Data array passed to method.");
        }
        #var_dump($data);
        if($this->CheckMessageForSpam($data['comment']))
        {
            //ret=0 = failed check, we think there is spam in this message.
            // return 0 to make the spammer think that the message was submitted.
            return 20;
        }

        if($this->CheckMessageForSpam($data['foodallergies']))
        {
            //ret=0 = failed check, we think there is spam in this message.
            // return 0 to make the spammer think that the message was submitted.
            return 20;
        }

        $prep = $this->SQL->conn->prepare("INSERT INTO `$this->db`.rsvp_confirmed (firstname, lastname, guest_firstname, guest_lastname, attending, `food_allergies`, `comment`, `timestamp`, `validate_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $prep->bindparam(1, $data['firstname'], PDO::PARAM_STR);
        $prep->bindparam(2, $data['lastname'], PDO::PARAM_STR);
        $prep->bindparam(3, $data['guest_firstname'], PDO::PARAM_STR);
        $prep->bindparam(4, $data['guest_lastname'], PDO::PARAM_STR);
        $prep->bindparam(5, $data['attending'], PDO::PARAM_STR);
        $prep->bindparam(6, $data['foodallergies'], PDO::PARAM_STR);
        $prep->bindparam(7, $data['comment'], PDO::PARAM_STR);
        $prep->bindparam(8, date("M d, Y  H:i:s"), PDO::PARAM_STR);
        $prep->bindparam(9, $data['validate_id'], PDO::PARAM_INT);
        $prep->execute();

        $arr = $prep->errorInfo();
        if($arr[0] !== "00000")
        {
            #var_dump($arr);
            return $arr;
        }

        $rsvp_id = $this->SQL->conn->lastInsertId();
        #var_dump($rsvp_id);

        if(!$data['noguest'])
        {
            $prep_g = $this->SQL->conn->prepare("INSERT INTO `$this->db`.rsvp_guests (id, rsvp_id, firstname, lastname) VALUES ('', ?, ?, ?)");
            if($data['num_allowed_guests'] > 1)
            {
                for($i=1; $i<=$data['num_allowed_guests']; $i++)
                {
                    $prep_g->bindparam(1, $rsvp_id, PDO::PARAM_INT);
                    $prep_g->bindparam(2, $data['guest_firstname_'.$i], PDO::PARAM_STR);
                    $prep_g->bindparam(3, $data['guest_lastname_'.$i], PDO::PARAM_STR);
                    $prep_g->execute();

                    $arr = $prep_g->errorInfo();

                    if ($arr[0] !== "00000") {
                        return $arr;
                    }
                }
            }else
            {
                $prep_g->bindparam(1, $rsvp_id, PDO::PARAM_INT);
                $prep_g->bindparam(2, $data['guest_firstname'], PDO::PARAM_STR);
                $prep_g->bindparam(3, $data['guest_lastname'], PDO::PARAM_STR);
                $prep_g->execute();

                $arr = $prep_g->errorInfo();

                if ($arr[0] !== "00000") {
                    return $arr;
                }
            }

        }

        if(!$data['norequest'])
        {
            $prep_s = $this->SQL->conn->prepare("INSERT INTO `$this->db`.`song_request` (id, rsvp_id, song_title, song_artist) VALUES ('', ?, ?, ?)");
            $prep_s->bindparam(1, $rsvp_id, PDO::PARAM_INT);
            $prep_s->bindparam(2, $data['song_name'], PDO::PARAM_STR);
            $prep_s->bindparam(3, $data['song_artist'], PDO::PARAM_STR);

            $prep_s->execute();
            $arr = $prep_s->errorInfo();
            if ($arr[0] !== "00000") {
                return $arr[2];
            }
        }
        return $rsvp_id;
    }

    function validateRsvpData($data = array())
    {
        if(empty($data))
        {
            return array("Empty Data array passed to method.");
        }

        $firstname_like = substr($data['firstname'], 0, 4).'%';
        $lastname_like = substr($data['lastname'], 0, 4).'%';
        $prep_c = $this->SQL->conn->prepare("SELECT `id` FROM `$this->db`.rsvp_validate WHERE firstname like ? AND lastname LIKE ? OR partnerfirstname like ? AND partnerlastname LIKE ?");
        $prep_c->bindparam(1, $firstname_like, PDO::PARAM_STR);
        $prep_c->bindparam(2, $lastname_like, PDO::PARAM_STR);
        $prep_c->bindparam(3, $firstname_like, PDO::PARAM_STR);
        $prep_c->bindparam(4, $lastname_like, PDO::PARAM_STR);

        $prep_c->execute();

        $err = $prep_c->errorInfo();
        #var_dump($err);
        if($err[0] != "00000")
        {
            return $err[2];
        }
        $fetch = @$prep_c->fetchAll(2)[0];
        /*if($fetch == false)
        {
            #var_dump("Welp, that sucks for you...");
            //return "I am sorry you were not found in the RSVP List, ".$data['firstname']." ".$data['lastname']. " </br> Please contact Gayle or Phil for assistance.";
        }*/
        #var_dump($fetch);

        $prep_s = $this->SQL->conn->prepare("SELECT id FROM `$this->db`.rsvp_confirmed WHERE firstname like ? AND lastname LIKE ?");
        $prep_s->bindparam(1, $firstname, PDO::PARAM_STR);
        $prep_s->bindparam(2, $lastname, PDO::PARAM_STR);
        $prep_s->execute();

        $err = $prep_s->errorInfo();

        if($err[0] !== "00000")
        {
            return $err[2];
        }
        $fetch_s = $prep_s->fetchAll(2);

        #var_dump($fetch_s);

        if(empty($fetch_s) and !empty($fetch['id']))
        {
            return $fetch['id'];

        }elseif(empty($fetch['id']))
        {
            return 0;

        }elseif(!empty($fetch_s['id']))
        {
            return "You have already submitted your RSVP. If you were looking to make a change, please call, text, or email Phil or Gayle.";
        }
    }

    function WordWrapArray($array)
    {
        $return = array();
        foreach( $array as $key=>$element)
        {
            $return[] = wordwrap($element, 50, "<br>", true);
        }
        return $return;
    }
}