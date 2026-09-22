<?php
// functie voor het connecteren met de database
function dbConnect()
{
    $db_username = "bit_academy";
    $db_password = "";
    $db_name     = "clanbase";
    $db_host     = "localhost";

    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Databaseverbinding mislukt: " . $e->getMessage());
    }
}
