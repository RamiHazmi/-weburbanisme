<?php
require_once __DIR__ . '/../../Controller/BikeStationController.php';

$controller = new BikeStationController();

$bikeStations = $controller->listStations();



// Debug temporaire pour voir ce que contient le tableau
echo '<pre>';
print_r($bikeStations);
echo '</pre>';

include 'TableBike.php';

?>
