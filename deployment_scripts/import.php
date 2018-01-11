<?php

if(!is_file($argv[1]))
{
    print("You need to define a config file for the site that you want to import the RSVP data into.\r\n
    Example:
        php import.php /var/www/lib/config.inc.php
    Or:
        php import.php templates/prod/config.inc.php
    ");
    exit(1);
}else {

    require($argv[1]);
}

$addresses = array();
$fp = fopen('address.csv', 'r');
while ( !feof($fp) )
{
    $line = fgets($fp, 2048);
    if($line !== false)
    {
        $addresses[] = str_getcsv($line, ",");
    }
}
fclose($fp);

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_PERSISTENT => TRUE,
);
$dsn = $srvc.':host='.$sql_host;
$conn = new PDO($dsn, $sql_user, $sql_pwd, $options);

$prep = $conn->prepare("INSERT INTO `$db`.`rsvp_validate` (`title`, `firstname`, `middlename`, `lastname`, `partnertitle`, `partnerfirstname`, `partnermiddlename`, `partnerlastname`, `namestogether`, `namesformal`, `namessuper-formal`, `namesfamily`, `company`, `address1`, `address2`, `city`, `stateregion`, `postalcode`, `country`, `mainphone`, `cellphone`, `homephone`, `email`, `birthday`, `partnerbirthday`, `anniversary`, `notes`, `groups`, `lastupdated`, `guest`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach($addresses as $key=>$address)
{
    if($key === 0)
    {
        continue;
    }

    #var_dump(is_numeric($address[14]));
    #var_dump($address[14]);

    if(is_numeric($address[14]))
    {
        $address2_alter = "#" . $address[14];
    }else
    {
        $address2_alter = $address[14];
    }

    print($address[1]." ".$address[3]."\r\n");

    $postalcode_alter = str_pad($address[17], 5, "0", STR_PAD_LEFT);

    $prep->bindParam(1, $address[0], PDO::PARAM_STR);
    $prep->bindParam(2, $address[1], PDO::PARAM_STR);
    $prep->bindParam(3, $address[2], PDO::PARAM_STR);
    $prep->bindParam(4, $address[3], PDO::PARAM_STR);
    $prep->bindParam(5, $address[4], PDO::PARAM_STR);
    $prep->bindParam(6, $address[5], PDO::PARAM_STR);
    $prep->bindParam(7, $address[6], PDO::PARAM_STR);
    $prep->bindParam(8, $address[7], PDO::PARAM_STR);
    $prep->bindParam(9, $address[8], PDO::PARAM_STR);
    $prep->bindParam(10, $address[9], PDO::PARAM_STR);
    $prep->bindParam(11, $address[10], PDO::PARAM_STR);
    $prep->bindParam(12, $address[11], PDO::PARAM_STR);
    $prep->bindParam(13, $address[12], PDO::PARAM_STR);
    $prep->bindParam(14, $address[13], PDO::PARAM_STR);
    $prep->bindParam(15, $address2_alter, PDO::PARAM_STR);
    $prep->bindParam(16, $address[15], PDO::PARAM_STR);
    $prep->bindParam(17, $address[16], PDO::PARAM_STR);
    $prep->bindParam(18, $postalcode_alter, PDO::PARAM_STR);
    $prep->bindParam(19, $address[18], PDO::PARAM_STR);
    $prep->bindParam(20, $address[19], PDO::PARAM_STR);
    $prep->bindParam(21, $address[20], PDO::PARAM_STR);
    $prep->bindParam(22, $address[21], PDO::PARAM_STR);
    $prep->bindParam(23, $address[22], PDO::PARAM_STR);
    $prep->bindParam(24, $address[23], PDO::PARAM_STR);
    $prep->bindParam(25, $address[24], PDO::PARAM_STR);
    $prep->bindParam(26, $address[25], PDO::PARAM_STR);
    $prep->bindParam(27, $address[26], PDO::PARAM_STR);
    $prep->bindParam(28, $address[27], PDO::PARAM_STR);
    $prep->bindParam(29, $address[28], PDO::PARAM_STR);
    $prep->bindParam(30, $address[29], PDO::PARAM_INT);

    $prep->execute();

    $err = $prep->errorInfo();

    if($err[0] !== "00000") {
        exit($err[2]);
    }
}