<?php
// Inclure la connexion à la base de données
require_once __DIR__ . '/../../database.php';
require_once __DIR__ . '/../../Controller/BikeStationController.php';

// Vérifier si 'station_id' est présent dans l'URL
if (isset($_GET['station_id'])) {
    $station_id = $_GET['station_id'];

    // Créer une instance du contrôleur des stations de vélos
    $bikeStationController = new BikeStationController();

    // Récupérer le nom de la station par ID
    $stationName = $bikeStationController->getStationNameById($station_id);

    // Retourner le nom de la station sous forme de JSON
    echo json_encode(['name' => $stationName]);
} else {
    // Si 'station_id' n'est pas passé, retourner une erreur
    echo json_encode(['error' => 'Station ID is missing']);
}
?>
