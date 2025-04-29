<?php
include '../../Model/ModelReservation.php';
include '../../Controller/ControllerReservation.php';

$ControllerReservationElectrique = new ControllerReservationElectrique();

if (
    isset($_POST["nomClient"]) &&
    isset($_POST["prenomClient"]) &&
    isset($_POST["emailClient"]) &&
    isset($_POST["date_reservation"]) &&
    isset($_POST["heure_debut"]) &&
    isset($_POST["heure_fin"]) &&
    isset($_POST["duree_charge"]) &&
    isset($_POST["tarif_estime"]) &&
    isset($_POST["statut_reservation"]) &&
    isset($_POST["id_borne"])&& 
    isset($_POST["mode_paiement"])&&
    isset($_POST["pourcentage_charge"])
) {
    $ModelReservationBorne = new ModelReservationBorne(
        $_POST["nomClient"],
        $_POST["prenomClient"],
        $_POST["emailClient"],
        $_POST["date_reservation"],
        $_POST["heure_debut"],
        $_POST["heure_fin"],
        $_POST["duree_charge"],
        $_POST["tarif_estime"],
        $_POST["statut_reservation"],
        $_POST["id_borne"],
        $_POST["mode_paiement"],
        $_POST["pourcentage_charge"]
    );

    $resultat = $ControllerReservationElectrique->ajouterResrvation($ModelReservationBorne);
 
    if ($resultat) {
        header("Location: TableReservationBorne.php");
        exit;
    } else {
        echo "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Reservation.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head>
<body>
    <div class="form-wrapper">
        <h2>Formulaire de Réservation de Borne</h2>
        <form id="formReservation" action="formReservation.php" method="POST">
      <div class="form-group">
    <label for="nom_client">Nom du Client :</label>
    <input type="text" name="nomClient" id="nomClient" required>
    <span id="nomClient_error" class="error"  style="color: red;"></span>
  </div>

  <div class="form-group">
    <label for="prenom_client">Prénom du Client :</label>
    <input type="text" name="prenomClient" id="prenomClient" required>
    <span class="error" id="prenomClient_error"  style="color: red;"></span>
  </div>

  <div class="form-group">
    <label for="email_client">Email du Client :</label>
    <input type="email" name="emailClient" id="emailClient" required>
    <span class="error" id="emailClient_error"  style="color: red;"></span>
  </div>

  <div class="form-group">
    <label for="date_reservation">Date de Réservation :</label>
    <input type="date" name="date_reservation" id="date_reservation" required>
    <span class="error" id="date_reservation_error"  style="color: red;"></span>
  </div>

  <div class="form-group">
    <label for="heure_debut">Heure de Début :</label>
    <input type="time" name="heure_debut" id="heure_debut" required>
    <span class="error" id="heure_debut_error"  style="color: red;"></span>
  </div>

  <div class="form-group">
    <label for="heure_fin">Heure de Fin :</label>
    <input type="time" name="heure_fin" id="heure_fin" required>
    <span class="error" id="heure_fin_error"  style="color: red;"> </span>
  </div>

  <div class="form-group">
    <label for="duree_charge">Durée de Charge (en heures) :</label>
    <input type="text" id="duree_charge" name="duree_charge" readonly>
    <span id="duree_charge_error" style="color: red;" class="error" ></span>
  </div>

  <div class="form-group">
    <label for="pourcentage_charge">Pourcentage de Charge Souhaité :</label>
    <input type="range" name="pourcentage_charge" id="pourcentage_charge" min="20" max="100" step="20" value="100" oninput="outputPourcentage.value = this.value + '%'">
    <output id="outputPourcentage">100%</output>
    <span id="pourcentage_charge_error" style="color: red;" class="error"></span>
  </div>

  <div class="form-group">
    <label for="tarif_estime">Tarif Estimé :</label>
    <input type="text" name="tarif_estime" id="tarif_estime" readonly>
    <span class="error"  id="tarif_estime_error" style="color: red;" > </span>
  </div>

  <div class="form-group">
  <label>Mode de Paiement :</label><br>
  <div class="radio-group">
    <label>
      <input type="radio" name="mode_paiement" value="en_ligne" required> Paiement en ligne
    </label>
    <label>
      <input type="radio" name="mode_paiement" value="sur_place" required onclick="afficherQRCode()"> Paiement sur place
    </label>
    <span  class="error" id="mode_paiement_error"  style="color: red;"></span>
  </div>
</div>

  <!-- QR Code -->
  <div id="qrcode-container" style="display:none; margin-top: 15px;">
  <p>Scannez ce QR-code pour payer :</p>
  <div id="qrcode"></div>
</div>

  <div class="online-payment-info" id="online-payment-info" style="display: none;">
    <p>💳 Vous avez choisi le paiement en ligne !</p>
    <p>Une fois le formulaire soumis, vous serez redirigé vers une page sécurisée pour finaliser votre paiement.</p>
    <p>✅ Votre place sera automatiquement réservée après le paiement.</p>
  </div>

  <div class="formeSpecial">
    <label for="statut_reservation">Statut de Réservation :</label>
    <select name="statut_reservation" id="statut_reservation">
      <option value="">-- Choisissez --</option>
      <option value="Confirmé">Confirmé</option>
      <option value="En attente">En attente</option>
      <option value="Annulée">Annulée</option>
    </select>
    <span class="error" id="statut_reservation_error"  style="color: red;"></span>
  </div>

  <div id="annulation-confirmation" style="display: none; margin-top: 10px;" class="formeSpecial">
    <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
    <button type="button" id="confirm-annulation" style="background-color: #e74c3c; color: white; margin-right: 10px;">Oui</button>
    <button type="button" id="cancel-annulation" style="background-color: #f1c40f; color: white;">Non</button>
  </div>

  <input type="hidden" name="id_borne" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">

  <button type="submit" id="btnSoumettre" class="formeSpecial">Soumettre</button>
</form>
    </div>

    <script src="dureeCharge.js"></script>
    <script src="StatutReservation.js"></script>
    <script src="Annulation.js"></script>
    <script src="OnlinePayment.js"></script>
    <script src="pourcentage.js"></script>
    <script src="controleSaisie3.js"></script>
    <script src="qrCode.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



</body>
</html>