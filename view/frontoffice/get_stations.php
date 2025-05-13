<?php
require_once __DIR__ . '/../../database.php';

// Get the station names from the request
$startStation = $_GET['start'];
$endStation = $_GET['end'];

// Get the PDO connection
$pdo = config::getConnexion();  // <-- THIS IS THE IMPORTANT FIX

// Prepare and execute the query to fetch coordinates for the start station
$query = $pdo->prepare("SELECT latitude, longitude FROM bikestation WHERE name = :name");
$query->execute(['name' => $startStation]);
$startStationData = $query->fetch(PDO::FETCH_ASSOC);

// Prepare and execute the query to fetch coordinates for the end station
$query->execute(['name' => $endStation]);
$endStationData = $query->fetch(PDO::FETCH_ASSOC);

// Return the data as JSON
if ($startStationData && $endStationData) {
    echo json_encode([
        'success' => true,
        'start' => [
            'lat' => $startStationData['latitude'],
            'lng' => $startStationData['longitude']
        ],
        'end' => [
            'lat' => $endStationData['latitude'],
            'lng' => $endStationData['longitude']
        ]
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
