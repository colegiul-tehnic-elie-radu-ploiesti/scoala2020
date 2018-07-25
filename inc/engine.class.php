<?php
/*
Clasa ENGINE este utilizata pentru a facilita conectarea la baza de date, pentru a facilita generarea meniului si a diverselor alte elemente din site.
*/
class engine
{
	//variabile interne ale clasei
	public $db; 			//va contine conexiunea catre baza de date;
	protected $caleExterna; //URL-ul site-ului vizibil pe internet
	protected $caleInterna; //folderul unde site-ul este stocat pe webserver
	
	//zona cu functii publice, accesibile din exteriorul clasei
	
	//constructor
	public function __construct($caleInterna, $caleExterna)
	{
		//initializare engine, setam caile initiale ale scriptului;
		$this->internalURL = $caleInterna;
		$this->externalURL = $caleExterna;
	}
	
	//destructor
	public function __destruct()
	{
		//inchidem conexiunea la baza de date
	}
	
	public function InitializareConexiuneDB()
	{
		 $options = array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        );

        try
        {
            $this->db = new PDO('mysql:dbname='.DB_DATABASE.';host='.DB_HOST, DB_USER, DB_PASS, $options);
        }
        catch(PDOException $e)
        {
           $this->AfisareEroare( 'A apărut o eroare în realizarea conexiunii cu baza de date.<br>Eroarea returnată: '.$e->getMessage());
        }
	}
	
	public function InitializarePagina($titlu)
	{
        $continut_template = $this->IncarcarePortiuneSite('header', true);
        $continut_template = str_replace('%TITLU%', $titlu, $continut_template);
		echo $continut_template;
	}
	
	public function AfisareMeniu()
	{
        if( isset ( $_SESSION['utilizator_autentificat'] ) && $_SESSION['utilizator_autentificat'] == true )


        $this->IncarcarePortiuneSite('meniulogat');

	    else

        $this->IncarcarePortiuneSite('meniu');
    }
	
	public function AfisareFooter()
	{
		$this->IncarcarePortiuneSite('footer');
		
		//echo 'footer site </body></html>';
	}
	
	public function AfisareFormularAutentificare()
	{
		$this->IncarcarePortiuneSite('formularlogin');
	}
	
	public function AfisareEroare($eroare)
	{
		echo '<div class="alert alert-danger">'.$eroare.'</div>';
	}
	
	public function VerificareAdmin()
	{
		if($_SESSION['nivel_acces_utilizator']!=3) die('Nu aveti acces la aceasta sectiune a site-ului.');
	}	
	
	public function VerificareParinte()
	{
		if($_SESSION['nivel_acces_utilizator']!=1) die('Nu aveti acces la aceasta sectiune a site-ului.');
	}	
	public function VerificareProfesor()
	{
		if($_SESSION['nivel_acces_utilizator']!=2) die('Nu aveti acces la aceasta sectiune a site-ului.');
	}

	public function AfisareMeniuAdministrator()
    {

        $meniu = 'Bun venit '.$_SESSION['nume_utilizator'].'<br> 
            
        
       
<ul class="nav nav-pills">
  <li role="presentation"><a href="sectiune_admin.php">Prima Pagina</a></li>
  <li role="presentation"><a href="admin_profesori_adaugare.php">Adaugare profesor</a></li>
  <li role="presentation"><a href="admin_profesori_vizualizare.php">Vizualizare profesor</a></li>
  <li role="presentation"><a href="admin_clase_adaugare.php">Adaugare clase</a></li>
  <li role="presentation"><a href="admin_clase_vizualizare.php">Vizualizare clase</a></li>
  <li role="presentation"><a href="admin_materii_adaugare.php">Adaugare materie</a></li>
  <li role="presentation"><a href="admin_materii_vizualizare.php">Vizualizare materii</a></li>
  <li role="presentation"><a href="admin_setari_vizualizare.php">Setari</a></li>
  <li role="presentation"><a href="deconectare.php">Deconectare</a></li>
</ul>';


        $meniu.='<hr>';

        echo $meniu;
    }

    public function AfisareMeniuDiriginte()
    {
        $meniu = 'Bun venit '.$_SESSION['nume_utilizator'].' <br> Adminstreaza clasa '.$_SESSION['denumire_clasa_diriginte'].'   <br>    

        
<ul class="nav nav-pills">
  <li role="presentation"><a href="sectiune_profesor.php">Prima Pagina</a></li>
  <li role="presentation"><a href="diriginte_elevi_adaugare.php">Adaugare Elev</a></li>
  <li role="presentation"><a href="diriginte_elevi_vizualizare.php">Vizualizare Elevi</a></li>
  <li role="presentation"><a href="diriginte_materii_adaugare.php">Adaugare Materii</a></li>
  <li role="presentation"><a href="diriginte_materii_vizualizare.php">Vizualizare Materii</a></li>
  <li role="presentation"><a href="diriginte_note_adaugare.php">Adaugare Nota</a></li>
  <li role="presentation"><a href="diriginte_absente_adaugare.php">Adaugare Absenta</a></li>
  <li role="presentation"><a href="diriginte_catalog.php">Vizualizare Catalog</a></li>
  <li role="presentation"><a href="diriginte_forum.php">Forum</a></li>
  <li role="presentation"><a href="deconectare.php">Deconectare</a></li>
</ul>';

        $meniu.='<hr>';

        echo $meniu;
    }

    public function AfisareMeniuParinte()
    {
        $meniu = 'Bun venit '.$_SESSION['nume_utilizator'].'<br>



<ul class="nav nav-pills">
  <li role="presentation"><a href="sectiune_parinte.php"> Prima pagina  </a></li>
  <li role="presentation"><a href="parinte_catalog.php"> Catalog </a></li>
  <li role="presentation"><a href="parinte_forum.php"> Forum </a></li>
</ul>';

        $meniu.='<hr>';
        echo $meniu;
    }

    public function preiaSetare($setare)
    {
        $rezultat = $this->db->prepare("select * from setari where setare=:setare");
        $rezultat->execute( array(':setare' => $setare) );
        if($rezultat->rowCount()==1)
        {
            $row = $rezultat->fetch(PDO::FETCH_ASSOC);
            return $row['valoare'];
        }
    }

	//zona cu functii protejate, ce nu sunt accesibile din exteriorul clasei
	protected function IncarcarePortiuneSite($portiune, $returneaza=false)
	{
		if(file_exists($this->internalURL.'/template/'.$portiune.'.html'))
		{
			//citim fisierul si il afisam sau il returnam, in functie de valoarea variabilei $returneaza
            $continut_template = file_get_contents($this->internalURL.'/template/'.$portiune.'.html');
            if($returneaza) return $continut_template;
            else
			echo $continut_template;
		}
	}

}

?>