<?php

class Covoiturage {
    private $id_trajet;
    private $depart;
    private $destination;
    private $date_heure;
    private $tarif;
    private $places_dispo;
    private $matricule_voiture;
    private $marque;
    private $couleur;
    private $image;

    public function __construct($depart, $destination, $date_heure, $tarif, $places_dispo, $matricule_voiture, $marque, $couleur, $image) {
        $this->depart = $depart;
        $this->destination = $destination;
        $this->date_heure = $date_heure;
        $this->tarif = $tarif;
        $this->places_dispo = $places_dispo;
        $this->matricule_voiture = $matricule_voiture;
        $this->marque = $marque;
        $this->couleur = $couleur;
        $this->image = $image;
    }

    public function getIdTrajet() { return $this->id_trajet; }
    public function setIdTrajet($id_trajet) { $this->id_trajet = $id_trajet; }

    public function getDepart() { return $this->depart; }
    public function setDepart($depart) { $this->depart = $depart; }

    public function getDestination() { return $this->destination; }
    public function setDestination($destination) { $this->destination = $destination; }

    public function getDateHeure() { return $this->date_heure; }
    public function setDateHeure($date_heure) { $this->date_heure = $date_heure; }

    public function getTarif() { return $this->tarif; }
    public function setTarif($tarif) { $this->tarif = $tarif; }

    public function getPlacesDispo() { return $this->places_dispo; }
    public function setPlacesDispo($places_dispo) { $this->places_dispo = $places_dispo; }

    public function getMatriculeVoiture() { return $this->matricule_voiture; }
    public function setMatriculeVoiture($matricule_voiture) { $this->matricule_voiture = $matricule_voiture; }

    public function getMarque() { return $this->marque; }
    public function setMarque($marque) { $this->marque = $marque; }

    public function getCouleur() { return $this->couleur; }
    public function setCouleur($couleur) { $this->couleur = $couleur; }

    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; }

    public function register() {
        $conn = config::getConnexion();
        $sql = "INSERT INTO covoiturage (depart, destination, date_heure, tarif, places_dispo, matricule_voiture, marque, couleur, image)
                VALUES (:depart, :destination, :date_heure, :tarif, :places_dispo, :matricule_voiture, :marque, :couleur, :image)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':depart', $this->depart);
            $stmt->bindParam(':destination', $this->destination);
            $stmt->bindParam(':date_heure', $this->date_heure);
            $stmt->bindParam(':tarif', $this->tarif);
            $stmt->bindParam(':places_dispo', $this->places_dispo);
            $stmt->bindParam(':matricule_voiture', $this->matricule_voiture);
            $stmt->bindParam(':marque', $this->marque);
            $stmt->bindParam(':couleur', $this->couleur);
            $stmt->bindParam(':image', $this->image);

            return $stmt->execute() ? "Le trajet de covoiturage a été ajouté avec succès!" : "Erreur lors de l'ajout du covoiturage.";
        } catch (PDOException $e) {
            return "Erreur: " . $e->getMessage();
        }
    }

    public static function getAllCovoiturages() {
        $conn = config::getConnexion();
        $stmt = $conn->prepare("SELECT * FROM covoiturage");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCovoiturage($id_trajet) {
        $conn = config::getConnexion();
        $sql = "DELETE FROM covoiturage WHERE id_trajet = :id_trajet";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateCovoiturage() {
        try {
            $conn = config::getConnexion();
            $query = "UPDATE covoiturage 
                      SET depart = :depart, destination = :destination, date_heure = :date_heure, 
                          tarif = :tarif, places_dispo = :places_dispo, matricule_voiture = :matricule_voiture, 
                          marque = :marque, couleur = :couleur, image = :image 
                      WHERE id_trajet = :id_trajet";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':depart', $this->depart);
            $stmt->bindParam(':destination', $this->destination);
            $stmt->bindParam(':date_heure', $this->date_heure);
            $stmt->bindParam(':tarif', $this->tarif);
            $stmt->bindParam(':places_dispo', $this->places_dispo);
            $stmt->bindParam(':matricule_voiture', $this->matricule_voiture);
            $stmt->bindParam(':marque', $this->marque);
            $stmt->bindParam(':couleur', $this->couleur);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':id_trajet', $this->id_trajet, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllCovoituragesfront() {
        $conn = config::getConnexion();
        $query = "SELECT * FROM covoiturage";  // No join with user anymore
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
