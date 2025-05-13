<?php
include_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../model/ModelReservation.php';

class ControllerReservationElectrique
{
    // ➤ Ajouter une réservation
    public function ajouterReservation($ModelReservationBorne)
    {
        $sql = "INSERT INTO reservationborne 
                (nomClient, emailClient, date_reservation, heure_debut, heure_fin, 
                duree_charge, tarif_estime, id_borne, mode_paiement, qr_code)
                VALUES 
                (:nomClient, :emailClient, :date_reservation, 
                :heure_debut, :heure_fin, :duree_charge, :tarif_estime, :id_borne, :mode_paiement, :qr_code)"; // Ajout du point-virgule ici

        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);

            $query->execute([
                'nomClient' => $ModelReservationBorne->getNomClient(),
                'emailClient' => $ModelReservationBorne->getEmailClient(),
                'date_reservation' => $ModelReservationBorne->getDateReservation(),
                'heure_debut' => $ModelReservationBorne->getHeureDebut(),
                'heure_fin' => $ModelReservationBorne->getHeureFin(),
                'duree_charge' => $ModelReservationBorne->getDureeCharge(),
                'tarif_estime' => $ModelReservationBorne->getTarifEstime(),
                'id_borne' => $ModelReservationBorne->getIdBorne(),
                'mode_paiement' => $ModelReservationBorne->getPaiement(),
                'qr_code' => $ModelReservationBorne->getQrCode()  // Garder cette ligne pour le qr_code
            ]);

            return true;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    // ➤ Afficher uniquement les réservations confirmées
public function afficherPourFront() {
    try {
        // Check if the user is logged in
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_username'])) {
            $user_email = $_SESSION['user_email'];
        } else {
            // If not logged in, redirect to login page
            echo "<script>
            alert('Vous devez être connecté pour accéder à cette page.');
            window.location.href = 'connexion.php';
            </script>";
            exit;
        }

        // Proceed with fetching reservations for the logged-in user
        $db = config::getConnexion();
        $sql = "SELECT * FROM reservationborne WHERE emailClient = :emailClient"; // Filter by user email
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':emailClient', $user_email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

    // ➤ Supprimer une réservation
    public function supprimerReservation($id_reservation)
    {
        $sql = "DELETE FROM reservationBorne WHERE id_reservation = :id_reservation";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
            return $query->execute();
        } catch (Exception $e) {
            echo 'Erreur lors de la suppression : ' . $e->getMessage();
            return false;
        }
    }

    // ➤ Modifier une réservation
    public function modifierReservation($ModelReservationBorne, $id_reservation)
    {
        $db = config::getConnexion();

        try {
            $query = $db->prepare("
                UPDATE reservationBorne SET 
                    nomClient = :nomClient,
                    emailClient = :emailClient,
                    date_reservation = :date_reservation,
                    tarif_estime = :tarif_estime,
                    heure_debut = :heure_debut,
                    heure_fin = :heure_fin,
                    duree_charge = :duree_charge,
                    id_borne = :id_borne,
                    mode_paiement = :mode_paiement,
                    pourcentage_charge = :pourcentage_charge
                WHERE id_reservation = :id_reservation
            ");

            $query->execute([
                'nomClient' => $ModelReservationBorne->getNomClient(),
                'emailClient' => $ModelReservationBorne->getEmailClient(),
                'date_reservation' => $ModelReservationBorne->getDateReservation(),
                'heure_debut' => $ModelReservationBorne->getHeureDebut(),
                'heure_fin' => $ModelReservationBorne->getHeureFin(),
                'duree_charge' => $ModelReservationBorne->getDureeCharge(),
                'tarif_estime' => $ModelReservationBorne->getTarifEstime(),
                'id_borne' => $ModelReservationBorne->getIdBorne(),
                'mode_paiement' => $ModelReservationBorne->getPaiement(),
                'pourcentage_charge' => $ModelReservationBorne->getPourcentage(),
                'id_reservation' => $id_reservation
            ]);

            return true;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // ➤ Récupérer une réservation par ID
    public function recupererReservation($id_reservation)
    {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM reservationborne WHERE id_reservation = :id_reservation";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
?>
