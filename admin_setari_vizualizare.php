<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Vizualizare setari | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Vizualizare setari </h2>';

$rezultat = $engine->db->query("select * from setari");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> Setare </th>
                <th> Valoare </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr>
        <td> '.$row['setare'].' </td> 
        <td> '.$row['valoare'].' </td> 
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