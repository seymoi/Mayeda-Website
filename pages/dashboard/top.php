<?php

include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";
$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $_SESSION['guild'] = get_guild($get_id);
    if (!$_SESSION['guild']['name']) {
        redirect('https://localhost/dashboard/guilds');
    }

    function check_good($guild)
    {
        for ($i = 0; $i < sizeof($_SESSION["guilds"]); $i++) {
            if ($_SESSION['guilds'][$i]["id"] == $_SESSION['guild']['id']) {
                if ($_SESSION['guilds'][$i]['permissions'] & "8") {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
        $guildOptions = $bdd->prepare('SELECT * FROM guildOptions WHERE guildId = ?');
        $guildOptions->execute(array($_SESSION["guild"]["id"]));
        if ($guildOptions->rowCount() == 1) {
            $options = $guildOptions->fetch();
            $language = $options['language'];
        }
        $guildMusicTop = $bdd->prepare('SELECT * FROM musicTop WHERE guildId =? ORDER BY listeningCount DESC');
        $guildMusicTop->execute(array($_SESSION['guild']["id"]));
        // if ($guildMusicTop->rowCount() == 1) {
        //     $musicTop = $guildMusicTop->fetch();
        //     $musicTitle = $musicTop['musicTitle'];
        //     $musicArtist = $musicTop['musicArtist'];
        //     $musicIcon = $musicTop['musicIcon'];
        //     $musicTopCount = $musicTop['listeningCount'];
        // }
    } catch (PDOException $err) {
        print 'Erreur: ' . $err->getMessage() . "</br>";
        die;
    }
    $_SESSION['lang'] = $language;
} else {
    redirect('https://localhost/dashboard/guilds');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Musics top of <?php echo $_SESSION['guild']['name'] ?> - Mayeda</title>
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
    <meta property="twitter:image" content="./assets/images/Mayeda/logo.png">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Mayeda - High quality music">
    <meta property="og:description" content="Mayeda offers you a high level of musical quality, with its configuration and its multitude of controls be sure to have a bot that suits you!">
    <meta property="og:image" content="https://localhost/images/Mayeda/logo.png">
    <meta property="og:url" content="https://mayeda.xyz">
    <meta property="og:title" content="Mayeda - High quality music">
    <link rel="icon" href="https://localhost/images/Mayeda/logo.png">
    <link rel="shortcut icon" href="https://localhost/images/Mayeda/logo.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="https://localhost/pages/dashboard/css/top-custom.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <?php if (check_good($_SESSION['guild']["id"])) { ?>
            <section class="home">

                <div class="text">

                    <div class="servname">
                        <?php if (!$_SESSION['guild']['icon']) { ?>
                            <img ondragstart="return false" class="avatar" alt="Server logo" src="https://localhost/images/logoserv.png">
                        <?php } else { ?>
                            <img ondragstart="return false" class='avatar' src='https://cdn.discordapp.com/icons/<?php $extention = is_animated($_SESSION['guild']['icon']);
                                                                                                                    echo $_SESSION['guild']["id"] . "/" . $_SESSION['guild']['icon'] . $extention; ?>'>
                        <?php } ?>
                        <div class="name"><?php echo $_SESSION['guild']['name']; ?></div>

                    </div>
                    <h2 class="link"><a href="https://localhost/dashboard/guild?id=<?php echo $_SESSION['guild']['id'] ?>">Revenir en arrière <i class="bx bx-right-arrow-alt"></i></a></h2>

                    <div class="group">
                        <div class="settings-content">
                            <div class="container">

                                <?php while ($top = $guildMusicTop->fetch()) {

                                ?>
                                    <div class="musicSquare">
                                        <img ondragstart="return false" class='music-icon' src='<?php echo $top['musicIcon']; ?>'>
                                        <div class="topText">
                                            <h1 class="topTitle"><?= $top['musicTitle'] ?> </h1>
                                            <h3 class="topArtist"><?= $top['musicArtist'] ?> </h3>
                                            <h3 class="topCount"><?= $top['listeningCount'] ?> écoute.s</h3>
                                        </div>

                                    </div>

                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        <?php } else { ?>
            <div class="modal">
                <p class="message"><?php echo $lang["denied_permissions"] ?></p>
                <div class="options">
                    <a class="btn" href="https://localhost/dashboard/guilds">Back</a>
                </div>
            </div>
        <?php } ?>
    <?php else : ?>
        </br>
        <div class="modal">
            <p class="message"><?php echo $lang['have_login'] ?></p>
            <div class="options">
                <a class="btn" href="<?= $auth_url ?>"><?php echo $lang["nav_login"] ?></a>
            </div>
        </div>

    <?php endif; ?>

</body>