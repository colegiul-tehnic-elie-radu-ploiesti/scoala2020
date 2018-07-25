<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Adaugare note | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Adaugare note </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $materie    = intval($_POST['materie']);
    $elev       = intval($_POST['elev']);
    $data_abs   = htmlentities($_POST['dataab'], ENT_QUOTES, 'utf-8');
    $nota       = intval($_POST['nota']);
    $teza       = intval($_POST['teza']);

    if($teza<0 || $teza>1) $teza = 0;

    $tip_eroare = 'alert-danger';

    preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $data_abs, $output_array);

    if( $materie < 1 ) $mesaj_eroare = 'Va rugam sa selectati materia!';
    else
    if( $elev < 1 ) $mesaj_eroare = 'Va rugam selectati elevul';
    else
    if( strlen($data_abs)!=10 ) $mesaj_eroare = 'Formatul datei nu este corect. Data trebuie sa fie de format ZZ/LL/AAAA';
    else
    if( $output_array[0]!=$data_abs ) $mesaj_eroare = 'Formatul datei nu este corect. Data trebuie sa fie de format ZZ/LL/AAAA!';
    else
    if($nota<1 || $nota>10) $mesaj_eroare = 'Nota trebuie sa fie in intervalul 1-10';
    else
    {
        $rezultat = $engine->db->prepare("insert into note( id_elev, id_materie, id_profesor, nota,  data_nota,  is_teza, id_an_scolar, semestru,  data_adaugare) 
                                                    values(:elev,   :materie,    :prof,      :nota,  :dataab,    :teza,   :anscolar,    :semestru, :da)");
        $rezultat->execute(
                array(
                        ':elev'     => $elev,
                        ':materie'  => $materie,
                        ':prof'     => $_SESSION['id_utilizator'],
                        ':nota'     => $nota,
                        ':dataab'   => $data_abs,
                        ':teza'     => $teza,
                        ':anscolar' => $engine->preiaSetare('an_scolar_curent'),
                        ':semestru' => $engine->preiaSetare('semestru_curent'),
                        ':da'       => time(),
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

?>

<form action="" method="POST">

    <label for="materie"> Materie: </label>
    <select class="form-control" name="materie" id="materie" required>

    <?php
        $rezultat = $engine->db->query("select a.* from materii as a left join materii_clase as m on m.id_materie = a.id_materie where m.id_clasa = ".$_SESSION['clasa_diriginte']." order by a.denumire_materie ASC");

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

    <label for="elev"> Elev: </label>
    <select class="form-control" name="elev" id="elev" required>

        <?php
        $rezultat = $engine->db->query("select * from elevi where id_clasa=".$_SESSION['clasa_diriginte']);

        if($rezultat->rowCount()>=1)
        {
            while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
            {
                echo '<option value="'.$row['id_elev'].'"> '.$row['nume_elev'].' </option>';
            }
        }
        else
            echo '<option value="-1"> Nu exista nicio materie in baza de date </option>';
        ?>

    </select>

    <br>

    <label for="dataab"> Data nota: </label>
    <input type="text" name="dataab" id="dataab" class="form-control" placeholder="Introduceti data notei (ZZ/LL/AAAA)..." required>

    <br>

    <label for="nota"> Nota: </label>
    <input type="number" name="nota" id="nota" class="form-control" placeholder="Introduceti nota..." value="10" step="1" min="1" max="10">

    <br>

    <label for="teza"> Teza: </label>
    <select class="form-control" name="teza" id="teza">
        <option value="0"> NU </option>
        <option value="1"> DA </option>
    </select>

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare nota" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>