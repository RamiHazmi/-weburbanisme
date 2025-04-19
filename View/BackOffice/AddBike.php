<?php
// Connexion à la base de données
require_once  '/xampp/htdocs/urbanisme/database.php';


// Affichage de la variable $_POST pour vérifier les données envoyées
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Vérifier si les champs nécessaires sont présents dans $_POST
    if (isset($_POST['station_id'], $_POST['status'], $_POST['kilometrage'])) {
        // Récupérer les valeurs du formulaire
        $station_id = $_POST['station_id'];
        $status = $_POST['status'];
        $total_kilometers = $_POST['kilometrage'];

        // Initialisation de l'erreur
        $error_message = "";

        // Vérifier si l'ID de la station est valide
        if (!empty($station_id)) {
            // Connexion à la base de données
            $db = config::getConnexion();

            // Vérifier si la station existe dans la base de données
            $sql_check_station = "SELECT id_station FROM bikestation WHERE id_station = :station_id";
            $stmt = $db->prepare($sql_check_station);
            $stmt->execute([':station_id' => $station_id]);
            $station = $stmt->fetch();

            if ($station) {
                // La station existe dans la base de données
                if (!empty($status) && !empty($total_kilometers)) {
                    if ($status !== 'Active' && $status !== 'Inactive') {
                        $error_message = "Le statut doit être soit 'Active' soit 'Inactive'.";
                    } else {
                        try {
                            // Requête pour insérer le vélo dans la table 'bike'
                            $sql = "INSERT INTO bike (station_id, status, total_kilometers)
                                    VALUES (:station_id, :status, :total_kilometers)";
                            
                            $query = $db->prepare($sql);
                            $query->execute([
                                ':station_id' => $station_id,
                                ':status' => $status,
                                ':total_kilometers' => $_POST['kilometrage']

                            ]);
                            $updateTotalSQL = "UPDATE bikestation SET total_bikes = total_bikes + 1 WHERE id_station = :station_id";
                            $updateTotalStmt = $db->prepare($updateTotalSQL);
                            $updateTotalStmt->execute([':station_id' => $station_id]);

                            if ($status === 'Inactive') {
                                $updateAvailableSQL = "UPDATE bikestation SET available_bikes = available_bikes + 1 WHERE id_station = :station_id";
                                $updateAvailableStmt = $db->prepare($updateAvailableSQL);
                                $updateAvailableStmt->execute([':station_id' => $station_id]);
                            }


                            // Redirection après succès
                            header('Location: Bikes.php');
                            exit(); // Stopper l'exécution après la redirection
                        } catch (Exception $e) {
                            // Si une erreur survient lors de l'insertion dans la base
                            $error_message = "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
                        }
                    }
                } else {
                    // Si le statut ou le kilométrage sont vides
                    $error_message = "Veuillez remplir tous les champs obligatoires.";
                }
            } else {
                // Si la station n'existe pas dans la base de données
                $error_message = "L'ID de station sélectionné n'existe pas.";
            }
        } else {
            // Si l'ID de station est vide
            $error_message = "Veuillez sélectionner une station.";
        }

        // Affichage des erreurs, s'il y en a
        if ($error_message != "") {
            echo "<div class='error-message' style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>$error_message</div>";
        }
    } else {
        // Si les champs nécessaires ne sont pas dans le POST
        echo "Le formulaire n'a pas été soumis correctement.";
    }
}
?>
