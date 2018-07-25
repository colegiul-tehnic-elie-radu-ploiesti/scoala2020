<?php
require 'configurare.php';

$engine->InitializarePagina('Despre proiect| Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
//$engine->InitializareConexiuneDB();
?>

<div class="row">

    <div class="page-heading text-center">
        <h1 id="h1">Despre "Scoala 2020"</h1>
    </div>
</div>
<hr>
<div class="row">
    <img id="tabla" src="img/tabla.jpg">

</div>
<hr>


<?php
$engine->AfisareFooter();
?>
