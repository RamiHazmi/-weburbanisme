function confirmDelete(event) {
    event.preventDefault();

    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        const form = event.target; 
        const formData = new FormData(form);

        console.log(' ID de la réservation à supprimer :', formData.get('reservation_id'));

        const actionUrl = '/urbanisme/controller/controllercovoituragereservation.php?action=deleteReservation';

        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Réservation supprimée avec succès.');
                let row = form.closest('tr');
                if (row) {
                    row.remove();
                } else {
                    // Fallback: remove parent card (frontoffice case)
                    const card = form.closest('.col-md-6');
                    if (card) card.remove();
                }
                        } else {
                alert('Erreur : ' + (data.message || 'Suppression échouée.'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue pendant la suppression.');
        });
    }

    return false;
}
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            updateStatus(id, 'confirmée');  // Or set to whatever status you want to use
        });
    });
});
    function updateStatus(reservationId, status) {
        fetch('/urbanisme/controller/controllercovoituragereservation.php?action=updateStatus', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_reservation: reservationId,
                statut: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
    
            if (data.success) {
                alert('Statut mis à jour avec succès.');
                console.log("Reloading now...");

                // Tu peux aussi mettre à jour l'affichage ici
                setTimeout(() => {
                    location.reload(true); 
                }, 1500);
            } else {
                alert('Erreur : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour :', error);
            alert('Une erreur est survenue.');
        });
    }
    

