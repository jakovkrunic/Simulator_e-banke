<?php require_once 'view/_header.php';
?>
<script src='./js/confirm_predlozak.js'></script>
<h2><?php echo $naslov; ?></h2>
<br>
<table>
	<tr>
    <th>Naziv predloška</th>
    <th>Moj račun</th>
    <th>Račun primatelja</th>
    <th>Valuta</th>
		<th></th>
		<th></th>
  </tr>
	<?php
		for($i=0;$i<count($platni);$i++)
		{
			echo '<tr>' .
			     '<td>' . $platni[$i]->ime . '</td>' .
			     '<td>' . $tipovi[$i] . '</td>' .
           '<td>' . $platni[$i]->racun_primatelj . '</td>' .
			     '<td>' . $platni[$i]->valuta . '</td>' .
					 '<td><a href="index.php?rt=predlozak/izmijeni&id_predlozak='.$platni[$i]->id.'">Izmijeni</a></td>' .
					 '<td><a href="index.php?rt=predlozak/obrisi&id_predlozak='.$platni[$i]->id.'" class="brisanje">Obriši</a></td>' .
			     '</tr>';
		}
	?>
</table><br>
<a href="index.php?rt=predlozak">Povratak na izbornik predložaka.</a>
<?php
require_once 'view/_footer.php'; ?>
