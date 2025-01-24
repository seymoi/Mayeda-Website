<?php

include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";
$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $_SESSION['guild'] = get_guild($get_id);
    print $_GET['id'];
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
            $prefix = $options['prefix'];
            $language = $options['language'];
            $volume = $options['defaultVolume'];
            $autoplay = $options['autoplay'];
            $dj = $options['dj'];
        }
        $guildInfos = $bdd->prepare('SELECT * FROM guildInfos WHERE guildId = ?');
        $guildInfos->execute(array($_SESSION["guild"]["id"]));
        if ($guildInfos->rowCount() == 1) {
            $infos = $guildInfos->fetch();
            $musicPlayed = $infos['musicPlayed'];
            $createdAt = $infos['createdAt'];
        }
        $guildMusicPlayed = $bdd->prepare('SELECT * FROM playedMusic WHERE guildId =?');
        $guildMusicPlayed->execute(array($_SESSION['guild']["id"]));
        if ($guildMusicPlayed->rowCount() == 1) {
            $playedMusic = $guildMusicPlayed->fetch();
            $musicTitle = $playedMusic['musicTitle'];
            $musicArtist = $playedMusic['musicArtist'];
            $musicIcon = $playedMusic['musicIcon'];
            $requestedBy = $playedMusic['requestedBy'];
            $musicUrl = $playedMusic['musicUrl'];
            $isPlay = $playedMusic['play'];
        }
        $guildMusicTop = $bdd->prepare('SELECT * FROM musicTop WHERE guildId =? ORDER BY listeningCount DESC LIMIT 5');
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
    if (isset($_POST['prefix'])) {
        if (!empty($_POST['prefix'])) {

            $new_prefix = htmlspecialchars($_POST['prefix']);
            if ($new_prefix == $prefix) {
                $message =  $lang["guild_options_prefix_msg_1"];
            } else {
                $ins = $bdd->prepare('UPDATE guildOptions SET prefix = ? WHERE guildId = ?');
                $ins->execute(array($new_prefix, $_SESSION["guild"]["id"]));

                $message =  $lang["guild_options_prefix_msg_2"];
                $prefix = $new_prefix;
            }
        } else {
            $message =  $lang["guild_options_choose"];
            $prefix = $prefix;
        }
    } elseif (isset($_POST['formLanguage'])) {
        if (!empty($_POST['formLanguage'])) {
            $new_language = htmlspecialchars($_POST['formLanguage']);
            if ($new_language == $language) {
                $langmessage = $lang["guild_options_language_msg_1"];
            } else {
                $ins = $bdd->prepare('UPDATE guildOptions SET language = ? WHERE guildId = ?');
                $ins->execute(array($new_language, $_SESSION["guild"]["id"]));
                $language = $new_language;
                $langmessage = $lang["guild_options_language_msg_2"];
            }
        }
    } elseif (isset($_POST['volume'])) {
        if (!empty($_POST['volume'])) {

            $new_volume = htmlspecialchars($_POST['volume']);
            if ($new_volume == $volume) {
                $volmessage = $lang["guild_options_volume_msg_1"];
            } else {
                $ins = $bdd->prepare('UPDATE guildOptions SET defaultVolume = ? WHERE guildId = ?');
                $ins->execute(array($new_volume, $_SESSION["guild"]["id"]));

                $volmessage = $lang["guild_options_volume_msg_2"];
                $volume = $new_volume;
            }
        } else {
            $volmessage = $lang["guild_options_choose"];
            $volume = $volume;
        }
    } elseif (isset($_POST['autoplay'])) {
        if ($_POST["autoplay"] == "1") {
            if ($autoplay == "1") {
                $apmessage = $lang["guild_options_autoplay_msg_1"];
            } else {
                $new_autoplay = htmlspecialchars($_POST['autoplay']);
                $ins = $bdd->prepare('UPDATE guildOptions SET autoplay = ? WHERE guildId = ?');
                $ins->execute(array($new_autoplay, $_SESSION["guild"]["id"]));
                $apmessage = $lang["guild_options_autoplay_msg_2"];
                $autoplay = $new_autoplay;
            }
        } else {
            if (!$autoplay == "1") {
                $apmessage = $lang["guild_options_autoplay_msg_3"];
            } else {
                $new_autoplay = htmlspecialchars($_POST['autoplay']);
                $ins = $bdd->prepare('UPDATE guildOptions SET autoplay = ? WHERE guildId = ?');
                $ins->execute(array($new_autoplay, $_SESSION["guild"]["id"]));
                $apmessage = $lang["guild_options_autoplay_msg_4"];
                $autoplay = $new_autoplay;
            }
        }
    } elseif (isset($_POST['dj'])) {
        if ($_POST["dj"] == "1") {
            if ($dj == "1") {
                $djmessage = $lang["guild_options_dj_msg_1"];
            } else {
                $new_dj = htmlspecialchars($_POST['dj']);
                $ins = $bdd->prepare('UPDATE guildOptions SET dj = ? WHERE guildId = ?');
                $ins->execute(array($new_dj, $_SESSION["guild"]["id"]));
                $djmessage = $lang["guild_options_dj_msg_2"];
                $dj = $new_dj;
            }
        } else {
            if (!$dj == "1") {
                $djmessage = $lang["guild_options_dj_msg_3"];
            } else {
                $new_dj = htmlspecialchars($_POST['dj']);
                $ins = $bdd->prepare('UPDATE guildOptions SET dj = ? WHERE guildId = ?');
                $ins->execute(array($new_dj, $_SESSION["guild"]["id"]));
                $djmessage = $lang["guild_options_dj_msg_4"];
                $dj = $new_dj;
            }
        }
    }
} else {
    redirect('https://localhost/dashboard/guilds');
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $_SESSION['guild']['name'] ?> - Mayeda</title>
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
    <link rel="stylesheet" href="https://localhost/pages/dashboard/css/guild-custom.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>

    <?php if (isset($_SESSION['user_id'])) : ?>
        <?php if (check_good($_SESSION['guild']["id"])) { ?>
            <nav class="sidebar close">
                <header>
                    <div class="image-text">
                        <span class="image">
                            <img ondragstart="return false" src="https://localhost/images/Mayeda/logo.png" alt="">
                        </span>

                        <div class="text logo-text">
                            <span class="name">MAYEDA</span>
                            <span class="profession">v2.0.0</span>
                        </div>
                    </div>

                    <i class='bx bx-chevron-left toggle'></i>
                </header>

                <div class="menu-bar">
                    <div class="menu">
                        <li class="server-box">
                            <a href="https://localhost/dashboard/guilds">
                                <i class='bx bx-folder icon'></i>
                                <span class="text nav-text"><?php echo $lang["guild_nav_serv"] ?></span>
                            </a>
                        </li>
                        </br>

                        <ul class="menu-links">

                            <li class="nav-link">
                                <a href="#dashboard">
                                    <i class='bx bxs-dashboard icon'></i>
                                    <span class="text nav-text"><?php echo $lang["guild_nav_dash"] ?></span>
                                </a>
                            </li>
                            <br>
                            <li class="nav-link">
                                <a href="#logs">
                                    <i class='bx bx-bell icon'></i>
                                    <span class="text nav-text">Logs</span>
                                </a>
                            </li>
                            <!-- <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">Notifications</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Analytics</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Likes</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Wallets</span>
                        </a>
                    </li> -->

                        </ul>
                    </div>

                    <div class="bottom-content">
                        <li class="">
                            <a href="https://localhost/logout">
                                <i class='bx bx-log-out icon'></i>
                                <span class="text nav-text"><?php echo $lang["nav_logout"] ?></span>
                            </a>
                        </li>

                    </div>
                </div>

            </nav>

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
                    <!-- <?php echo json_encode($_SESSION['guild']) ?> -->
                    <div class="servinfos">
                        <h3 class="title"><?php echo $lang["guild_infos_title"] ?></h3>
                        <ul class="server-info">
                            <li><?php echo $lang["guild_infos_date"] ?><span class="number"><?php echo date('d/m/Y', strtotime($createdAt)); ?></span></li>
                            <li><span class="number"><?php echo $musicPlayed ?></span><?php echo $lang["guild_infos_musicplayed"] ?></li>
                        </ul>
                    </div>


                    <div class="group-settings">
                        <div class="settings-content">
                            <h3 class="title"><?php echo $lang["guild_options_gen_title"] ?></h3>
                            <label class="label">Prefix</label>
                            <form method="POST" class="text-form">
                                <p class="control"><input class="input" type="text" name="prefix" maxlength="5" placeholder="<?php echo $prefix ?>"><button onclick="toggle()" type="submit" class="button"><i class='bx bx-check-circle'></i></button></p>
                                <div id="message"><?php echo isset($message) ? '<p>' . htmlspecialchars($message) . '</p>' : '' ?></div>
                            </form>
                            <label class="label">Language</label>
                            <form method="POST" class="text-form">
                                <p class="control">
                                    <select class="select" name="formLanguage">
                                        <?php if ($language == "en") { ?>
                                            <option value="en"><?php echo $lang['lang_en'] ?></option>
                                            <option value="fr"><?php echo $lang['lang_fr'] ?></option>
                                        <?php } else { ?>
                                            <option value="fr"><?php echo $lang['lang_fr'] ?></option>
                                            <option value="en"><?php echo $lang['lang_en'] ?></option>
                                        <?php } ?>
                                    </select> <button onclick="toggle()" type="submit" class="button"><i class='bx bx-check-circle'></i></button>
                                </p>
                                <div id="message"><?php echo isset($langmessage) ? '<p>' . htmlspecialchars($langmessage) . '</p>' : '' ?></div>
                            </form>
                        </div>
                    </div>
                    <div class="group-settings">
                        <div class="settings-content">
                            <h3 class="title"><?php echo $lang["guild_options_music_title"] ?></h3>
                            <label class="label"><?php echo $lang["guild_options_music_volume"] ?></label>
                            <form method="POST" class="text-form">
                                <p class="control"><input class="input" type="number" min=5 max=100 name="volume" placeholder="<?php echo $volume ?>"><button onclick="toggle()" type="submit" class="button"><i class='bx bx-check-circle'></i></button></p>
                            </form>
                            <div id="message"><?php echo isset($volmessage) ? '<p>' . htmlspecialchars($volmessage) . '</p>' : '' ?></div>
                            <label class="label">Autoplay</label>
                            <form method="POST" class="text-form">
                                <div class="control rich-toggle "><span><input type="hidden" name="autoplay" value="0"><?php if ($autoplay) {
                                                                                                                            echo '<input name="autoplay" value="1" type="checkbox" checked>';
                                                                                                                        } else {
                                                                                                                            echo '<input name="autoplay" value="1" type="checkbox">';
                                                                                                                        } ?><label class="checkbox" for="Autoplay automatique"><?php echo $lang["guild_options_music_autoplay"] ?></label></span>
                                    <button onclick="toggle()" type="submit" class="button_large"><i class='bx bx-check-circle'></i></button>
                                    <div id="message"><?php echo isset($apmessage) ? '<p>' . htmlspecialchars($apmessage) . '</p>' : '' ?></div>
                                </div>
                            </form>
                            <label class="label">DJ <span class="information"><?php echo $lang["guild_options_music_dj_infos"] ?></span></label>
                            <form method="POST" class="text-form">
                                <div class="control rich-toggle "><span><input type="hidden" name="dj" value="0"><?php if ($dj) {
                                                                                                                        echo '<input name="dj" value="1" type="checkbox" checked>';
                                                                                                                    } else {
                                                                                                                        echo '<input name="dj" value="1" type="checkbox">';
                                                                                                                    } ?><label class="checkbox" for="Nécessiter DJ"><?php echo $lang["guild_options_music_dj"] ?></label></span>
                                    <button onclick="toggle()" type="submit" class="button_large"><i class='bx bx-check-circle'></i></button>
                                    <div id="message"><?php echo isset($djmessage) ? '<p>' . htmlspecialchars($djmessage) . '</p>' : '' ?></div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="group-settings-2">
                        <div class="settings-content">
                            <h3 class="title">En cours de lecture
                                <div class="tooltip"><i class='bx bx-info-circle icon'></i>
                                    <span class="tooltiptext">Les musiques de l'autoplay ne sont pas prises en compte par le top. </span>
                                </div>
                            </h3>

                            <?php if (!$isPlay) { ?>
                                <img ondragstart="return false" class="music-icon" src="https://localhost/images/croix.png">
                            <?php } else { ?>
                                <img ondragstart="return false" class='music-icon' src='<?php echo $musicIcon; ?>'>
                            <?php } ?>
                            <?php if (!$isPlay) { ?>
                                <h1 class="music-title">No playing Song</h1>

                            <?php } else { ?>
                                <h1 class="music-title"><?php echo $musicTitle ?></h1>
                                <h2 class="music-artist"><?php echo $musicArtist ?></h2>
                                <h2 class="music-url"> <a target="blank" href="<?php echo $musicUrl ?>">Ecouter cette musique <i class='bx bx-chevron-right toggle'></i></a></h2>
                                <h2 class="music-request">Requested by: <p class="requester"><?php echo $requestedBy; ?></p>
                                </h2>
                            <?php } ?>
                            <br>
                            <h3 class="title">Le top 5</h3>


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
                                <?php if ($guildMusicTop->rowCount()  > 1) { ?>
                                    <a class="link" href="https://localhost/dashboard/top?id=<?php echo $_SESSION['guild']['id'] ?>" class="topTitle">Agrandir <i class="bx bx-right-arrow-alt"></i></a>
                                <?php   } ?>
                            </div>

                        </div>
                    </div>
                </div>


            </section>

            <script>
                const body = document.querySelector('body'),
                    sidebar = body.querySelector('nav'),
                    toggle = body.querySelector(".toggle");


                toggle.addEventListener("click", () => {
                    sidebar.classList.toggle("close");
                })
            </script>
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


</html>