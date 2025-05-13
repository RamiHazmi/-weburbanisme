document.addEventListener("DOMContentLoaded", function () {
    // Affichage initial des messages d'erreur
    document.getElementById("date_reservation_error").textContent = "Veuillez choisir une date de réservation valide.";
    document.getElementById("heure_debut_error").textContent = "Veuillez spécifier l'heure de début.";
    document.getElementById("heure_fin_error").textContent = "Veuillez spécifier l'heure de fin.";
    document.getElementById("mode_paiement_error").textContent = "Veuillez choisir un mode de paiement.";
    document.getElementById("pourcentage_charge_error").textContent = "Veuillez entrer un pourcentage entre 20 et 100.";

    let isValid = true;

    document.getElementById("formReservation").addEventListener("submit", function (event) {
        isValid = true;

        document.querySelectorAll('.error-message').forEach(function (msg) {
            msg.textContent = "";
        });

        function setError(id, message) {
            document.getElementById(id).textContent = message;
            isValid = false;
        }

        const date = new Date(document.getElementById("date_reservation").value);
        const heureDebut = document.getElementById("heure_debut").value;
        const heureFin = document.getElementById("heure_fin").value;
        const modePaiement = document.querySelector('input[name="mode_paiement"]:checked');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (isNaN(date.getTime())) setError("date_reservation_error", "Date invalide.");
        if (heureDebut === "") setError("heure_debut_error", "Heure de début requise.");
        if (heureFin === "") setError("heure_fin_error", "Heure de fin requise.");
        if (!modePaiement) setError("mode_paiement_error", "Mode de paiement requis.");

        if (heureDebut && heureFin) {
            const [hDebut, mDebut] = heureDebut.split(":").map(Number);
            const [hFin, mFin] = heureFin.split(":").map(Number);

            const debutMinutes = hDebut * 60 + mDebut;
            const finMinutes = hFin * 60 + mFin;

            if (finMinutes <= debutMinutes) {
                setError("heure_fin_error", "L'heure de fin doit être supérieure à l'heure de début.");
            } else {
                const duree = finMinutes - debutMinutes;
                const heures = Math.floor(duree / 60);
                const minutes = duree % 60;
                document.getElementById("duree_charge").value = `${heures}h ${minutes}min`;
            }
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    // Auto-calcul de la durée dès que les heures changent
    function calculerDuree() {
        const heureDebut = document.getElementById("heure_debut").value;
        const heureFin = document.getElementById("heure_fin").value;

        if (heureDebut && heureFin) {
            const [hDebut, mDebut] = heureDebut.split(":").map(Number);
            const [hFin, mFin] = heureFin.split(":").map(Number);

            const debutMinutes = hDebut * 60 + mDebut;
            const finMinutes = hFin * 60 + mFin;

            if (finMinutes > debutMinutes) {
                const duree = finMinutes - debutMinutes;
                const heures = Math.floor(duree / 60);
                const minutes = duree % 60;
                document.getElementById("duree_charge").value = `${heures}h ${minutes}min`;
            } else {
                document.getElementById("duree_charge").value = "Invalide";
            }
        }
    }

    document.getElementById("heure_debut").addEventListener("change", calculerDuree);
    document.getElementById("heure_fin").addEventListener("change", calculerDuree);

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

    function percentageValid(value) {
        const val = parseInt(value);
        return !isNaN(val) && val >= 20 && val <= 100;
    }


    clearErrorOnInput("date_reservation", "date_reservation_error", notEmpty);
    clearErrorOnInput("heure_debut", "heure_debut_error", notEmpty);
    clearErrorOnInput("heure_fin", "heure_fin_error", notEmpty);
    clearErrorOnInput("pourcentage_charge", "pourcentage_charge_error", percentageValid);

    document.querySelectorAll('input[name="mode_paiement"]').forEach(function (radio) {
        radio.addEventListener("change", function () {
            document.getElementById("mode_paiement_error").textContent = "";
        });
    });
});
