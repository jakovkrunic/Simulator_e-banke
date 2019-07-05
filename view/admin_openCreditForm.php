<?php require_once 'view/admin_header.php';

?>

<br>
<script src='./js/kreiranje_racuna.js'></script>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/openCreditOpen'?>">
    <label>Upišite tražene podatke. </label> <br><br>

    <label>OIB: </label> <input type="text" name="oib"  id="oib" value="<?php echo $oib_korisnika; ?>" disabled />
    <label>Ime: </label> <input type="text" name="ime" id="ime" value="<?php echo $ime_korisnika; ?>" disabled/>
    <label>Prezime: </label> <input type="text" name="prezime"  id="prezime" value="<?php echo $prezime_korisnika; ?>" disabled/> <br>

    <label>Račun:</label>
    <select name='vrsta' id="vrstaRacuna" required>
    <?php 
        $brojac = 0;
        foreach ($racuni as $key) {
            if($brojac==0)
                echo "<option selected value=".$key->tip_racuna.">".$key->tip_racuna."</option>";
            else echo "<option value=".$key->tip_racuna.">".$key->tip_racuna."</option>";
            $brojac++;
        }
    ?>
    </select><br>
    <label>Valuta računa:</label>
    <select name='valuta' id='valutaRacuna'>
    </select><br>

    <label>Iznos kredita: </label> <input type="text" name="iznos"/> <br>
    <label>Rata kredita: </label> <input type="text" name="rata"/> <br>
    <label>Kamatna stopa: </label> <input type="text" name="kamatna_stopa"/> <br>
    
    
    <button class="button" type="submit">Otvori kredit korisniku!</button>
</form>	

<?php

if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';

?>
