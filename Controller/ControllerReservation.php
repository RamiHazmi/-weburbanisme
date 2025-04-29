<?php
include_once __DIR__ . '/../Config/config.php';


class ControllerReservationElectrique {

 
public function ajouterResrvation($ModelReservationBorne)
{
    $sql = "INSERT INTO reservationBorne 
            (nomClient, prenomClient, emailClient, date_reservation, heure_debut, heure_fin, 
            duree_charge, tarif_estime, statut_reservation, id_borne, mode_paiement, pourcentage_charge) 
            VALUES 
            (:nomClient, :prenomClient, :emailClient, :date_reservation, 
            :heure_debut, :heure_fin, :duree_charge, :tarif_estime, :statut_reservation, :id_borne, :mode_paiement,
            :pourcentage_charge)";

    $db = config::getConnexion();  // Connexion à la base de données

    try {
        $query = $db->prepare($sql);  // Préparation de la requête SQL

        // Exécution de la requête avec les données du modèle
        $query->execute([
            'nomClient' => $ModelReservationBorne->getNomClient(),
            'prenomClient' => $ModelReservationBorne->getPrenomClient(),
            'emailClient' => $ModelReservationBorne->getEmailClient(),
            'date_reservation' => $ModelReservationBorne->getDateReservation(),
            'heure_debut' => $ModelReservationBorne->getHeureDebut(),
            'heure_fin' => $ModelReservationBorne->getHeureFin(),
            'duree_charge' => $ModelReservationBorne->getDureeCharge(),
            'tarif_estime' => $ModelReservationBorne->getTarifEstime(),
            'statut_reservation' => $ModelReservationBorne->getStatutReservation(),
            'id_borne' => $ModelReservationBorne->getIdBorne(),
            'mode_paiement' => $ModelReservationBorne->getPaiement(),
            'pourcentage_charge' => $ModelReservationBorne->getPourcentage()
        ]);

        return true;  // Si tout va bien, on retourne vrai
    } catch (Exception $e) {
        echo 'Erreur: ' . $e->getMessage();  // Affichage de l'erreur en cas d'exception
        return false;  // Retourner faux en cas d'erreur
    }
}
public function afficherPourFront()
{
    try {
        $db = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM reservationborne WHERE statut_reservation = 'Confirmé'";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}


public function supprimerReservation($id_reservation)
{
    $sql = "DELETE FROM reservationborne WHERE id_reservation = :id_reservation";
    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->bindParam(':id_reservation', $id_reservation);
        return $query->execute();
    } catch (Exception $e) {
        echo 'Erreur lors de la suppression : ' . $e->getMessage();
        return false;
    }
} 

public function modifierReservation($db,$ModelReservationBorne, $id_reservation)
{

    echo "Modification en cours pour ID: $id_reservation";  // Affiche un message de débogage

    try {
        
            // Préparez la requête
            $query = $db->prepare("UPDATE reservationborne SET prenomClient = :prenomClient,
                    nomClient = :nomClient,
                    emailClient = :emailClient,
                    date_reservation = :date_reservation,
                    tarif_estime = :tarif_estime,
                    statut_reservation = :statut_reservation,
                    heure_debut = :heure_debut,
                    heure_fin = :heure_fin,
                    duree_charge = :duree_charge,
                    id_borne = :id_borne,
                    mode_paiement = :mode_paiement,
                    pourcentage_charge = :pourcentage_charge
                WHERE id_reservation = :id_reservation");

                // Exécutez la requête
                $query->execute([
                    'nomClient' => $ModelReservationBorne->getNomClient(),
                    'prenomClient' => $ModelReservationBorne->getPrenomClient(),
                    'emailClient' => $ModelReservationBorne->getEmailClient(),
                    'date_reservation' => $ModelReservationBorne->getDateReservation(),
                    'heure_debut' => $ModelReservationBorne->getHeureDebut(),
                    'heure_fin' => $ModelReservationBorne->getHeureFin(),
                    'duree_charge' => $ModelReservationBorne->getDureeCharge(),
                    'tarif_estime' => $ModelReservationBorne->getTarifEstime(),
                    'statut_reservation' => $ModelReservationBorne->getStatutReservation(),
                    'id_borne' => $ModelReservationBorne->getIdBorne(),
                    'mode_paiement' => $ModelReservationBorne->getPaiement(),
                    'pourcentage_charge' => $ModelReservationBorne->getPourcentage(),
                    'id_reservation' => $id_reservation

                ]);

                echo "Modification réussie !";  // Message de succès pour confirmer que la requête a été exécutée

                
   

    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage(); // Affiche l'erreur si une exception est levée
    }
}

public function recupererReservation($id_reservation) {
    $db = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM reservationborne WHERE id_reservation = :id_reservation";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



}
?>