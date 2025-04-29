<?php
include_once __DIR__ . '/../../Config/config.php';

// Si $conn n'existe toujours pas après le include, on se connecte ici
if (!isset($conn)) {
    try {
        // Connexion à la base de données
        $conn = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

// Sécurité: vérifier que l'id est présent
if (!isset($_GET['id_reservation'])) {
    die('ID réservation manquant.');
}

$id_reservation = $_GET['id_reservation'];

// Récupérer les infos de la réservation
$stmt = $conn->prepare("SELECT * FROM reservationborne WHERE id_reservation = ?");
$stmt->execute([$id_reservation]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die('Réservation introuvable.');
}

// Vérifier que l'id_reservation existe dans la table reservationborne
$stmt_check = $conn->prepare("SELECT COUNT(*) FROM reservationborne WHERE id_reservation = ?");
$stmt_check->execute([$id_reservation]);
$reservation_exists = $stmt_check->fetchColumn();

if ($reservation_exists == 0) {
    die('L\'id_reservation n\'existe pas dans la table reservationborne.');
}

// Ajouter un identifiant unique dans le titre ou la description pour éviter les doublons
$unique_id = "reservation_" . $row["id_reservation"]; // Identifiant unique basé sur l'ID de la réservation

// Vérifier si l'événement a déjà été ajouté dans la base de données ou autre mécanisme de stockage
$stmt_check_event = $conn->prepare("SELECT * FROM google_calendar_events WHERE unique_id = ?");
$stmt_check_event->execute([$unique_id]);
$existing_event = $stmt_check_event->fetch(PDO::FETCH_ASSOC);

if ($existing_event) {
    echo "<script>
            alert('Cet événement a déjà été ajouté à Google Calendar.');
            window.location.href = 'Reservation.php';  // Rediriger vers la page Reservation.php
          </script>";
    exit;  // Arrêter l'exécution du script PHP après l'alerte et la redirection
}


// Préparer les paramètres pour Google Calendar
$start = date('Ymd\THis\Z', strtotime($row["date_reservation"] . ' ' . $row["heure_debut"]));
$end = date('Ymd\THis\Z', strtotime($row["date_reservation"] . ' ' . $row["heure_fin"]));
$title = "🔋 Recharge - " . $row["nomClient"] . " " . $row["prenomClient"] . " - " . $unique_id . 
         " - ✉️ " . $row["emailClient"] . 
         " - 🕒 Heure début : " . $row["heure_debut"] . 
         " - 🕒 Heure fin : " . $row["heure_fin"] . 
         " - 🔌 Durée de charge : " . $row["duree_charge"] . " minutes" . 
         " - 🔋 Pourcentage : " . $row["pourcentage_charge"] . "%" . 
         " - 💵 Tarif estimé : " . $row["tarif_estime"] . " €" . 
         " - 💳 Mode de paiement : " . $row["mode_paiement"];

// Description avec des emojis et les données de la réservation
$description = "🧑 Nom Client : " . $row["nomClient"] . "\n" . 
               "🧑‍🦱 Prénom Client : " . $row["prenomClient"] . "\n" . 
               "✉️ Email : " . $row["emailClient"] . "\n" . 
               "🗓️ Date : " . $row["date_reservation"] . "\n" . 
               "🕒 Heure début : " . $row["heure_debut"] . "\n" . 
               "🕒 Heure fin : " . $row["heure_fin"] . "\n" . 
               "🔌 Durée de charge : " . $row["duree_charge"] . " minutes\n" . 
               "🔋 Pourcentage : " . $row["pourcentage_charge"] . "%\n" . 
               "💵 Tarif estimé : " . $row["tarif_estime"] . " \n" . 
               "💳 Mode de paiement : " . $row["mode_paiement"] . "\n" . 
               "📌 Statut : " . $row["statut_reservation"] . "\n" . 
               "ID unique : " . $unique_id; // Pas besoin d'encoder ici

// Construire l'URL pour Google Calendar (pas d'URL encoding ici, uniquement dans `http_build_query`)
$googleCalendarUrl = "https://calendar.google.com/calendar/render?" . http_build_query([
    'action' => 'TEMPLATE',
    'text' => $title,
    'dates' => $start . '/' . $end,
    'details' => $description, // Description sans double encodage
    'location' => $location, // Ajoutez la localisation si nécessaire
]);

// Enregistrer l'événement dans la base de données pour éviter les doublons
$stmt_insert = $conn->prepare("INSERT INTO google_calendar_events (id_reservation, unique_id, title, description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt_insert->execute([$id_reservation, $unique_id, $title, $description, $start, $end]);

// Rediriger vers Google Calendar
header("Location: $googleCalendarUrl");
exit;
?>
