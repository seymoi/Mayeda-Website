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
?>

<head>
    <title>Mayeda - Démo</title>
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
    <link rel="stylesheet" type="text/css" href="https://localhost/pages/dashboard/css/demo-custom.css">

</head>


<body>
<header> <span class="logo">Demo - Discord Oauth</span>
		<span class="menu">
			<?php
			$auth_url = url($client_id, $redirect_url, $scopes);
			if (isset($_SESSION['user'])) {
				echo '<a href="includes/logout.php"><button class="log-in">LOGOUT</button></a>';
			} else {
				echo "<a href='$auth_url'><button class='log-in'>LOGIN</button></a>";
			}
			?>
		</span>
	</header>
	<h1 style="text-align: center;">A Simple Working Demo of the Script </h2>
		<?php
		if (!isset($_SESSION['user'])) {
			echo "<h2 style='color:red; font-weight:900; text-align: center;'> LOGIN WITH THE LINK ABOVE TO SEE IT WORK! </h2><br/>";
			echo "<h4 style='color:red; font-weight:500; text-align: center;'> IGNORE THE ERRORS IF YOU HAVEN'T LOGGED IN! </h4>";
		}
		?>
		<h2> User Details :</h2>
		<p> Name : <?php echo $_SESSION['username'] . '#' . $_SESSION['discrim']; ?></p>
		<p> ID : <?php echo $_SESSION['user_id']; ?></p>
		<?php
		if (isset($_SESSION['email'])) {
			echo '<p> Email: ' . $_SESSION['email'] . '</p>';
		}
		?>

		<p> Profile Picture : <img src="https://cdn.discordapp.com/avatars/<?php $extention = is_animated($_SESSION['user_avatar']);
																			echo $_SESSION['user_id'] . "/" . $_SESSION['user_avatar'] . $extention; ?>" /></p>
		<br>
		<h2>User Response :</h2>
		<div class="response-block">
			<p><?php echo json_encode($_SESSION['user']); ?></p>
		</div>
		<br>
		<h2> User Guilds :</h2>
		<table border="1">
			<tr>
				<th>NAME</th>
				<th>ID</th>
			</tr>
			<?php
			for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {
				echo "<tr><td>";
				echo $_SESSION['guilds'][$i]['name'];
				echo "<td>";
				echo $_SESSION['guilds'][$i]['id'];
				echo "</td>";
				echo "</tr></td>";
			}
			?>
		</table>
		<br>
		<h2> User Guilds Response :</h2>
		<div class="response-block">
			<p> <?php echo json_encode($_SESSION['guilds']); ?></p>
		</div>
		<br>
		<h2> User Connections :</h2>
		<table border="1">
			<tr>
				<th>NAME</th>
				<th>TYPE</th>
			</tr>
			<?php
			for ($i = 0; $i < sizeof($_SESSION['connections']); $i++) {
				echo "<tr><td>";
				echo $_SESSION['connections'][$i]['name'];
				echo "<td>";
				echo $_SESSION['connections'][$i]['type'];
				echo "</td>";
				echo "</tr></td>";
			}
			?>
		</table>
		<br>
		<h2> User Connections Response :</h2>
		<div class="response-block">
			<p> <?php echo json_encode($_SESSION['connections']); ?></p>
		</div>
</body>