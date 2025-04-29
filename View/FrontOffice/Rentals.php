<?php

require_once '/xampp/htdocs/urbanisme/database.php';
$pdo = config::getConnexion();
$id_user = 1; // 🔁 Later: use $_SESSION['id_user']

// 🧠 Handle POST actions (delete or checkout)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_rental'])) {
        $rental_id = $_POST['rental_id'];
    
        // 🔍 Récupérer la location
        $stmt = $pdo->prepare("SELECT * FROM BikeRental WHERE id_rental = :id AND id_user = :user");
        $stmt->execute(['id' => $rental_id, 'user' => $id_user]);
        $rental = $stmt->fetch();
    
        if ($rental) {
            if ($rental['end_time'] === null) {
                // 🚲 Location encore en cours → réincrémenter la station de départ
    
                $start_station_name = $rental['start_station'];
                $bike_id = $rental['id_bike'];
    
                // 🎯 Récupérer id_station depuis le nom
                $stationQuery = $pdo->prepare("SELECT id_station FROM BikeStation WHERE name = :name");
                $stationQuery->execute(['name' => $start_station_name]);
                $station = $stationQuery->fetch();
    
                if ($station) {
                    $station_id = $station['id_station'];
    
                    // 🔁 Réincrémenter la dispo
                    $updateStation = $pdo->prepare("UPDATE BikeStation SET available_bikes = available_bikes + 1 WHERE id_station = :id");
                    $updateStation->execute(['id' => $station_id]);
                }
    
                // 🔧 Remettre le vélo en disponible
                $updateBike = $pdo->prepare("UPDATE Bike SET status = 'Inactive' WHERE id_bike = :bike_id");
                $updateBike->execute(['bike_id' => $bike_id]);
                
            }
    
            // 🗑️ Supprimer la location
            $deleteRental = $pdo->prepare("DELETE FROM BikeRental WHERE id_rental = :id AND id_user = :user");
            $deleteRental->execute(['id' => $rental_id, 'user' => $id_user]);
        }
    
        header('Location: Rentals.php');
        exit;
    }
    

    if (isset($_POST['checkout_rental'])) {
        $rental_id = $_POST['rental_id'];
        $feedback = $_POST['feedback'] ?? null;
        $end_time = date('Y-m-d H:i:s');
        $start_station_name = $_POST['start_station'];
        $distance = $_POST['distance']; // Fetch the distance from the form or POST data

    
        // 🔍 Récupérer la location
        $stmt = $pdo->prepare("SELECT * FROM BikeRental WHERE id_rental = :rental_id");
        $stmt->execute(['rental_id' => $rental_id]);
        $rental = $stmt->fetch();
    
        if ($rental) {
            $bike_id = $rental['id_bike'];
            $end_station_id = $rental['end_station'];
    
            // 🔹 Update rental with end time and feedback
            $updateRental = $pdo->prepare("UPDATE BikeRental SET end_time = :end_time, feedback = :feedback WHERE id_rental = :rental_id");
            $updateRental->execute([
                'end_time' => $end_time,
                'feedback' => $feedback,
                'rental_id' => $rental_id
            ]);
    
            // 🔹 Obtenir l’ID de la station de départ à partir de son nom
            $getStartId = $pdo->prepare("SELECT id_station FROM BikeStation WHERE name = :name");
            $getStartId->execute(['name' => $start_station_name]);
            $start_station = $getStartId->fetch();
    
            if ($start_station) {
                $start_station_id = $start_station['id_station'];
    
                // 🔻 Décrémenter total_bikes dans la station de départ
                $decreaseStart = $pdo->prepare("UPDATE BikeStation SET total_bikes = total_bikes - 1 WHERE id_station = :id");
                $decreaseStart->execute(['id' => $start_station_id]);
            }
    
            // 🔺 Incrémenter total et available_bikes dans la station d’arrivée
            $increaseEnd = $pdo->prepare("
                UPDATE BikeStation 
                SET total_bikes = total_bikes + 1, available_bikes = available_bikes + 1 
                WHERE id_station = :id
            ");
            $increaseEnd->execute(['id' => $end_station_id]);
    
            // 🚲 Mettre à jour le vélo (statut + station actuelle)
            $updateBike = $pdo->prepare("UPDATE Bike SET total_kilometers =  total_kilometers + :distance , status = 'Inactive', station_id = :station_id WHERE id_bike = :bike_id");
            $updateBike->execute([
                'distance' => $distance,
                'station_id' => $end_station_id,
                'bike_id' => $bike_id
            ]);
    
            header('Location: Rentals.php');
            exit;
        } else {
            echo "Location non trouvée.";
        }
    }
    if (isset($_POST['update_end_station'])) {
        $rentalId = $_POST['rental_id'];
    $newEndStationId = $_POST['new_end_station'];

    // Mettre à jour la base de données
    $update = $pdo->prepare("
        UPDATE bikerental 
        SET end_station = :new_station 
        WHERE id_rental = :rental_id
    ");
    $update->execute([
        ':new_station' => $newEndStationId,
        ':rental_id' => $rentalId
    ]);

       
    }
    

    
}

// 🛒 Fetch Rentals
$sql = "
    SELECT 
        r.id_rental,
        r.id_bike,
        r.start_time,
        r.end_time,
        r.feedback,
        r.start_station,
        s.name AS end_station_name
    FROM 
        BikeRental r
    JOIN 
        BikeStation s ON r.end_station = s.id_station
    WHERE 
        r.id_user = :id_user
    ORDER BY 
        r.start_time DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_user' => $id_user]);
$rentals = $stmt->fetchAll();

?>

<!-- 🌈 CSS stylé -->
<style>
    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-top: 30px;
    }
    th, td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    thead {
        background-color: #3f51b5;
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    .btn {
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    .delete-btn {
        background-color: #e53935;
    }
    .checkout-btn {
        background-color: #43a047;
    }
    .feedback-form textarea {
        width: 90%;
        height: 60px;
        margin: 10px 0;
        resize: vertical;
    }
    .dropdown {
  position: relative;
  display: inline-block;
}

.action-menu {
  background-color: #3f51b5;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 120px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 1;
  right: 0;
  border-radius: 8px;
  overflow: hidden;
}

.dropdown-content form {
  margin: 0;
}

.dropdown-content .dropdown-item {
  color: black;
  padding: 10px 15px;
  text-decoration: none;
  display: block;
  width: 100%;
  border: none;
  background: none;
  text-align: left;
  cursor: pointer;
}

.dropdown-content .dropdown-item:hover {
  background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
  display: block;
}

</style>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Logistica - Shipping Company Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">


  

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">

    





</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">Logistica</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="price.html" class="dropdown-item">Pricing Plan</a>
                        <a href="feature.html" class="dropdown-item">Features</a>
                        <a href="Stations.php" class="dropdown-item active">Free Quote</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+012 345 6789</h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Rentals</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-white active" aria-current="page">Rentals</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Stations Start -->
    

    <h2 style="text-align:center;">🚲 Mes locations</h2>

<!-- Search and Sort Controls -->
<div class="w-100 d-flex justify-content-center mb-4">
  <div class="d-flex align-items-center">
    <label for="rental-search" class="me-2 mb-0 small">Search Bike:</label>
    <input type="text" id="rental-search" class="form-control form-control-sm me-3" placeholder="Search by Bike ID" onkeyup="filterRentals()" style="width: 200px;">

    <label for="sort-rentals" class="me-2 mb-0 small">Sort by:</label>
    <select id="sort-rentals" class="form-select form-select-sm" onchange="sortRentals()" style="width: 180px;">
      <option value="none">No Sorting</option>
      <option value="recent">Recent Ended First</option>
      <option value="ongoing">Still Ongoing First</option>
    </select>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>Vélo</th>
      <th>Date début</th>
      <th>Date fin</th>
      <th>Station Début</th>
      <th>Station Retour</th>
      <th>Feedback</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="rental-container">
    <?php foreach ($rentals as $rental): ?>
      <tr class="rental-row" data-bike-id="<?= strtolower($rental['id_bike']) ?>" data-end-time="<?= $rental['end_time'] ? strtotime($rental['end_time']) : 0 ?>">
        <td><?= htmlspecialchars($rental['id_bike']) ?></td>
        <td><?= htmlspecialchars($rental['start_time']) ?></td>
        <td><?= $rental['end_time'] ?? 'En cours...' ?></td>
        <td><?= htmlspecialchars($rental['start_station']) ?></td>
        <td><?= htmlspecialchars($rental['end_station_name']) ?></td>
        <td><?= htmlspecialchars($rental['feedback'] ?? '-') ?></td>
        <td>
          <!-- Actions dropdown and forms exactly as you already have -->
          <div class="dropdown">
            <button class="btn action-menu">⚙️ Actions</button>
            <div class="dropdown-content">
              <?php if (!$rental['end_time']): ?>
                <button type="button" class="dropdown-item show-edit-form-btn" data-rental-id="<?= $rental['id_rental'] ?>">✏️ Modifier la destination</button>
                <button type="button" 
        class="dropdown-item show-track-map-btn" 
        data-start-station="<?= htmlspecialchars($rental['start_station']) ?>" 
        data-end-station="<?= htmlspecialchars($rental['end_station_name']) ?>">
  🗺️ Suivre le trajet
</button>

                <button type="button" class="dropdown-item show-feedback-btn" data-rental-id="<?= $rental['id_rental'] ?>">✔️ Terminer</button>
              <?php endif; ?>
              <form method="POST">
                <input type="hidden" name="rental_id" value="<?= $rental['id_rental'] ?>">
                <button type="submit" name="delete_rental" class="dropdown-item">🗑️ Supprimer</button>
              </form>
            </div>
          </div>

          <?php if (!$rental['end_time']): ?>
            <div class="feedback-popup" id="feedback-form-<?= $rental['id_rental'] ?>" style="display: none;">
              <form method="POST" class="feedback-form">
                <input type="hidden" name="rental_id" value="<?= $rental['id_rental'] ?>">
                <input type="hidden" name="start_station" value="<?= htmlspecialchars($rental['start_station']) ?>">
                <textarea name="feedback" placeholder="Ajoutez un retour..."></textarea>
                <input type="hidden" name="distance" class="distance-input" value="">
                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 5px;">
                  <button type="submit" name="checkout_rental" class="btn checkout-btn">✔️ Terminer</button>
                  <button type="button" class="btn cancel-btn" data-rental-id="<?= $rental['id_rental'] ?>">❌ Annuler</button>
                </div>
              </form>
            </div>
          <?php endif; ?>

          <div class="edit-form-popup" id="edit-form-<?= $rental['id_rental'] ?>" style="display: none;">
            <form method="POST">
              <input type="hidden" name="rental_id" value="<?= $rental['id_rental'] ?>">
              <label for="new_end_station">Nouvelle station de retour :</label>
              <select name="new_end_station" required>
                <?php
                  $stations = $pdo->query("SELECT id_station, name FROM BikeStation")->fetchAll();
                  foreach ($stations as $station) {
                    echo "<option value='{$station['id_station']}'>{$station['name']}</option>";
                  }
                ?>
              </select>
              <div style="display: flex; gap: 10px; justify-content: center; margin-top: 10px;">
                <button type="submit" name="update_end_station" class="btn">✅ Confirmer</button>
                <button type="button" class="btn cancel-edit-btn" data-rental-id="<?= $rental['id_rental'] ?>">❌ Annuler</button>
              </div>
            </form>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>



    <!-- Quote End -->
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="">Air Freight</a>
                    <a class="btn btn-link" href="">Sea Freight</a>
                    <a class="btn btn-link" href="">Road Freight</a>
                    <a class="btn btn-link" href="">Logistic Solutions</a>
                    <a class="btn btn-link" href="">Industry solutions</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<!-- Leaflet Routing Machine JS -->
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>



    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>



    <!-- MAP MODAL -->
<!-- Modal for displaying the map -->
<div id="track-map-modal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.6); z-index:1000; justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; border-radius:8px; width:90%; height:90%; max-width:1000px; position:relative; display: flex; flex-direction: column;">
    <h4 style="text-align:center; margin-bottom: 10px;">🗺️ Track Route</h4>
    <div id="track-map" style="flex: 1 1 auto; width: 100%;"></div>
    <div id="route-info" style="margin-top:10px; text-align:center; font-size: 18px; font-weight: bold;"></div>
    <button id="close-map-btn" class="btn btn-danger" style="position:absolute; top:10px; right:10px;">✖️</button>
  </div>
</div>


</body>
<script>
  // Quand on clique sur "Terminer"
 // Afficher le formulaire de modification de la station de retour
// Afficher le formulaire de modification de la station de retour
document.querySelectorAll('.show-edit-form-btn').forEach(button => {
    button.addEventListener('click', function () {
        const rentalId = this.getAttribute('data-rental-id');
        const form = document.getElementById(`edit-form-${rentalId}`);
        if (form) form.style.display = 'block';
    });
});

// Masquer le formulaire de modification de la station de retour
document.querySelectorAll('.cancel-edit-btn').forEach(button => {
    button.addEventListener('click', function () {
        const rentalId = this.getAttribute('data-rental-id');
        const form = document.getElementById(`edit-form-${rentalId}`);
        if (form) form.style.display = 'none';
    });
});

// Afficher le formulaire de feedback lorsque le bouton 'Terminer' est cliqué
document.querySelectorAll('.show-feedback-btn').forEach(button => {
    button.addEventListener('click', function () {
        const rentalId = this.getAttribute('data-rental-id');
        const form = document.getElementById(`feedback-form-${rentalId}`);
        if (form) form.style.display = 'block';
    });
});

// Masquer le formulaire de feedback lorsque le bouton 'Annuler' est cliqué
document.querySelectorAll('.cancel-feedback-btn').forEach(button => {
    button.addEventListener('click', function () {
        const rentalId = this.getAttribute('data-rental-id');
        const form = document.getElementById(`feedback-form-${rentalId}`);
        if (form) form.style.display = 'none';
    });
});

</script>
<script>
  // Affiche le formulaire de feedback
  document.querySelectorAll('.show-feedback-btn').forEach(button => {
    button.addEventListener('click', function () {
      const rentalId = this.getAttribute('data-rental-id');
      const form = document.getElementById(`feedback-form-${rentalId}`);
      if (form) form.style.display = 'block';
    });
  });

  // Ferme le formulaire de feedback
  document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function () {
      const rentalId = this.getAttribute('data-rental-id');
      const form = document.getElementById(`feedback-form-${rentalId}`);
      if (form) form.style.display = 'none';
    });
  });
  // Afficher formulaire de modification
