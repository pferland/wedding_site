<?php

include "/var/www/dev-html/lib/core.inc.php";

$wedding = new core();

$result = $wedding->SQL->conn->query("SELECT id, firstname, lastname, partnerfirstname, partnerlastname FROM wedding_dev.rsvp_validate");
$fetch = $result->fetchAll(2);
$attend_array = array(
    'Yes',
    'No',
);
$comment_array = array(
    'random comment',
    'Another Random Comment',
    'Hpe you guys for the best!',
    'Misspelled comment with no context',
    "Woot! There it is!",
    "Oh come on... there has to be something better..."
);
$food_array = array(
    'Yes',
    'No',
    'mayo',
    'nutmeg',
    'fish',
    'all food',
    'yup thats right, all food'
);

foreach($fetch as $row)
{
    $attend_key = array_rand($attend_array);
    $attend = $attend_array[$attend_key];

    $comment_key = array_rand($comment_array);
    $comment = $comment_array[$comment_key];

    $food_key = array_rand($food_array);
    $food = $food_array[$food_key];

    $timestamp = date("M d, Y  H:i:s");

    $prep = $wedding->SQL->conn->prepare("INSERT INTO `wedding_dev`.`rsvp_confirmed` 
        (`firstname`, `lastname`, `guest_firstname`, `guest_lastname`, `attending`, `food_allergies`, `comment`, `timestamp`, `validate_id`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $prep->bindParam(1, $row['firstname'], PDO::PARAM_STR);
    $prep->bindParam(2, $row['lastname'], PDO::PARAM_STR);
    $prep->bindParam(3, $row['partnerfirstname'], PDO::PARAM_STR);
    $prep->bindParam(4, $row['partnerfirstname'], PDO::PARAM_STR);
    $prep->bindParam(5, $attend, PDO::PARAM_STR);
    $prep->bindParam(6, $food, PDO::PARAM_STR);
    $prep->bindParam(7, $comment, PDO::PARAM_STR);
    $prep->bindParam(8, $timestamp, PDO::PARAM_STR);
    $prep->bindParam(9, $row['id'], PDO::PARAM_INT);

    $prep->execute();
    var_dump($wedding->SQL->conn->errorInfo()[0]);
    print $row['firstname']." ".$row['lastname']." - ".$row['id']."\r\n";

}