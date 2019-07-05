<?php require_once 'view/admin_header.php';
?>

<br>
<script src='./js/kreiranje_racuna.js'></script>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/openSavingUser'?>">
    <label>Upišite tražene podatke </label> <br><br>
    <label>Ime: </label> <input type="text" name="ime"/>
    <label>Prezime: </label> <input type="text" name="prezime"/> 
    <label>OIB: </label> <input type="text" name="oib"> <br><br>

    <label>Početni iznos: </label> <input type="text" name="iznos"/> <br>
    <label>Kamatna stopa: </label> <input type="text" name="kamatna_stopa"/> <br>
    <label>Valuta: </label> 
    <select name='valuta'>
    <option value='HRK' selected >HRK</option>
    <option value='AUD'>AUD</option>
    <option value='BAM'>BAM</option>
    <option value='CAD'>CAD</option>
    <option value='CHF'>CHF</option>
    <option value='DKK'>DKK</option>
    <option value='EUR'>EUR</option>
    <option value='GBP'>GBP</option>
    <option value='JPY'>JPY</option>
    <option value='NOK'>NOK</option>
    <option value='RSD'>RSD</option>
    <option value='SEK'>SEK</option>
    <option value='USD'>USD</option>
    </select><br>  <br>

    <button class="button" type="submit">Otvori štednju korisniku!</button>
</form>	

<?php

if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';

?>