document.querySelectorAll('.show-edit-form-btn').forEach(button => {
  button.addEventListener('click', function () {
    const rentalId = this.getAttribute('data-rental-id');
    const form = document.getElementById(`edit-form-${rentalId}`);
    if (form) form.style.display = 'block';
  });
});

// Cacher formulaire de modification
document.querySelectorAll('.cancel-edit-btn').forEach(button => {
  button.addEventListener('click', function () {
    const rentalId = this.getAttribute('data-rental-id');
    const form = document.getElementById(`edit-form-${rentalId}`);
    if (form) form.style.display = 'none';
  });
});

</script>

<script> 
  // Array of important locations you want to track
const weatherLocations = [
  { name: 'Tunis', lat: 36.8065, lng: 10.1815 },
  { name: 'Sousse', lat: 35.8256, lng: 10.6084 },
  { name: 'Sfax', lat: 34.7406, lng: 10.7603 },
  { name: 'Gabes', lat: 33.8815, lng: 10.0982 },
  { name: 'Bizerte', lat: 37.2744, lng: 9.8739 },
  { name: 'Ariana', lat: 36.8664, lng: 10.1415 },
  { name: 'Manouba', lat: 36.7833, lng: 9.9667 },
  { name: 'Ben Arous', lat: 36.7373, lng: 10.1855 },
  { name: 'Kairouan', lat: 35.6752, lng: 9.8760 },
  { name: 'Kasserine', lat: 35.1667, lng: 8.8333 },
  { name: 'Sidi Bouzid', lat: 35.0333, lng: 9.4667 },
  { name: 'Siliana', lat: 36.0667, lng: 9.3833 },
  { name: 'Tozeur', lat: 33.9180, lng: 8.1267 },
  { name: 'Gafsa', lat: 34.4250, lng: 8.7760 },
  { name: 'Tataouine', lat: 32.9333, lng: 10.4667 },
  { name: 'Medenine', lat: 33.3717, lng: 10.5030 },
  { name: 'Zaghouan', lat: 36.3992, lng: 10.1481 },
  { name: 'Beja', lat: 36.7333, lng: 9.1833 },
  { name: 'Nabeul', lat: 36.4565, lng: 10.7341 },
  { name: 'Monastir', lat: 35.7769, lng: 10.8250 },
  { name: 'Mahdia', lat: 35.5101, lng: 11.0626 },
  { name: 'Jendouba', lat: 36.5000, lng: 8.7833 },
  { name: 'Le Kef', lat: 36.1833, lng: 8.7125 },
  { name: 'El Kef', lat: 36.1833, lng: 8.7125 },
  { name: 'Tunis', lat: 36.8065, lng: 10.1815 }
];


