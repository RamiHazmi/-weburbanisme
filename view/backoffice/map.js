let map;
let markers = [];

// Liste des bornes avec leurs coordonnées
const bornes = [
    { name: "Borne 1", lat: 36.8065, lng: 10.1815, localisation: "Tunis" },
    { name: "Borne 2", lat: 34.7402, lng: 10.7600, localisation: "Sfax" },
    { name: "Borne 3", lat: 35.8256, lng: 10.6369, localisation: "Sousse" },
    { name: "Borne 4", lat: 35.6782, lng: 10.0960, localisation: "Kairouan" }
];

function openMap() {
    const mapDiv = document.getElementById("map");

    // Affiche le cadre en ajustant les styles
    mapDiv.style.display = "block";
    mapDiv.style.visibility = "visible";
    mapDiv.style.height = "400px";
    mapDiv.style.border = "1px solid #ccc";
    mapDiv.style.marginTop = "10px";

    if (!map) {
        map = L.map('map').setView([36.8065, 10.1815], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        bornes.forEach(function(borne) {
            let marker = L.marker([borne.lat, borne.lng]).addTo(map);
            marker.bindPopup(`<b>${borne.name}</b><br>${borne.localisation}`)
                .on('click', function() {
                    document.getElementById("localisation").value = borne.localisation;
                });
            markers.push(marker);
        });
    }
}
