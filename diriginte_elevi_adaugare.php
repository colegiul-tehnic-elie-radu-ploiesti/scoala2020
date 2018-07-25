<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Adaugare elev | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Adaugare elev </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $nume       = htmlentities($_POST['numeElev'], ENT_QUOTES, 'utf-8');
    $matricol   = htmlentities($_POST['nrMatricol'], ENT_QUOTES, 'utf-8');
    $adresa     = htmlentities($_POST['adresa'], ENT_QUOTES, 'utf-8');
    $telefon    = htmlentities($_POST['telefon'], ENT_QUOTES, 'utf-8');
    $email      = htmlentities($_POST['email'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    if( strlen($nume)<4 ) $mesaj_eroare = 'Va rugam sa introduceti un nume de minim 4 caractere!';
    else
    if( strlen($matricol)<1 )  $mesaj_eroare = 'Introduceti nr matricol.';
    else
    {
        $rezultat = $engine->db->prepare("insert into elevi(id_clasa, nume_elev, nr_matricol, adresa, telefon, email) values(:clasa, :nume, :matricol, :adresa, :telefon, :email)");
        $rezultat->execute( array( ':clasa' => $_SESSION['clasa_diriginte'],  ':nume' => $nume, ':matricol' => $matricol, ':adresa' => $adresa, ':telefon' => $telefon,  ':email' => $email) );

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

    <label for="numeElev"> Nume elev: </label>
    <input type="text" name="numeElev" id="numeElev" class="form-control" placeholder="Introduceti numele elevului..." required>

    <br>

    <label for="nrMatricol"> Nr matricol: </label>
    <input type="text" name="nrMatricol" id="nrMatricol" class="form-control" placeholder="Introduceti numarul matricol..." required>

    <br>

    <label for="adresa"> Adresa: </label>
    <input type="text" name="adresa" id="adresa" class="form-control" placeholder="Introduceti adresa elevului...">


    <br>

    <label for="telefon"> Telefon: </label>
    <input type="text" name="telefon" id="telefon" class="form-control" placeholder="Introduceti nr de telefon al elevului...">

    <br>

    <label for="email"> E-mail: </label>
    <input type="text" name="email" id="email" class="form-control" placeholder="Introduceti adresa de e-mail a elevului...">



    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare elev" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>