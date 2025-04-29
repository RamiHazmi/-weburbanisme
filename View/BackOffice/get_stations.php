<?php
 require_once __DIR__ . '/../../Controller/BikeStationController.php'; // Nouveau contrôleur à créer

$controller = new BikeStationController();
$stations = $controller->listStations();

header('Content-Type: application/json');
echo json_encode($stations);
?>
