<?php
require_once 'C:/xampp/htdocs/urbanisme/Model/parking.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_parking'])) {
    $id_parking = $_POST['id_parking'];

    try {
        Parking::deleteParking($id_parking);
        echo "Le parking a été  supprimé avec succès.";
    } catch (Exception $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}

?>