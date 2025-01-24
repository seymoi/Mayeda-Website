<?php
include "includes/discord/functions.php";
include "includes/discord/discord.php";
include "config.php";


try {
    $bdd = new PDO('mysql:host=localhost;dbname=mayeda;', $user, $pass);
    $guildInf = $bdd->query('SELECT SUM(musicPlayed) FROM guildInfos');
    if ($guildInf->rowCount() == 1) {
        $options = $guildInf->fetch();
        $songs = $options["SUM(musicPlayed)"];
    }
    $guildInf = $bdd->query('SELECT SUM(cmdUsed) FROM guildInfos');
    if ($guildInf->rowCount() == 1) {
        $options = $guildInf->fetch();
        $servers = $options["SUM(cmdUsed)"];
    }
    $guildNum = $bdd->query('SELECT guildId FROM guild');
    if ($guildNum->rowCount() == 1) {
        $guilds = $guildNum->rowCount();
    }
} catch (PDOException $err) {
    print 'Erreur: ' . $err->getMessage() . "</br>";
    die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mayeda - <?php echo $lang["title"] ?></title>
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
    <meta property="og:image" content="./images/Mayeda/logo.png">
    <meta property="og:url" content="https://mayeda.xyz">
    <meta property="og:title" content="Mayeda - High quality music">
    <link rel="icon" href="./images/Mayeda/logo.png">
    <link rel="shortcut icon" href="./images/Mayeda/logo.png">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/6c2f0e159c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/custom.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body class="on">

    <div>
        <section id="head">
            <?php include "./includes/nav.php"; ?>
            <div class="body">
                <div class="text">
                    <h1 class="title animate__animated animate__bounce">Mayeda</h1>
                    <h2 class="description"><?php echo $lang['title'] ?></h2>
                    <h2 class="subtitle"><?php echo $lang['description'] ?></h2>
                    <div class="buttons animate__animated animate__tada">
                        <a class="button white " style="vertical-align:middle" href="/invite"><i class="fa fa-plus"></i><span>&nbsp;<?php echo $lang["head_btn_discord"] ?></span></a>
                        <a class="button black" style="vertical-align:middle" href="#features"><i class="fab fa-discord"></i><span>&nbsp;<?php echo $lang["head_btn_features"] ?></span></a>
                    </div>
                    <div class="feats">
                        <ul class="list">
                            <li class="item"><i class="fas fa-headphones-alt"></i><span>&nbsp;<?php echo $lang["head_feat_audio"] ?></span></li>
                            <li class="item"><i class="fas fa-filter"></i><span>&nbsp;<?php echo $lang["head_feat_filter"] ?></span></li>
                            <li class="item"><i class="fas fa-tools"></i><span>&nbsp;<?php echo $lang["head_feat_config"] ?></span></li>
                        </ul>
                    </div>

                </div>
                <span class="scroll-down"><i class="fas fa-arrow-down"></i></span>
            </div>

        </section>

        <section id="features">
            <!-- features -->
            <div class="features-box">
                <h1 class="features-t" id="features">We are provide the best.</h1>
                <div class="container">
                    <div class="features">
                        <div class="feature">
                            <img class="feature-img" src="./images/presentation.png"></img>
                            <div class="feature-info">
                                <h2 class="feature-info-t">Feature 1</h2>
                                <p class="feature-info-d">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            </div>
                        </div>
                        <div class="feature">
                            <img class="feature-img" src="./images/dashboard.png"></img>
                            <div class="feature-info">
                                <h2 class="feature-info-t">Dashboard</h2>
                                <p class="feature-info-d">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            </div>
                        </div>
                        <div class="feature">
                            <img class="feature-img" src="./images/presentation.png"></img>
                            <div class="feature-info">
                                <h2 class="feature-info-t">Feature 3</h2>
                                <p class="feature-info-d">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- features end -->
        </section>
        <section id="services">
            <div class="services-box">
                <h1 class="services-t" id="services"><?php echo $lang["services_title"]?></h1>
                <div class="container">
                    <div class="services">
                        <div class="service">
                            <span><i class="fas fa-server"></i> <?php echo $guildNum->rowCount() ?> <?php echo $lang["services_servers"]?></span>
                        </div>
                        <div class="service">
                            <span><i class="fas fa-music"></i> <?php echo $songs ?> <?php echo $lang["services_songs"]?></span>
                        </div>
                        <div class="service">
                            <span><i class="fas fa-slash"></i> <?php echo $servers?> <?php echo $lang["services_commands"]?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="add">
            <div class="container">
                <div class="text">
                    <h1 class="title"><?php echo $lang["add_title"] ?></h1>
                    <a class="button blue" style="vertical-align:middle" href="/invite"><?php echo $lang["head_btn_discord"] ?></a>
                </div>
            </div>
        </section>
        <?php include "./includes/footer.php"; ?>
    </div>
    <script>
        console.log("Made with love by SEY <3");
    </script>

    <!-- <script>
        (function() {
            if (!localStorage.getItem('cookieconsent')) {
                document.body.innerHTML += '\
		<div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#000;color:#FFF;text-align:center;width:100%;z-index:99999;">\
			<?php echo $lang["cookie_text"] ?> \
			<a style="color:#aaaa;"><?php echo $lang["cookie_btn"] ?></a>\
		</div>\
		';
                document.querySelector('.cookieconsent a').onclick = function(e) {
                    e.preventDefault();
                    document.querySelector('.cookieconsent').style.display = 'none';
                    localStorage.setItem('cookieconsent', true);
                };
            }
        })();
    </script> -->
    <script type="text/javascript" src="./assets/js/main.js"></script>
</body>


<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>


</html>