<?php
class ReservationCovoiturage {
    private $id_reservationc;
    private $id_utilisateur;
    private $id_trajet;
    private $nbr_place;
    private $commentaire;
    private $statut;
    private $date_reservation;

    public function __construct($id_utilisateur, $id_trajet, $nbr_place, $commentaire = null, $statut = 'en attente') {
        $this->id_utilisateur = $id_utilisateur;
        $this->id_trajet = $id_trajet;
        $this->nbr_place = $nbr_place;
        $this->commentaire = $commentaire;
        $this->statut = $statut;
    }

    // Getters
    public function getIdReservation() {
        return $this->id_reservationc;
    }

    public function getIdUtilisateur() {
        return $this->id_utilisateur;
    }

    public function getIdTrajet() {
        return $this->id_trajet;
    }

    public function getNbrPlace() {
        return $this->nbr_place;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getDateReservation() {
        return $this->date_reservation;
    }

    // Setters
    public function setIdReservation($id_reservationc) {
        $this->id_reservationc = $id_reservationc;
    }

    public function setIdUtilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setIdTrajet($id_trajet) {
        $this->id_trajet = $id_trajet;
    }

    public function setNbrPlace($nbr_place) {
        $this->nbr_place = $nbr_place;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setDateReservation($date_reservation) {
        $this->date_reservation = $date_reservation;
    }

   
    
    public static function ajouterReservation($id_trajet, $id_utilisateur, $nbr_place, $commentaire, $status = 'en attente', $date_reservation = null) {
        try {
            $db = config::getConnexion();
    
            if ($date_reservation === null) {
                $date_reservation = date('Y-m-d H:i:s');
            }
    
            $sql = "INSERT INTO reservationcovoiturage 
                    (id_trajet, id_utilisateur, nbr_place, commentaire, statut, date_reservation)
                    VALUES 
                    (:id_trajet, :id_utilisateur, :nbr_place, :commentaire, :status, :date_reservation)";
    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_trajet', $id_trajet);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':nbr_place', $nbr_place);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':date_reservation', $date_reservation);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Erreur: ' . $e->getMessage()); // log it instead of printing
            return false;
        }
    }
    
    public static function getReservationsByUser($user_id) {
        try {
            // Get the database connection
            $db = config::getConnexion();
            
            // SQL query to fetch the required data by joining the tables
            $sql = "SELECT  r.id_reservationc , 
             c.depart, c.destination, r.nbr_place, r.date_reservation
                    FROM reservationcovoiturage r
                    JOIN covoiturage c ON r.id_trajet = c.id_trajet
                    WHERE r.id_utilisateur = :id_utilisateur";
                    
            // Prepare and execute the query
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Fetch all the reservations
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Return the results
            return $reservations;
        } catch (PDOException $e) {
            // Handle errors (e.g., database connection issues)
            echo 'Erreur: ' . $e->getMessage();
        }
    }
    public static function updateAvailablePlaces($id_trajet, $nbr_place) {
        try {
            // Get database connection
            $db = config::getConnexion();

            // Update the available places
            $stmt = $db->prepare("UPDATE covoiturage SET places_dispo = places_dispo + ? WHERE id_trajet = ?");
            $stmt->execute([$nbr_place, $id_trajet]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteReservation($reservation_id) {
        try {
            // Delete the reservation from the database
            $db = config::getConnexion();
            $stmt = $db->prepare("DELETE FROM reservationcovoiturage WHERE id_reservationc = ?");
            $stmt->execute([$reservation_id]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function getAllReservationsWithDetails() {
        $db = config::getConnexion();
        try {
            $query = $db->prepare("     
            SELECT 
            r.id_reservationc, 
            r.nbr_place, 
            r.commentaire, 
            r.statut, 
            r.date_reservation,
            c.depart, 
            c.destination,
            c.date_heure,
            u.username,      
            u.phone           
        FROM reservationcovoiturage r
        JOIN covoiturage c ON r.id_trajet = c.id_trajet
        JOIN user u ON r.id_utilisateur = u.id  
        
                    ");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public static function updateStatus($reservation_id, $newStatus) {
        $db = config::getConnexion();
        
        try {
            $stmt = $db->prepare("UPDATE reservationcovoiturage SET statut = ? WHERE id_reservationc = ?");
            $stmt->execute([$newStatus, $reservation_id]);
    
            // If the update was successful, return true.
            return $stmt->rowCount() > 0; 
        } catch (Exception $e) {
            // In case of an error, return false.
            return false;
        }
    }
    public static function updateReservationDetails($id, $new_nbr_place, $commentaire) {
        $db = config::getConnexion();
    
        try {
            // Step 1: Fetch old reservation
            $stmt = $db->prepare("SELECT nbr_place, id_trajet FROM reservationcovoiturage WHERE id_reservationc = :id");
            $stmt->execute([':id' => $id]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$reservation) return false;
    
            $old_nbr_place = $reservation['nbr_place'];
            $trajet_id = $reservation['id_trajet'];
    
            // Step 2: Get current places_dispo
            $stmt = $db->prepare("SELECT places_dispo FROM covoiturage WHERE id_trajet = :trajet_id");
            $stmt->execute([':trajet_id' => $trajet_id]);
            $trajet = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$trajet) return false;
    
            $places_dispo = $trajet['places_dispo'];
    
            // Step 3: Calculate difference
            $diff = $new_nbr_place - $old_nbr_place;
    
            // Step 4: If requesting more places, check availability
            if ($diff > 0 && $diff > $places_dispo) {
                return 'error_places';
            }
    
            // Step 5: Update reservation
            $stmt = $db->prepare("UPDATE reservationcovoiturage 
                                  SET nbr_place = :nbr, commentaire = :comment 
                                  WHERE id_reservationc = :id");
            $stmt->execute([
                ':nbr' => $new_nbr_place,
                ':comment' => $commentaire,
                ':id' => $id
            ]);
    
            // Step 6: Update places_dispo
            $new_places_dispo = $places_dispo - $diff;
            $stmt = $db->prepare("UPDATE covoiturage 
                                  SET places_dispo = :new_dispo 
                                  WHERE id_trajet = :trajet_id");
            $stmt->execute([
                ':new_dispo' => $new_places_dispo,
                ':trajet_id' => $trajet_id
            ]);
    
            return true;
    
        } catch (PDOException $e) {
            return false;
        }
    }
    
    
    
    
    
    
    
}
