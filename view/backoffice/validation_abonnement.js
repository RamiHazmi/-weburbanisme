function afficherErreur(message) {
    const errorMessageDiv = document.getElementById("error-message");
    errorMessageDiv.innerText = message;
}

function effacerErreurs() {
    const errorMessageDiv = document.getElementById("error-message");
    errorMessageDiv.innerText = '';
}

function validerFormulaire() {
    effacerErreurs();

    const dateDebut = document.getElementById("modal-date-debut").value.trim();
    const dateFin = document.getElementById("modal-date-fin").value.trim();
    const placesReserveesValue = document.getElementById("modal-places-reservees").value.trim();
    const idParking = document.getElementById("modal-id-parking").value.trim();

    if (!dateDebut || !dateFin || !placesReserveesValue || !idParking) {
        afficherErreur("Tous les champs doivent être remplis.");
        return false;
    }

    const placesReservees = parseInt(placesReserveesValue);
    if (isNaN(placesReservees) || placesReservees <= 0) {
        afficherErreur("Le nombre de places réservées doit être strictement supérieur à 0.");
        return false;
    }

    if (new Date(dateFin) <= new Date(dateDebut)) {
        afficherErreur("La date de fin doit être après la date de début.");
        return false;
    }

    return true; // ✅ Formulaire valide
}
 

  
