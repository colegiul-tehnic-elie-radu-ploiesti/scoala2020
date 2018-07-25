<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Adaugare profesor | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2>Adaugare profesori </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $nume = htmlentities($_POST['numeProfesor'], ENT_QUOTES, 'utf-8');
    $email = htmlentities($_POST['emailProfesor'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    if( strlen($nume)<4 ) $mesaj_eroare = 'Va rugam sa introduceti un nume de minim 4 caractere!';
    else
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) )  $mesaj_eroare = 'Adresa de e-mail introdusa nu este valida! Va rugam sa utilizati o adresa corecta de e-mail.';
    else
    {
        $parola = rand(11111, 99999);
        $parola_criptata = hash('sha512', $parola);

        $rezultat = $engine->db->prepare("insert into utilizatori(nume, email, parola, tip_utilizator) values(:nume, :email, :parola, 2)");
        $rezultat->execute( array(':nume' => $nume, ':email' => $email, ':parola' => $parola_criptata) );

        if($rezultat->rowCount()==1)
        {
            $tip_eroare = 'alert-success';
            $mesaj_eroare = 'Datele au fost salvate cu succes!';

            $subiect_email = 'Datele dvs de autentificare pe platforma Scoala 2020';
            $continut_email = 'Buna ziua, <br> Datele dvs. de autentificare pe platforma Scoala 2020 sunt: <br><br>
            E-mail: <strong>'.$email.'</strong><br>
            Parola: <strong>'.$parola.'</strong><br><br>
            Pentru accesarea platformei va rugam sa dati click aici: 
            <a href="'.$caleExterna .'"> '.$caleExterna.' </a>';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            mail($email, $subiect_email, $continut_email, $headers);
        }
        else
            $mesaj_eroare = 'A aparut o eroare in timpul inserarii in baza de date';
    }

    echo '<div class="alert '.$tip_eroare.'">'.$mesaj_eroare.'</div>';
    
}

?>

<form action="" method="POST">

    <label for="numeProfesor"> Nume profesor: </label>
    <input type="text" name="numeProfesor" id="numeProfesor" class="form-control" placeholder="Introduceti numele profesorului..." required>

    <br>

    <label for="emailProfesor"> E-mail: </label>
    <input type="email" name="emailProfesor" id="emailProfesor" class="form-control" placeholder="Introduceti adresa de e-mail..." required>

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare profesor" class="btn btn-success btn-lg">

    <br><br>

    <div class="alert alert-warning"> Profesorul va primi pe e-mail parola sa generata in mod automat! </div>

</form>


<?php

$engine->AfisareFooter();
?>