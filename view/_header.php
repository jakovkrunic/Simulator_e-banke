<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="icon" href="https://d29fhpw069ctt2.cloudfront.net/icon/image/49289/preview.svg">
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


	<nav>
		<ul>
			<li><a href="index.php?rt=user">Naslovnica</a></li>
			<li><a href="index.php?rt=account">Računi i stanje računa</a></li>
			<li><a href="index.php?rt=transaction">Transakcije</a></li>
			<li><a href="index.php?rt=periodic"> Periodičke transakcije</a></li>
			<li><a href="index.php?rt=predlozak">Predlošci</a></li>
			<li><a href="index.php?rt=saving">Štednje</a></li>
			<li><a href="index.php?rt=credit">Krediti</a></li>
		</ul>
	</nav>

	<div class = "user">
	Korisnik:  <?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']; ?>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/logout'?>">
	<button class="button" type="submit">Odjavi se</button>
	</form>
	</div>

	 <br>
