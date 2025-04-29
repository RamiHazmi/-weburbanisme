window.addEventListener("DOMContentLoaded", () => {
    function calculerDuree() {
        const heureDebut = document.getElementById("heure_debut").value;
        const heureFin = document.getElementById("heure_fin").value;

        if (heureDebut && heureFin) {
            const [hDeb, mDeb] = heureDebut.split(":").map(Number);
            const [hFin, mFin] = heureFin.split(":").map(Number);

            const dateDebut = new Date(0, 0, 0, hDeb, mDeb);
            const dateFin = new Date(0, 0, 0, hFin, mFin);

            let diffMs = dateFin - dateDebut;
            if (diffMs < 0) diffMs += 24 * 60 * 60 * 1000; // ajoute 24h si négatif

            const totalMinutes = Math.floor(diffMs / (1000 * 60));
            const heures = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            const dureeTexte = `${heures}H${minutes}Minute`;
            document.getElementById("duree_charge").value = dureeTexte;
        }
    }

    document.getElementById("heure_debut").addEventListener("change", calculerDuree);
    document.getElementById("heure_fin").addEventListener("change", calculerDuree);
});
