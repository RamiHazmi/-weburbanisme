<?php
// Tu peux enregistrer ici la session Stripe dans ta base de données si besoin

// Tu peux aussi afficher des détails via $_GET['id_reservation'] si tu veux
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement réussi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 80px;
        }

        .container {
            padding: 20px;
        }

        .message {
            font-size: 22px;
            color: green;
            margin-bottom: 20px;
        }

        .redirect {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">✅ Paiement effectué avec succès !</div>
        <div class="redirect">Redirection vers la page de réservation dans quelques secondes...</div>
    </div>

    <script>
        // Redirection automatique après 5 secondes
        setTimeout(function() {
            window.location.href = "ReservationBorne.php";
        }, 5000);
    </script>
</body>
</html>
