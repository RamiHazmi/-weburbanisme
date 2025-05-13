// Fonction pour afficher/masquer les boutons en fonction du mode de paiement
function togglePaymentButton() {
    var modePaiement = document.querySelector('input[name="mode_paiement"]:checked').value;
    var submitButton = document.getElementById("btnSoumettre");
    var paymentButton = document.getElementById("paymentButton");

    if (modePaiement === "en_ligne") {
        submitButton.style.display = "none";  // Masquer le bouton "Soumettre"
        paymentButton.style.display = "inline-block";  // Afficher le bouton "Passer au paiement en ligne"
    } else {
        submitButton.style.display = "inline-block";  // Afficher le bouton "Soumettre"
        paymentButton.style.display = "none";  // Masquer le bouton "Passer au paiement en ligne"
    }
}

// Ajouter un écouteur d'événement pour détecter le changement de mode de paiement
document.querySelectorAll('input[name="mode_paiement"]').forEach(function (radioButton) {
    radioButton.addEventListener("change", togglePaymentButton);
});

// Appeler la fonction pour initialiser l'affichage au chargement de la page
window.onload = togglePaymentButton;
