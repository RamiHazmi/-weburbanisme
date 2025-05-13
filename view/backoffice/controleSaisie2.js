document.addEventListener("DOMContentLoaded", function () {
    // Messages par défaut
    document.getElementById("id_borne_error").textContent = 'Cliquez sur "Générer" pour créer un ID aléatoire.';
    document.getElementById("localisation_error").textContent = 'Cliquez sur 📍 "Choisir sur la carte" pour sélectionner une localisation.';
    document.getElementById("type_bornes_error").textContent = 'Veuillez sélectionner un type de borne.';
    document.getElementById("etat_borne_error").textContent = 'Veuillez sélectionner l’état de la borne.';
    document.getElementById("operateur_error").textContent = "Veuillez sélectionner un opérateur.";
    document.getElementById("nombre_ports_error").textContent = "Veuillez entrer un nombre entier positif.";
    document.getElementById("power-error-message").textContent = "Veuillez entrer un nombre entier positif.";
    document.getElementById("date_installation_error").textContent = "Veuillez choisir une date d'installation valide (aujourd'hui ou future).";

    const generateBtn = document.getElementById("generateBtn");
    generateBtn.addEventListener("click", function () {
        document.getElementById("id_borne_error").textContent = "";
        generateBtn.disabled = true;
    });

    const validLocalisations = ["Tunis", "Sfax", "Sousse", "Kairouan"];
    document.getElementById("localisation").addEventListener("input", function () {
        const localisationError = document.getElementById("localisation_error");
        const userInput = this.value.trim();
        if (validLocalisations.includes(userInput)) {
            localisationError.textContent = "";
        }
    });

    // Met à jour automatiquement le champ nombre_ports selon le type
    document.getElementById("type_bornes").addEventListener("change", function () {
        const type = this.value;
        const typeBornesError = document.getElementById("type_bornes_error");
        const nombrePortsInput = document.getElementById("nombre_ports");
        const puissanceInput = document.getElementById("puissance");

        if (type !== "") {
            typeBornesError.textContent = "";
        }

        let portsParDefaut = "";
        switch (type) {
            case "Lente":
                portsParDefaut = 1;
                break;
            case "Accélérée":
                portsParDefaut = 2;
                break;
            case "Rapide":
                portsParDefaut = 3;
                break;
            case "Ultra-rapide":
                portsParDefaut = 4;
                break;
        }

        if (portsParDefaut !== "") {
            nombrePortsInput.value = portsParDefaut;
            nombrePortsInput.dispatchEvent(new Event('input')); // déclenche l’événement input
            document.getElementById("nombre_ports_error").textContent = "";
        }

        if (puissanceInput.value !== "") {
            validatePuissance();
        }
    });

    document.getElementById("etat_borne").addEventListener("change", function () {
        if (this.value !== "") {
            document.getElementById("etat_borne_error").textContent = "";
        }
    });

    document.getElementById("operateur").addEventListener("change", function () {
        if (this.value !== "") {
            document.getElementById("operateur_error").textContent = "";
        }
    });

    document.getElementById("puissance").addEventListener("input", validatePuissance);
    document.getElementById("puissance").addEventListener("change", validatePuissance);

    function validatePuissance() {
        const puissance = parseInt(document.getElementById("puissance").value);
        const typeBorne = document.getElementById("type_bornes").value;
        const puissanceError = document.getElementById("power-error-message");

        if (isNaN(puissance) || puissance <= 0) {
            puissanceError.textContent = "Veuillez entrer un nombre entier supérieur à 0.";
            return;
        }

        let message = "";
        switch (typeBorne) {
            case "Lente":
                if (puissance < 3 || puissance > 7) {
                    message = "Pour une borne Lente, la puissance doit être entre 3 et 7 kW.";
                }
                break;
            case "Accélérée":
                if (puissance < 7 || puissance > 22) {
                    message = "Pour une borne Accélérée, la puissance doit être entre 7 et 22 kW.";
                }
                break;
            case "Rapide":
                if (puissance < 22 || puissance > 50) {
                    message = "Pour une borne Rapide, la puissance doit être entre 22 et 50 kW.";
                }
                break;
            case "Ultra-rapide":
                if (puissance < 50 || puissance > 350) {
                    message = "Pour une borne Ultra-rapide, la puissance doit être entre 50 et 350 kW.";
                }
                break;
            default:
                message = "Veuillez sélectionner un type de borne valide.";
        }

        puissanceError.textContent = message;
    }

    document.getElementById("date_installation").addEventListener("change", function () {
        const selectedDate = new Date(this.value);
        const today = new Date();
        selectedDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);
        const error = document.getElementById("date_installation_error");

        if (selectedDate < today) {
            error.textContent = "La date d'installation ne peut pas être dans le passé.";
        } else {
            error.textContent = "";
        }
    });

    document.getElementById("formBorne").addEventListener("submit", function (event) {
        let isValid = true;

        document.querySelectorAll('.error-message').forEach(function (msg) {
            msg.textContent = "";
        });

        const idBorne = document.getElementById("id_borne");
        if (!idBorne.value.trim()) {
            document.getElementById("id_borne_error").textContent = "L'ID de la borne est requis.";
            isValid = false;
        }

        const typeBornes = document.getElementById("type_bornes");
        if (typeBornes.value === "") {
            document.getElementById("type_bornes_error").textContent = "Veuillez sélectionner un type de borne.";
            isValid = false;
        }

        const etatBorne = document.getElementById("etat_borne");
        if (etatBorne.value === "") {
            document.getElementById("etat_borne_error").textContent = "Veuillez sélectionner l’état de la borne.";
            isValid = false;
        }

        const operateur = document.getElementById("operateur");
        if (operateur.value === "") {
            document.getElementById("operateur_error").textContent = "Veuillez sélectionner un opérateur.";
            isValid = false;
        }

        const nombrePorts = document.getElementById("nombre_ports").value;
        if (!/^\d+$/.test(nombrePorts) || parseInt(nombrePorts) <= 0) {
            document.getElementById("nombre_ports_error").textContent = "Veuillez entrer un nombre entier supérieur à 0.";
            isValid = false;
        }

        const dateInstallation = new Date(document.getElementById("date_installation").value);
        const today = new Date();
        dateInstallation.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);
        if (dateInstallation < today) {
            document.getElementById("date_installation_error").textContent = "La date d'installation ne peut pas être dans le passé.";
            isValid = false;
        }

        const puissance = parseInt(document.getElementById("puissance").value);
        const typeBorne = document.getElementById("type_bornes").value;
        const puissanceError = document.getElementById("power-error-message");

        if (isNaN(puissance) || puissance <= 0) {
            puissanceError.textContent = "Veuillez entrer un nombre entier supérieur à 0.";
            isValid = false;
        } else {
            let message = "";
            switch (typeBorne) {
                case "Lente":
                    if (puissance < 3 || puissance > 7) {
                        message = "Pour une borne Lente, la puissance doit être entre 3 et 7 kW.";
                    }
                    break;
                case "Accélérée":
                    if (puissance < 7 || puissance > 22) {
                        message = "Pour une borne Accélérée, la puissance doit être entre 7 et 22 kW.";
                    }
                    break;
                case "Rapide":
                    if (puissance < 22 || puissance > 50) {
                        message = "Pour une borne Rapide, la puissance doit être entre 22 et 50 kW.";
                    }
                    break;
                case "Ultra-rapide":
                    if (puissance < 50 || puissance > 350) {
                        message = "Pour une borne Ultra-rapide, la puissance doit être entre 50 et 350 kW.";
                    }
                    break;
                default:
                    message = "Veuillez sélectionner un type de borne valide.";
            }

            if (message !== "") {
                puissanceError.textContent = message;
                isValid = false;
            } else {
                puissanceError.textContent = "";
            }
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
