<?php require_once 'view/_header.php';

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src='./js/kreiranje_transakcije.js'></script>
<h2>Nova Transakcija</h2>
<br>
<form class="" action="<?php echo __SITE_URL . '/index.php?rt=transaction/save'?>" method="post">

      <label>Odaberite vaš račun:</label>
      <select name='koji' id="odabirRacuna" required>
      <?php
          foreach ($accts as $key)
             echo "<option value=".$key->id.">".$key->id . " (". $key->valuta_racuna . ")" ."</option>";

          foreach ($assigneeaccts as $opacct){
            echo "<option value=".$opacct->id.">". $opacct->id. " (". $opacct->valuta_racuna . ")" . "</option>";
            }
      ?>
      </select><br>
      <label>Unesite racun primatelja:</label>
      <input name="racun_primatelj" type="number" id="primatelj" value="0"><br>

      <label>Unesite opis:</label>
      <input name="opis" type="textbox"><br>

      <label>Unesite iznos:</label>
      <input name = "iznos" type="number" id="iznos" value="0"><br>

       <!--<label>Odaberite valutu:</label>
      <select name='valuta' id='valutaRacuna'>
      </select><br> -->

      <button class="button" type="submit" id="klik">Do it!</button>
</form>
<?php
require_once 'view/_footer.php'; ?>
