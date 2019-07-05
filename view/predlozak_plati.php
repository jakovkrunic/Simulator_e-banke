<?php require_once 'view/_header.php';
?>
<script src="./js/login.js"></script>
<h2><?php echo $naslov; ?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=predlozak/transakcija&id_predlozak='.$predlozak->id?>">
	Naziv predloška:
	<?php echo $predlozak->ime;?><br>
	Broj mog računa:
	<?php echo $predlozak->racun_posiljatelj;?><br>
	Broj računa primatelja:
	<?php echo $predlozak->racun_primatelj;?><br>
	Valuta:
	<?php echo $predlozak->valuta;?><br>
	Iznos:
	<input type="number" name="iznos"><br>
	<button type="submit" name="izmijeni">Pošalji zahtjev za transakcijom!</button>
</form><br>
<a href="index.php?rt=predlozak">Povratak na izbornik predložaka.</a>
<?php echo '<br>' . $message . '<br>';
require_once 'view/_footer.php'; ?>
