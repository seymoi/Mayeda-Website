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

$auth_url = url($client_id, $redirect_url, $scopes);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mayeda - Articles</title>
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
                <div class="text">
                    <h1 class="title"><?php echo $lang["articles_title"] ?></h1>
                    <h2 class="description" style="color: #fff;"><?php echo $lang["articles_description"] ?></h2>
                </div>
                <br>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <ul class="tilesWrap">
                        <?php while ($a = $articles->fetch()) {

                            if (strlen($a['contenu']) > 50) $a['contenu'] = substr($a['contenu'], 0, 50) . "...</a>"; ?>

                            <li>
                                <div class="text">
                                    <h3><?= $a['titre'] ?></h3>
                                    <p>
                                        <?= $a['contenu'] ?>
                                    </p>
                                </div>
                                <div class="options">
                                    <a class="btn" style="vertical-align:middle" href="read?num=<?= $a["id"] ?>"><i class="fa fa-plus"></i><span>&nbsp;Read more</span></a>
                                </div>
                                <p class="date"><?= $a['date_time_publication'] ?></p>
                            </li>
                        <?php } ?>
                    </ul>
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