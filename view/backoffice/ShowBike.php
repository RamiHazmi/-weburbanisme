<?php
include 'database.php';

if (isset($_GET['station_id'])) {
    $station_id = intval($_GET['station_id']);

    $stmt = $pdo->prepare("SELECT id_bike, status, total_kilometers FROM bike WHERE station_id = ?");
    $stmt->execute([$station_id]);
    $bikes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($bikes) > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>ID</th><th>Status</th><th>Km</th></tr></thead><tbody>';
        foreach ($bikes as $bike) {
            echo '<tr>
                    <td>' . $bike['id_bike'] . '</td>
                    <td>' . $bike['status'] . '</td>
                    <td>' . $bike['total_kilometers'] . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info">Aucun vélo trouvé pour cette station.</div>';
    }
} else {
    echo '<div class="alert alert-danger">ID de station invalide.</div>';
}
