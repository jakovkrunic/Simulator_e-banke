<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
    <th>Iznos</th>
    <th>Kamatna stopa</th>
    <th>Valuta</th>
  </tr>
	<?php
		foreach( $stednje as $stednja )
		{
			echo '<tr>' .
			     '<td>' . $stednja->iznos_stednje . '</td>' .
			     '<td>' . $stednja->kamatna_stopa . '</td>' .
           '<td>' . $stednja->valuta . '</td>' .
			     '</tr>';
		}
	?>
</table>
<br>

<div align="center">
	Za otvaranje štednje posjetite nas u nekoj od naših <a href="index.php?rt=user#map">poslovnica</a>.
</div>
<?php
require_once 'view/_footer.php'; ?>
