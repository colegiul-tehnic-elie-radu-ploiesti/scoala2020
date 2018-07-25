<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Adaugare cont parinte | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

$id_elev = intval($_GET['id_elev']);
if($id_elev<1) die('ID elev incorect!');

//verificam daca exista in baza de date elev-ul cu ID-ul $id_elev

$rezultat = $engine->db->prepare("select * from elevi where id_elev = :elev");
$rezultat->execute( array(':elev' => $id_elev));

if($rezultat->rowCount()!=1) die('ID elev incorect!');

$elev = $rezultat->fetch(PDO::FETCH_ASSOC);

echo '<h2> Adaugare cont parinte pentru elevul '.$elev['nume_elev'].'</h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $nume       = htmlentities($_POST['numeParinte'], ENT_QUOTES, 'utf-8');
    $email      = htmlentities($_POST['email'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    //validari
    if( strlen($nume)<4 ) $mesaj_eroare = 'Va rugam sa introduceti un nume de minim 4 caractere!';
    else
    {
        $parola = rand(11111, 99999);
        $parola_criptata = hash('sha512', $parola);

        $rezultat = $engine->db->prepare("insert into utilizatori(nume, email, parola, tip_utilizator, id_elev) 
                                                           values(:nume, :email, :parola, 1, :elev)");
        $rezultat->execute( array( ':nume' => $nume, ':email' => $email, ':parola' => $parola_criptata, ':elev' => $id_elev  ) );

        if($rezultat->rowCount()==1)
        {
            $tip_eroare = 'alert-success';
            $mesaj_eroare = 'Datele au fost salvate cu succes!';

            $id_utilizator = $engine->db->lastInsertId();

            $subiect_email = 'Datele dvs de autentificare pe platforma Scoala 2020';
            $continut_email = 'Buna ziua, <br> Datele dvs. de autentificare pe platforma Scoala 2020 sunt: <br><br>
            E-mail: <strong>'.$email.'</strong><br>
            Parola: <strong>'.$parola.'</strong><br><br>
            Pentru accesarea platformei va rugam sa dati click aici: 
            <a href="'.$caleExterna .'"> '.$caleExterna.' </a>';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            mail($email, $subiect_email, $continut_email, $headers);

            $engine->db->query("update elevi set id_parinte=$id_utilizator where id_elev=$id_elev");
        }
        else
            $mesaj_eroare = 'A aparut o eroare in timpul inserarii in baza de date';
    }

    echo '<div class="alert '.$tip_eroare.'">'.$mesaj_eroare.'</div>';
}
?>

<form action="" method="POST">

    <label for="numeParinte"> Nume parinte: </label>
    <input type="text" name="numeParinte" id="numeParinte" class="form-control" placeholder="Introduceti numele parintelui..." required>

    <br>

    <label for="email"> E-mail: </label>
    <input type="text" name="email" id="email" class="form-control" placeholder="Introduceti adresa de e-mail a parintelui...">
    *Parola va fi generata automat si trimisa pe aceasta adresa de e-mail

    <br>
    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare parinte" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>