<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Vizualizare materii | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Afisare materii </h2>';

//afisam intai materiile pe semestru I

$an_scolar_curent = $engine->preiaSetare('an_scolar_curent');
$rezultat = $engine->db->query("select * from ani_scolari where id_an_scolar=".$an_scolar_curent." ");
$an_scolar = $rezultat->fetch(PDO::FETCH_ASSOC);

echo '<h3>An scolar '.$an_scolar['denumire_an_scolar'].'</h3>';

$rezultat = $engine->db->query("select a.*,m.denumire_materie from materii_clase as a left join materii as m on a.id_materie = m.id_materie where a.id_clasa=".$_SESSION['clasa_diriginte']."  order by m.denumire_materie ASC");

$i=0;

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> Nr. crt. </th>
                <th> Materie </th>
                <th> Teza </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        $i++;
        echo '<tr>
        <td> '.$i.' </td> 
        <td> '.$row['denumire_materie'].' </td> 
        <td> '.($row['are_teza']==1?'DA':'NU').' </td> 
        </tr>';
    }

    echo '</table>';
}
else
    echo '<div class="alert alert-danger"> Nicio inregistrare in baza de date </div>';

?>

<?php

$engine->AfisareFooter();
?>