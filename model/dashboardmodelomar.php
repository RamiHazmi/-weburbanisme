<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';

class Statistique
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Taux d'occupation par parking
    public function getTauxOccupation()
    {
        $sql = "
            SELECT 
                p.nom_parking,
                p.capacite_totale,
                COALESCE(SUM(a.places_reservees), 0) AS total_places_reservees
            FROM parking p
            LEFT JOIN abonnement a ON p.id_parking = a.id_parking
            GROUP BY p.id_parking
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultats = $stmt->fetchAll();
    
        // Calculer le taux d'occupation en PHP
        foreach ($resultats as &$row) {
            $row['taux'] = ($row['capacite_totale'] > 0) 
                ? round(($row['total_places_reservees'] / $row['capacite_totale']) * 100, 2) 
                : 0;
        }
    
        return $resultats;
    }
    


    // Revenus par abonnement (via calcul dynamique)
    public function calculerPrixAbonnement($id_abonnement)
    {
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

    // Revenus totaux par parking (en calculant chaque abonnement)
    public function getRevenusParParking()
    {
        $sql = "
            SELECT a.id_abonnement, a.id_parking
            FROM abonnement a
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $abonnements = $stmt->fetchAll();

        $revenus = [];

        foreach ($abonnements as $abonnement) {
            $id_parking = $abonnement['id_parking'];
            $prix = $this->calculerPrixAbonnement($abonnement['id_abonnement']);

            if (!isset($revenus[$id_parking])) {
                $revenus[$id_parking] = 0;
            }

            $revenus[$id_parking] += $prix;
        }

        // Récupérer les noms des parkings
        $sql = "SELECT id_parking, nom_parking FROM parking";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $parkings = $stmt->fetchAll();

        $resultat = [];

        foreach ($parkings as $p) {
            $id = $p['id_parking'];
            $resultat[] = [
                'nom_parking' => $p['nom_parking'],
                'revenus' => isset($revenus[$id]) ? round($revenus[$id], 2) : 0
            ];
        }

        return $resultat;
    }
}

?>
