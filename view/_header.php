<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	

	<nav>
		<ul>
			<li><a href="">Naslovnica</a></li>
			<li><a href="">Računi i stanje računa</a></li>
			<li><a href="">Transakcije</a></li>
			<li><a href="">Predlošci</a></li>
			<li><a href="">Štednje</a></li>
			<li><a href="">Krediti</a></li>
		</ul>
	</nav>
	<hr>
	<div class = "user">
	Korisnik:  <?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']; ?> 
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/logout'?>">
	<button class="button" type="submit">Odjavi se</button>
	</form>
	</div>
	 <hr>
	 <br>

