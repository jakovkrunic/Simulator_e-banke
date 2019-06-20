<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="./js/login.js"></script>
</head>
<body>
	<h1><?php echo $title; ?></h1>

	
	<br> <br>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/provjeri'?>">
   		OIB:
  		<input type="text" name="oib" id="oib"/> <p id="OIBerror"></p> <br>
		email:
  		<input type="text" name="email" />
  		<br /> <br>
  		Lozinka:
  		<input type="password" name="password" />
  		<br /> <br>
  		<button class="button" type="submit">Ulogiraj se!</button>
  	</form>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/registracija_stranica'?>">
	Želite li zatražiti otvaranje novog korisničkog računa u našoj banci, kliknite ovdje! <button class="button" type="submit">Pošalji zahtjev!</button>
	</form>
	<?php echo '<br>' . $message . '<br>'; ?>
  <?php require_once __SITE_PATH . '/view/_footer.php'; ?>
