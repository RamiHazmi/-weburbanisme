<?php
// Include necessary files
require_once __DIR__ . '/../../Controller/BikeStationController.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_station = $_POST['id_station']; // Don't modify id_station
    $name = $_POST['name'];
    $location = $_POST['location'];
    $status = $_POST['status']; // Can be modified

    // Create a BikeStation object with the updated data (id_station is not passed to constructor)
    $station = new BikeStation(
        null, // Pass null or any placeholder for id_station (since it's not to be modified)
        $name, 
        $location, 
        (int)$total_bikes, 
        (int)$available_bikes, 
        (float)$status
    );

    // Create a BikeStationController object
    $controller = new BikeStationController();

    // Call the updateStation method to update the bike station, passing the id_station and the station object
    $controller->updateStation($id_station, $station);

    // Redirect to the stations list page after the update
    header('Location: TableBike.php');  // Adjust the path accordingly
    exit();
}
?>
