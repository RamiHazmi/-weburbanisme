const slider = document.getElementById("pourcentage_charge");
const output = document.getElementById("outputPourcentage");
const tarifInput = document.getElementById("tarif_estime");


const colorMap = {
  "20": "#e74c3c",  // Rouge
  "40": "#e67e22",  // Orange
  "60": "#f1c40f",  // Jaune
  "80": "#27ae60",  // Vert
  "100": "#2980b9"  // Bleu
};

slider.addEventListener("input", function () {
  const value = slider.value;
  const color = colorMap[value] || "#2980b9";

  // Mettre à jour la couleur du texte
  output.textContent = value + "%";
  output.className = "";
  output.style.color = color;

  // Mettre à jour la couleur de la ligne du slider
  slider.style.background = color;
});

// Appliquer la couleur initiale
window.addEventListener("DOMContentLoaded", () => {
  const value = slider.value;
  const color = colorMap[value];
  output.style.color = color;
  slider.style.background = color;

   // Fonction pour mettre à jour affichage et tarif
   function updateTarifEtPourcentage() {
    const pourcentage = parseInt(slider.value);
    outputPourcentage.textContent = pourcentage + "%";
    tarifInput.value = pourcentage + " DT"; // Affiche "40 DT", "60 DT", etc.
  }

  slider.addEventListener("input", updateTarifEtPourcentage);

  // Mise à jour au chargement initial
  window.addEventListener("DOMContentLoaded", updateTarifEtPourcentage);
});