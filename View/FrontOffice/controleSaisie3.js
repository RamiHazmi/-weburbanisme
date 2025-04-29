document.addEventListener("DOMContentLoaded", function () {
    // Messages d'erreur par défaut
    document.getElementById("nomClient_error").textContent = "Veuillez entrer le nom du client.";
    document.getElementById("prenomClient_error").textContent = "Veuillez entrer le prénom du client.";
    document.getElementById("emailClient_error").textContent = "Veuillez entrer un email valide.";
    document.getElementById("date_reservation_error").textContent = "Veuillez choisir une date de réservation valide.";
    document.getElementById("statut_reservation_error").textContent = "Veuillez sélectionner un statut.";
    document.getElementById("heure_debut_error").textContent = "Veuillez spécifier l'heure de début.";
    document.getElementById("heure_fin_error").textContent = "Veuillez spécifier l'heure de fin.";
    document.getElementById("mode_paiement_error").textContent = "Veuillez choisir un mode de paiement.";
    document.getElementById("pourcentage_charge_error").textContent = "Veuillez entrer un pourcentage entre 20 et 100.";
    // Gestion de la soumission du formulaire
    document.getElementById("formReservation").addEventListener("submit", function (event) {
        let isValid = true;

        // Réinitialiser les messages
        document.querySelectorAll('.error-message').forEach(function (msg) {
            msg.textContent = "";
        });

        function setError(id, message) {
            document.getElementById(id).textContent = message;
            isValid = false;
        }

        const nom = document.getElementById("nomClient").value.trim();
        const prenom = document.getElementById("prenomClient").value.trim();
        const email = document.getElementById("emailClient").value.trim();
        const date = new Date(document.getElementById("date_reservation").value);
        const statut = document.getElementById("statut_reservation").value;
        const heureDebut = document.getElementById("heure_debut").value;
        const heureFin = document.getElementById("heure_fin").value;
        const duree = parseFloat(document.getElementById("duree_charge").value);
        const modePaiement = document.querySelector('input[name="mode_paiement"]:checked');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (nom === "") setError("nomClient_error", "Nom requis.");
        if (prenom === "") setError("prenomClient_error", "Prénom requis.");
        if (!emailRegex.test(email)) setError("emailClient_error", "Email invalide.");
        if (isNaN(date.getTime())) setError("date_reservation_error", "Date invalide.");
        if (statut === "") setError("statut_reservation_error", "Statut requis.");
        if (heureDebut === "") setError("heure_debut_error", "Heure de début requise.");
        if (heureFin === "") setError("heure_fin_error", "Heure de fin requise.");
        if (isNaN(duree) || duree <= 0) setError("duree_charge_error", "Durée invalide.");
        if (!modePaiement) setError("mode_paiement_error", "Mode de paiement requis.");

        if (!isValid) event.preventDefault();
    });

    // Effacer les erreurs lorsqu'on corrige les champs
    function clearErrorOnInput(idInput, idError, validator) {
        const input = document.getElementById(idInput);
        input.addEventListener("input", function () {
            if (validator(input.value)) {
                document.getElementById(idError).textContent = "";
            }
        });
    }

    function notEmpty(value) {
        return value.trim() !== "";
    }

    function validEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function positiveNumber(value) {
        return !isNaN(value) && parseFloat(value) > 0;
    }

    function percentageValid(value) {
        const val = parseInt(value);
        return !isNaN(val) && val >= 0 && val <= 100;
    }

    clearErrorOnInput("nomClient", "nomClient_error", notEmpty);
    clearErrorOnInput("prenomClient", "prenomClient_error", notEmpty);
    clearErrorOnInput("emaillient", "emailClient_error", validEmail);
    clearErrorOnInput("date_reservation", "date_reservation_error", notEmpty);
    clearErrorOnInput("heure_debut", "heure_debut_error", notEmpty);
    clearErrorOnInput("heure_fin", "heure_fin_error", notEmpty);
    clearErrorOnInput("duree_charge", "duree_charge_error", positiveNumber);
    clearErrorOnInput("pourcentage_charge", "pourcentage_charge_error", percentageValid);

    document.getElementById("statut_reservation").addEventListener("change", function () {
        if (this.value !== "") {
            document.getElementById("statut_reservation_error").textContent = "";
        }
    });

    document.querySelectorAll('input[name="mode_paiement"]').forEach(function (radio) {
        radio.addEventListener("change", function () {
            document.getElementById("mode_paiement_error").textContent = "";
        });
    });
});
