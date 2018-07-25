<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Adaugare absente | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Adaugare absente </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $materie    = intval($_POST['materie']);
    $elev       = intval($_POST['elev']);
    $data_abs   = htmlentities($_POST['dataab'], ENT_QUOTES, 'utf-8');
    $comentarii = htmlentities($_POST['comentarii'], ENT_QUOTES, 'utf-8');

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
    {
        $rezultat = $engine->db->prepare("insert into absente(id_an_scolar, id_materie, id_clasa, semestru, id_elev, data_absenta, comentarii, motivata, data_adaugare) 
                                                       values(:anscolar,    :materie,   :clasa,  :semestru, :elev,  :dataab,      :comm,       :mm,     :da)");
        $rezultat->execute(
                array(
                        ':anscolar' => $engine->preiaSetare('an_scolar_curent'),
                        ':materie'  => $materie,
                        ':clasa'    => $_SESSION['clasa_diriginte'],
                        ':semestru' => $engine->preiaSetare('semestru_curent'),
                        ':elev'     => $elev,
                        ':dataab'   => $data_abs,
                        ':comm'     => $comentarii,
                        ':mm'       => 0,
                        ':da'       => time()
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

    <label for="dataab"> Data absenta: </label>
    <input type="text" name="dataab" id="dataab" class="form-control" placeholder="Introduceti data absentei (ZZ/LL/AAAA)..." required>

    <br>

    <label for="comentarii"> Comentarii: </label>
    <input type="text" name="comentarii" id="comentarii" class="form-control" placeholder="Introduceti comentariile...">

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare absenta" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>