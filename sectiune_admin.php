<?php
require 'configurare.php';

$engine->VerificareAdmin();

$engine->InitializarePagina('Administrare | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
//$engine->InitializareConexiuneDB();

$engine->AfisareMeniuAdministrator();

?>

<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Profesori:</h3>
            </div>
            <div class="panel-body">
                <a class="btn btn-primary btn-block" href="admin_profesori_adaugare.php"> Adaugare profesor </a> <br>
                <a class="btn btn-primary btn-block" href="admin_profesori_vizualizare.php"> Vizualizare profesori </a> <br>
            </div>
        </div>
    </div>



        <div class="col-md-6 col-xs-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Clase:</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-success btn-block" href="admin_clase_adaugare.php"> Adaugare clase </a> <br>
                    <a class="btn btn-success btn-block" href="admin_clase_vizualizare.php"> Vizualizare clase </a> <br>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Materii:</h3>
            </div>
            <div class="panel-body">
                <a class="btn btn-danger btn-block" href="admin_materii_vizualizare.php"> Vizualizare materii </a> <br>
                <a class="btn btn-danger btn-block" href="admin_materii_adaugare.php"> Adaugare materie </a> <br>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Unelte:</h3>
            </div>
            <div class="panel-body">
                <a class="btn btn-warning btn-block" href="admin_setari_vizualizare.php"> Setari </a> <br>
                <a class="btn btn-warning btn-block" href="deconectare.php"> Deconectare </a> <br>
            </div>
        </div>
    </div>

</div>


<?php

$engine->AfisareFooter();
?>