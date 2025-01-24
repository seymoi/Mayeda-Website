<?php

include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
    if (isset($_GET['num']) and !empty($_GET['num'])) {
        $get_id = htmlspecialchars($_GET['num']);
        $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
        $article->execute(array($get_id));
        if ($article->rowCount() == 1) {
            $article = $article->fetch();
            $titre = $article['titre'];
            $contenu = $article['contenu'];
            $id = $article['id'];
            $date = $article['date_time_publication'];
            $username = $article['username'];
            $userid = $article['user_user_id'];
            $user_avatar_id = $article['user_avatar_id'];
        } else {
            header("Location: http://localhost/articles/articles");
            die;
        }
    } else {
        die('Erreur');
    }
} catch (PDOException $e) {
    print 'Erreur: ' . $e->getMessage() . "</br>";
    die;
}
$auth_url = url($client_id, $redirect_url, $scopes);

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $titre ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="description" content="Mayeda offers you a high level of musical quality, with its configuration and its multitude of controls be sure to have a bot that suits you!">
    <meta name="author" content="MAYEDA.XYZ">
    <meta name="publisher" content="MAYEDA.XYZ">
    <meta name="twitter:card" value="summary">
    <meta name="twitter:site" content="@mayeda_">
    <meta name="twitter:creator" content="@mayeda_">
    <meta property="twitter:title" content="Mayeda">
    <meta property="twitter:description" content="Mayeda offers you a high level of musical quality, with its configuration and its multitude of controls be sure to have a bot that suits you!">
    <meta property="twitter:image" content="../../assets/images/Mayeda/logo.png">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Mayeda - High quality music">
    <meta property="og:description" content="Mayeda offers you a high level of musical quality, with its configuration and its multitude of controls be sure to have a bot that suits you!">
    <meta property="og:image" content="../../images/Mayeda/logo.png">
    <meta property="og:url" content="https://mayeda.xyz">
    <meta property="og:title" content="Mayeda - High quality music">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../images/Mayeda/logo.png">
    <link rel="shortcut icon" href="../../images/Mayeda/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/6c2f0e159c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://localhost/pages/articles/css/custom.css">

</head>

<body>

    <div>
        <section id="head">
            <?php include "../../includes/nav.php"; ?>
            <div class="body">
                <?php if (isset($_SESSION['user'])) : ?>

                    <div class="text">
                        <h3 class="subtitle">Article n°<?= $id ?></h3>
                        <div class="article">
                            <div class="user">
                                <img class='avatar' src='https://cdn.discordapp.com/avatars/<?= $userid ?>/<?= $user_avatar_id ?>.png?size=32'>
                                <span> <?= $username ?> </span>
                            </div>

                            <h1 class="title"><?= $titre ?></h1>
                            <h2 class="description" style="color: #fff;"><?= $contenu ?></h2>
                            <h2 class="date"><?= $date ?></h2>
                            <?php if ($_SESSION['user_id'] == "677932206189969448") { ?>
                                <a href="delete?id=<?= $id ?>">Supprimer l'article.</a>
                            <?php } ?>
                        </div>
                    </div>
                    <br>
                <?php else : ?>
                    </br>
                    <div class="modal">
                        <p class="message"><?php echo $lang['have_login'] ?></p>
                        <div class="options">
                            <a class="btn" href="<?= $auth_url ?>"><?php echo $lang["nav_login"] ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php include "../../includes/footer.php"; ?>
    </div>
</body>

</html>