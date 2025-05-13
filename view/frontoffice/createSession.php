<?php
// Inclure la bibliothèque Stripe
require_once 'C:/xampp/htdocs/Urbanisme/vendor/autoload.php';

// Clé secrète Stripe (à sécuriser via .env en production)
\Stripe\Stripe::setApiKey('sk_test_51RLpATQPCRwnkvLJTAr0zIbzlesDKUIPYMVDHCQ7qJgu3aOczYLUQcVIKiLwOJ05hNeqnIy2Kr8O639ow8zZDfrd00OE7qXkXN');

// Headers pour JSON et CORS (à ajuster si tu as un domaine spécifique)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Récupération des données
$input = json_decode(file_get_contents('php://input'), true);

// Vérification des paramètres
if (!isset($input['tarif_estime']) || !isset($input['id_reservation'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres manquants']);
    exit;
}

$tarif = floatval($input['tarif_estime']); // en euros
$id_reservation = intval($input['id_reservation']);

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => 'Paiement Réservation Borne'],
                'unit_amount' => $tarif * 100, // conversion en centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/success.php?session_id={CHECKOUT_SESSION_ID}&id_reservation=' . $id_reservation,
        'cancel_url' => 'http://localhost/cancel.php',
    ]);

    echo json_encode(['sessionId' => $session->id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
