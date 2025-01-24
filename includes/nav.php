<?php
$auth_url = url($client_id, $redirect_url, $scopes);
?>

<head>

    <link rel="stylesheet" type="text/css" href="../includes/css/custom.css">
</head>

<div class="nav">

    <div class="content">
        <a href="/">
            <div ondragstart="return false" class="logo" id="logo"><img src="../images/Mayeda/logo.png" alt="Logo">
            </div>
        </a>
        <div class="navs" id="navs">

            <ul>
                <li><a href="https://localhost#commands"><?php echo $lang['nav_commands'] ?></a></li>
                <li><a href="/tutorials"><?php echo $lang['nav_tuto'] ?></a></li>
                <li><a target=" _blank" href="/discord"><?php echo $lang['nav_server'] ?></a></li>
                <li><a><?php echo $lang['nav_articles'] ?></a>
                    <ul class="dropdown">
                        <li><a href="https://localhost/articles/articles">Liste</a></li>
                        <li><a href="https://localhost/articles/redaction">Rédiger un article</a></li>
                    </ul>

                </li>
                <li><a class="premium" href="/premium"><?php echo $lang['nav_premium'] ?></a></li>

                <?php if (isset($_SESSION["user_id"])) : ?>
                    <li>
                        <?php if (!$_SESSION["user_avatar"]) { ?>
                            <img ondragstart="return false" class='avatar' alt="avatar" src="https://localhost/images/logoserv.png">
                        <?php } else { ?>
                            <img ondragstart="return false" class='avatar' src='https://cdn.discordapp.com/avatars/<?php $extention = is_animated($_SESSION['user_avatar']);
                                                                                                                    echo $_SESSION['user_id'] . "/" . $_SESSION['user_avatar'] . $extention; ?>'>
                        <?php } ?>


                        <ul class="dropdown">
                            <li style="cursor:default;     margin-bottom: 8px;">
                                <span style="font-size: 14px; text-align:center; color:#aaa;"><?php echo $_SESSION['username'], "#", $_SESSION['discrim'] ?></span>
                                <br>
                                <span style="font-size: 11px; text-align:center; color:#8d8d8d;"><?php echo $_SESSION["user_id"] ?></span>
                            </li>
                            <li><a href="https://localhost/dashboard/guilds">Dashboard</a></li>
                            <li><a style="color: #E15F5F;" href="logout"><?php echo $lang["nav_logout"] ?></a></li>
                        </ul>

                    </li>

                <?php else : ?>
                    <li><a href="<?= $auth_url ?>"><?php echo $lang["nav_login"] ?> <i class="fab fa-discord"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="./assets/js/main.js"></script>