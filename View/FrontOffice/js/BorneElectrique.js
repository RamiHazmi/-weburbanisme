let map; // Variable globale pour la carte

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".show-map").forEach(button => {
        button.addEventListener("click", function () {
            let lat = parseFloat(this.getAttribute("data-lat"));
            let lng = parseFloat(this.getAttribute("data-lng"));

            // Afficher la carte
            document.getElementById("map-container").style.display = "block";

            // Si la carte n'existe pas encore, on la crée
            if (!map) {
                map = L.map('map').setView([lat, lng], 10);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
            } else {
                map.setView([lat, lng], 10);
            }

            // Ajouter un marqueur
            L.marker([lat, lng]).addTo(map)
                .bindPopup("Borne de recharge ici")
                .openPopup();
        });
    });
});

