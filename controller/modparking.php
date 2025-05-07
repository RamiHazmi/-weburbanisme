<?php
require_once 'C:/xampp/htdocs/Urbanisme/Model/parking.php';
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';



// Récupérer l'instance de PDO à partir de la classe config
$pdo = config::getConnexion();

// Vérifier si la connexion a bien été établie
if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Vérifiez si la requête est une soumission POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs envoyées par le formulaire
    $id_parking = $_POST['id_parking'];
    $nom_parking = $_POST['nom_parking'];
    $localisation = $_POST['localisation'];
    $ville = $_POST['ville'];
    $capacite_totale = $_POST['capacite_totale'];
    $places_dispo = $_POST['places_dispo'];
    $tarif_horaire = $_POST['tarif_horaire'];
    $securise = $_POST['securise'];

    try {
         
        $sql = "UPDATE parking SET nom_parking = :nom_parking, localisation = :localisation, ville = :ville, capacite_totale = :capacite_totale, places_dispo = :places_dispo, tarif_horaire = :tarif_horaire, securise = :securise WHERE id_parking = :id_parking";
        
        
        $stmt = $pdo->prepare($sql);
        
         
        $stmt->bindParam(':nom_parking', $nom_parking);
        $stmt->bindParam(':localisation', $localisation);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':capacite_totale', $capacite_totale, PDO::PARAM_INT);
        $stmt->bindParam(':places_dispo', $places_dispo, PDO::PARAM_INT);
        $stmt->bindParam(':tarif_horaire', $tarif_horaire, PDO::PARAM_STR);
        $stmt->bindParam(':securise', $securise, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_parking', $id_parking, PDO::PARAM_INT);

       
        if ($stmt->execute()) {
            echo "<span style='color: green;'>Parking modifié avec succès!</span>";
        } else {
            echo "<span style='color: red;'>Erreur lors de la modification du parking.</span>";
        }
    } catch (PDOException $e) {
       
        echo "<span style='color: red;'>Erreur de la base de données : " . $e->getMessage() . "</span>";
    }
}
?>

