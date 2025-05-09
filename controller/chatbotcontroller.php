<?php
session_start();

include_once __DIR__ . '/../database.php';
include(__DIR__ . '/../model/modelcovoituragereservation.php');
include_once __DIR__ . '/controllercovoituragereservation.php';
include(__DIR__ . '/../model/user.php');
include_once (__DIR__ . '/userC.php');
header('Content-Type: application/json');

$pdo = config::getConnexion();
$question = strtolower(trim($_POST['message'] ?? ''));
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];

}
  $id_utilisateur = $_POST['id_utilisateur'] ?? $_SESSION['user_id'];

// Récupérer tous les trajets
$sql = "SELECT * FROM covoiturage";
$stmt = $pdo->query($sql);
$offers = $stmt->fetchAll();

$response = "";
$matched = false; 
if (strpos($question, 'salut') !== false || strpos($question, 'bonjour') !== false) {
    try {
        $stmt = $pdo->prepare("SELECT username FROM user WHERE id = ?");
        $stmt->execute([$id_utilisateur]);
        $user = $stmt->fetch();

        $username = $user ? $user['username'] : 'Utilisateur';

        $response .= "Salut $username ! 👋 Je peux t'aider sur les départs, destinations, places dispo, tarifs ou voitures, ainsi que vos réservations.<br>";
    } catch (PDOException $e) {
        $response .= "Salut ! 👋 Je peux t'aider sur les départs, destinations, places dispo, tarifs ou voitures.<br>";
    }
    $matched = true;
}

if (strpos($question, 'définition') !== false) {
    // Clean the input question to identify what the user is asking about
    preg_match('/définition\s+de\s+([a-zA-Z ]+)/i', $question, $matches);
    $term_demande = trim(strtolower($matches[1] ?? ''));

    // Provide a definition based on the term the user asks about
    if ($term_demande) {
        // For example, you can check for specific terms like "covoiturage", "destination", etc.
        switch ($term_demande) {
            case 'covoiturage':
                $response .= "Le *covoiturage* est une pratique qui consiste à partager un véhicule entre plusieurs personnes pour effectuer un trajet commun, généralement en réduisant les coûts de transport et l'impact environnemental.";
                break;
            case 'destination':
                $response .= "Une *destination* est un lieu où une personne souhaite se rendre en voyage ou en transport. Dans le contexte de notre service, cela fait référence à l'endroit où un trajet se termine.";
                break;
            case 'trajet':
                $response .= "Un *trajet* est un parcours effectué entre un point de départ et une destination, souvent utilisé pour se déplacer d'une ville à une autre.";
                break;
            default:
                $response .= "Désolé, je ne connais pas la définition de *$term_demande*. Peut-être que vous pouvez essayer un autre terme.";
        }
    } else {
        $response .= "Désolé, je n'ai pas pu identifier le terme pour lequel vous souhaitez obtenir la définition.";
    }

    // Mark that a response for definition has been handled
    $matched = true; // Ensure this marks the definition as answered
}
if (strpos($question, 'depart') !== false) {
    $departs = array_unique(array_column($offers, 'depart'));
    $response .= "🚏 Départs disponibles : " . implode(", ", $departs) . "<br>";
    $matched = true;
}

