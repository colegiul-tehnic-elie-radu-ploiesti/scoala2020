<?php
require 'configurare.php';

$engine->VerificareProfesor();

$engine->InitializarePagina('Catalog | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

$engine->AfisareMeniuDiriginte();


if(isset($_GET['butonAfisare']))
{
    $materia = intval($_GET['materia']);
    $elev = intval($_GET['elev']);
}

?>
    <form action="" method="GET">
    <label>Materia</label>
    <select name="materia" id="materia" class="form-control">

        <?php
        $rezultat = $engine->db->query("select a.* from materii as a left join materii_clase as m on m.id_materie = a.id_materie where m.id_clasa = ".$_SESSION['clasa_diriginte']." order by a.denumire_materie ASC");

        if($rezultat->rowCount()>=1)
        {
            while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
            {
                if(!isset($materia)) $materia = $row['id_materie'];
                echo '<option value="'.$row['id_materie'].'" '.($materia==$row['id_materie']?'selected':'').'> '.$row['denumire_materie'].' </option>';
            }
        }
        else
            echo '<option value="-1"> Nu exista nicio materie in baza de date </option>';
        ?>

    </select>
    <br>
    
    <label>Elev</label>
    <select name="elev" id="elev" class="form-control">

        <?php
        $rezultat = $engine->db->query("select * from elevi where id_clasa=".$_SESSION['clasa_diriginte']);

        if($rezultat->rowCount()>=1)
        {
            while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
            {
                if(!isset($elev)) $elev = $row['id_elev'];
                echo '<option value="'.$row['id_elev'].'" '.($elev==$row['id_elev']?'selected':'').'> '.$row['nume_elev'].' </option>';
            }
        }
        else
            echo '<option value="-1"> Nu exista nicio materie in baza de date </option>';
        ?>

    </select>
    <br>
    
    <div class="text-center">
        <input type="submit" class="btn btn-success" name="butonAfisare" value="Afisare" style="min-width:200px">
    </div>
    
</form>
<hr>

<h2 class="text-center"> Afisare Catalog </h2>

<h4> Semestrul I</h4>
<?php

afisareCatalogMaterie(1);

echo '<hr> <h4> Semestrul II</h4>';

afisareCatalogMaterie(2);


function afisareCatalogMaterie($semestru)
{
    global $engine;
    global $materia;
    global $elev;

    $rezultat = $engine->db->query("select * from note where id_materie = $materia and id_elev=$elev and id_an_scolar=". $engine->preiaSetare('an_scolar_curent')." and semestru=$semestru order by data_adaugare ASC");

    if($rezultat->rowCount()>=1)
    {

        echo '<table class="table table-bordered table-striped table-hover">
                <tr class="success">
                    <th colspan="3" class="text-center"> NOTE </th>
                </tr>
                <tr>
                    <th> Nr. crt. </th>
                    <th> Nota </th>
                    <th> Data </th>
                </tr>';

        $i=0;
        $suma_note = 0;
        $numar_note = 0;
        $nota_teza = 0;
        while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
        {
            $i++;
            echo '<tr '.($row['is_teza']==1?'class="danger"':'').'>
                    <td>'.$i.'</td>
                    <td>'.$row['nota'].' '.($row['is_teza']==1?'<span class="label label-warning"> TEZA </span>':'').'</td>
                    <td>'.$row['data_nota'].'</td>
                    </tr>';
            if($row['is_teza']==0)
            {
                $numar_note++;
                $suma_note+=$row['nota'];
            }
            else
            {
                $nota_teza = $row['nota'];
            }
        }

        if($i>=2)
        {
            if($nota_teza==0)
            {
                $media = round($suma_note/$numar_note,2 );
            }
            else
            {
                $media = round( (($suma_note / $numar_note ) * 3 + $nota_teza ) / 4, 2);
            }

            echo '<tr class="info"> 
                <td colspan="2"> <strong>Media</strong> </td>
                <td><strong>'.$media.'</strong></td>
                </tr>';
        }

        echo '</table>';

    }
    else
        echo '<div class="alert alert-danger"> Nicio nota inregistrata in baza de date </div>';



    $rezultat = $engine->db->query("select * from absente where id_materie = $materia and id_elev=$elev and id_an_scolar=". $engine->preiaSetare('an_scolar_curent')." and semestru=$semestru order by data_adaugare ASC");

    if($rezultat->rowCount()>=1)
    {

        echo '<table class="table table-bordered table-striped table-hover">
                <tr class="success">
                    <th colspan="4" class="text-center"> ABSENTE </th>
                </tr>
                <tr>
                    <th> Nr. crt. </th>
                    <th> Data absenta </th>
                    <th> Motivata </th>
                    <th> Comentarii </th>
                </tr>';

        $i=0;
        while( $row = $rezultat->fetch(PDO::FETCH_ASSOC) )
        {
            $i++;
            echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row['data_absenta'].'</td>
                    <td>'.($row['motivata']==0?'<span class="label label-danger">NU</span> <a href="diriginte_absente_motivare.php?id_absenta='.$row['id_absenta'].'" class="btn btn-success btn-sm pull-right"> motivare </a>':'<span class="btn btn-success btn-sm">DA</span><br>'.$row['comentarii_motivare'].'<br>'.$row['data_motivare']).'</td>
                    <td>'.$row['comentarii'].'</td>
                    </tr>';

        }
        echo '</table>';

    }
    else
        echo '<div class="alert alert-danger"> Nicio absenta inregistrata in baza de date </div>';


}


?>

<?php

$engine->AfisareFooter();
?>