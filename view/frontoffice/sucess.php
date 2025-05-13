<?php
require_once 'C:/xampp/htdocs/urbanisme/vendor/autoload.php';


// Connexion à la base de données
$host = 'localhost';
$db = 'urbanisme';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Récupération des données POST
$nomClient = $_POST['nomClient'] ?? 'John';
$prenomClient = $_POST['prenomClient'] ?? 'Doe';
$emailClient = $_POST['emailClient'] ?? 'john.doe@example.com';
$tarif_estime = $_POST['tarif_estime'] ?? 10.50;
$id_borne = $_POST['id_borne'] ?? 1;
$heure_debut = $_POST['heure_debut'] ?? '12:00';
$heure_fin = $_POST['heure_fin'] ?? '14:00';
$duree_charge = $_POST['duree_charge'] ?? 2;

// ID de réservation (généré automatiquement)
$id_reservation = uniqid('res_');

// Création de la session Stripe
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => 'Paiement Réservation Borne'],
                'unit_amount' => $tarif_estime * 100, // Conversion en centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/AffichageReservation.php?id_reservation=' . $id_reservation . '&session_id={CHECKOUT_SESSION_ID}',
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
