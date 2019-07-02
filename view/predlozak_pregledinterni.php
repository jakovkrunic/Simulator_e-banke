<?php require_once 'view/_header.php';
?>
<script src='./js/confirm_predlozak.js'></script>
<h2><?php echo $naslov; ?></h2>
<br>
<table>
	<tr>
    <th>Naziv predloška</th>
    <th>Račun s kojeg šaljem</th>
		<th>Račun na koji šaljem</th>
    <th>Račun primatelja</th>
    <th>Valuta</th>
		<th></th>
		<th></th>
  </tr>
	<?php
		for($i=0;$i<count($interni);$i++)
		{
			echo '<tr>' .
			     '<td>' . $interni[$i]->ime . '</td>' .
			     '<td>' . $tipovi1[$i] . '</td>' .
					 '<td>' . $tipovi2[$i] . '</td>' .
           '<td>' . $interni[$i]->racun_primatelj . '</td>' .
			     '<td>' . $interni[$i]->valuta . '</td>' .
					 '<td><a href="index.php?rt=predlozak/plati&id_predlozak='.$interni[$i]->id.'">Unos</a></td>' .
					 '<td><a href="index.php?rt=predlozak/izmijeni&id_predlozak='.$interni[$i]->id.'">Izmijeni</a></td>' .
					 '<td><a href="index.php?rt=predlozak/obrisi&id_predlozak='.$interni[$i]->id.'" class="brisanje">Obriši</a></td>' .
			     '</tr>';
		}
	?>
</table><br>
<a href="index.php?rt=predlozak">Povratak na izbornik predložaka.</a>
<?php
require_once 'view/_footer.php'; ?>
