<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';

class Abonnement {
    public function ajouterAbonnement($id_user, $id_parking, $date_debut, $date_fin, $places_reservees) {
        try {
            $pdo = config::getConnexion();
            $places_reservees = (int) $places_reservees;
    
            // Vérification : la date de début ne doit pas être dans le passé
            $date_debut_obj = new DateTime($date_debut);
            $today = new DateTime();
            $today->setTime(0, 0, 0); // On ignore l'heure pour ne comparer que les dates
    
            if ($date_debut_obj < $today) {
                return "Erreur : La date de début ne peut pas être dans le passé.";
            }
    
            // Étape 1 : Vérifier les places disponibles
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
    
            // Étape 2 : Insertion de l’abonnement
            $sql = "INSERT INTO abonnement (id_user, id_parking, date_debut, date_fin, places_reservees) 
                    VALUES (:id_user, :id_parking, :date_debut, :date_fin, :places_reservees)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_parking', $id_parking);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);
            $stmt->bindParam(':places_reservees', $places_reservees);
            $stmt->execute();
    
            // Étape 3 : Mise à jour des places disponibles
            $update = $pdo->prepare("UPDATE parking SET places_dispo = places_dispo - :places_reservees WHERE id_parking = :id_parking");
            $update->bindParam(':places_reservees', $places_reservees);
            $update->bindParam(':id_parking', $id_parking);
            $update->execute();
    
            return "Réservation effectuée avec succès ! Places restantes : " . ($places_dispo - $places_reservees);
    
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
    
    public function supprimerAbonnement($id_abonnement) {
        try {
            $pdo = config::getConnexion();
    
            // Étape 1 : Récupérer les infos de l’abonnement (id_parking + places_reservees)
            $query = $pdo->prepare("SELECT id_parking, places_reservees FROM abonnement WHERE id_abonnement = :id_abonnement");
            $query->bindParam(':id_abonnement', $id_abonnement);
            $query->execute();
            $abonnement = $query->fetch(PDO::FETCH_ASSOC);
    
            if (!$abonnement) {
                return "Erreur : L’abonnement n'existe pas.";
            }
    
            $id_parking = $abonnement['id_parking'];
            $places_reservees = (int)$abonnement['places_reservees'];
    
            // Étape 2 : Supprimer l’abonnement
            $delete = $pdo->prepare("DELETE FROM abonnement WHERE id_abonnement = :id_abonnement");
            $delete->bindParam(':id_abonnement', $id_abonnement);
            $delete->execute();
    
            // Étape 3 : Mettre à jour les places disponibles dans le parking
            $update = $pdo->prepare("UPDATE parking SET places_dispo = places_dispo + :places_reservees WHERE id_parking = :id_parking");
            $update->bindParam(':places_reservees', $places_reservees);
            $update->bindParam(':id_parking', $id_parking);
            $update->execute();
    
            return "Abonnement supprimé avec succès. Les places ont été remises à jour.";
            
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
<<<<<<< HEAD
    public function getAbonnementsExpires()
    {
        $pdo = config::getConnexion();
        $today = date('Y-m-d H:i:s');  
        $userId = 1;  
    
        $sql = "SELECT a.id_user, u.username, u.phone, p.nom_parking, a.date_fin
                FROM abonnement a
                JOIN user u ON a.id_user = u.id
                JOIN parking p ON a.id_parking = p.id_parking
                WHERE a.date_fin < :today AND a.id_user = :userId";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':today', $today);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    

    
    

=======
>>>>>>> origin/parking
    
}
?>
