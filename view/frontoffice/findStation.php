<?php
header('Content-Type: application/json');

try {
    // Get the station name from the request
    $stationName = isset($_POST['station_name']) ? trim($_POST['station_name']) : '';
    
    if (empty($stationName)) {
        throw new Exception('No station name provided');
    }

    // Include the controller
    require_once __DIR__ . '/../../Controller/BikeStationController.php';
    
    // Create controller instance
    $controller = new BikeStationController();
    
    // Get station ID
    $stationId = $controller->getStationIdByName($stationName);
    
    if ($stationId) {
        echo json_encode([
            'success' => true,
            'station' => [
                'id_station' => $stationId,
                'name' => $stationName
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No matching station found'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 