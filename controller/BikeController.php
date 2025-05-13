<?php 

require_once __DIR__ . '/../database.php';
include __DIR__ . '/../Model/BikeM.php';

class BikeController
{
    // Lister tous les vélos
    public function listBikes()
    {
        $sql = 'SELECT * FROM bike';
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getBikesByStation($station_id)
    {
        $sql = 'SELECT * FROM bike WHERE station_id = :station_id';
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['station_id' => $station_id]);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getBikeById($id_bike)
{
    $sql = 'SELECT * FROM bike WHERE id_bike = :id';
    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id_bike, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


    // Ajouter un nouveau vélo
    public function addBike(Bike $bike)
    {
        $sql = "INSERT INTO bike (station_id, status, total_kilometers)
                VALUES (:station_id, :status, :total_kilometers)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'station_id' => $bike->getStationId(),
                'status' => $bike->getStatus(),
                'total_kilometers' => $bike->getTotalKilometers()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Supprimer un vélo
    public function deleteBike($id_bike)
{
    $db = config::getConnexion();

    try {
        // Étape 1 : Récupérer les infos du vélo
        $sql_select = "SELECT station_id, status FROM bike WHERE id_bike = :id_bike";
        $stmt = $db->prepare($sql_select);
        $stmt->execute(['id_bike' => $id_bike]);
        $bike = $stmt->fetch();

        if ($bike) {
            $station_id = $bike['station_id'];
            $status = $bike['status'];

            // Étape 2 : Supprimer le vélo
            $sql_delete = "DELETE FROM bike WHERE id_bike = :id_bike";
            $query = $db->prepare($sql_delete);
            $query->execute(['id_bike' => $id_bike]);

            // Étape 3 : Décrémenter total_bikes
            $sql_update_total = "UPDATE bikestation SET total_bikes = total_bikes - 1 WHERE id_station = :station_id";
            $stmt_total = $db->prepare($sql_update_total);
            $stmt_total->execute(['station_id' => $station_id]);

            // Étape 4 : Décrémenter available_bikes si le vélo était inactif
            if ($status === 'Inactive') {
                $sql_update_available = "UPDATE bikestation SET available_bikes = available_bikes - 1 WHERE id_station = :station_id";
                $stmt_available = $db->prepare($sql_update_available);
                $stmt_available->execute(['station_id' => $station_id]);
            }
        }

    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


    // Modifier un vélo existant
    public function updateBike($id_bike, Bike $bike)
{
    $db = config::getConnexion();

    try {
        // 🔍 Étape 1 : Récupérer les anciennes données du vélo
        $sql_old = "SELECT station_id, status FROM bike WHERE id_bike = :id_bike";
        $stmt_old = $db->prepare($sql_old);
        $stmt_old->execute(['id_bike' => $id_bike]);
        $oldBike = $stmt_old->fetch();

        if (!$oldBike) {
            throw new Exception("Vélo avec ID $id_bike introuvable.");
        }

        $old_station = $oldBike['station_id'];
        $old_status = $oldBike['status'];

        $new_station = $bike->getStationId();
        $new_status = $bike->getStatus();

        // 🛠 Étape 2 : Mise à jour des compteurs si nécessaire
        // 🚲 Changement de station
        if ($old_station != $new_station) {
            // Ancienne station
            $db->prepare("UPDATE bikestation SET total_bikes = total_bikes - 1 WHERE id_station = :id")
                ->execute(['id' => $old_station]);

            if ($old_status == 'Inactive') {
                $db->prepare("UPDATE bikestation SET available_bikes = available_bikes - 1 WHERE id_station = :id")
                    ->execute(['id' => $old_station]);
            }

            // Nouvelle station
            $db->prepare("UPDATE bikestation SET total_bikes = total_bikes + 1 WHERE id_station = :id")
                ->execute(['id' => $new_station]);

            if ($new_status == 'Inactive') {
                $db->prepare("UPDATE bikestation SET available_bikes = available_bikes + 1 WHERE id_station = :id")
                    ->execute(['id' => $new_station]);
            }
        }
        // 🔄 Même station, mais changement de statut
        elseif ($old_status != $new_status) {
            if ($old_status == 'Inactive' && $new_status == 'Active') {
                $db->prepare("UPDATE bikestation SET available_bikes = available_bikes - 1 WHERE id_station = :id")
                    ->execute(['id' => $old_station]);
            } elseif ($old_status == 'Active' && $new_status == 'Inactive') {
                $db->prepare("UPDATE bikestation SET available_bikes = available_bikes + 1 WHERE id_station = :id")
                    ->execute(['id' => $old_station]);
            }
        }

        // ✅ Étape 3 : Mettre à jour le vélo
        $sql = "UPDATE bike 
                SET station_id = :station_id, 
                    status = :status, 
                    total_kilometers = :total_kilometers
                WHERE id_bike = :id_bike";

        $query = $db->prepare($sql);
        $query->execute([
            'id_bike' => $id_bike,
            'station_id' => $new_station,
            'status' => $new_status,
            'total_kilometers' => $bike->getTotalKilometers()
        ]);

    } catch (Exception $e) {
        die('Erreur lors de la mise à jour : ' . $e->getMessage());
    }
}

}
