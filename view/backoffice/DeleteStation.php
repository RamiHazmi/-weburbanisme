<?php
require_once __DIR__ . '/../../Controller/BikeStationController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurité : convertir en entier
    $controller = new BikeStationController();
    $controller->deleteStation($id);
}

// Après suppression, redirection vers la page d'affichage
header("Location: TableBike.php");
exit;
?>