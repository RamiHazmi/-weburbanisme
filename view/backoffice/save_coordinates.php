<?php
 require_once __DIR__ . '/../../Controller/BikeStationController.php'; // Nouveau contrôleur à créer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stationId = $_POST['stationId'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if (!$stationId || !$latitude || !$longitude) {
        echo 'Missing data!';
        exit;
    }

    try {
        $db = config::getConnexion();
        $sql = "UPDATE bikestation SET latitude = :latitude, longitude = :longitude WHERE id_station = :id_station";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':id_station' => $stationId,
        ]);
        echo 'Coordinates saved successfully!';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
