<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Vizualizare materii | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Afisare materii </h2>';

$rezultat = $engine->db->query("select * from materii order by id_materie ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> ID </th>
                <th> Denumire materie </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr>
        <td> '.$row['id_materie'].' </td> 
        <td> '.$row['denumire_materie'].' </td> 
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