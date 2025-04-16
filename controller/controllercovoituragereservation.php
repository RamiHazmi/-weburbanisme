<?php
// Include the necessary files
include_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../model/modelcovoituragereservation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'ajouterReservation') {
        $controller = new ReservationController();
        $controller->ajouterReservation();
    }
    elseif (isset($_GET['action']) && $_GET['action'] === 'deleteReservation') {
       
            // Check if reservation_id is set in POST data
            if (isset($_POST['reservation_id'])) {
                $reservation_id = $_POST['reservation_id'];
    
                // Call the controller to delete the reservation
                $controller = new ReservationController();
                $controller->deleteReservation($reservation_id);
            }
        }
        elseif (isset($_GET['action']) && $_GET['action'] === 'updateStatus') {
           
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['id_reservation']) && isset($data['statut'])) {
                $reservation_id = $data['id_reservation'];
                $statut = $data['statut'];
        
                $controller = new ReservationController();
                $controller->updateReservation($reservation_id, $statut);
            } else {
                echo json_encode(['success' => false, 'message' => 'Données manquantes']);
                exit;
            }
            
        }
        elseif (isset($_GET['action']) && $_GET['action'] === 'updaterese') {
            if (isset($_POST['reservation_id'], $_POST['nbr_place'], $_POST['commentaire'])) {
                $id = $_POST['reservation_id'];
                $nbr_place = $_POST['nbr_place'];
                $commentaire = $_POST['commentaire'];
        
                $controller = new ReservationController();
                $result = $controller->updateReservationDetails($id, $nbr_place, $commentaire);
        
                if ($result === true) {
                    echo json_encode(['status' => 'success', 'message' => 'Réservation mise à jour avec succès !']);
                } elseif ($result === 'error_places') {
                    echo json_encode(['status' => 'error', 'message' => 'Pas assez de places disponibles.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour.']);
                }
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Champs manquants.']);
                exit;
            }
        }
        
        
}

class ReservationController {

    public function ajouterReservation() {
    header('Content-Type: application/json'); 

    if (isset($_POST['id_trajet'], $_POST['nbr_place'], $_POST['commentaire'])) {
        $id_trajet = $_POST['id_trajet'];
        $nbr_place = $_POST['nbr_place'];
        $commentaire = $_POST['commentaire'];

        try {
            $db = config::getConnexion();

            // Fetch current available places
            $stmt = $db->prepare("SELECT places_dispo FROM covoiturage WHERE id_trajet = ?");
            $stmt->execute([$id_trajet]);
            $result = $stmt->fetch();
            $places_dispo = $result ? $result['places_dispo'] : 0;
            $id_utilisateur = $_POST['id_utilisateur'];

            if ($places_dispo >= $nbr_place) {
                $status = 'en attente';
                date_default_timezone_set('Africa/Tunis');
                $date_reservation = date('Y-m-d H:i:s');

                // Insert reservation
                $reservationAdded = ReservationCovoiturage::ajouterReservation(
                    $id_trajet,
                    $id_utilisateur,
                    $nbr_place,
                    $commentaire,
                    $status,
                    $date_reservation
                );

                if ($reservationAdded) {
                    // Update remaining places
                    $stmtUpdate = $db->prepare("UPDATE covoiturage SET places_dispo = places_dispo - ? WHERE id_trajet = ?");
                    $stmtUpdate->execute([$nbr_place, $id_trajet]);

                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => "Impossible d'ajouter la réservation."]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Pas assez de places disponibles. Il reste seulement $places_dispo place(s)."
                ]);
            }

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Données invalides.']);
    }
}

public function listreservationcovoiturage($user_id) {
    // Fetch reservations for the specified user ID
    if ($user_id) {
        $reservations = ReservationCovoiturage::getReservationsByUser($user_id);
        return $reservations;
    }
    
    return []; // Return an empty array if no user_id is provided
}
public function deleteReservation($reservation_id) {
    header('Content-Type: application/json');

    if (empty($reservation_id)) {
        echo json_encode(['success' => false, 'message' => 'Reservation ID is missing.']);
        return;
    }

    try {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT nbr_place, id_trajet FROM reservationcovoiturage WHERE id_reservationc = ?");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch();

        if (!$reservation) {
            echo json_encode(['success' => false, 'message' => 'Reservation not found.']);
            return;
        }

        $nbr_place = $reservation['nbr_place'];
        $id_trajet = $reservation['id_trajet'];

        // Delete the reservation
        $result = ReservationCovoiturage::deleteReservation($reservation_id);

        if ($result) {
            // Update the available places by calling the model's method
            $updateResult = ReservationCovoiturage::updateAvailablePlaces($id_trajet, $nbr_place);

            if ($updateResult) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update available places.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete the reservation.']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}

public function afficherReservationsAvecDetails() {
    try {
        return ReservationCovoiturage::getAllReservationsWithDetails();
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}

public function updateReservation($reservation_id, $statut) {
    header('Content-Type: application/json');

    $success = ReservationCovoiturage::updateStatus($reservation_id, $statut); 

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour.']);
    }

    exit;
}
public function updateReservationDetails($id, $new_nbr_place, $commentaire) {
    $result = ReservationCovoiturage::updateReservationDetails($id, $new_nbr_place, $commentaire);

    if ($result === true) {
        return true;
    } elseif ($result === 'error_places') {
        return 'error_places'; // Not enough places
    } else {
        return false; // Some other error
    }
}
}






?>
