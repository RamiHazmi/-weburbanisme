document.querySelectorAll('input[name="mode_paiement"]').forEach((el) => {
    el.addEventListener('change', function () {
        const info = document.getElementById("online-payment-info");
        if (this.value === "en_ligne") {
            info.style.display = "block";
        } else {
            info.style.display = "none";
        }
    });
});
