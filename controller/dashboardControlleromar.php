<?php
require_once 'C:/xampp/htdocs/urbanisme/model/dashboardmodelomar.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';
$db = config::getConnexion();
$stat = new Statistique($db);
$taux = $stat->getTauxOccupation();
 

?>
