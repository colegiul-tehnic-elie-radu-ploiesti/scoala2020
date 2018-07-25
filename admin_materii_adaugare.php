<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Adaugare materie | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Adaugare materie </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $nume = htmlentities($_POST['denumire'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    if( strlen($nume)<4 ) $mesaj_eroare = 'Va rugam sa introduceti denumirea materiei,  minim 4 caractere!';
    else
    {
        $rezultat = $engine->db->prepare("insert into materii(denumire_materie) values(:nume)");
        $rezultat->execute( array(':nume' => $nume) );

        if($rezultat->rowCount()==1)
        {
            $tip_eroare = 'alert-success';
            $mesaj_eroare = 'Datele au fost salvate cu succes!';
        }
        else
            $mesaj_eroare = 'A aparut o eroare in timpul inserarii in baza de date';
    }

    echo '<div class="alert '.$tip_eroare.'">'.$mesaj_eroare.'</div>';
}

?>

<form action="" method="POST">

    <label for="denumire"> Denumire materie: </label>
    <input type="text" name="denumire" id="denumire" class="form-control" placeholder="Introduceti denumirea materiei..." required>

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare materie" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>