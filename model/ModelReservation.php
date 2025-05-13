
<?php
include_once __DIR__ . '/../database.php';

class ModelReservationBorne {
    private $nomClient;
    private $emailClient;
    private $date_reservation;
    private $heureDebut;
    private $heureFin;
    private $dureeCharge;
    private $tarifEstime;
    private $idBorne;
    private $paiement;
    private $Pourcentage;
    private $qrCode;


    // Constructeur
// Modèle après suppression de 'statutReservation'
public function __construct($nomClient, $emailClient, $date_reservation, $heureDebut, $heureFin, $dureeCharge, $tarifEstime, $idBorne, $paiement, $Pourcentage, $qrCode) {
    $this->nomClient = $nomClient;
    $this->emailClient = $emailClient;
    $this->date_reservation = $date_reservation;
    $this->heureDebut = $heureDebut;
    $this->heureFin = $heureFin;
    $this->dureeCharge = $dureeCharge;
    $this->tarifEstime = $tarifEstime;
    $this->idBorne = $idBorne;
    $this->paiement = $paiement;
    $this->Pourcentage = $Pourcentage;
    $this->qrCode = $qrCode;

}

public function getQrCode()
{
    return $this->qrCode;
}

// Méthode pour définir la valeur du QR code, si nécessaire
public function setQrCode($qrCode)
{
    $this->qrCode = $qrCode;
}

    // Getters pour chaque attribut
    public function getNomClient() {
        return $this->nomClient;
    }


    public function getEmailClient() {
        return $this->emailClient;
    }

    public function getDateReservation() {
        return $this->date_reservation;
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
    
     
    
        public function setEmailClient($emailClient) {
            $this->emailClient = $emailClient;
        }
    
        public function setDateReservation($dateReservation) {
            $this->date_reservation = $dateReservation;
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
