<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<br>
<table>
	<tr>
    <th>Naziv predloška</th>
    <th>Račun s kojeg šaljem</th>
		<th>Račun na koji šaljem</th>
    <th>Račun primatelja</th>
    <th>Valuta</th>
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
			     '</tr>';
		}
	?>
</table>
<?php
require_once 'view/_footer.php'; ?>
