<?php 
require_once 'C:/xampp/htdocs/urbanisme/database.php';

class Parking {
    private $id_parking;
    private $nom_parking;
    private $localisation;
    private $capacite_totale;
    private $places_dispo;
    private $tarif_horaire;
    private $securise;
    private $ville;  

     
    public function __construct($nom_parking = null, $localisation = null, $capacite_totale = null, $places_dispo = null, $tarif_horaire = null, $securise = null, $ville = null) {
        $this->nom_parking = $nom_parking;
        $this->localisation = $localisation;
        $this->capacite_totale = $capacite_totale;
        $this->places_dispo = $places_dispo;
        $this->tarif_horaire = $tarif_horaire;
        $this->securise = $securise;
        $this->ville = $ville;  
    }
    
public function getNomParking() {
    return $this->nom_parking;
}

 
public function getLocalisation() {
    return $this->localisation;
}

 
public function getVille() {
    return $this->ville;
}

 
public function getCapaciteTotale() {
    return $this->capacite_totale;
}

 
public function getPlacesDispo() {
    return $this->places_dispo;
}

 
public function getTarifHoraire() {
    return $this->tarif_horaire;
}

 
public function isSecurise() {
    return $this->securise;
}
 
public function setNomParking($nom_parking) {
    $this->nom_parking = $nom_parking;
}

 
public function setLocalisation($localisation) {
    $this->localisation = $localisation;
}

 
public function setVille($ville) {
    $this->ville = $ville;
}

 
public function setCapaciteTotale($capacite_totale) {
    $this->capacite_totale = $capacite_totale;
}

 
public function setPlacesDispo($places_dispo) {
    $this->places_dispo = $places_dispo;
}

 
public function setTarifHoraire($tarif_horaire) {
    $this->tarif_horaire = $tarif_horaire;
}

 
public function setSecurise($securise) {
    $this->securise = $securise;
}


     
    public function insertIntoDatabase() {
        $pdo = config::getConnexion();
    
        $query = "INSERT INTO parking (nom_parking, localisation, capacite_totale, places_dispo, tarif_horaire, securise, ville)
                  VALUES (:nom_parking, :localisation, :capacite_totale, :places_dispo, :tarif_horaire, :securise, :ville)";
    
        $stmt = $pdo->prepare($query);
    
         
        $stmt->bindParam(':nom_parking', $this->nom_parking);
        $stmt->bindParam(':localisation', $this->localisation);
        $stmt->bindParam(':capacite_totale', $this->capacite_totale);
        $stmt->bindParam(':places_dispo', $this->places_dispo);
        $stmt->bindParam(':tarif_horaire', $this->tarif_horaire);
        $stmt->bindParam(':securise', $this->securise, PDO::PARAM_BOOL);
        $stmt->bindParam(':ville', $this->ville);  
    
        
        $stmt->execute();
    }
    public static function getAllParkings() {
        $pdo = config::getConnexion();
        $query = "SELECT * FROM parking";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function deleteParking($id_parking) {
        $pdo = config::getConnexion();
        $query = "DELETE FROM parking WHERE id_parking = :id_parking";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_parking', $id_parking);
        $stmt->execute();
    }
    public function afficherParVille($ville) {
        $pdo = config::getConnexion();  
    
        $sql = "SELECT * FROM parking WHERE ville = :ville AND places_dispo > 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":ville", $ville, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll();
    }
    public function afficherTous() {
        $db = config::getConnexion();
        try {
            $query = $db->query("SELECT * FROM parking");
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }
    public function afficherParSecurite($securise) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM parking WHERE securise = :securise";
        $req = $db->prepare($sql);
        $req->bindValue(':securise', $securise, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
    
    public function afficherParVilleEtSecurite($ville, $securise) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM parking WHERE ville = :ville AND securise = :securise";
        $req = $db->prepare($sql);
        $req->bindValue(':ville', $ville);
        $req->bindValue(':securise', $securise, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
    
     
    
    
}
?>
