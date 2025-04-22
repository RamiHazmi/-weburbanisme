<?php

require_once __DIR__ . '/../database.php';
include __DIR__ .'/../Model/BikeStation.php';

class BikeStationController
{
    public function listStations()
    {
        $sql = 'SELECT * FROM bikestation';
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getStationNameById($station_id)
{
    $sql = 'SELECT name FROM bikestation WHERE id_station = :station_id';
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['station_id' => $station_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['name']; // Retourne le nom de la station
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}



    public function addStation(BikeStation $station)
    {
        $sql = "INSERT INTO bikestation (name, location, status)
                VALUES (:name, :location, :status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'name' => $station->getName(),
                'location' => $station->getLocation(),
                'status' => $station->getStatus()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function deleteStation($id_station)
    {
        $db = config::getConnexion();
    
        try {
            // Étape 1 : compter le nombre total de vélos de la station à supprimer
            $sqlCountTotal = "SELECT COUNT(*) as total FROM bike WHERE station_id = :id_station";
            $stmtTotal = $db->prepare($sqlCountTotal);
            $stmtTotal->execute(['id_station' => $id_station]);
            $totalBikes = $stmtTotal->fetch()['total'];
    
            // Étape 2 : compter les vélos "Inactive"
            $sqlCountInactive = "SELECT COUNT(*) as inactive FROM bike WHERE station_id = :id_station AND status = 'Inactive'";
            $stmtInactive = $db->prepare($sqlCountInactive);
            $stmtInactive->execute(['id_station' => $id_station]);
            $inactiveBikes = $stmtInactive->fetch()['inactive'];
    
            // Étape 3 : transférer les vélos vers la station 20
            $sqlUpdateBikes = "UPDATE bike SET station_id = 21 WHERE station_id = :id_station";
            $stmtUpdate = $db->prepare($sqlUpdateBikes);
            $stmtUpdate->execute(['id_station' => $id_station]);
    
            // Étape 4 : mettre à jour les compteurs dans la station 20
            $sqlUpdateStation = "UPDATE bikestation 
                                 SET total_bikes = total_bikes + :total,
                                     available_bikes = available_bikes + :inactive
                                 WHERE id_station = 21";
            $stmtUpdateStation = $db->prepare($sqlUpdateStation);
            $stmtUpdateStation->execute([
                'total' => $totalBikes,
                'inactive' => $inactiveBikes
            ]);
    
            // Étape 5 : supprimer la station
            $sqlDeleteStation = "DELETE FROM bikestation WHERE id_station = :id_station";
            $stmtDelete = $db->prepare($sqlDeleteStation);
            $stmtDelete->execute(['id_station' => $id_station]);
    
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    


    public function updateStation($id_station, $station)
    {
        $sql = "UPDATE bikestation 
            SET name = :name, location = :location,  status = :status 
            WHERE id_station = :id_station";

    $db = config::getConnexion();
    $query = $db->prepare($sql);

    try {
        $query->execute([
            'id_station' => $id_station,  // This remains the same (not modified)
            'name' => $station->getName(),
            'location' => $station->getLocation(),
            'status' => $station->getStatus(),
        ]);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
    }
}
