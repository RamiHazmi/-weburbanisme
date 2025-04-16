<?php


class Covoiturage {
    // Private attributes
    private $id_trajet;
    private $depart;
    private $destination;
    private $date_heure;
    private $tarif;
    private $places_dispo;
    private $conducteur_id;
    private $matricule_voiture;
    private $marque;
    private $couleur;
    private $image;


    // Constructor
    public function __construct($depart, $destination, $date_heure, $tarif, $places_dispo, $conducteur_id, $matricule_voiture , $marque , $couleur , $image ) {
        $this->depart = $depart;
        $this->destination = $destination;
        $this->date_heure = $date_heure;
        $this->tarif = $tarif;
        $this->places_dispo = $places_dispo;
        $this->conducteur_id = $conducteur_id;
        $this->matricule_voiture = $matricule_voiture;
        $this->marque = $marque;
        $this->couleur = $couleur;
        $this->image = $image;


    }

    // Getter and Setter methods

    public function getIdTrajet() {
        return $this->id_trajet;
    }

    public function setIdTrajet($id_trajet) {
        $this->id_trajet = $id_trajet;
    }

    public function getDepart() {
        return $this->depart;
    }

    public function setDepart($depart) {
        $this->depart = $depart;
    }

    public function getDestination() {
        return $this->destination;
    }

    public function setDestination($destination) {
        $this->destination = $destination;
    }

    public function getDateHeure() {
        return $this->date_heure;
    }

    public function setDateHeure($date_heure) {
        $this->date_heure = $date_heure;
    }

    public function getTarif() {
        return $this->tarif;
    }

    public function setTarif($tarif) {
        $this->tarif = $tarif;
    }

    public function getPlacesDispo() {
        return $this->places_dispo;
    }

    public function setPlacesDispo($places_dispo) {
        $this->places_dispo = $places_dispo;
    }

    public function getConducteurId() {
        return $this->conducteur_id;
    }

    public function setConducteurId($conducteur_id) {
        $this->conducteur_id = $conducteur_id;
    }
    public function getMatriculeVoiture() {
        return $this->matricule_voiture;
    }

    public function setMatriculeVoiture($matricule_voiture) {
        $this->matricule_voiture = $matricule_voiture;
    }

    public function getMarque() {
        return $this->marque;
    }

    public function setMarque($marque) {
        $this->marque = $marque;
    }

    public function getCouleur() {
        return $this->couleur;
    }

