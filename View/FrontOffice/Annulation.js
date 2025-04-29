const selectStatut = document.getElementById("statut_reservation");
    const annulationBox = document.getElementById("annulation-confirmation");
    const confirmBtn = document.getElementById("confirm-annulation");
    const cancelBtn = document.getElementById("cancel-annulation");
    const submitBtn = document.querySelector("button[type='submit']"); // Bouton Soumettre

    selectStatut.addEventListener("change", function () {
        if (selectStatut.value === "Annulée") {
            annulationBox.style.display = "block";
            submitBtn.style.display = "none"; // Masquer le bouton Soumettre
        } else {
            annulationBox.style.display = "none";
            submitBtn.style.display = "block"; // Réafficher dans les autres cas
        }
    });

    confirmBtn.addEventListener("click", function () {
        // Redirection vers ReservationBorne.php
        window.location.href = "ReservationBorne.php";
    });

    cancelBtn.addEventListener("click", function () {
        // Réinitialisation
        selectStatut.value = ""; 
        annulationBox.style.display = "none";
        submitBtn.style.display = "block"; // Réafficher le bouton Soumettre
        alert("Votre réservation n'est pas annulée. Vous pouvez encore la modifier ou la confirmer 😉");
    });