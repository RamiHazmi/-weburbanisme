<?php
require_once 'C:/xampp/htdocs/urbanisme/Model/parking.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';

$parkingModel = new Parking();

// Tableau d'images aléatoires pour les parkings
$images = [
    'img/parking1.jpg', 'img/parking2.jpg', 'img/parking3.jpg',
    'img/parking4.jpg', 'img/parking5.jpg', 'img/parking6.jpg',
    'img/parking7.jpg', 'img/parking8.jpg', 'img/parking9.jpg', 'img/parking10.jpg'
];

function genererCarteParking($parking, $id) {
    global $images;

    $image = $images[array_rand($images)];

    return '
    <div class="col-md-6 col-lg-4 mb-4 wow fadeInUp" data-wow-delay="0.3s">
        <div class="p-4 border shadow-sm rounded-4 hover-shadow" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
            <div class="overflow-hidden mb-3 text-center">
                <img src="' . htmlspecialchars($image) . '" class="img-fluid rounded" alt="Image parking" style="max-height: 200px; object-fit: cover;">
            </div>
            <h4 class="mb-2" style="color: #007bff; font-weight: bold;">' . htmlspecialchars($parking->getNomParking()) . '</h4>
            <p><strong>Adresse:</strong> ' . htmlspecialchars($parking->getLocalisation()) . '</p>
            <p><strong>Places disponibles:</strong> ' . intval($parking->getPlacesDispo()) . '</p>
            <p><strong>Tarif:</strong> ' . floatval($parking->getTarifHoraire()) . ' DT/h</p>
            <p><strong>Sécurisé:</strong> ' . ($parking->isSecurise() ? 'Oui' : 'Non') . '</p>

            <form class="form-reservation mt-3">
                <input type="hidden" name="id_parking" value="' . intval($id) . '">
                <input type="hidden" name="client_id" value="123">  
                <button type="button" class="btn btn-primary w-100 btn-reserver"
                    data-id="' . intval($id) . '" 
                    data-nom="' . htmlspecialchars($parking->getNomParking()) . '" 
                    data-ville="' . htmlspecialchars($parking->getVille()) . '">
                    <i class="fa fa-check"></i> Réserver
                </button>
            </form>
        </div>
    </div>
    <style>
        .col-md-6.col-lg-4 {
            transition: transform 0.3s ease;
        }
        .col-md-6.col-lg-4:hover {
            transform: translateY(-10px);
        }
        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .hover-shadow:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
    </style>
    ';
}

// Fonction pour créer un objet Parking à partir d’un tableau
function creerObjetParking($donnees) {
    $parking = new Parking(
        $donnees['nom_parking'],
        $donnees['localisation'],
        $donnees['capacite_totale'],
        $donnees['places_dispo'],
        $donnees['tarif_horaire'],
        $donnees['securise'],
        $donnees['ville']
    );

    $reflection = new ReflectionClass($parking);
    $prop = $reflection->getProperty('id_parking');
    $prop->setAccessible(true);
    $prop->setValue($parking, $donnees['id_parking']);

    return $parking;
}

// Réception et traitement de l'action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $resultats = [];

    switch ($action) {
        case 'afficher_tous_les_parkings':
            $resultats = $parkingModel->afficherTous();
            break;

        case 'rechercher_par_ville':
            if (!empty($_POST['ville'])) {
                $ville = trim($_POST['ville']);
                $resultats = $parkingModel->afficherParVille($ville);
            }
            break;

        case 'rechercher_par_securite':
            $securite = $_POST['securite'] ?? null;
            $ville = isset($_POST['ville']) ? trim($_POST['ville']) : null;

            $securiseBool = null;
            if ($securite === 'securise') $securiseBool = 1;
            elseif ($securite === 'non_securise') $securiseBool = 0;

            if ($ville !== null && $securiseBool !== null) {
                $resultats = $parkingModel->afficherParVilleEtSecurite($ville, $securiseBool);
            } elseif ($securiseBool !== null) {
                $resultats = $parkingModel->afficherParSecurite($securiseBool);
            } elseif ($ville !== null) {
                $resultats = $parkingModel->afficherParVille($ville);
            } else {
                $resultats = $parkingModel->afficherTous();
            }
            break;
    }

    // Affichage
    if (!empty($resultats)) {
        foreach ($resultats as $p) {
            echo genererCarteParking(creerObjetParking($p), $p['id_parking']);
        }
    } else {
        echo "<p class='text-muted'>Aucun parking trouvé avec les critères sélectionnés.</p>";
    }
}
?>
