function afficherQRCode() {
  const paiementSurPlace = document.querySelector('input[value="sur_place"]').checked;
  const qrContainer = document.getElementById('qrcode-container');
  const qrCodeDiv = document.getElementById('qrcode');

  if (paiementSurPlace) {
      qrContainer.style.display = "block";
      qrCodeDiv.innerHTML = ""; // Effacer l'ancien QR si déjà affiché

      // Assurez-vous que les variables PHP sont correctement passées à JavaScript
      const reservationId = "<?= isset($row['id_reservation']) ? $row['id_reservation'] : '' ?>";
      const nomClient = "<?= isset($row['nomClient']) ? htmlspecialchars($row['nomClient']) : '' ?>";
      const prenomClient = "<?= isset($row['prenomClient']) ? htmlspecialchars($row['prenomClient']) : '' ?>";
      const emailClient = "<?= isset($row['emailClient']) ? htmlspecialchars($row['emailClient']) : '' ?>";
      const tarifEstime = "<?= isset($row['tarif_estime']) ? htmlspecialchars($row['tarif_estime']) : '' ?>";

      // Construire l'URL de paiement avec ces informations
      const urlPaiement = `https://votre-site.com/paiement-sur-place?id=${reservationId}&nom=${nomClient}&prenom=${prenomClient}&email=${emailClient}&tarif=${tarifEstime}`;
      
      // Générer le QR code avec l'URL contenant les informations de la réservation
      new QRCode(qrCodeDiv, {
          text: urlPaiement,  // L'URL inclut les informations de la réservation
          width: 200,
          height: 200
      });
  } else {
      qrContainer.style.display = "none";
      qrCodeDiv.innerHTML = "";
  }
}

// Masquer le QR si paiement en ligne sélectionné
document.querySelector('input[value="en_ligne"]').addEventListener('change', afficherQRCode);

// Initialisation du QR Code si déjà sélectionné au moment du chargement
document.addEventListener("DOMContentLoaded", function () {
  afficherQRCode();
});
