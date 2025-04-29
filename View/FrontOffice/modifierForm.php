<?php
include '../../Controller/ControllerReservation.php';
include '../../Model/ModelReservation.php';

$ControllerReservationElectrique = new ControllerReservationElectrique();
$liste = $ControllerReservationElectrique->afficherPourFront();

// Si l'id est passé dans l'URL
if (isset($_GET['id_reservation']) && !empty($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation'];
    $reservation = $ControllerReservationElectrique->recupererReservation($id_reservation);
} else {
    $reservation = null; // pas de réservation sélectionnée
}

// Si on arrive depuis le bouton "modifier" (POST)
if (isset($_POST['modifierReservation'])) {
    // Récupération des données du formulaire
    $id_reservation = $_POST['id_reservation'];
    $nomClient = $_POST['nomClient'];
    $prenomClient = $_POST['prenomClient'];
    $emailClient = $_POST['emailClient'];
    $dateReservation = $_POST['date_reservation'];
    $tarifEstime = $_POST['tarif_estime'];
    $statutReservation = $_POST['statut_reservation'];
    $heureDebut = $_POST['heure_debut'];
    $heureFin = $_POST['heure_fin'];
    $dureeCharge = $_POST['duree_charge'];
    $idBorne = $_POST['id_borne'];
    $paiement = $_POST['mode_paiement'];
    $pourcentage = $_POST['pourcentage_charge'];

    $ModelReservationBorne = new ModelReservationBorne(
        $id_reservation,
        $nomClient, $prenomClient, $emailClient, $dateReservation,
        $heureDebut, $heureFin, $dureeCharge, $tarifEstime,
        $statutReservation, $idBorne, $paiement, $pourcentage
    );

    try {
        $db = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }

    // Modifier la réservation
    $ControllerReservationElectrique->modifierReservation($db, $ModelReservationBorne, $id_reservation);

    // Redirection après modification
    header("Location: AffichageReservation.php?success=1");
    exit;
}

// Liste des réservations pour affichage
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
        <?php foreach ($liste as $borne): ?>
            <tr>
                <td><?= $borne["id_reservation"]; ?></td>
                <td><?= $borne["id_borne"]; ?></td>
                <td><?= $borne["nomClient"]; ?></td>
                <td><?= $borne["prenomClient"]; ?></td>
                <td><?= $borne["emailClient"]; ?></td>
                <td><?= $borne["date_reservation"]; ?></td>
                <td><?= $borne["heure_debut"]; ?></td>
                <td><?= $borne["heure_fin"]; ?></td>
                <td><?= $borne["duree_charge"]; ?></td>
                <td><?= $borne["pourcentage_charge"]; ?></td>
                <td><?= $borne["tarif_estime"]; ?></td>
                <td><?= $borne["mode_paiement"]; ?></td>
                <td><?= $borne["statut_reservation"]; ?></td>
                <td>
                    <a href="modifierForm.php?id_reservation=<?= $borne["id_reservation"] ?>">Modifier</a>
                    <a href="AffichageReservation.php?delete=<?= $borne["id_reservation"] ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-wrapper">
    <h2>Modifier une Réservation</h2>
    <form action="modifierForm.php" id="formReservation" method="POST">
        <input type="hidden" name="id_reservation" value="<?= isset($reservation['id_reservation']) ? $reservation['id_reservation'] : '' ?>">
        <div class="form-group">
            <label for="nom_client">Nom du Client :</label>
            <input type="text" name="nomClient" id="nomClient" value="<?= isset($reservation['nomClient']) ? $reservation['nomClient'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="prenom_client">Prénom du Client :</label>
            <input type="text" name="prenomClient" id="prenomClient" value="<?= isset($reservation['prenomClient']) ? $reservation['prenomClient'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="email_client">Email du Client :</label>
            <input type="email" name="emailClient" id="emailClient" value="<?= isset($reservation['emailClient']) ? $reservation['emailClient'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="date_reservation">Date de Réservation :</label>
            <input type="date" name="date_reservation" id="date_reservation" value="<?= isset($reservation['date_reservation']) ? $reservation['date_reservation'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure de Début :</label>
            <input type="time" name="heure_debut" id="heure_debut" value="<?= isset($reservation['heure_debut']) ? $reservation['heure_debut'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure de Fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" value="<?= isset($reservation['heure_fin']) ? $reservation['heure_fin'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="duree_charge">Durée de Charge :</label>
            <input type="text" name="duree_charge" id="duree_charge" value="<?= isset($reservation['duree_charge']) ? $reservation['duree_charge'] : '' ?>" readonly>
        </div>

        <div class="form-group">
            <label for="pourcentage_charge">Pourcentage de Charge :</label>
            <input type="range" name="pourcentage_charge" id="pourcentage_charge" min="20" max="100" step="20" value="<?= isset($reservation['pourcentage_charge']) ? $reservation['pourcentage_charge'] : '' ?>">
        </div>

        <div class="form-group">
            <label for="tarif_estime">Tarif Estimé :</label>
            <input type="text" name="tarif_estime" id="tarif_estime" value="<?= isset($reservation['tarif_estime']) ? $reservation['tarif_estime'] : '' ?>" readonly>
        </div>

        <div class="form-group">
            <label>Mode de Paiement :</label><br>
            <label>
                <input type="radio" name="mode_paiement" value="en_ligne" <?= isset($reservation['mode_paiement']) && $reservation['mode_paiement'] === 'en_ligne' ? 'checked' : '' ?>> En ligne
            </label>
            <label>
                <input type="radio" name="mode_paiement" value="sur_place" <?= isset($reservation['mode_paiement']) && $reservation['mode_paiement'] === 'sur_place' ? 'checked' : '' ?>> Sur place
            </label>
        </div>

        <div class="form-group">
            <label for="statut_reservation">Statut de Réservation :</label>
            <select name="statut_reservation" id="statut_reservation">
                <option value="">-- Choisissez --</option>
                <option value="Confirmé" <?= $reservation['statut_reservation'] === 'Confirmé' ? 'selected' : '' ?>>Confirmé</option>
                <option value="En attente" <?= $reservation['statut_reservation'] === 'En attente' ? 'selected' : '' ?>>En attente</option>
            </select>
        </div>

        <button type="submit" name="modifierReservation" class="submit-button">Modifier</button>
    </form>
</div>

</body>
</html>