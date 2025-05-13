<?php
// Inclure la bibliothèque Stripe
require_once 'C:/xampp/htdocs/urbanisme/vendor/autoload.php';

// Clé secrète Stripe
\Stripe\Stripe::setApiKey('sk_test_51RLpATQPCRwnkvLJTAr0zIbzlesDKUIPYMVDHCQ7qJgu3aOczYLUQcVIKiLwOJ05hNeqnIy2Kr8O639ow8zZDfrd00OE7qXkXN');

// Connexion à la base de données
$host = 'localhost';
$db = 'urbanisme';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Récupération des données POST, avec valeurs par défaut si non envoyées
$nomClient = $_POST['nomClient'] ?? null;
$emailClient = $_POST['emailClient'] ?? null;
$tarif_estime = $_POST['tarif_estime'] ?? null;
$id_borne = $_POST['id_borne'] ?? null;
$heure_debut = $_POST['heure_debut'] ?? null;
$heure_fin = $_POST['heure_fin'] ?? null;
$duree_charge = $_POST['duree_charge'] ?? null;

// Vérification si les données sont disponibles dans la base de données si non fournies via POST
if ($nomClient === null || $emailClient === null || $tarif_estime === null || $id_borne === null) {
    // Exemple de requête pour obtenir les informations liées à l'ID de la borne
    $sql = "SELECT nomClient, emailClient, tarif_estime FROM reservationborne WHERE id_borne = :id_borne LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_borne' => $id_borne]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si une réservation est trouvée pour cet ID de borne, affecter les valeurs à partir de la base de données
    if ($reservation) {
        $nomClient = $nomClient ?? $reservation['nomClient'];
        $emailClient = $emailClient ?? $reservation['emailClient'];
        $tarif_estime = $tarif_estime ?? $reservation['tarif_estime'];
    } else {
        // Si aucune réservation n'existe, utiliser des valeurs par défaut
        $nomClient = $nomClient ?? 'John Doe';
        $emailClient = $emailClient ?? 'john.doe@example.com';
        $tarif_estime = $tarif_estime ?? 10.50;
    }
}

// ID de réservation (généré automatiquement)
$id_reservation = uniqid('res_');

// Création de la session Stripe
try {
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Réservation une borne', // Nom discret obligatoire
            ],
            'unit_amount' => $tarif_estime * 100,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/urbanisme/view/frontoffice/sucess.php?session_id={CHECKOUT_SESSION_ID}&id_reservation=' . $id_reservation,
    'cancel_url' => 'http://localhost/cancel.php',
]);


    // Rediriger l'utilisateur vers Stripe
    header('Location: ' . $session->url);
    exit;

} catch (Exception $e) {
    echo 'Erreur lors de la création de la session Stripe: ' . $e->getMessage();
    exit;
}
?>
