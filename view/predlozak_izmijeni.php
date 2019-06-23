<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=predlozak/provjeri&akcija='.$predlozak->id?>">
	Naziv predloška:
	<input type="text" autocomplete="off" name="ime" value ="<?php echo $predlozak->ime;?>" ><br>
	Broj mog računa:
	<input type="text" autocomplete="off" name="moj" value ="<?php echo $predlozak->racun_posiljatelj;?>"><br>
	Broj računa primatelja:
	<input type="text" autocomplete="off" name="primatelj" value ="<?php echo $predlozak->racun_primatelj;?>"><br>
	Valuta:
	<input type="text" autocomplete="off" name="valuta" value ="<?php echo $predlozak->valuta;?>"><br>
	<button type="submit" name="izmijeni">Izmijeni!</button>
</form><br>
<a href="index.php?rt=predlozak">Povratak na izbornik predložaka.</a>
<?php echo '<br>' . $message . '<br>';
require_once 'view/_footer.php'; ?>