if (strpos($question, 'destination') !== false && strpos($question, 'définition') === false) {
    // Remove unnecessary words like "pour"
    $question_cleaned = str_ireplace('pour', '', $question);

    // Match the destination using a regex
    preg_match('/destinations\s+([a-zA-Z ]+)/i', $question_cleaned, $matches);
    $destination_demande = trim(strtolower($matches[1] ?? ''));

    // Fetch available destinations dynamically from the database
    $sql = "SELECT DISTINCT destination FROM covoiturage";
    $stmt = $pdo->query($sql);
    $destinations = $stmt->fetchAll(PDO::FETCH_COLUMN); // Get an array of distinct destinations

    if ($destination_demande) {
        // Match destinations based on the cleaned input
        $trajets_filtered = array_filter($offers, function($offer) use ($destination_demande) {
            return stripos(strtolower($offer['destination']), $destination_demande) !== false;
        });

        if ($trajets_filtered) {
            $response .= "Voici les trajets disponibles pour la destination *$destination_demande* :<br>";
            foreach ($trajets_filtered as $trajet) {
                $response .= "🚗 *Destination :* " . $trajet['destination'] . "<br>";
                $response .= "🗓️ *Date et Heure :* " . $trajet['date_heure'] . "<br>";
                $response .= "💰 *Tarif :* " . $trajet['tarif'] . "€<br>";
                $response .= "🛣️ *Départ :* " . $trajet['depart'] . "<br>";
                $response .= "🛺 *Places disponibles :* " . $trajet['places_dispo'] . "<br>";
                $response .= "🚘 *Marque et Voiture :* " . $trajet['marque'] . " - " . $trajet['matricule_voiture'] . "<br>";
                $response .= "🎨 *Couleur :* " . $trajet['couleur'] . "<br>";
                $response .= "📸 *Image :* " . $trajet['image'] . "<br><br>";
            }
        } else {
            $response .= "Désolé, il n'y a pas de trajets pour la destination *$destination_demande* pour le moment. 🙁<br>";
        }
    } else {
        // If no specific destination is mentioned, list all available destinations
        $response .= "📍 Destinations disponibles : " . implode(", ", $destinations) . "<br>";
    }
    $matched = true;
}



if ((strpos($question, 'place') !== false || strpos($question, 'dispo') !== false) && strpos($question, 'modifier') === false && !preg_match('/réserver\s*\d+\s*pour\s*\d+\s*places*/i', $question)) {
    $response .= "👥 Places disponibles :<br>";
    foreach ($offers as $o) {
        $response .= "{$o['depart']} → {$o['destination']}: {$o['places_dispo']} places disponibles<br>";
    }
    $matched = true;
}

if (strpos($question, 'date') !== false || strpos($question, 'heure') !== false || strpos($question, 'quand') !== false) {
    $uniqueRoutes = [];

    foreach ($offers as $o) {
        $key = "{$o['depart']}→{$o['destination']}→{$o['date_heure']}";
        $uniqueRoutes[$key] = "{$o['depart']} → {$o['destination']} le {$o['date_heure']}";
    }

    $response .= "📅 Trajets disponibles :<br>" . implode("<br>", array_values($uniqueRoutes)) . "<br>";
    $matched = true;
}

if (strpos($question, 'tarif') !== false) {
    $response .= "💰 Tarifs des trajets :<br>";
    foreach ($offers as $o) {
        $response .= "{$o['depart']} → {$o['destination']}: {$o['tarif']} DT<br>";
    }
    $matched = true;
}

if (strpos($question, 'matricule') !== false || strpos($question, 'voiture') !== false) {
    $response .= "🚗 Voitures utilisées :<br>";
    foreach ($offers as $o) {
        $response .= "{$o['marque']} {$o['couleur']} - Matricule : {$o['matricule_voiture']}<br>";
    }
    $matched = true;
}

if (strpos($question, 'covoiturage') !== false && strpos($question, 'définition') === false || strpos($question, 'trajet') !== false  && strpos($question, 'définition') === false) {
    $response .= "🚗 Nos trajets disponibles :<br>";

    $i = 1;
    $_SESSION['trajets'] = []; // Réinitialiser les trajets en session

    foreach ($offers as $o) {
        $response .= "$i. {$o['depart']} → {$o['destination']} ({$o['places_dispo']} places disponibles, {$o['tarif']} DT, {$o['marque']} {$o['couleur']} - Matricule : {$o['matricule_voiture']})<br>";
        $_SESSION['trajets'][$i] = $o['id_trajet']; // Associer numéro => id_trajet
        $i++;
    }

    $response .= "➡️ Pour réserver, écris par exemple : *réserver 2 pour 3 places*<br>";
    $matched = true;
}

