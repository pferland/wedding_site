<?php

class reports
{
    private $core = null;
    private $db = null;
    function __construct()
    {
        include "config.inc.php";
        #include $www_dev_root."lib/config.inc.php";
        #include $www_dev_root."lib/SQL.php";
        include $www_root."lib/config.inc.php";
        include $www_root."lib/SQL.php";

        $this->db = $db;
        $this->SQL = new SQL( array('host'=> $sql_host, 'srvc'=> $srvc, 'db'=> $this->db,'db_user'=> $sql_user,'db_pwd'=> $sql_pwd,'collate'=> 'utf8') );
    }

    function GetRSVPs()
    {
        $result = $this->SQL->conn->query("SELECT * FROM `$this->db`.`rsvp_confirmed`");
        $fetch = $result->fetchAll(2);
        #var_dump($fetch);
        $non_validated = 0;
        $validated = 0;
        foreach($fetch as $row)
        {
            print "==============================================\r\n";
            if ($row["validate_id"] == 0)
            {
                print "Non-Validated Entry:\r\n";
                var_dump($row);
                $non_validated++;
                continue;
            }
            $validated++;
            print "Validated Entry:\r\n";
            var_dump($row);
        }
        print "\r\n\r\n\r\n";
        print "-------------------------------------------------\r\n";
        print "Validated Entries: ".$validated."\r\n";
        print "Non-Validated Entries: ".$non_validated."\r\n";
        print "-------------------------------------------------\r\n";

        return $fetch;
    }

}