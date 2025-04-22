<?php

require_once __DIR__ . '/../database.php';
include __DIR__ . '/../Model/BikeRentalM.php';

class BikeRentalController
{
    // List all rentals
    public function listRentals()
    {
        $sql = 'SELECT * FROM bikerental';
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new rental
    public function addRental(BikeRental $rental)
    {
        $sql = "INSERT INTO bikerental (id_bike, id_user, end_station, start_time, end_time, feedback,start_station)
                VALUES (:id_bike, :id_user, :end_station, :start_time, :end_time, :feedback, :start_station)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_bike' => $rental->getIdBike(),
                'id_user' => $rental->getIdUser(),
                'end_station' => $rental->getEndStation(),
                'start_time' => $rental->getStartTime(),
                'end_time' => $rental->getEndTime(),
                'feedback' => $rental->getFeedback(),
                'start_station' => $rental->getStartStation()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Delete a rental
    public function deleteRental($id_rental)
    {
        $sql = "DELETE FROM bikerental WHERE id_rental = :id_rental";
        $db = config::getConnexion();
        $query = $db->prepare($sql);

        try {
            $query->execute(['id_rental' => $id_rental]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a rental
    public function updateRental($id_rental, BikeRental $rental)
    {
        $sql = "UPDATE bikerental 
                SET id_bike = :id_bike,
                    id_user = :id_user,
                    start_station =:start_station,
                    end_station = :end_station,
                    start_time = :start_time,
                    end_time = :end_time,
                    feedback = :feedback
                WHERE id_rental = :id_rental";
        $db = config::getConnexion();
        $query = $db->prepare($sql);

        try {
            $query->execute([
                'id_rental' => $id_rental,
                'id_bike' => $rental->getIdBike(),
                'id_user' => $rental->getIdUser(),
                'end_station' => $rental->getEndStation(),
                'start_time' => $rental->getStartTime(),
                'end_time' => $rental->getEndTime(),
                'feedback' => $rental->getFeedback(),
                'start_station' => $rental->getStartStation()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
