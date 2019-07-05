<?php require_once 'view/_header.php';
?>
<?php if (isset($poruka)){
	?>
	<div style = "text-align: center">
		<?php echo $poruka;  ?>
	</div>
	<br>
	<?php
}

 ?>

 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=transaction/new'?>">
 			<button class="button" type="submit">Nova transakcija</button>
 		</form>	<br>

 <h2> Poslane transakcije</h2>
<table align="center">
	<tr>
    <th>Opis</th>
    <th>Pošiljatelj</th>
    <th>Primatelj</th>
    <th>Iznos</th>
    <th>Valuta</th>
		<th>Status</th>
    <th>Datum</th>
		<th>Poništi</th>
  </tr>
	<?php
		foreach( $transactions as $transaction )
		{
			echo '<tr>' .
           '<td>' . $transaction->opis . '</td>' .
			     '<td>' . $transaction->racun_posiljatelj . '</td>' .
			     '<td>' . $transaction->racun_primatelj . '</td>' .
           '<td>' . $transaction->iznos . '</td>' .
			     '<td>' . $transaction->valuta . '</td>' ;
					 if ($transaction->odobrena==1) echo
					 '<td> Approved </td>' ;
					 else if($transaction->odobrena==-1)echo
					 '<td> Denied </td>' ;
					 else echo '<td> Pending </td>' ;
           echo '<td>' . $transaction->datum . '</td>' ;
					 if ($transaction->odobrena==0) { ?>
					 <td>
						 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=transaction/undo'?>">
							  	<input type="hidden" name="ponisti" value="<?php echo $transaction->id; ?>">
						 			<button class="button" type="submit">Poništi</button>
						 		</form>	<br>
						 </td>

					 <?php }
					 else echo '<td> </td>' ;
			     echo '</tr>';
		}
	?>
</table>
<br>
<h2> Primljene transakcije</h2>
<table align="center">
	<tr>
    <th>Opis</th>
    <th>Pošiljatelj</th>
    <th>Primatelj</th>
    <th>Iznos</th>
    <th>Valuta</th>
		<th>Status</th>
    <th>Datum</th>
  </tr>
	<?php
		foreach( $incomingtransactions as $transaction )
		{
			echo '<tr>' .
           '<td>' . $transaction->opis . '</td>' .
			     '<td>' . $transaction->racun_posiljatelj . '</td>' .
			     '<td>' . $transaction->racun_primatelj . '</td>' .
           '<td>' . $transaction->iznos . '</td>' .
			     '<td>' . $transaction->valuta . '</td>' ;
					 if ($transaction->odobrena==1) echo
					 '<td> Approved </td>' ;
					 else if($transaction->odobrena==-1)echo
					 '<td> Denied </td>' ;
					 else echo '<td> Pending </td>' ;
           echo '<td>' . $transaction->datum . '</td>' ;
			     echo '</tr>';
		}
	?>
</table>
<br>

<?php
require_once 'view/_footer.php'; ?>
