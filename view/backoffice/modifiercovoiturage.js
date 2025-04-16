document.addEventListener("DOMContentLoaded", function () {
    const modificationForm = document.getElementById("modification-form");
    const updateForm = document.getElementById("updateForm");
    const messageDiv = document.getElementById("message");
    const imagePreview = document.getElementById("imagePreview");
    const imageUpload = document.getElementById("imageUpload");

    // Fill the form when 'Modifier' button is clicked
    document.querySelectorAll(".modifier-btn").forEach(button => {
        button.addEventListener("click", function () {
            modificationForm.style.display = "block";

            document.getElementById("id_trajet").value = this.dataset.id;
            document.getElementById("depart").value = this.dataset.depart;
            document.getElementById("destination").value = this.dataset.destination;
            document.getElementById("date_heure").value = this.dataset.date_heure;
            document.getElementById("tarif").value = this.dataset.tarif;
            document.getElementById("places_dispo").value = this.dataset.places_dispo;
            document.getElementById("conducteur_id").value = this.dataset.conducteur_id;
            document.getElementById("matricule_voiture").value = this.dataset.matricule_voiture;
            document.getElementById("marque").value = this.dataset.marque;
            document.getElementById("couleur").value = this.dataset.couleur;
            document.getElementById("existing_image").value = this.dataset.image;

            imagePreview.src = this.dataset.image;
            imagePreview.style.display = "block";
        });
    });

    // Show preview of selected image before upload
    imageUpload.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "";
            imagePreview.style.display = "none";
        }
    });

    // Submit form for modification
    updateForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(updateForm);
        formData.append("action", "modifyCovoiturage");

        
        fetch("/urbanisme/controller/controllercovoiturage.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            try {
                const data = JSON.parse(result);
                
                // Display the message with the appropriate color
                messageDiv.innerHTML = data.message;
                messageDiv.style.color = data.status === "success" ? "green" : "red";

                if (data.status === "success") {
                    setTimeout(() => location.reload(), 1500);
                }
            } catch (e) {
                messageDiv.innerHTML = "<p style='color:red;'>Erreur inattendue : " + result + "</p>";
            }
        })
        .catch(error => {
            console.error("Error:", error);
            messageDiv.innerHTML = "<p style='color:red;'>Erreur lors de la mise à jour.</p>";
        });
    });

    document.getElementById("annuler").addEventListener("click", () => {
        modificationForm.style.display = "none";
        updateForm.reset();
        imagePreview.style.display = "none";
        messageDiv.innerHTML = "";
    });
});
