<?php
// Connexion à la base de données
require_once  '/xampp/htdocs/urbanisme/database.php';
require_once __DIR__ . '/../../Controller/BikeStationController.php';


$pdo = config::getConnexion();
$bikeStationController = new BikeStationController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bike_id = $_POST['bike_id'];
    $user_id = $_POST['user_id'];
    $end_station = $_POST['end_station'];
    $start_time = date('Y-m-d H:i:s');

    // 🔸 Étape 1 : récupérer la station actuelle AVANT modification
    $stmt = $pdo->prepare("SELECT station_id FROM Bike WHERE id_bike = :bike_id");
    $stmt->execute(['bike_id' => $bike_id]);
    $bike = $stmt->fetch();

    if (!$bike) {
        die("Vélo non trouvé.");
    }

    $old_station_id = $bike['station_id'];
    $old_station_name=$bikeStationController->getStationNameById($old_station_id);


    // 🔸 Étape 2 : insérer la location dans BikeRental
    $insertRental = $pdo->prepare("INSERT INTO BikeRental (id_bike, id_user, end_station, start_time, start_station) VALUES (:bike_id, :user_id, :end_station, :start_time , :start_station)");
    $insertRental->execute([
        'bike_id' => $bike_id,
        'user_id' => $user_id,
        'end_station' => $end_station,
        'start_time' => $start_time,
        'start_station' => $old_station_name

    ]);
    $updateBike = $pdo->prepare("UPDATE Bike SET status = 'Rented' WHERE id_bike = :bike_id");
    $updateBike->execute([
        'bike_id' => $bike_id
    ]);
    

    $decreaseOldStation = $pdo->prepare("
        UPDATE BikeStation 
        SET available_bikes = available_bikes - 1
        WHERE id_station = :old_id
    ");
    $decreaseOldStation->execute(['old_id' => $old_station_id]);

    

    /* 🔸 Étape 3 : mettre à jour le vélo
    $updateBike = $pdo->prepare("UPDATE Bike SET status = 'Rented', station_id = :station_id WHERE id_bike = :bike_id");
    $updateBike->execute([
        'station_id' => $end_station,
        'bike_id' => $bike_id
    ]);

    // 🔸 Étape 4 : décrémenter la station précédente (seulement si différente de la nouvelle)
if ($old_station_id != $end_station) {
    $decreaseOldStation = $pdo->prepare("
        UPDATE BikeStation 
        SET total_bikes = total_bikes - 1,
            available_bikes = available_bikes - 1
        WHERE id_station = :old_id
    ");
    $decreaseOldStation->execute(['old_id' => $old_station_id]);

    // 🔸 Étape 5 : incrémenter la nouvelle (mais pas available_bikes, car le vélo est loué)
    $increaseNewStation = $pdo->prepare("
        UPDATE BikeStation 
        SET total_bikes = total_bikes + 1
        WHERE id_station = :new_id
    ");
    $increaseNewStation->execute(['new_id' => $end_station]);
} else {
    // Cas spécial : si l'utilisateur choisit la même station en fin (rare)
    $updateSameStation = $pdo->prepare("
        UPDATE BikeStation 
        SET available_bikes = available_bikes - 1
        WHERE id_station = :station_id
    ");
    $updateSameStation->execute(['station_id' => $old_station_id]);
}*/
header('Location: Stations.php');



    // ✅ Redirection ou message de succès
}

?>
