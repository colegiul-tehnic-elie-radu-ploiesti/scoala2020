<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Adaugare clasa | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

echo '<h2> Adaugare clase </h2>';

/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $clasa = intval($_POST['clasa']);
    $sufix = htmlentities($_POST['sufix'], ENT_QUOTES, 'utf-8');
    $diriginte = intval($_POST['diriginte']);

    $tip_eroare = 'alert-danger';

    $clasa_existenta = $engine->db->prepare("select id_clasa from clase where nivel_clasa=:nivel and sufix_clasa=:sufx");
    $clasa_existenta->execute( array(':nivel' => $clasa, ':sufx' => $sufix) );

    $diriginte_existent = $engine->db->prepare("select id_clasa from clase where id_diriginte=:diriginte");
    $diriginte_existent->execute( array(':diriginte' => $diriginte) );

    if($clasa_existenta->rowCount()>=1) $mesaj_eroare = 'Clasa '.$clasa.' '.$sufix.' exista deja in baza de date!';
    else
    if($diriginte_existent->rowCount()>=1) $mesaj_eroare = 'Dirigintele cu ID '.$diriginte.' are deja o clasa asociata si nu poate fi diriginte la mai multe clase in acelasi timp!';
    else
    if( $clasa<1 || $clasa>12 ) $mesaj_eroare = 'Va rugam sa selectati clasa.';
    else
    if( $diriginte<0 )  $mesaj_eroare = 'Va rugam sa selectati profesorul diriginte.';
    else
    if( strlen($sufix)<1 ) $mesaj_eroare = 'Va rugam sa introduceti sufixul clasei';
    else
    {
        $rezultat = $engine->db->prepare("insert into clase(nivel_clasa, sufix_clasa, id_diriginte) values(:nivel, :sufx, :diriginte)");
        $rezultat->execute( array(':nivel' => $clasa, ':sufx' => $sufix, ':diriginte' => $diriginte) );

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

    <label for="clasa"> Clasa: </label>
    <select class="form-control" name="clasa" id="clasa">
        <option value="1"> I </option>
        <option value="2"> II </option>
        <option value="3"> III </option>
        <option value="4"> IV </option>
        <option value="5"> V </option>
        <option value="6"> VI </option>
        <option value="7"> VII </option>
        <option value="8"> VIII </option>
        <option value="9"> IX </option>
        <option value="10"> X </option>
        <option value="11"> XI </option>
        <option value="12"> XII </option>
    </select>

    <br>

    <label for="sufix"> Sufix: </label>
    <input type="text" name="sufix" id="sufix" class="form-control" placeholder="A, B, C..." required>

    <br>

    <label for="diriginte"> Diriginte: </label>
    <select class="form-control" name="diriginte" id="diriginte">

    <?php
        $rezultat = $engine->db->query("select id_utilizator, nume from utilizatori where tip_utilizator=2 order by id_utilizator ASC");

        if($rezultat->rowCount()>=1)
        {
            while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
            {
                echo '<option value="'.$row['id_utilizator'].'"> '.$row['nume'].' </option>';
            }
        }
        else
            echo '<option value="-1"> Nu exista niciun profesor in baza de date </option>';
    ?>
    </select>

    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare clasa" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>