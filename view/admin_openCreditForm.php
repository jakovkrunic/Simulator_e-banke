<?php require_once 'view/admin_header.php';

?>

<br>
<script src='./js/kreiranje_racuna.js'></script>
<script src='./js/za_kredit.js'></script>

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
            if($key->tip_racuna !== "devizni")
            {
            if($brojac==0)
                echo "<option selected value=".$key->tip_racuna.">".$key->tip_racuna."</option>";
            else echo "<option value=".$key->tip_racuna.">".$key->tip_racuna."</option>";
            $brojac++;
            }
        }
    ?>
    </select><br>
    <label>Valuta računa:</label>
    <select name='valuta' id='valutaRacuna'>
    </select><br>

    <label>Iznos kredita: </label> <input type="text" name="iznos" id="iznos"/> <br>    
    <label>Kamatna stopa: </label> <input type="text" name="kamatna_stopa" id="kamatna_stopa"/> <br>    
    <label>Vrijeme u godinama: </label> <input type="text" name="godine" id="godine"/> <br>
    <label>Rata kredita: </label> <input type="text" name="rata" id="rata"/> <br>
    <span id='ukupne_kamate'></span> <br>
    <span id='ukupni_iznos'></span> <br>
    
    <button class="button" type="submit">Otvori kredit korisniku!</button>
</form>	

<?php

if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';

?>
