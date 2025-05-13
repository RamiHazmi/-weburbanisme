<?php
require_once 'C:/xampp/htdocs/urbanisme/vendor/autoload.php';

require_once __DIR__ . '/../../database.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$id_reservation = $_GET['id_reservation'] ?? null;

if (!$id_reservation) {
    header('Content-Type: text/plain');
    echo 'ID de réservation manquant.';
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$stmt = $pdo->prepare("SELECT nomClient, emailClient, id_borne FROM reservationborne WHERE id_reservation = ?");
$stmt->execute([$id_reservation]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    header('Content-Type: text/plain');
    echo 'Réservation introuvable.';
    exit;
}

$qrText = "Nom: " . $reservation['nomClient'] . "\n" .
          "Email: " . $reservation['emailClient'] . "\n" .
          "Borne ID: " . $reservation['id_borne'];

$result = Builder::create()
    ->writer(new PngWriter())
    ->data($qrText)
    ->size(256)
    ->margin(10)
    ->build();

header('Content-Type: ' . $result->getMimeType());
echo $result->getString();
exit;
?>