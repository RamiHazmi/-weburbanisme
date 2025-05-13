<?php
// Récupération de id_borne depuis GET ou POST
$id_borne = $_GET['id_borne'] ?? $_POST['id_borne'] ?? null;

if (!$id_borne) {
    echo "Erreur : ID de la borne manquant.";
    exit;
}

// Récupération du tarif estimé depuis GET/POST ou valeur par défaut
$tarif_estime_raw = $_GET['tarif_estime'] ?? $_POST['tarif_estime'] ?? 60.00; // 60.00 € en exemple

// Nettoyage : suppression des caractères non numériques sauf le point (.)
$tarif_estime = floatval(preg_replace('/[^0-9.]/', '', $tarif_estime_raw));

// Exemple : ID de réservation (à générer ou récupérer selon ta logique)
$id_reservation = uniqid('res_');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement avec Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<h2>Paiement pour la borne #<?= htmlspecialchars($id_borne) ?></h2>
<p>Tarif estimé : <?= number_format($tarif_estime, 2) ?> €</p>

<!-- Formulaire de paiement Stripe -->
<form id="payment-form">
    <div id="card-element">
        <!-- Un champ pour saisir les informations de la carte -->
    </div>
    <div id="card-errors" role="alert"></div>
    <button id="submit">Payer maintenant</button>
</form>

<script>
    const stripe = Stripe("pk_test_51RLpATQPCRwnkvLJ0U379ykVN2b7aXjrfDmjXArR4ma0rdm0q8OkbrfdWa1quutSz7vSpxvUbnZJk3nxOXLpPBMM008d2Cdgoa");
    const elements = stripe.elements();

    // Créer un élément de carte Stripe
    const card = elements.create("card");
    card.mount("#card-element");

    // Gestion des erreurs
    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Lorsque l'utilisateur soumet le formulaire
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        // Créer un paiement avec Stripe
        const {token, error} = await stripe.createToken(card);

        if (error) {
            // Afficher l'erreur à l'utilisateur
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            // Si le token est généré, envoyer le token au serveur
            fetch('processPayment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    token: token.id,
                    tarif_estime: <?= json_encode($tarif_estime) ?>,
                    id_reservation: <?= json_encode($id_reservation) ?>,
                    id_borne: <?= json_encode($id_borne) ?>
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paiement réussi !');
                    // Enregistrer la réservation dans la base de données
                    window.location.href = 'success.php'; // Redirection vers une page de succès
                } else {
                    alert('Erreur lors du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
    });
</script>

</body>
</html>
