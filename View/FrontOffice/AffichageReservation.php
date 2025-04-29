<?php
include '../../Model/ModelReservation.php';
include '../../Controller/ControllerReservation.php';

$ControllerReservationElectrique = new ControllerReservationElectrique();
$liste = $ControllerReservationElectrique->afficherPourFront();
 
// Suppression
if (isset($_GET['id_reservation']) && !empty($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation'];
    $resultat = $ControllerReservationElectrique->supprimerReservation($id_reservation);

    if ($resultat) {
        header('Location: AffichageReservation.php?success=1');
        exit();
    } else {
        header('Location: AffichageReservation.php?error=1');
        exit();
    }
}

//var_dump($_POST);  // Affiche le contenu de $_POST pour vérifier que les données sont envoyées


// Modification
if (isset($_POST['modifierReservation'])) {
    $id_reservation = $_POST['id_reservation']; // récupère l'id
    $nomClient = $_POST['nomClient'];
    $prenomClient = $_POST['prenomClient'];
    $emailClient = $_POST['emailClient'];
    $date_reservation = $_POST['date_reservation'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $duree_charge = $_POST['duree_charge'];
    $tarif_estime = $_POST['tarif_estime'];
    $statut_reservation = $_POST['statut_reservation'];
    $id_borne = $_POST['id_borne'];
    $mode_paiement = $_POST['mode_paiement'];
    $pourcentage_charge = $_POST['pourcentage_charge'];

    $ModelReservationBorne = new ModelReservationBorne(
        $id_reservation,
        $nomClient, 
        $prenomClient, 
        $emailClient, 
        $date_reservation, 
        $heure_debut, 
        $heure_fin, 
        $duree_charge, 
        $tarif_estime, 
        $statut_reservation, 
        $id_borne, 
        $mode_paiement, 
        $pourcentage_charge
    );
    
    
    
    // Ici tu passes bien $reservation et non $donnees !
    $ControllerReservationElectrique->modifierReservation($db,$ModelReservationBorne, $id_reservation);

    header("Location: modifierForm.php");
    exit; 
}

$liste = $ControllerReservationElectrique->afficherPourFront();


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réservations</title>
    <link rel="stylesheet" href="tableReservation.css">
</head>
<body>
    <h1>Liste des Réservations</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Réservation</th>
                <th>ID Borne</th>
                <th>Nom Client</th>
                <th>Prénom Client</th>
                <th>Email Client</th>
                <th>Date Réservation</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Durée Charge</th>
                <th>Pourcentage Charge</th>
                <th>Tarif Estimé</th>
                <th>Mode Paiement</th>
                <th>Statut Réservation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($liste as $reservation): ?>
    <tr id="row-<?= $reservation['id_reservation']; ?>">
        <td><?= $reservation["id_reservation"]; ?></td>
        <td><?= $reservation["id_borne"]; ?></td>
        <td><?= $reservation["nomClient"]; ?></td>
        <td><?= $reservation["prenomClient"]; ?></td>
        <td><?= $reservation["emailClient"]; ?></td>
        <td><?= $reservation["date_reservation"]; ?></td>
        <td><?= $reservation["heure_debut"]; ?></td>
        <td><?= $reservation["heure_fin"]; ?></td>
        <td><?= $reservation["duree_charge"]; ?></td>
        <td><?= $reservation["pourcentage_charge"]; ?></td>
        <td><?= $reservation["tarif_estime"]; ?></td>
        <td><?= $reservation["mode_paiement"]; ?></td>
        <td><?= $reservation["statut_reservation"]; ?></td>
        <td class="actions">
            <a href="modifierForm.php?id_reservation=<?= $reservation['id_reservation']; ?>" class="on-default edit-row">
                <i class="fa fa-pencil"></i> modifier 
            </a>
            <a href="AffichageReservation.php?id_reservation=<?= $reservation['id_reservation']; ?>" 
               class="on-default remove-row" 
               onclick="return confirm('Voulez-vous vraiment supprimer la réservation ID <?= $reservation['id_reservation']; ?> ?');">
                <i class="fa fa-trash-o"></i> supprimer 
            </a>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>

    </table>
</body>
</html>
