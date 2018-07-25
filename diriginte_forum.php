<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Forum | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $subiect = htmlentities($_POST['subiect'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    if( strlen($subiect)<2 ) $mesaj_eroare = 'Introduceti subiectul de discutie, minim 2 caractere';
    else
    {
        $rezultat = $engine->db->prepare("insert into forum_subiecte(id_clasa, denumire_subiect, initiator, data_adaugare) 
                                                       values(:clasa,   :sub,  :init,     :da)");
        $rezultat->execute(
            array(
                ':clasa'    => $_SESSION['clasa_diriginte'],
                ':sub'      => $subiect,
                ':init'     => $_SESSION['id_utilizator'],
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

echo '<h2> Forum </h2>';

//afisam subiectele de discutie...

$rezultat = $engine->db->query("select * from forum_subiecte where id_clasa=".$_SESSION['clasa_diriginte']." order by denumire_subiect ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table-condensed table-striped" style="width:100%">';
    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr> <td style="width:45px"> <img style="width:40px" src="img/folder.png"> </td> <td> <a href="diriginte_forum_subiect.php?id_subiect='.$row['id_subiect'].'"> <h3>'.$row['denumire_subiect'].' </h3> </a> </td> 
        </tr>';
    }
    echo '</table>';
}
else
    echo '<option value="-1"> Nu exista niciun subiect in baza de date </option>';

?>
<br>

<hr>

<h2> Adaugare subiect nou </h2>

<form action="" method="POST">

    <label for="subiect"> Subiect nou de discutie: </label>
    <input type="text" name="subiect" id="subiect" class="form-control" placeholder="Introduceti denumirea subiectului nou de discutii...">

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare subiect nou" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>