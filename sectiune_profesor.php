<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Sectiune profesor | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
//$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();

?>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Elevi:</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary btn-block" href="diriginte_elevi_adaugare.php"> Adaugare elevi </a> <br>
                    <a class="btn btn-primary btn-block" href="diriginte_elevi_vizualizare.php"> Vizualizare elevi </a> <br>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Materii:</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-success btn-block" href="diriginte_materii_adaugare.php"> Adaugare materii </a> <br>
                    <a class="btn btn-success btn-block" href="diriginte_materii_vizualizare.php"> Vizualizare materii </a> <br>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Catalog</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-block" href="diriginte_note_adaugare.php"> Adaugare nota </a> <br>
                    <a class="btn btn-danger btn-block" href="diriginte_absente_adaugare.php"> Adaugare absenta </a> <br>
                    <a class="btn btn-danger btn-block" href="diriginte_catalog.php"> Vizualizare catalog</a> <br>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">Forum:</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-warning btn-block" href="diriginte_forum.php"> Accesare forum </a> <br>
                </div>
            </div>
        </div>

    </div>





<?php

$engine->AfisareFooter();
?>