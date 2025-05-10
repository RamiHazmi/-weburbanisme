<?php
require_once 'C:/xampp/htdocs/urbanisme/model/abonnement.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';

$pdo = config::getConnexion(); // 👈 Ajouter cette ligne ici !

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées depuis le formulaire
    $id_abonnement = $_POST['id_abonnement'];
    $nom_parking = $_POST['nom_parking'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $places_reservees = (int) $_POST['places_reservees'];
    $old_places_reservees = (int) $_POST['old_places_reservees'];

    // Vérification : la date de début ne doit pas être dans le passé
    $date_debut_obj = new DateTime($date_debut);
    $today = new DateTime();
    $today->setTime(0, 0, 0);

    if ($date_debut_obj < $today) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur : La date de début ne peut pas être dans le passé.']);
        exit;
    }

    // Vérifier le parking et les places disponibles
    $query = "SELECT places_dispo FROM parking WHERE nom_parking = :nom_parking";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':nom_parking' => $nom_parking]);
    $parking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($parking) {
        $places_dispo = (int) $parking['places_dispo'];
        $places_dispo = $places_dispo + $old_places_reservees - $places_reservees;

        if ($places_dispo < 0) {
            echo json_encode(['status' => 'error', 'message' => 'Erreur : Pas assez de places disponibles.']);
            exit;
        }

        // Mise à jour des abonnements
        $updateQuery = "UPDATE abonnement SET date_debut = :date_debut, date_fin = :date_fin, places_reservees = :places_reservees WHERE id_abonnement = :id_abonnement";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
            ':places_reservees' => $places_reservees,
            ':id_abonnement' => $id_abonnement
        ]);

        // Mise à jour des places du parking
        $updateParkingQuery = "UPDATE parking SET places_dispo = :places_dispo WHERE nom_parking = :nom_parking";
        $updateParkingStmt = $pdo->prepare($updateParkingQuery);
        $updateParkingStmt->execute([
            ':places_dispo' => $places_dispo,
            ':nom_parking' => $nom_parking
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Abonnement modifié avec succès']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parking introuvable']);
    }
}
?>
