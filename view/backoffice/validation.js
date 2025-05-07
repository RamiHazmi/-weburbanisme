function afficherErreur(idChamp, message) {
    const champ = document.getElementById(idChamp);
    let erreur = champ.parentElement.parentElement.querySelector(".error-message");

    if (!erreur) {
        erreur = document.createElement("div");
        erreur.className = "error-message";
        erreur.style.color = "red";
        erreur.style.fontSize = "13px";
        erreur.style.marginTop = "5px";
        champ.parentElement.parentElement.appendChild(erreur);
    }

    erreur.innerText = message;
}

function effacerErreurs() {
    const erreurs = document.querySelectorAll(".error-message");
    erreurs.forEach(el => el.remove());
}

function validerFormulaire() {
    effacerErreurs();

    let nomParking = document.getElementById("nom_parking").value.trim();
    let localisation = document.getElementById("localisation").value.trim();
    let capaciteTotale = parseInt(document.getElementById("capacite_totale").value.trim());
    let placesDispo = parseInt(document.getElementById("places_dispo").value.trim());
    let tarifHoraire = parseFloat(document.getElementById("tarif_horaire").value.trim());
    let securise = document.getElementById("securise").value;
    let ville = document.getElementById("ville").value.trim();

    let securiseBool = securise === "1";  

    let valide = true;

    if (nomParking.length < 3) {
        afficherErreur("nom_parking", "Le nom du parking doit contenir au moins 3 caractères.");
        valide = false;
    }

    if (localisation.length < 3) {
        afficherErreur("localisation", "La localisation doit contenir au moins 3 caractères.");
        valide = false;
    }

    if (ville.length < 3) {
        afficherErreur("ville", "Le nom de la ville doit contenir au moins 3 caractères.");
        valide = false;
    }

    if (isNaN(capaciteTotale) || capaciteTotale <= 0) {
        afficherErreur("capacite_totale", "La capacité totale doit être un nombre positif.");
        valide = false;
    }

    if (isNaN(placesDispo) || placesDispo <= 0) {
        afficherErreur("places_dispo", "Le nombre de places disponibles doit être un nombre positif.");
        valide = false;
    } else if (placesDispo >= capaciteTotale) {
        afficherErreur("places_dispo", "Les places disponibles doivent être inférieures à la capacité totale.");
        valide = false;
    }

    if (isNaN(tarifHoraire) || tarifHoraire <= 0) {
        afficherErreur("tarif_horaire", "Le tarif horaire doit être un nombre valide.");
        valide = false;
    }

    
    if (securise === "") {
        afficherErreur("securise", "Veuillez sélectionner si le parking est sécurisé.");
        valide = false;
    } else if (securise === "1") {
        console.log("Parking sécurisé");
    } else if (securise === "0") {
        console.log("Parking non sécurisé");
    }

    return valide;
}