// Function to fetch and display weather for all locations
function displayWeatherOnMap() {
  weatherLocations.forEach(location => {
    fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${location.lat}&lon=${location.lng}&units=metric&appid=8f3194baf68b70b1535f1d0818f3d3bf`)
      .then(response => response.json())
      .then(weatherData => {
        const weather = weatherData.weather[0].main; // Example: Clear, Rain, Clouds
        const windSpeed = weatherData.wind.speed; // m/s

        console.log(`${location.name} weather: ${weather}`); // Log weather condition

        let weatherEmoji = '🌤️'; // Default to "partly cloudy"

        // Determine emoji based on weather condition
        if (weather.includes('Clear')) {
          weatherEmoji = '☀️'; // Sunny
        } else if (weather.includes('Clouds')) {
          weatherEmoji = '☁️'; // Cloudy
        } else if (weather.includes('Rain')) {
          weatherEmoji = '🌧️'; // Rainy
        } else if (weather.includes('Snow')) {
          weatherEmoji = '❄️'; // Snowy
        }

        const weatherMarker = L.marker([location.lat, location.lng], {
          icon: L.divIcon({
            className: 'weather-icon',
            html: `<span style="font-size: 24px;">${weatherEmoji}</span>`, // Emoji in marker
            iconSize: [30, 30] // Size of the icon
          })
        }).addTo(trackMap);

        // Optionally, add a popup with weather info
        weatherMarker.bindPopup(`
          ${location.name} <br>
          🌬️ Wind Speed: ${windSpeed} m/s
        `);
      })
      .catch(error => {
        console.error(`Erreur météo pour ${location.name}:`, error);
      });
  });
}

// ➡️ Call this function after map initialization

</script>


<script>
    function filterRentals() {
  var input = document.getElementById('rental-search').value.toLowerCase();
  var rows = document.querySelectorAll('.rental-row');

  rows.forEach(function(row) {
    var bikeId = row.getAttribute('data-bike-id');
    if (bikeId.includes(input)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

function sortRentals() {
  var sortType = document.getElementById('sort-rentals').value;
  var container = document.getElementById('rental-container');
  var rows = Array.from(document.querySelectorAll('.rental-row'));

  rows.sort(function(a, b) {
    var endA = parseInt(a.getAttribute('data-end-time'));
    var endB = parseInt(b.getAttribute('data-end-time'));

    if (sortType === 'recent') {
      // Rentals that ended recently first
      return endB - endA;
    } else if (sortType === 'ongoing') {
      // Rentals still ongoing first (those with end_time = 0)
      if (endA === 0 && endB !== 0) return -1;
      if (endB === 0 && endA !== 0) return 1;
      return 0;
    } else {
      return 0; // No sorting
    }
  });

  rows.forEach(function(row) {
    container.appendChild(row);
  });
}

let trackMap;
let startMarker, endMarker;
let routingControl;

// When "Track Route" button is clicked
document.querySelectorAll('.show-track-map-btn').forEach(button => {
  button.addEventListener('click', function () {
    const startStation = this.getAttribute('data-start-station');
    const endStation = this.getAttribute('data-end-station');

    document.getElementById('track-map-modal').style.display = 'flex';

    setTimeout(() => {
      if (!trackMap) {
        trackMap = L.map('track-map').setView([36.8065, 10.1815], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
        }).addTo(trackMap);
        displayWeatherOnMap();
      } else {
        trackMap.invalidateSize();
      }

      fetch(`get_stations.php?start=${encodeURIComponent(startStation)}&end=${encodeURIComponent(endStation)}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            if (startMarker) trackMap.removeLayer(startMarker);
            if (endMarker) trackMap.removeLayer(endMarker);
            if (routingControl) trackMap.removeControl(routingControl);

            startMarker = L.marker([data.start.lat, data.start.lng])
              .addTo(trackMap)
              .bindPopup(`🚏 Départ : ${startStation}`)
              .openPopup();

            endMarker = L.marker([data.end.lat, data.end.lng])
              .addTo(trackMap)
              .bindPopup(`🏁 Arrivée : ${endStation}`);

            routingControl = L.Routing.control({
              waypoints: [
                L.latLng(data.start.lat, data.start.lng),
                L.latLng(data.end.lat, data.end.lng)
              ],
              routeWhileDragging: false,
              show: false,
              addWaypoints: false,
              draggableWaypoints: false,
              fitSelectedRoutes: true,
              createMarker: () => null
            }).addTo(trackMap);

            routingControl.on('routesfound', function (e) {
              const route = e.routes[0];
              const distanceInMeters = route.summary.totalDistance;
              const timeInSeconds = route.summary.totalTime;

              const distanceInKm = (distanceInMeters / 1000).toFixed(2);
              const distance = (distanceInMeters / 1000).toFixed(2); // calculate in km
              document.querySelector('.distance-input').value = distance;



              const timeInMinutes = Math.round(timeInSeconds / 60);

              // Remove the default blue line
              trackMap.eachLayer(function (layer) {
                if (layer instanceof L.Polyline && !(layer instanceof L.Polygon)) {
                  trackMap.removeLayer(layer);
                }
              });

              // Draw custom colored segments
              const coordinates = route.coordinates;
              for (let i = 0; i < coordinates.length - 1; i++) {
                const pointA = coordinates[i];
                const pointB = coordinates[i + 1];

                // Simulate traffic condition (you can replace this later with real traffic data)
                const randomTraffic = Math.random();
                let color = 'green'; // Default = low traffic
                if (randomTraffic < 0.6) {
                  color = 'green'; // 60% clear
                } else if (randomTraffic < 0.85) {
                  color = 'orange'; // 25% medium traffic
                } else {
                  color = 'red'; // 15% heavy traffic
                }

                L.polyline([ [pointA.lat, pointA.lng], [pointB.lat, pointB.lng] ], {
                  color: color,
                  weight: 6,
                  opacity: 0.8
                }).addTo(trackMap);
              }

              // Fetch weather based on start location
              fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${data.start.lat}&lon=${data.start.lng}&units=metric&appid=8f3194baf68b70b1535f1d0818f3d3bf`)
                .then(response => response.json())
                .then(weatherData => {
                  const windSpeed = weatherData.wind.speed;
                  let adjustedTime = timeInMinutes;
                  if (windSpeed > 5) {
                    adjustedTime = Math.round(timeInMinutes * 1.1);
                  }

                  document.getElementById('route-info').innerHTML = `
                    🚴 Distance : ${distanceInKm} km <br>
                    ⏱️ Temps estimé : ${adjustedTime} minutes <br>
                    🌬️ Vent : ${windSpeed} m/s
                  `;
                })
                .catch(error => {
                  console.error('Erreur météo :', error);
                  document.getElementById('route-info').innerHTML = `
                    🚴 Distance : ${distanceInKm} km <br>
                    ⏱️ Temps estimé : ${timeInMinutes} minutes
                  `;
                });
            });

            const group = new L.featureGroup([startMarker, endMarker]);
            trackMap.fitBounds(group.getBounds().pad(0.2));

          } else {
            alert('Erreur : Impossible de trouver les stations.');
          }
        })
        .catch(error => {
          console.error('Erreur de récupération des stations :', error);
          alert('Erreur de communication avec le serveur.');
        });
    }, 200);
  });
});

// Close the map modal
document.getElementById('close-map-btn').addEventListener('click', function () {
  document.getElementById('track-map-modal').style.display = 'none';
});



</script>



</html>