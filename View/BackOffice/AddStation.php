<?php
// Connexion à la base de données
require_once  '/xampp/htdocs/urbanisme/database.php';

// Vérifier si le formulaire est bien soumis
if (isset($_POST['name'], $_POST['location'], $_POST['status'])) {

    // Récupérer les valeurs du formulaire
    $name = $_POST['name'];
    $location = $_POST['location'];
    $status = $_POST['status']; 

    $error_message = "";  // Variable to store error messages

    // Vérifier que toutes les données sont présentes
    if (!empty($name) && !empty($location) && isset($status)) {
        
        // Ajouter la validation pour vérifier si le nombre total de vélos est supérieur ou égal aux vélos disponibles
        
            try {
                // Connexion à la base de données
                $db = config::getConnexion();
                
                // Requête SQL pour insérer les données
                $sql = "INSERT INTO bikestation (name, location, status) 
                        VALUES (:name, :location,  :status)";
                
                // Préparer la requête
                $query = $db->prepare($sql);

                // Exécuter la requête avec les données
                $query->execute([
                    ':name' => $name,
                    ':location' => $location,
                    ':status' => $status
                ]);

                // Confirmation de l'ajout de la station
                echo "<script>
                alert('Station ajouté avec succès !');
                window.location.href = 'Bike.php';
            </script>";
            exit();
                
            } catch (Exception $e) {
                $error_message = "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
            }
        
    } else {
        $error_message = "Veuillez remplir tous les champs du formulaire.";
    }

    // Display the error message if any
    if ($error_message != "") {
        echo "<div class='error-message' style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>$error_message</div>";
    }

} else {
    echo "Le formulaire n'a pas été soumis correctement.";
}
?>
