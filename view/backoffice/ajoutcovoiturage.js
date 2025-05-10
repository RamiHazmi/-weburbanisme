document.getElementById("covoiturageForm").addEventListener("submit", function (e) {
    e.preventDefault(); 

    if (!validateForm()) {
        console.log("Form validation failed.");
        return;
    }

    // Log form data for debugging
    const formData = new FormData(this);
    formData.forEach((value, key) => {
        console.log(key + ": " + value);
    });

    // Make the AJAX request
    fetch("indexc.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Form submitted successfully. Response:", data);
		message.style.display = "block";
        document.getElementById("message").innerHTML = data;
        document.getElementById("covoiturageForm").reset();
		setTimeout(function() {
    document.getElementById("message").style.display = "none";
}, 3000);
    })
    .catch(error => {
		message.style.display = "block";
        console.error("Error during the request:", error);
        document.getElementById("message").innerHTML = `<div class="alert alert-danger">Erreur lors de l'ajout: ${error}</div>`;
    });
});

function validateForm() {
    let valid = true;
    document.querySelectorAll(".error").forEach(e => e.textContent = ""); // Reset any previous errors

    function showError(id, message) {
        document.getElementById(id).textContent = message;
        valid = false;
    }

    // Validate required fields
    if (document.getElementById("depart").value.trim() === "") showError("depart_error", "Ce champ est obligatoire");
    if (document.getElementById("destination").value.trim() === "") showError("destination_error", "Ce champ est obligatoire");
    if (document.getElementById("date_heure").value.trim() === "") showError("date_heure_error", "La date et l'heure du départ doivent être un moment valide et supérieur ou égal à aujourd'hui.");
    if (document.getElementById("tarif").value.trim() === "") showError("tarif_error", "Le tarif doit être un nombre valide et supérieur à 0.");
    if (document.getElementById("places_dispo").value.trim() === "") showError("places_dispo_error", "Le nombre de places disponibles doit être valide.");
    if (document.getElementById("matricule_voiture").value.trim() === "") showError("matricule_voiture_error", "Le matricule doit être sous la forme xxTunis1234 ou xxxTunis1234.");
    if (document.getElementById("marque").value.trim() === "") showError("marque_error", "Ce champ est obligatoire");
    if (document.getElementById("couleur").value.trim() === "") showError("couleur_error", "Ce champ est obligatoire");
    if (document.getElementById("image").files.length === 0) showError("image_error", "Veuillez télécharger une image");

    return valid;
}