// Gestion des réservations
if (preg_match('/réserver\s*(\d+)\s*pour\s*(\d+)\s*places*/i', $question, $matches) 
    && strpos($question, 'modifier') === false) {
            $numero = intval($matches[1]);
    $nbr_place = intval($matches[2]);

    if (isset($_SESSION['trajets'][$numero])) {
        $id_trajet = $_SESSION['trajets'][$numero];
        
        try {
            $db = config::getConnexion();

            // Vérifier les places disponibles
            $stmt = $db->prepare("SELECT places_dispo, depart, destination, date_heure FROM covoiturage WHERE id_trajet = ?");
            $stmt->execute([$id_trajet]);
            $result = $stmt->fetch();
            $places_dispo = $result ? intval($result['places_dispo']) : 0;

            $commentaire = "Réservé via chatbot";

            if ($places_dispo >= $nbr_place) {
                $status = 'en attente';
                date_default_timezone_set('Africa/Tunis');
                $date_reservation = date('Y-m-d H:i:s');

                // Insérer la réservation
                $reservationAdded = ReservationCovoiturage::ajouterReservation(
                    $id_trajet,
                    $id_utilisateur,
                    $nbr_place,
                    $commentaire,
                    $status,
                    $date_reservation
                );

                if ($reservationAdded) {
                    // Mise à jour des places disponibles
                    $stmtUpdate = $db->prepare("UPDATE covoiturage SET places_dispo = places_dispo - ? WHERE id_trajet = ?");
                    $stmtUpdate->execute([$nbr_place, $id_trajet]);

                    // Préparer affichage trajet
                    $depart = $result['depart'];
                    $destination = $result['destination'];
                    $date_heure = $result['date_heure'];

                    $response .= "✅ Réservation Enregistrée et En attente pour $nbr_place place(s) sur le trajet <strong>$depart → $destination</strong> à <strong>$date_heure</strong> ! Merci 😃<br>";
                } else {
                    $response .= "❌ Oups, une erreur est survenue lors de la réservation.";
                }
            } else {
                $response .= "🚫 Désolé, il n'y a que $places_dispo place(s) disponible(s) pour ce trajet.";
            }

        } catch (PDOException $e) {
            error_log('Erreur: ' . $e->getMessage());
            $response .= "❌ Une erreur technique est survenue.";
        }
    } else {
        $response .= "❌ Trajet non trouvé. Veuillez redemander la liste des trajets.";
    }

    $matched = true;
}
// Condition pour afficher toutes les réservations
if (preg_match('/^(?!.*\bsupprimer\b).*(mes\s+)?réservations?/i', $question) && ( strpos($question, 'modifier') === false)) {
    try {
        $db = config::getConnexion();
        
        
        // On récupère les réservations avec JOIN pour avoir les trajets
        $stmt = $db->prepare("
            SELECT r.id_reservationc, r.nbr_place, 
                   c.depart, c.destination, c.date_heure
            FROM reservationcovoiturage r
            JOIN covoiturage c ON r.id_trajet = c.id_trajet
            WHERE r.id_utilisateur = ?
        ");
        $stmt->execute([$id_utilisateur]);
        $reservations = $stmt->fetchAll();
        
        if ($reservations) {
            $response .= "📋 Voici vos réservations :<br>";
            $_SESSION['reservations'] = []; // pour stocker temporairement
            
            $i = 1;
            foreach ($reservations as $r) {
                $_SESSION['reservations'][$i] = $r['id_reservationc']; // associer numéro au vrai id
                $depart = htmlspecialchars($r['depart']);
                $destination = htmlspecialchars($r['destination']);
                $date_heure = date('d/m/Y H:i', strtotime($r['date_heure']));
                $nbr_place = intval($r['nbr_place']);
                
                $response .= "$i ➔ $depart → $destination, Départ : $date_heure, Places réservées : $nbr_place<br>";
                $i++;
            }
            $response .= "🧹 Pour supprimer, tapez par exemple : supprimer réservation 1<br>";
            $response .= "✏️ Pour modifier cette réservation, tapez par exemple: modifier réservation 1 avec  places<br><br>";

        } else {
            $response .= "📭 Vous n'avez aucune réservation.";
        }
    } catch (PDOException $e) {
        error_log('Erreur: ' . $e->getMessage());
        $response .= "❌ Erreur lors de la récupération des réservations.";
        
    }

    $matched = true;
}


// Condition pour supprimer une réservation
if (preg_match('/supprimer\s+réservation\s*(\d+)/i', $question, $matches)) {
    $numero = intval($matches[1]);

    if (isset($_SESSION['reservations'][$numero])) {
        $reservation_id = $_SESSION['reservations'][$numero];

        try {
            $db = config::getConnexion();
            
            // Récupérer les infos de la réservation + trajet
            $stmt = $db->prepare("
            SELECT r.nbr_place, r.id_trajet, c.depart, c.destination, c.date_heure
            FROM reservationcovoiturage r
            JOIN covoiturage c ON r.id_trajet = c.id_trajet
            WHERE r.id_reservationc = ?
        ");
        
            $stmt->execute([$reservation_id]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $response .= "❌ Réservation introuvable.";
            } else {
                $nbr_place = $reservation['nbr_place'];
                $id_trajet = $reservation['id_trajet'];
                $nbr_place = intval($reservation['nbr_place']);
                $depart = htmlspecialchars($reservation['depart']);
                $destination = htmlspecialchars($reservation['destination']);
                $date_heure = date('d/m/Y H:i', strtotime($reservation['date_heure']));

                // Supprimer la réservation
                $result = ReservationCovoiturage::deleteReservation($reservation_id);

                if ($result) {
                    // Mettre à jour les places disponibles
                    $updateResult = ReservationCovoiturage::updateAvailablePlaces($id_trajet, $nbr_place);

                    $response .= "✅ Réservation supprimée :<br>";
                    $response .= "➔ $depart → $destination, Départ : $date_heure, Places réservées : $nbr_place<br>";
                } else {
                    $response .= "❌ Erreur lors de la suppression de la réservation.";
                }
            }
        } catch (PDOException $e) {
            error_log('Erreur: ' . $e->getMessage());
            $response .= "❌ Erreur SQL: " . $e->getMessage(); // Show real SQL error
        }
    } else {
        $response .= "❌ Numéro de réservation invalide. Veuillez afficher vos réservations avec 'mes réservations'.";
    }

    $matched = true;
}

if (preg_match('/modifier\s+réservation\s*(\d+)\s+avec\s+(\d+)\s*places?(?:\s+et\s+(.+))?/i', $question, $matches)) {
    $numero = intval($matches[1]);
    $new_nbr_place = intval($matches[2]);
    $new_commentaire = isset($matches[3]) ? trim($matches[3]) : null; // Attention ici : null si pas donné

    if (!isset($_SESSION['reservations'][$numero])) {
        $response .= "❌ Numéro de réservation invalide. Tapez 'mes réservations' pour voir vos réservations.";
    } else {
        $reservation_id = $_SESSION['reservations'][$numero];

        try {
            // Si pas de commentaire tapé, récupérer l'ancien commentaire
            if ($new_commentaire === null) {
                $db = config::getConnexion();
                $stmt = $db->prepare("SELECT commentaire FROM reservationcovoiturage WHERE id_reservationc = ?");
                $stmt->execute([$reservation_id]);
                $oldData = $stmt->fetch();
                $commentaire = $oldData ? $oldData['commentaire'] : 'Modification'; // Si jamais problème, mettre 'Modification' par défaut
            } else {
                $commentaire = $new_commentaire;
            }

            $updateResult = ReservationCovoiturage::updateReservationDetails($reservation_id, $new_nbr_place, $commentaire);

            if ($updateResult === 'error_places') {
                $response .= "❌ Pas assez de places disponibles pour augmenter votre réservation.";
            } elseif ($updateResult) {
                $response .= "✅ Réservation $numero mise à jour avec $new_nbr_place places.";
                if ($new_commentaire !== null) { // Affiche le commentaire seulement si l'utilisateur en a tapé un
                    $response .= "<br>📝 Commentaire : " . htmlspecialchars($new_commentaire);
                }
            } else {
                $response .= "❌ Une erreur est survenue lors de la mise à jour.";
            }
        } catch (PDOException $e) {
            error_log('Erreur: ' . $e->getMessage());
            $response .= "❌ Erreur technique: " . $e->getMessage();
        }
    }

    $matched = true;
}


// Si aucun mot-clé n'a été reconnu
if (!$matched) {
    $response = "🤖 Désolé ! Je ne comprends pas. Tu peux me poser une question sur les *covoiturages*, le *départ*, la *destination*, les *places*, le *tarif* ou la *voiture*.";
}

echo $response;
?>