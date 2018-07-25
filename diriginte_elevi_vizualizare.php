<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Vizualizare elevi | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

echo '<h2> Afisare elevi </h2>';

$rezultat = $engine->db->query("select a.*,b.nume from elevi as a left join utilizatori as b on a.id_parinte = b.id_utilizator where a.id_clasa=".$_SESSION['clasa_diriginte']."  order by a.nume_elev ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table table-bordered table-striped table-hover">
            <tr>
                <th> ID </th>
                <th> Nume </th>
                <th> Nr. matricol </th>
                <th> Adresa </th>
                <th> Telefon </th>
                <th> Email </th>
                <th> Cont parinte </th>
            </tr>';

    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr>
        <td> '.$row['id_elev'].' </td> 
        <td> '.$row['nume_elev'].' </td> 
        <td> '.$row['nr_matricol'].' </td> 
        <td> '.$row['adresa'].' </td> 
        <td> '.$row['telefon'].' </td> 
        <td> '.$row['email'].' </td> 
        <td> '.($row['id_parinte']>0?$row['nume']:'<a href="diriginte_elevi_adaugare_cont_parinte.php?id_elev='.$row['id_elev'].'" class="btn btn-success btn-sm"> adaugare cont parinte </a>').' </td> 
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