<?php require_once 'view/_header.php';

?>
<h2>Nova Transakcija</h2>
<br>
<script src='./js/kreiranje_transakcije.js'></script>
<form class="" action="<?php echo __SITE_URL . '/index.php?rt=transaction/save'?>" method="post">

      <label>Odaberite vaš račun:</label>
      <select name='koji' id="odabirRacuna" required>
      <?php
          foreach ($accts as $key)
             echo "<option value=".$key->id.">".$key->id . " (". $key->valuta_racuna . ")" ."</option>";
      ?>
      </select><br>
      <label>Unesite racun primatelja:</label>
      <input name="racun_primatelj" type="number" value="0"><br>

      <label>Unesite opis:</label>
      <input name="opis" type="textbox"><br>

      <label>Unesite iznos:</label>
      <input name = "iznos" type="number" value="0"><br>

       <!--<label>Odaberite valutu:</label>
      <select name='valuta' id='valutaRacuna'>
      </select><br> -->

      <button class="button" type="submit">Do it!</button>
</form>
<?php
require_once 'view/_footer.php'; ?>
