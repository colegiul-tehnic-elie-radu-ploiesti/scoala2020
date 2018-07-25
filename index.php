<?php
require 'configurare.php';

$engine->InitializarePagina('Prima pagina | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
//$engine->InitializareConexiuneDB();
?>


<div class="background">
    <img id="img1" src="img/cafea.jpg">
</div>
<hr>



<?php
$engine->AfisareFooter();
?>