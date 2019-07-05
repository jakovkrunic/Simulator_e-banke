<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
    <th>Opis</th>
    <th>Pošiljatelj</th>
    <th>Primatelj</th>
    <th>Iznos</th>
    <th>Valuta</th>
    <th>Datum</th>
  </tr>
	<?php
		foreach( $transactions as $transaciton )
		{
			echo '<tr>' .
           '<td>' . $transaciton->opis . '</td>' .
			     '<td>' . $transaciton->racun_posiljatelj . '</td>' .
			     '<td>' . $transaciton->racun_primatelj . '</td>' .
           '<td>' . $transaciton->iznos . '</td>' .
			     '<td>' . $transaciton->valuta . '</td>' .
           '<td>' . $transaciton->datum . '</td>' .
			     '</tr>';
		}
	?>
</table>
<?php
require_once 'view/_footer.php'; ?>
