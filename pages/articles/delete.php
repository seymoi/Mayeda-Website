<?php
include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";
try {
    $bdd = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
    $articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC');
} catch (PDOException $e) {
    print 'Erreur: ' . $e->getMessage() . "</br>";
    die;
}
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $suppr_id = htmlspecialchars($_GET['id']);
    $suppr = $bdd->prepare('DELETE FROM articles WHERE id = ?');
    $suppr->execute(array($suppr_id));
    header('Location: http://localhost/articles/articles');
}
