<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=urbanisme';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit;
}

// Récupérer les réservations depuis la table 'reservationborne'
$query = 'SELECT id_reservation, id_borne, nomClient, emailClient, date_reservation, heure_debut, heure_fin, duree_charge, pourcentage_charge, tarif_estime, mode_paiement FROM reservationborne';
$stmt = $pdo->query($query);

$events = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Formatage des dates pour FullCalendar (en ISO 8601)
    $startDate = $row['date_reservation'] . 'T' . substr($row['heure_debut'], 0, 5);
    $endDate = $row['date_reservation'] . 'T' . substr($row['heure_fin'], 0, 5);

    $events[] = [
        'title' => 'Réservation de ' . $row['nomClient'],
        'start' => $startDate,
        'end' => $endDate,
        'id_borne' => $row['id_borne'],
        'emailClient' => $row['emailClient'],
        'duree_charge' => $row['duree_charge'],
        'tarif_estime' => $row['tarif_estime'],
        'mode_paiement' => $row['mode_paiement']
    ];
}

// Retourner les événements au format JSON
header('Content-Type: application/json');
echo json_encode($events);
?>