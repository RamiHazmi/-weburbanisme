<?php
class StripeModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function calculerPrixAbonnement($id_abonnement) {
        $stmt = $this->db->prepare("
            SELECT a.date_debut, a.date_fin, a.places_reservees, p.tarif_horaire
            FROM abonnement a
            JOIN parking p ON a.id_parking = p.id_parking
            WHERE a.id_abonnement = :id_abonnement
        ");
        $stmt->execute(['id_abonnement' => $id_abonnement]);
        $data = $stmt->fetch();

        if ($data) {
            $dateDebut = new DateTime($data['date_debut']);
            $dateFin = new DateTime($data['date_fin']);
            $nbHeures = ($dateFin->getTimestamp() - $dateDebut->getTimestamp()) / 3600;

            $prix = $nbHeures * $data['tarif_horaire'] * $data['places_reservees'];
            return round($prix, 2);
        }

        return false;
    }

   

    
 
    public function updateAbonnementStatus($id_abonnement) {
        try {
            $stmt = $this->db->prepare("UPDATE abonnement SET status = 'payé' WHERE id_abonnement = :id_abonnement AND status  = 'non payé'");
            $stmt->execute(['id_abonnement' => $id_abonnement]);

            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
