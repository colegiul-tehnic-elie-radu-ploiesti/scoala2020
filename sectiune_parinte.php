<?php
require 'configurare.php';

$engine->VerificareParinte();

$engine->InitializarePagina('Sectiune parinti | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuParinte();


$ultimele_24_ore = time() - 24 * 60 * 60;

$rezultat = $engine->db->query("select a.*, b.id_clasa from forum_mesaje as a left join forum_subiecte as b on b.id_subiect=a.id_subiect where a.data_adaugare>".$ultimele_24_ore." and b.id_clasa = ".$_SESSION['id_clasa']." ");

$mesaje_azi = $rezultat->rowCount();



$note = $engine->db->query("select * from note where data_adaugare>".$ultimele_24_ore." and id_elev = ".$_SESSION['id_elev']." ");

$note_azi = $note->rowCount();


$absente = $engine->db->query("select * from absente where data_adaugare>".$ultimele_24_ore." and id_elev = ".$_SESSION['id_elev']." ");

$absente_azi = $absente->rowCount();


?>
    <div class="row text-center">
    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Acces Parinte:</h3>
            </div>
            <div class="panel-body">
                <a class="btn btn-primary btn-block" href="parinte_catalog.php"> Catalog </a> <br>
                <a class="btn btn-primary btn-block" href="parinte_forum.php"> Forum </a> <br>
            </div>
        </div>
    </div>



    <div class="row text-center">
    <div class="col-md-6 col-xs-12">
    <div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Statistici:</h3>
    </div>
        <div class="panel-body">
            <button class="btn btn-success">
                Mesaje pe forum in ultimele 24 ore: <span class="badge"><?php echo $mesaje_azi; ?></span>
            </button> <br> <br>
    <button class="btn btn-success">
        Note adaugate in ultimele 24 ore: <span class="badge"><?php echo $note_azi; ?></span>
    </button><br><br>
            <button class="btn btn-success">
                Absente adaugate in ultimele 24 ore: <span class="badge"><?php echo $absente_azi; ?></span>
            </button><br><br>
        </div>
    </div>
    </div>
    </div>
    </div>


<br><br>
<?php

$engine->AfisareFooter();
?>