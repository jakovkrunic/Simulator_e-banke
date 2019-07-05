<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
    <th>Iznos</th>
    <th>Kamatna stopa</th>
    <th>Rata plaćanja</th>
    <th>Valuta</th>
  </tr>
	<?php
		foreach( $krediti as $kredit )
		{
			echo '<tr>' .
			     '<td>' . $kredit->iznos_kredita . '</td>' .
			     '<td>' . $kredit->kamatna_stopa . '</td>' .
           '<td>' . $kredit->rata_placanja . '</td>' .
			     '<td>' . $kredit->valuta . '</td>' .
			     '</tr>';
		}
	?>
</table>
<br>

<div align="center">
	Za dizanje kredita posjetite nas u nekoj od naših <a href="index.php?rt=user#map">poslovnica</a>.
</div>
<?php
require_once 'view/_footer.php'; ?>
