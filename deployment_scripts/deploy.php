<?php

if(empty($argv[1]))
{
    print("You need to define a config file to be used.\r\nExample:\r\n php deploy.php /wedding_site/deployment scripts/templates/config.inc.php\r\n\r\n");
    exit(1);
}else
{
    // Load variables from the config file that is defined in the argv
    include($argv[1]);
    var_dump($sql_host, $sql_user, $sql_pwd, $db, $http_folder, $template_folder, $site_url, $end_date, $guestbook_txt_limit );
}

if( empty($argv[2]) )
{
    print("You need to define a config file to be used.\r\nExample:\r\n php deploy.php scripts/templates/config.inc.php scripts/templates/data.inc.php\r\n\r\n");
    exit(1);
}else
{
    // Load variables from the config file that is defined in the argv
    include($argv[1]);
    var_dump($sql_host, $sql_user, $sql_pwd, $db, $http_folder, $template_folder, $site_url, $end_date, $guestbook_txt_limit );
}

/**************************************************************************/
// Boiler Plate Code
/**************************************************************************/
function prompt_silent($prompt = "Enter Password:") {
    if (preg_match('/^win/i', PHP_OS)) {
        $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
        file_put_contents(
            $vbscript, 'wscript.echo(InputBox("'
            . addslashes($prompt)
            . '", "", "password here"))');
        $command = "cscript //nologo " . escapeshellarg($vbscript);
        $password = rtrim(shell_exec($command));
        unlink($vbscript);
        return $password;
    } else {
        $command = "/usr/bin/env bash -c 'echo OK'";
        if (rtrim(shell_exec($command)) !== 'OK') {
            trigger_error("Can't invoke bash");
            return;
        }
        $command = "/usr/bin/env bash -c 'read -s -p \""
            . addslashes($prompt)
            . "\" mypassword && echo \$mypassword'";
        $password = rtrim(shell_exec($command));
        echo "\n";
        return $password;
    }
}

$dsn = $srvc.':host='.$sql_host;
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_PERSISTENT => TRUE,
);
/**************************************************************************/
// End Boiler Plate code
/**************************************************************************/

// Read in SQL template and replace the {{db_name}} with the actual DB name to be used
$sql_source = file_get_contents("templates/wedding_db_template.sql");

$sql_modified = str_replace("{{db_name}}", $db, $sql_source);
#var_dump($sql_modified);

print("We need the root user for MySQL so that we can create the wedding site user and give it permissions to the wedding db.\r\n");
$root_user = readline("MySQL Root User: ");

print("Now we need the MySQL Root password.\r\n");
$root_pwd = prompt_silent();

print("Making connection to MySQL with supplied information...\r\n");
$conn = new PDO($dsn, $root_user, $root_pwd, $options);

print("Importing the Wedding DB template SQL\r\n");
$conn->exec($sql_modified);
print($conn->errorCode()."\r\n");

print("Create $sql_user MySQL User.\r\n");
$conn->exec("CREATE USER '$sql_user'@'localhost' IDENTIFIED BY '$sql_pwd';");
print($conn->errorCode()."\r\n");

print("Grant permissions for $sql_user to $db.\r\n");
$conn->exec("GRANT ALL PRIVILEGES ON $db.* TO '$sql_user'@'localhost';");
print($conn->errorCode()."\r\n");

print("Flush Privileges.\r\n");
$conn->exec("flush privileges;");
print($conn->errorCode()."\r\n");

print("Test connection with new user: $sql_user\r\n");
$conn2 = new PDO($dsn, $sql_user, $sql_pwd, $options);
$conn2->query("USE $db");
if( $conn2->errorCode() === "00000")
{
    print("Success!\r\n");
}else
{
    print($conn2->errorCode()."\r\n");
    exit(1);
}


print("Now we are going to insert the default data for the site from the data.inc.php file.");
$prep = $conn2->prepare("INSERT INTO `$db`.`wedding_story` (`story`, `location`, `date`) VALUES (?, ?, ?);");
$prep->bindParam(1, $story, PDO::PARAM_STR);
$prep->bindParam(2, $location, PDO::PARAM_STR);
$prep->bindParam(3, $date, PDO::PARAM_STR);
$prep->execute();
if( $conn2->errorCode() === "00000")
{
    print("Success!\r\n");
}else
{
    print($conn2->errorCode()."\r\n");
    exit(1);
}



print("Now we are going to deploy the WWW files to their new home.\r\n");
print("Copy $argv[1] to: ".$http_folder."lib/config.inc.php\r\n");
copy( $argv[1], $http_folder."lib/config.inc.php");









