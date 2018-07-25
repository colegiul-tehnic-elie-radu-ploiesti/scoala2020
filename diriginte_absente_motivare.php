<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Motivare absenta | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

$id_absenta = intval($_GET['id_absenta']);
if($id_absenta<1) die('ID absenta incorect');

//verificam daca exista absenta in baza de date

$rezultat = $engine->db->query("select * from absente where id_absenta = $id_absenta");
if($rezultat->rowCount()!=1)
{
    die('ID absenta incorect!');
}
else
{
    $absenta = $rezultat->fetch(PDO::FETCH_ASSOC);
}

echo '<h2> Motivare absenta din '.$absenta['data_absenta'].'</h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $data_abs   = htmlentities($_POST['dataab'], ENT_QUOTES, 'utf-8');
    $comentarii = htmlentities($_POST['comentarii'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $data_abs, $output_array);

    if( strlen($data_abs)!=10 ) $mesaj_eroare = 'Formatul datei nu este corect. Data trebuie sa fie de format ZZ/LL/AAAA';
    else
    if( $output_array[0]!=$data_abs ) $mesaj_eroare = 'Formatul datei nu este corect. Data trebuie sa fie de format ZZ/LL/AAAA!';
    else
    {
        $rezultat = $engine->db->prepare("update absente set motivata=1, data_motivare = :dm, comentarii_motivare = :cm where id_absenta = :id");
        $rezultat->execute(
                array(
                        ':id' => $id_absenta,
                        ':dm'   => $data_abs,
                        ':cm'     => $comentarii
                    ) );

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
else
{

}
?>

<form action="" method="POST">

    <label for="dataab"> Data motivare: </label>
    <input type="text" name="dataab" id="dataab" class="form-control" placeholder="Introduceti data motivarii (ZZ/LL/AAAA)..." required>

    <br>

    <label for="comentarii"> Comentarii motivare: </label>
    <input type="text" name="comentarii" id="comentarii" class="form-control" placeholder="Introduceti comentariile...">

    <br>

    <input type="submit" name="butonAdaugare" value="Motivare absenta" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>