<?php


class core
{
    public $guestbook_txt_limit;
    public $endDate;
    public $smarty;
    private $SQL;


    function __construct()
    {
        include 'config.inc.php';
        include 'SQL.php';
        require 'smarty/Smarty.class.php';

        $this->endDate = $end_date;  // $end_date is defined in the config.inc.php file.
        $this->guestbook_txt_limit = $guestbook_txt_limit;

        $this->smarty = new smarty();
        $this->smarty->template_dir = $http_folder.$template_folder;
        $this->smarty->assign('site_url', $site_url);
        $this->smarty->assign('template_url', $site_url.$template_folder);

        $this->SQL = new SQL( array('host'=> $sql_host, 'srvc'=> $srvc, 'db'=> $db,'db_user'=> $sql_user,'db_pwd'=> $sql_pwd,'collate'=> 'utf8') );
    }

    function daysUntil()
    {
        $now = time(); // or your date as well
        $your_date = strtotime($this->endDate);
        $datediff = $now - $your_date;

        return (floor($datediff / (60 * 60 * 24))/ (-1));
    }

    function insertRsvpData($data = array())
    {
        if(empty($data))
        {
            return array("Empty Data array passed to method.");
        }

        #var_dump($data);
        $prep = $this->SQL->conn->prepare("INSERT INTO `wedding`.rsvp_confirmed (firstname, lastname, guest, attending, food_allergies, comment, `timestamp`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if($data['noguest'])
        {
            $guest = 0;
        }else
        {
            $guest = 1;
        }
        $prep->bindparam(1, $data['firstname'], PDO::PARAM_STR);
        $prep->bindparam(2, $data['lastname'], PDO::PARAM_STR);
        $prep->bindparam(3, $guest, PDO::PARAM_STR);
        $prep->bindparam(4, $data['attending'], PDO::PARAM_STR);
        $prep->bindparam(5, $data['foodallergies'], PDO::PARAM_STR);
        $prep->bindparam(6, $data['comment'], PDO::PARAM_STR);
        $prep->bindparam(7, date("M d, Y  H:i:s"), PDO::PARAM_STR);
        $prep->execute();

        $arr = $prep->errorInfo();
        if($arr[0] !== "00000")
        {
            #var_dump($arr);
            return $arr[0];
        }

        $rsvp_id = $this->SQL->conn->lastInsertId();
        #var_dump($rsvp_id);

        $prep_g = $this->SQL->conn->prepare("INSERT INTO `wedding`.rsvp_guests (id, rsvp_id, firstname, lastname) VALUES ('', ?, ?, ?)");

        $prep_g->bindparam(1, $rsvp_id, PDO::PARAM_INT);
        $prep_g->bindparam(2, $data['guest_firstname'], PDO::PARAM_STR);
        $prep_g->bindparam(3, $data['guest_lastname'], PDO::PARAM_STR);

        $prep_g->execute();
        $arr = $prep_g->errorInfo();
        if($arr[0] !== "00000")
        {
            return $arr[2];
        }

        $prep_s = $this->SQL->conn->prepare("INSERT INTO `wedding`.`song_request` (id, rsvp_id, song_title, song_artist) VALUES ('', ?, ?, ?)");
        $prep_s->bindparam(1, $rsvp_id, PDO::PARAM_INT);
        $prep_s->bindparam(2, $data['song_name'], PDO::PARAM_STR);
        $prep_s->bindparam(3, $data['song_artist'], PDO::PARAM_STR);

        $prep_s->execute();
        $arr = $prep_s->errorInfo();
        if($arr[0] !== "00000")
        {
            return $arr[2];
        }

        return 0;
    }

    function validateRsvpData($data = array())
    {
        if(empty($data))
        {
            return array("Empty Data array passed to method.");
        }

        $firstname = substr($data['firstname'], 0, 4).'%';
        $lastname = substr($data['lastname'], 0, 4).'%';
        $prep_c = $this->SQL->conn->prepare("SELECT * FROM `wedding`.rsvp_validate WHERE firstname like ? AND lastname LIKE ?");
        $prep_c->bindparam(1, $firstname, PDO::PARAM_STR);
        $prep_c->bindparam(2, $lastname, PDO::PARAM_STR);

        $prep_c->execute();

        $err = $prep_c->errorInfo();

        if($err[0] !== "00000")
        {
            return $err[2];
        }
        $fetch = $prep_c->fetchAll(2)[0];
        #var_dump($fetch);
        if($fetch == false)
        {
            #var_dump("Welp, that sucks for you...");
            return "I am sorry you were not found in the RSVP List, ".$data['firstname']." ".$data['lastname']. " </br> Please contact Gayle or Phil for assistance.";
        }
        $prep_s = $this->SQL->conn->prepare("SELECT * FROM `wedding`.rsvp_confirmed WHERE firstname like ? AND lastname LIKE ?");
        $prep_s->bindparam(1, $fetch['firstname'], PDO::PARAM_STR);
        $prep_s->bindparam(2, $fetch['lastname'], PDO::PARAM_STR);
        $prep_s->execute();

        $err = $prep_s->errorInfo();

        if($err[0] !== "00000")
        {
            return $err[2];
        }
        $fetch_s = $prep_s->fetchAll(2);
        #var_dump($fetch_s);
        if( empty($fetch_s) )
        {
            return 0;
        }else
        {
            return "You have already submitted your RSVP. If you were looking to make a change, please call, text, or email Phil or Gayle.";
        }
    }

    function getGuestBookPosts()
    {
        $query = $this->SQL->conn->query("SELECT * FROM `wedding`.guestbook ORDER BY id ASC");
        $err = $query->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }

        $fetch = $query->fetchAll(2);
        return $fetch;
    }

    function getGuestBookEntry($entry = 0)
    {
        if($entry === 0)
        {
            return "Invalid Entry Record supplied";
        }
        $prep = $this->SQL->conn->prepare("SELECT * FROM `wedding`.guestbook WHERE id = ?");
        $prep->bindParam(1, $entry, PDO::PARAM_INT);
        $prep->execute();
        $err = $prep->errorInfo();
        if($err[0] !== "00000")
        {
            return array();
        }

        $fetch = $prep->fetchAll(2);
        return $fetch;
    }

    function insertGuestBookPost($data)
    {
        if(strlen($data['message']) > $this->guestbook_txt_limit)
        {
            return "Your message is longer than the maximum defined allowed. Please remove some text.";
        }

        $prep_s = $this->SQL->conn->prepare("INSERT INTO `wedding`.guestbook (`name`, `message`, `time`)  VALUES (?, ?, ?)");
        $prep_s->bindparam(1, $data['name'], PDO::PARAM_STR);
        $prep_s->bindparam(2, $data['message'], PDO::PARAM_STR);
        $prep_s->bindparam(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $prep_s->execute();
        $err = $prep_s->errorInfo();
        if($err[0] !== "00000")
        {
            return $err[2];
        }else{
            return 0;
        }
    }
}