<?php
/* SETARI BAZA DE DATE */
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'scoala2020');

/* SETARI CAI */
$caleInterna = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR;
$caleExterna = 'http://localhost/scoala2020/';

/* INITIALIZARE ENGINE */
require $caleInterna.'inc/engine.class.php';
$engine = new engine($caleInterna, $caleExterna);

/* INITIALIZARE SESIUNE */
session_start();
?>