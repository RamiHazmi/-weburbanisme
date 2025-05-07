<?php
require_once 'C:/xampp/htdocs/Urbanisme/Model/parking.php';
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_parking = $_POST['nom_parking'];
    $localisation = $_POST['localisation'];
    $capacite_totale = $_POST['capacite_totale'];
    $places_dispo = $_POST['places_dispo'];
    $tarif_horaire = $_POST['tarif_horaire'];
    $securise = ($_POST['securise'] === '1') ? true : false;
    $ville = $_POST['ville'];  

     
    $parking = new Parking($nom_parking, $localisation, $capacite_totale, $places_dispo, $tarif_horaire, $securise, $ville);

    try {
        $parking->insertIntoDatabase();
        echo "Le parking a été ajouté avec succès.";
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>
