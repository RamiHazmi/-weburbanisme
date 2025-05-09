<?php
require_once 'C:/xampp/htdocs/urbanisme/database.php';
require_once 'C:/xampp/htdocs/urbanisme/Model/abonnement.php';

if (isset($_POST['id_abonnement'])) {
    $id_abonnement = $_POST['id_abonnement'];

     
    $abonnementModel = new Abonnement();
    
    
    $resultat = $abonnementModel->supprimerAbonnement($id_abonnement);

    
    if (strpos($resultat, 'Erreur') !== false) {
        echo "error";
    } else {
        echo "success";
    }
} else {
    echo "error";
}
?>
