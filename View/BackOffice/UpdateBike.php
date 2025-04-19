<?php
// Include necessary files
require_once __DIR__ . '/../../Controller/BikeController.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_bike = $_POST['id_bike'];
    $station_id = $_POST['station_id']; // Change to station_id, assuming this is correct
    $status = $_POST['status']; // Assuming 'Valable' or 'Reservé'
    $total_kilometers = $_POST['total_kilometers'];

    // Create a Bike object with the updated data
    $bike = new Bike(
        null, // id_bike should not be passed here, it's auto-generated
        (int)$station_id, 
        $status,
        (float)$total_kilometers
    );

    // Create a BikeController object
    $controller = new BikeController();

    // Update the bike entry in the database
    $controller->updateBike($id_bike, $bike);

    // Redirect to the list page
    header('Location: BikeList.php');
    exit();
}
?>
