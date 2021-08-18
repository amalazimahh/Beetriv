<?php
try{
    $serverName = 'localhost';
    $dbname = "beetriv";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$serverName;dbname=$dbname", $username, $password);

     //echo "Connection success";

}
catch(PDOException $e){
    echo "Error: ". $e->getMessage();
}



?>