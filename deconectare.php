<?php
require 'configurare.php';

$engine->InitializarePagina('Deconectare | Platforma Scoala 2020');
session_unset();
session_destroy();
$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
//$engine->InitializareConexiuneDB();
?>

<div class="alert alert-success"> Ati fost deconectat cu succes! <br><br> La revedere! </div>


<?php


$engine->AfisareFooter();
?>