<?php
require_once __DIR__ . '/../../Controller/BikeController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurité : s'assurer que c'est bien un entier
    $controller = new BikeController();

    // On récupère les infos du vélo avant suppression
    $bike = $controller->getBikeById($id); // Méthode à créer si elle n'existe pas

    if ($bike) {
        $status = strtolower(trim($bike['status'])); // Normalisation

        if ($status === 'Rented' || $status === 'Active') {
            echo "<script>
                    alert('❌ Impossible de supprimer un vélo qui est \"Rented\" ou \"Active\".');
                    window.location.href = 'BikeList.php';
                  </script>";
            exit;
        }

        // Si statut valide, supprimer
        $controller->deleteBike($id);
        header("Location: BikeList.php?deleted=true");
        exit;
    } else {
        echo "<script>
                alert('🚫 Vélo introuvable.');
                window.location.href = 'BikeList.php';
              </script>";
        exit;
    }
}
?>
