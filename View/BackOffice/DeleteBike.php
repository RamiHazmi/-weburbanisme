<?php
require_once __DIR__ . '/../../Controller/BikeController.php'; // Nouveau contrôleur à créer

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurité : s'assurer que c'est bien un entier
    $controller = new BikeController();
    $controller->deleteBike($id); // Méthode à créer dans ton contrôleur
}

// Redirection vers la liste des trajets
header("Location: BikeList.php"); // Change le nom si ta page s'appelle autrement
exit;
?>