    public function setCouleur($couleur) {
        $this->couleur = $couleur;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function register() {
        $conn = config::getConnexion();
    
        $sql = "INSERT INTO covoiturage (depart, destination, date_heure, tarif, places_dispo, conducteur_id, matricule_voiture ,marque , couleur , image)
                VALUES (:depart, :destination, :date_heure, :tarif, :places_dispo, :conducteur_id, :matricule_voiture ,:marque ,:couleur ,:image)";
    
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':depart', $this->depart, PDO::PARAM_STR);
            $stmt->bindParam(':destination', $this->destination, PDO::PARAM_STR);
            $stmt->bindParam(':date_heure', $this->date_heure, PDO::PARAM_STR);
            $stmt->bindParam(':tarif', $this->tarif, PDO::PARAM_STR);
            $stmt->bindParam(':places_dispo', $this->places_dispo, PDO::PARAM_INT);
            $stmt->bindParam(':conducteur_id', $this->conducteur_id, PDO::PARAM_INT);
            $stmt->bindParam(':matricule_voiture', $this->matricule_voiture, PDO::PARAM_STR);
            $stmt->bindParam(':marque', $this->marque, PDO::PARAM_STR);
            $stmt->bindParam(':couleur', $this->couleur, PDO::PARAM_STR);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);


    
            // Execute the query
            if ($stmt->execute()) {
                return "Le trajet de covoiturage a été ajouté avec succès!";
            } else {
                return "Erreur lors de l'ajout du covoiturage.";
            }
        } catch (PDOException $e) {
            return "Erreur: " . $e->getMessage();
        }
    }
    
    

    
    public static function getAllCovoiturages() {
        $conn = config::getConnexion(); 

        $query = "SELECT * FROM covoiturage";  

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

     

        return $result;  
    }

    public function deleteCovoiturage($id_trajet) {
            // Get the database connection
            $conn = config::getConnexion();
    
            // Check if the connection is successful
            if (!$conn) {
                error_log("Database connection failed in deleteCovoiturage method.");
                return false;
            }
    
            // Prepare the delete query
            $sql = "DELETE FROM covoiturage WHERE id_trajet = :id_trajet";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);
    
            // Log the SQL query for debugging
            error_log("SQL Query for deletion: " . $sql);
            error_log("Binding ID: " . $id_trajet);
    
            // Execute the query and check the result
            try {
                if ($stmt->execute()) {
                    error_log("Covoiturage with ID $id_trajet deleted successfully.");
                    return true;  // Return true if deletion was successful
                } else {
                    error_log("Failed to delete Covoiturage with ID $id_trajet.");
                    return false;  // Return false if deletion failed
                }
            } catch (Exception $e) {
                // Log any exceptions that occur during execution
                error_log("Error during deletion: " . $e->getMessage());
                return false;  // Return false if there was an error
            }
        
    }

        public function updateCovoiturage() {
            try {
                // Get the database connection
                $conn = config::getConnexion();
        
                // Prepare the SQL UPDATE query
                $query = "UPDATE covoiturage 
                          SET depart = :depart, destination = :destination, date_heure = :date_heure, 
                              tarif = :tarif, places_dispo = :places_dispo, conducteur_id = :conducteur_id, 
                              matricule_voiture = :matricule_voiture, marque = :marque, couleur = :couleur, image = :image 
                          WHERE id_trajet = :id_trajet";
        
                // Prepare the statement
                $stmt = $conn->prepare($query);
        
                // Bind parameters
                $stmt->bindParam(':depart', $this->depart);
                $stmt->bindParam(':destination', $this->destination);
                $stmt->bindParam(':date_heure', $this->date_heure);
                $stmt->bindParam(':tarif', $this->tarif);
                $stmt->bindParam(':places_dispo', $this->places_dispo);
                $stmt->bindParam(':conducteur_id', $this->conducteur_id);
                $stmt->bindParam(':matricule_voiture', $this->matricule_voiture);
                $stmt->bindParam(':marque', $this->marque);
                $stmt->bindParam(':couleur', $this->couleur);
                $stmt->bindParam(':image', $this->image);
                $stmt->bindParam(':id_trajet', $this->id_trajet, PDO::PARAM_INT);
        
                // Execute the query
                return $stmt->execute();
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
                return false;
            }
        }
    
        public static function getAllCovoituragesfront() {
            // Get the database connection
            $conn = config::getConnexion(); 

    // Adjusted query to fetch username, phone, and role from the users table
    $query = "SELECT c.*, u.username AS conducteur_username, u.phone AS conducteur_phone, u.role AS conducteur_role
              FROM covoiturage c
              LEFT JOIN user u ON c.conducteur_id = u.id";  

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;  
        }



        public static function getAvailablePlaces($id_trajet) {
            $db = config::getConnexion();
            $sql = "SELECT places_dispo FROM covoiturage WHERE id_trajet = :id_trajet";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_trajet', $id_trajet);
            $stmt->execute();
            $result = $stmt->fetch();
        
            return $result ? $result['places_dispo'] : 0;
        }
        
        public static function updateAvailablePlaces($id_trajet, $reservedPlaces) {
            $db = config::getConnexion();
            $sql = "UPDATE covoiturage SET places_dispo = places_dispo - :reservedPlaces WHERE id_trajet = :id_trajet";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':reservedPlaces', $reservedPlaces);
            $stmt->bindParam(':id_trajet', $id_trajet);
            return $stmt->execute();
        }
        
        
}
?>
