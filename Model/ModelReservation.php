<?php
include_once __DIR__ . '/../Config/config.php';

class ModelReservationBorne {
    private $nomClient;
    private $prenomClient;
    private $emailClient;
    private $dateReservation;
    private $heureDebut;
    private $heureFin;
    private $dureeCharge;
    private $tarifEstime;
    private $statutReservation;
    private $idBorne;
    private $paiement;
    private $Pourcentage;

    // Constructeur
    public function __construct($nomClient, $prenomClient, $emailClient, $dateReservation, $heureDebut, $heureFin, $dureeCharge, $tarifEstime, $statutReservation, $idBorne, $paiement, $Pourcentage) {
        $this->nomClient = $nomClient;
        $this->prenomClient = $prenomClient;
        $this->emailClient = $emailClient;
        $this->dateReservation = $dateReservation;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->dureeCharge = $dureeCharge;
        $this->tarifEstime = $tarifEstime;
        $this->statutReservation = $statutReservation;
        $this->idBorne = $idBorne;
        $this->paiement = $paiement;
        $this->Pourcentage = $Pourcentage;


    }

    // Getters pour chaque attribut
    public function getNomClient() {
        return $this->nomClient;
    }

    public function getPrenomClient() {
        return $this->prenomClient;
    }

    public function getEmailClient() {
        return $this->emailClient;
    }

    public function getDateReservation() {
        return $this->dateReservation;
    }

    public function getHeureDebut() {
        return $this->heureDebut;
    }

    public function getHeureFin() {
        return $this->heureFin;
    }

    public function getDureeCharge() {
        return $this->dureeCharge;
    }

    public function getTarifEstime() {
        return $this->tarifEstime;
    }

    public function getStatutReservation() {
        return $this->statutReservation;
    }

    public function getIdBorne() {
        return $this->idBorne;
    }
    
    public function getPaiement() {
        return $this->paiement;
    }

    public function getPourcentage() {
        return $this->Pourcentage;
    }
        // Setters pour chaque attribut
        public function setNomClient($nomClient) {
            $this->nomClient = $nomClient;
        }
    
        public function setPrenomClient($prenomClient) {
            $this->prenomClient = $prenomClient;
        }
    
        public function setEmailClient($emailClient) {
            $this->emailClient = $emailClient;
        }
    
        public function setDateReservation($dateReservation) {
            $this->dateReservation = $dateReservation;
        }
    
        public function setHeureDebut($heureDebut) {
            $this->heureDebut = $heureDebut;
        }
    
        public function setHeureFin($heureFin) {
            $this->heureFin = $heureFin;
        }
    
        public function setDureeCharge($dureeCharge) {
            $this->dureeCharge = $dureeCharge;
        }
    
        public function setTarifEstime($tarifEstime) {
            $this->tarifEstime = $tarifEstime;
        }
    
        public function setStatutReservation($statutReservation) {
            $this->statutReservation = $statutReservation;
        }
    
        public function setIdBorne($idBorne) {
            $this->idBorne = $idBorne;
        }
    
        public function setPaiement($paiement) {
            $this->paiement = $paiement;
        }
    
        public function setPourcentage($Pourcentage) {
            $this->Pourcentage = $Pourcentage;
        }
    
}
?>