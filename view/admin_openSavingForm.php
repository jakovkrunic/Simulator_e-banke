<?php require_once 'view/admin_header.php';

?>

<br>
<script src='./js/kreiranje_racuna.js'></script>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/openSavingOpen'?>">
    <label>Upišite tražene podatke. </label> <br><br>

    <label>OIB: </label> <input type="text" name="oib"  id="oib" value="<?php echo $oib_korisnika; ?>" disabled />
    <label>Ime: </label> <input type="text" name="ime" id="ime" value="<?php echo $ime_korisnika; ?>" disabled/>
    <label>Prezime: </label> <input type="text" name="prezime"  id="prezime" value="<?php echo $prezime_korisnika; ?>" disabled/> <br>

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
    </select><br>  
    
    <button class="button" type="submit">Otvori štednju korisniku!</button>
</form>	

<?php

if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';

?>
