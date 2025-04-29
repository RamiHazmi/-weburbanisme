const radios = document.getElementsByName("mode_paiement");
const infoBox = document.getElementById("online-payment-info");

radios.forEach(radio => {
    radio.addEventListener("change", () => {
        if (radio.value === "en_ligne") {
            infoBox.style.display = "block";
        } else {
            infoBox.style.display = "none";
        }
    });
});
