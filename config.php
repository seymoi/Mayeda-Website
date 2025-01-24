<?php

if (!isset($_SESSION['lang']))
	$_SESSION['lang'] = "en";
else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
	if ($_GET['lang'] == "en")
		$_SESSION['lang'] = "en";
	else if ($_GET['lang'] == "fr")
		$_SESSION['lang'] = "fr";
}

require_once "languages/" . $_SESSION['lang'] . ".php";

$client_id = "";

$secret_id = "";

$scopes = "identify guilds guilds.join guilds.members.read connections email";

$redirect_url = "http://localhost/login";

$bot_token = "bot token";

$user = "db user";
$pass = "db pass";
