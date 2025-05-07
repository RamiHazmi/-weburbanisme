<?php
require_once 'C:/xampp/htdocs/Urbanisme/model/dashboardmodelomar.php';
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';
$db = config::getConnexion();
$stat = new Statistique($db);
$taux = $stat->getTauxOccupation();
$revenus = $stat->getRevenusParParking();

?>
