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
public function getStationIdByName($name)
{
    $sql = 'SELECT id_station, name FROM bikestation WHERE LOWER(name) = LOWER(:name)';
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['name' => $name]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        // Check if a station is found and return the id_station
        if ($result) {
            return $result['id_station'];
        } else {
            // Try partial match if exact match fails
            $sql = 'SELECT id_station, name FROM bikestation WHERE LOWER(name) LIKE LOWER(:name)';
            $query = $db->prepare($sql);
            $query->execute(['name' => '%' . $name . '%']);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($results)) {
                // Return the first match
                return $results[0]['id_station'];
            }
            return null;
        }
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

public function getStationIdByNameExact($stationName) {
    $db = config::getConnexion();
    try {
        error_log('getStationIdByNameExact called with station name: "' . $stationName . '"');
        
        // First try exact match (case-insensitive)
        $sql = "SELECT id_station, name FROM bikestation WHERE LOWER(name) = LOWER(:name)";
        $query = $db->prepare($sql);
        $query->execute(['name' => $stationName]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            error_log('Found exact match: ' . $result['name'] . ' (ID: ' . $result['id_station'] . ')');
            return $result['id_station'];
        }
        
        error_log('No exact match found, trying partial match');
        
        // If no exact match, try partial match at the start of the name
        $sql = "SELECT id_station, name FROM bikestation WHERE LOWER(name) LIKE LOWER(:name)";
        $query = $db->prepare($sql);
        $query->execute(['name' => $stationName . '%']);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        error_log('Found ' . count($results) . ' partial matches');
        foreach ($results as $station) {
            error_log('Partial match: ' . $station['name'] . ' (ID: ' . $station['id_station'] . ')');
        }
        
        if (count($results) === 1) {
            // Only return if there's exactly one match
            error_log('Returning single partial match: ' . $results[0]['name'] . ' (ID: ' . $results[0]['id_station'] . ')');
            return $results[0]['id_station'];
        } else if (count($results) > 1) {
            // If multiple matches, try to find the best match
            $bestMatch = null;
            $bestScore = 0;
            
            error_log('Multiple matches found, calculating similarity scores');
            foreach ($results as $station) {
                $stationNameLower = strtolower($station['name']);
                $searchNameLower = strtolower($stationName);
                
                // Calculate similarity score
                $score = 0;
                if (strpos($stationNameLower, $searchNameLower) === 0) {
                    $score += 2; // Bonus for prefix match
                    error_log('Prefix match bonus for: ' . $station['name']);
                }
                similar_text($stationNameLower, $searchNameLower, $similarity);
                $score += $similarity;
                
                error_log('Similarity score for ' . $station['name'] . ': ' . $score);
                
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestMatch = $station['id_station'];
                }
            }
            
            if ($bestScore > 0.7) { // Only return if we have a good match
                error_log('Best match found with score ' . $bestScore . ': ID ' . $bestMatch);
                return $bestMatch;
            } else {
                error_log('No good match found (best score: ' . $bestScore . ')');
            }
        }
        
        error_log('No suitable match found for: "' . $stationName . '"');
        return null; // Return null if no good match found
    } catch (Exception $e) {
        error_log('Error in getStationIdByNameExact: ' . $e->getMessage());
        return null;
    }
}

public function getAvailableBikesCount($stationId) {
    $sql = "SELECT available_bikes FROM bikestation WHERE id_station = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['id' => $stationId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['available_bikes'] : 0;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

public function getFirstAvailableBike($stationId) {
    $sql = "SELECT id_bike FROM bike WHERE station_id = :station_id AND status = 'Inactive' LIMIT 1";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['station_id' => $stationId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_bike'] : null;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

public function processRental($bikeId, $startStationId, $endStationId, $userId = 1) {
    $db = config::getConnexion();
    try {
        // Start transaction
        $db->beginTransaction();

        // 1. Update bike status
        $updateBike = $db->prepare("UPDATE bike SET status = 'Rented' WHERE id_bike = :bike_id");
        $updateBike->execute(['bike_id' => $bikeId]);

        // 2. Decrease available bikes at start station
        $decreaseBikes = $db->prepare("
            UPDATE bikestation 
            SET available_bikes = available_bikes - 1 
            WHERE id_station = :station_id
        ");
        $decreaseBikes->execute(['station_id' => $startStationId]);

        // 3. Create rental record
        $startTime = date('Y-m-d H:i:s');
        $insertRental = $db->prepare("
            INSERT INTO bikerental (id_bike, id_user, end_station, start_time, start_station) 
            VALUES (:bike_id, :user_id, :end_station, :start_time, :start_station)
        ");
        $insertRental->execute([
            'bike_id' => $bikeId,
            'user_id' => $userId,
            'end_station' => $endStationId,
            'start_time' => $startTime,
            'start_station' => $startStationId
        ]);

        // Commit transaction
        $db->commit();
        return true;
    } catch (Exception $e) {
        // Rollback on error
        $db->rollBack();
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

    public function updateBikeStatus($bikeId, $status) {
        $sql = "UPDATE bike SET status = :status WHERE id_bike = :bike_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'status' => $status,
                'bike_id' => $bikeId
            ]);
            return true;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function decreaseAvailableBikes($stationId) {
        $sql = "UPDATE bikestation SET available_bikes = available_bikes - 1 WHERE id_station = :station_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['station_id' => $stationId]);
            return true;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getTotalBikesCount($stationId) {
        $sql = "SELECT total_bikes FROM bikestation WHERE id_station = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $stationId]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['total_bikes'] : 0;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
