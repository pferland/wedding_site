<?php

if(empty($argv[1]))
{
    print("You need to define a config file to be used.\r\nExample:\r\n php deploy.php /wedding_site/deployment scripts/templates/config.inc.php\r\n\r\n");
    exit(1);
}

// Load variables from the config file that is defined in the argv
include($argv[1]);



// Read in SQL template and replace the {{db_name}} with the actual DB name to be used
$sql_source = file_get_contents("templates/wedding_db_template.sql");

$sql_modified = str_replace("{{db_name}}", $db, $sql_source);

var_dump($sql_modified);



// Parse the config.inc.php.sample and replace {{ }} tags with actual values.

