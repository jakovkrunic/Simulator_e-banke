<?php require_once 'view/_header.php';
?>
<script src="./js/login.js"></script>
<h2><?php echo $naslov; ?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=account/provjera&id_racun='.$racun->id?>">
	Tip računa:
	<?php echo $racun->tip_racuna;?><br>
	Unesite OIB osobe kojoj želite dati punomoć:
	<input type="text" name="oib" id="oib"/> <p id="OIBerror"></p> <br>
	<button type="submit" name="posalji">Pošalji zahtjev za davanjem punomoći!</button>
</form><br>
<?php echo '<br>' . $message . '<br>';
require_once 'view/_footer.php'; ?>
