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

    // Vérification que les éléments existent
    const dateDebutElement = document.getElementById("edit-date-debut");
    const dateFinElement = document.getElementById("edit-date-fin");
    const placesReserveesElement = document.getElementById("edit-places");

    if (!dateDebutElement || !dateFinElement || !placesReserveesElement) {
        afficherErreur("Certains champs sont manquants.");
        return false;
    }

    const dateDebut = dateDebutElement.value.trim();
    const dateFin = dateFinElement.value.trim();
    const placesReserveesValue = placesReserveesElement.value.trim();

    if (!dateDebut || !dateFin || !placesReserveesValue) {
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
