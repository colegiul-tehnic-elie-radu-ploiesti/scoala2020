<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Adaugare materii | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Adaugare materii </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $materie    = intval($_POST['materie']);
    $teza       = intval($_POST['teza']);

    $tip_eroare = 'alert-danger';

    if( $materie<1 ) $mesaj_eroare = 'Va rugam sa selectati materia!';
    else
    {
        $rezultat = $engine->db->prepare("insert into materii_clase(id_clasa, id_materie, id_an_scolar, are_teza) 
                                                            values(:clasa,   :materie,   :anscolar,    :teza)");
        $rezultat->execute(
                array(
                        ':clasa'    => $_SESSION['clasa_diriginte'],
                        ':materie'  => $materie,
                        ':anscolar' => $engine->preiaSetare('an_scolar_curent'),
                        ':teza'     => $teza) );

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

    <label for="materie"> Materie: </label>
    <select class="form-control" name="materie" id="materie">

    <?php
        $rezultat = $engine->db->query("select * from materii order by denumire_materie ASC");

        if($rezultat->rowCount()>=1)
        {
            while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
            {
                echo '<option value="'.$row['id_materie'].'"> '.$row['denumire_materie'].' </option>';
            }
        }
        else
        echo '<option value="-1"> Nu exista nicio materie in baza de date </option>';
    ?>

    </select>

    <br>

    <label for="teza"> Teza: </label>
    <select class="form-control" name="teza" id="teza">
        <option value="0"> NU </option>
        <option value="1"> DA </option>
    </select>

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare materie" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>