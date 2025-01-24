<?php
include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";


try {

    function check_db($guild)
    {
        include "../../config.php";
        $bdd = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
        $serveurs = $bdd->prepare('SELECT * FROM guild WHERE guildId = ?');
        $serveurs->execute(array($guild));
        if ($serveurs->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
} catch (PDOException $e) {
    print 'Erreur: ' . $e->getMessage() . "</br>";
    die;
}

$serveurs_num = null;
?>

<head>
    <title>Mayeda - Listes des serveurs</title>
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
    <meta property="og:image" content="https://localhost/images/Mayeda/logo.png">
    <meta property="og:url" content="https://mayeda.xyz">
    <meta property="og:title" content="Mayeda - High quality music">
    <link rel="icon" href="https://localhost/images/Mayeda/logo.png">
    <link rel="shortcut icon" href="https://localhost/images/Mayeda/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/6c2f0e159c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://localhost/pages/dashboard/css/custom.css">


</head>

<body class="on">
    <div>

        <section id="head">
            <?php include "../../includes/nav.php"; ?>

            <div class="body ">
                <div class="text">
                    <h1 class="title"><?php echo $lang["guilds_title"] ?></h1>
                    <h2 class="subtitle"><?php echo $lang["guilds_description"] ?></h2>
                </div>
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="servers">
                        <?php

                        for ($i = 0; $i < sizeof($_SESSION["guilds"]); $i++) {
                       
                            if ($_SESSION["guilds"][$i]["permissions"] & "8") {
                                $serveurs_num++;

                        ?>
                                <ul>
                                    <li>
                                        <?php if (!$_SESSION['guilds'][$i]['icon']) { ?>
                                            <img ondragstart="return false" alt="Server logo" src="https://localhost/images/logoserv.png">
                                        <?php } else { ?>
                                            <img ondragstart="return false" src='https://cdn.discordapp.com/icons/<?php $extention = is_animated($_SESSION['guilds'][$i]['icon']);
                                                                                                                    echo $_SESSION['guilds'][$i]['id'] . "/" . $_SESSION['guilds'][$i]['icon'] . $extention; ?>'>
                                        <?php } ?>
                                        <div class="title"><?php echo $_SESSION['guilds'][$i]['name'] ?></div>
                                        <div class="link">

                                            <?php

                                            if (check_db($_SESSION['guilds'][$i]['id'])) { ?>
                                                <a href='https://localhost/pages/dashboard/guild.php?id=<?php echo $_SESSION['guilds'][$i]['id'] ?>'><?php echo $lang["guilds_btn_2"] ?></a>
                                            <?php } else { ?>
                                                <a href='https://discord.com/api/oauth2/authorize?client_id=937040684475625532&permissions=8&redirect_uri=https%3A%2F%2Flocalhost%2Fdashboard%2Fserveurs&response_type=code&scope=bot%20applications.commands%20identify&guild_id=<?php echo $_SESSION['guilds'][$i]['id'] ?>'><?php echo $lang["guilds_btn_1"] ?></a>
                                            <?php }
                                            ?>

                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                        <?php  } ?>
                        <p>You're in <?php echo $serveurs_num ?> guilds with admin permissions</p>
                    </div>
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
    <script type="text/javascript" src="https://localhost/assets/js/main.js"></script>
</body>