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

 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=periodic/new'?>">
 			<button class="button" type="submit">Nova transakcija</button>
 		</form>	<br>

 <h2> Lista periodičkih transakcija </h2>

 <table align="center">
 	<tr>
     <th>Opis</th>
     <th>Pošiljatelj</th>
     <th>Primatelj</th>
     <th>Iznos</th>
     <th>Valuta</th>
 		<th>Status</th>
    <th> Period </th>
     <th>Datum sljedeće</th>
 		<th>Poništi</th>
   </tr>
 	<?php
 		foreach( $periodic_transactions as $transaction )
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
           echo '<td>' . $transaction->period . '</td>';
            echo '<td>' . $transaction->datum_sljedece . '</td>' ;
            ?>
 					 <td>
 						 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=periodic/undo'?>">
 							  	<input type="hidden" name="ponisti" value="<?php echo $transaction->id; ?>">
 						 			<button class="button" type="submit">Poništi</button>
 						 		</form>	<br>
 						 </td>

 					 <?php
 			     echo '</tr>';
 			}
 			foreach ($assignee_periodic_trans as $trans) {

 			foreach($trans as $transaction)
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
             echo '<td>' . $transaction->period . '</td>';
              echo '<td>' . $transaction->datum_sljedece . '</td>' ;
   					 ?>
   					 <td>
   						 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=periodic/undo'?>">
   							  	<input type="hidden" name="ponisti" value="<?php echo $transaction->id; ?>">
   						 			<button class="button" type="submit">Poništi</button>
   						 		</form>	<br>
   						 </td>

   					 <?php
   			     echo '</tr>';
 			}
 		}
 	?>
 </table>
