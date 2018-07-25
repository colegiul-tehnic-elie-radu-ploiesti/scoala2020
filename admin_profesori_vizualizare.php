<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Vizualizare profesori | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Afisare profesori </h2>';

$rezultat = $engine->db->query("select id_utilizator, email, nume, tip_utilizator from utilizatori where tip_utilizator=2 order by id_utilizator ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> ID </th>
                <th> Nume </th>
                <th> Email </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr>
        <td> '.$row['id_utilizator'].' </td> 
        <td> '.$row['nume'].' </td> 
        <td> '.$row['email'].' </td> 
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