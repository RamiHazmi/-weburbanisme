<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_FILES['photo']) &&
        isset($_FILES['photo']['tmp_name']) &&
        !empty($_FILES['photo']['tmp_name']) &&
        isset($_POST['id_reservation'])
    ) {
        $id_reservation = $_POST['id_reservation'];
        $uploadDir = 'images/';
        $imageName = 'user_' . $id_reservation . '.png'; // Nom personnalisé
        $uploadFile = $uploadDir . basename($imageName);

        // Vérifier le type MIME de manière sécurisée
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/pjpeg'];
        $mimeType = mime_content_type($_FILES['photo']['tmp_name']);

        if (in_array($mimeType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                header("Location: AffichageReservation.php");
                exit;
            } else {
                echo "Erreur lors du téléchargement.";
            }
        } else {
            echo "Format d'image non autorisé.";
        }
    } else {
        echo "Aucun fichier sélectionné ou données manquantes.";
    }
}
?>
