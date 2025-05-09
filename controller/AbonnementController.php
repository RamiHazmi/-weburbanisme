<?php
require_once 'C:/xampp/htdocs/urbanisme/Model/abonnement.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';



class AbonnementController {

    public function reserverParking($id_user, $id_parking, $date_debut, $date_fin, $places_reservees) {
        $abonnement = new Abonnement();
        return $abonnement->ajouterAbonnement($id_user, $id_parking, $date_debut, $date_fin, $places_reservees);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'] ?? null;
    $id_parking = $_POST['id_parking'] ?? null;
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;
    $places_reservees = $_POST['places_reservees'] ?? null;

    $controller = new AbonnementController();
    $message = $controller->reserverParking($id_user, $id_parking, $date_debut, $date_fin, $places_reservees);

    echo $message;
}
?>
