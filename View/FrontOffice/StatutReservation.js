document.addEventListener("DOMContentLoaded", () => {
    const statutSelect = document.getElementById("statut_reservation");
    const btnSoumettre = document.getElementById("btnSoumettre");
    const form = document.querySelector("form");

    statutSelect.addEventListener("change", () => {
        const statut = statutSelect.value;

        // Réinitialiser les styles
        btnSoumettre.style.backgroundColor = "";
        btnSoumettre.disabled = false;

        if (statut === "Confirmé") {
            btnSoumettre.style.backgroundColor = "green";
        } else if (statut === "En attente") {
            btnSoumettre.style.backgroundColor = "orange";
        }
    });

    form.addEventListener("submit", (e) => {
        const statut = statutSelect.value;

        if (statut === "En attente") {
            e.preventDefault(); // Empêche la soumission directe

            const confirmation = confirm("Tu veux changer une chose ?");

            if (confirmation) {
                statutSelect.value = "Confirmé";
                btnSoumettre.style.backgroundColor = "green";
                alert("Formulaire modifié, statut changé à 'Confirmé'.");
            } else {
                statutSelect.value = "Confirmé";
                btnSoumettre.style.backgroundColor = "green";
                form.submit(); // Soumission automatique si "non"
            }
        }
    });
});