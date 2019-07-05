<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
    <th>Iznos</th>
    <th>Kamatna stopa</th>
    <th>Valuta</th>
		<th>Uplata</th>
  </tr>
	<?php
		foreach( $stednje as $stednja )
		{
			echo '<tr>' .
			     '<td>' . $stednja->iznos_stednje . '</td>' .
			     '<td>' . $stednja->kamatna_stopa . '</td>' .
           '<td>' . $stednja->valuta . '</td>' ;
					 ?>
					 <td>
						 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=saving/dodaj'?>">
									<input type="hidden" name="dodaj" value="<?php echo $stednja->id; ?>">
									<button class="button" type="submit">Uplati!</button>
								</form>	<br>
						 </td>
					 <?php
			     echo '</tr>';
		}
	?>
</table>
<br>

<div align="center">
	Za otvaranje štednje posjetite nas u nekoj od naših <a href="index.php?rt=user#map">poslovnica</a>.
</div>
<?php
require_once 'view/_footer.php'; ?>
