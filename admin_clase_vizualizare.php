<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Vizualizare clase | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Afisare clase </h2>';

$rezultat = $engine->db->query("select a.*, b.nume from clase as a left join utilizatori as b on a.id_diriginte = b.id_utilizator order by a.nivel_clasa ASC, a.sufix_clasa ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> ID </th>
                <th> Clasa </th>
                <th> Diriginte </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr>
        <td> '.$row['id_clasa'].' </td> 
        <td> '.$row['nivel_clasa'].' '.$row['sufix_clasa'].'</td> 
        <td> '.$row['nume'].' </td> 
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