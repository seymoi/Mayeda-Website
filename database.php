<?php

$user = "";
$pass = "";

try {
    $db = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
} catch (PDOException $e) {
    print 'Erreur: ' . $e->getMessage() . "</br>";
    die;
}
