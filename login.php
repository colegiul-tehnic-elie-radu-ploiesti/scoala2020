<?php
require 'configurare.php';
ob_start();

$engine->InitializarePagina('Autentificare | Platforma Scoala 2020');

$engine->AfisareMeniu();

//doar pe paginile unde e nevoie de conexiune la baza de date
$engine->InitializareConexiuneDB();

if( isset($_POST['autentificare']) )
{
	$email = htmlentities($_POST['email'], ENT_QUOTES, 'utf-8');
	$parola = htmlentities($_POST['parola'], ENT_QUOTES, 'utf-8');
	
	$stil_alerta = 'alert-danger';
	if(strlen($email)<5 || strlen($parola)<4 ) $mesaj_alerta = 'Va rugam sa introduceti o adresa de email/o parola';
	else
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $mesaj_alerta = 'Adresa de e-mail introdusa nu este valida';
	else
    {
        //verificam in baza de date daca exista un user cu datele furnizate
        $parola_criptata = hash('sha512', $parola);

        $rezultat = $engine->db->prepare("select id_utilizator,nume,tip_utilizator,id_elev from utilizatori where email=:email and parola=:parola");
        $rezultat->execute(array(':email' => $email, ':parola' => $parola_criptata));

        if($rezultat->rowCount()==1)
        {
            //am gasit o inregistrare in baza de date care corespunde
            $detalii_utilizator = $rezultat->fetch(PDO::FETCH_ASSOC);

            $_SESSION['id_utilizator'] = $detalii_utilizator['id_utilizator'];
            $_SESSION['email_utilizator'] = $email;
            $_SESSION['nume_utilizator'] = $detalii_utilizator['nume'];
            $_SESSION['nivel_acces_utilizator'] = $detalii_utilizator['tip_utilizator'];
            $_SESSION['utilizator_autentificat'] = true;

            //parinte
            if($_SESSION['nivel_acces_utilizator']==1)
            {
                $_SESSION['este_parinte'] = true;
                $_SESSION['id_elev'] = $detalii_utilizator['id_elev'];

                $clasa = $engine->db->prepare("select id_clasa from elevi where id_elev=:elev");
                $clasa->execute( array(':elev' => $detalii_utilizator['id_elev']));
                $clasa = $clasa->fetch(PDO::FETCH_ASSOC);

                $_SESSION['id_clasa'] = $clasa['id_clasa'];

                header('Location: sectiune_parinte.php');
            }
            else
            if($_SESSION['nivel_acces_utilizator']==2)
            {
                //verificam daca exista vreo clasa ce are asociat acest profesor ca si diriginte

                $clase_diriginte = $engine->db->prepare("select * from clase where id_diriginte=:diriginte");
                $clase_diriginte->execute(array(':diriginte' => $_SESSION['id_utilizator']));

                if($clase_diriginte->rowCount()>=1)
                {
                    $_SESSION['este_diriginte'] = true;
                    $detalii_clasa_diriginte = $clase_diriginte->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['clasa_diriginte'] = $detalii_clasa_diriginte['id_clasa'];
                    $_SESSION['denumire_clasa_diriginte'] = $detalii_clasa_diriginte['nivel_clasa'].' '.$detalii_clasa_diriginte['sufix_clasa'];
                }

                header('Location: sectiune_profesor.php'); //profesor
            }
            else
            if($_SESSION['nivel_acces_utilizator']==3)           //admin
            {
                header('Location: sectiune_admin.php');
            }
        }
        else
        {
            $mesaj_alerta = 'Date de autentificare introduse nu sunt corecte.';
        }

        echo '<div class="alert '.$stil_alerta.'">'.$mesaj_alerta.'</div>';

        //TODO: de sters
        //$statement = $this->conn->query($query);
        //$statement = $this->conn->prepare($query);
        //$statement->execute($params);
    }
}

$engine->AfisareFormularAutentificare();

$engine->AfisareFooter();
?>