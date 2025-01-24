<?php
include "../../includes/discord/functions.php";
include "../../includes/discord/discord.php";
include "../../config.php";
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
    <meta property="twitter:image" content="../../assets/images/Mayeda/logo.png">
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

</head>

<body>
    <div>
        <section id="head" style="background: linear-gradient(to right, rgb(232, 120, 60), 45%, rgb(230, 177, 63));">
            <?php include "../../includes/nav.php"; ?>
            <div class="body">

                <div class="text">
                    <h1 class="title">Premium<i style="color: #DAA520;" class="fa fa-crown"></i>Mayeda</h1>
                    <h2 class="description" style="color: #fff;"><?php echo $lang["premium_subtitle"] ?></h2>
                </div>
                <br>
                <div class="text">
                    <h1 class="headline"><?php echo $lang["premium_not_now"] ?></h1>
                    <div id="countdown">
                        <ul>
                            <li><span id="days"></span><?php echo $lang["days"] ?></li>
                            <li><span id="hours"></span><?php echo $lang["hours"] ?></li>
                            <li><span id="minutes"></span><?php echo $lang["min"] ?></li>
                            <li><span id="seconds"></span><?php echo $lang["seconds"] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <?php include "../../includes/footer.php"; ?>
    </div>

    <script>
        (function() {
            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

            let today = new Date(),
                dd = String(today.getDate()).padStart(2, "0"),
                mm = String(today.getMonth() + 1).padStart(2, "0"),
                dateToReach = "01/01/2025";

            const countDown = new Date(dateToReach).getTime(),
                x = setInterval(function() {

                    const now = new Date().getTime(),
                        distance = countDown - now;

                    document.getElementById("days").innerText = Math.floor(distance / (day)),
                        document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                        document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                        document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                    if (distance < 0) {
                        document.getElementById("countdown").style.display = "none";
                        clearInterval(x);
                    }
                }, 0)
        }());
    </script>

    <script>
        console.log("Made with love by SEY <3");
    </script>

    <script>
        (function() {
            if (!localStorage.getItem('cookieconsent')) {
                document.body.innerHTML += '\
		<div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#000;color:#FFF;text-align:center;width:100%;z-index:99999;">\
			<?php echo $lang["cookie_text"] ?> \
			<a style="color:#CCCCCC;"><?php echo $lang["cookie_btn"] ?></a>\
		</div>\
		';
                document.querySelector('.cookieconsent a').onclick = function(e) {
                    e.preventDefault();
                    document.querySelector('.cookieconsent').style.display = 'none';
                    localStorage.setItem('cookieconsent', true);
                };
            }
        })();
    </script>
</body>

</html>