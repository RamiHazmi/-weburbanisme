<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';

class Abonnement {
    public function ajouterAbonnement($id_user, $id_parking, $date_debut, $date_fin, $places_reservees) {
        try {
            $pdo = config::getConnexion();
            $places_reservees = (int) $places_reservees;

            // Étape 1 : Vérifier les places disponibles dans le parking
            $check = $pdo->prepare("SELECT places_dispo FROM parking WHERE id_parking = :id_parking");
            $check->bindParam(':id_parking', $id_parking);
            $check->execute();
            $row = $check->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return "Erreur : Le parking spécifié n'existe pas.";
            }

            $places_dispo = $row['places_dispo'];

            if ($places_reservees > $places_dispo) {
                return "Erreur : Pas assez de places disponibles. Places restantes : $places_dispo";
            }
             
            

            // Étape 2 : Insérer l’abonnement
            $sql = "INSERT INTO abonnement (id_user, id_parking, date_debut, date_fin, places_reservees) 
                    VALUES (:id_user, :id_parking, :date_debut, :date_fin, :places_reservees)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_parking', $id_parking);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);
            $stmt->bindParam(':places_reservees', $places_reservees);
            $stmt->execute();

            // Étape 3 : Mettre à jour les places disponibles
            $update = $pdo->prepare("UPDATE parking SET places_dispo = places_dispo - :places_reservees WHERE id_parking = :id_parking");
            $update->bindParam(':places_reservees', $places_reservees);
            $update->bindParam(':id_parking', $id_parking);
            $update->execute();

            return " Réservation effectuée avec succès ! Places restantes : " . ($places_dispo - $places_reservees);
             
        } catch (PDOException $e) {
            return " Erreur : " . $e->getMessage();
        }
    }
}
?>
