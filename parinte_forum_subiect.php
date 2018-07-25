<?php
require 'configurare.php';

$engine->VerificareParinte();

$engine->InitializarePagina('Forum | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuParinte();


$id_subiect = intval($_GET['id_subiect']);

if($id_subiect<1) die('ID subiect incorect');


/* Salvare date din formular */

if( isset($_POST['butonAdaugare']) )
{
    $mesaj = htmlentities($_POST['mesaj'], ENT_QUOTES, 'utf-8');

    $tip_eroare = 'alert-danger';

    if( strlen($mesaj)<2 ) $mesaj_eroare = 'Introduceti mesajul, minim 2 caractere';
    else
    {
        $rezultat = $engine->db->prepare("insert into forum_mesaje(id_subiect, mesaj, id_autor, data_adaugare) 
                                                                  values(:subiect,   :mesaj,  :autor,     :da)");
        $rezultat->execute(
            array(
                ':subiect'    => $id_subiect,
                ':mesaj'      => $mesaj,
                ':autor'      => $_SESSION['id_utilizator'],
                ':da'       => time()
            ) );

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

$subiect = $engine->db->query("select * from forum_subiecte where id_subiect = $id_subiect");

if($subiect->rowCount()!=1) die('ID Subiect incorect!');

$subiect = $subiect->fetch(PDO::FETCH_ASSOC);

echo '<h2> '.$subiect['denumire_subiect'].' </h2>';

//afisam mesajele din topicul curent...

$rezultat = $engine->db->query("select a.*, b.nume from forum_mesaje as a left join utilizatori as b on b.id_utilizator=a.id_autor where a.id_subiect = ".$id_subiect." order by data_adaugare ASC");

if($rezultat->rowCount()>=1)
{
    echo '<table class="table-condensed table-striped" style="width:100%">
<tr>
    <th>Mesaj</th>
    <th>Postat de</th>
    <th>Data postare</th>
</tr>';
    while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<tr> 
                    <td> '.$row['mesaj'].' </td> 
                    <td><img src="img/user.png" style="width:40px">'.$row['nume'].'</td>
                    <td>'.date('d-m-Y H:i', $row['data_adaugare']).'</td>
        </tr>';
    }
    echo '</table>';
}
else
    echo '<option value="-1"> Nu exista niciun mesaj </option>';

?>
<br>

<hr>

<h2> Adaugare mesaj nou </h2>

<form action="" method="POST">

    <label for="mesaj"> Mesaj: </label>
    <textarea name="mesaj" id="mesaj" class="form-control" placeholder="Introduceti mesajul..." required></textarea>
    <br>

    <input type="submit" name="butonAdaugare" value="Adaugare mesaj nou" class="btn btn-success btn-lg">

    <br>

</form>


<?php

$engine->AfisareFooter();
?>