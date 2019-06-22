<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<br>
<table>
	<tr>
    <th>Naziv predloška</th>
    <th>Moj račun</th>
    <th>Račun primatelja</th>
    <th>Valuta</th>
  </tr>
	<?php
		for($i=0;$i<count($platni);$i++)
		{
			echo '<tr>' .
			     '<td>' . $platni[$i]->ime . '</td>' .
			     '<td>' . $tipovi[$i] . '</td>' .
           '<td>' . $platni[$i]->racun_primatelj . '</td>' .
			     '<td>' . $platni[$i]->valuta . '</td>' .
			     '</tr>';
		}
	?>
</table>
<?php
require_once 'view/_footer.php'; ?>
