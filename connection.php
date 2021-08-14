<?php
try{
    $serverName = 'localhost';
    $dbname = "beetriv";
    $db_user = "root";
    $db_password = "";
    $conn = new PDO("mysql:host=$serverName;dbname=$dbname", $db_user, $db_password);

    //echo "Connection success";

}
catch(PDOException $e){
    echo "Error: ". $e->getMessage();
}



?>