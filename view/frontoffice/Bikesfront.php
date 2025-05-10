<?php
session_start(); // IMPORTANT : Pour utiliser $_SESSION


include '../../model/user.php';
include '../../controller/userC.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];


    $userC = new userC();
    $user = $userC->getUserByEmail($user_email);
    

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit;
    }
} else {
    echo "<script>
    alert('Vous devez être connecté pour accéder à cette page.');
    window.location.href = 'connexion.php';
    </script>";
    exit;
}

?>
<?php
// Inclure la connexion à la base de données et le modèle BikeController
require_once __DIR__ . '/../../Controller/BikeController.php';
require_once __DIR__ . '/../../Controller/BikeStationController.php';

$bikeStationController = new BikeStationController();

// Récupérer l'ID de la station depuis l'URL
$station_id = isset($_GET['station_id']) ? $_GET['station_id'] : null;

if ($station_id) {
    // Créer un objet de contrôleur de vélos
    $bikeController = new BikeController();

    // Récupérer les vélos associés à cette station
    $bikes = $bikeController->getBikesByStation($station_id);
} else {
    $bikes = [];
}
?>
<?php
// Include necessary files for database connection
require_once __DIR__ . '/../../database.php';
require_once __DIR__ . '/../../Controller/BikeStationController.php'; // Nouveau contrôleur à créer


// Retrieve only the station names from the 'bikestation' table
$sql = "SELECT id_station, name FROM bikestation";
$db = config::getConnexion();
$stations = [];
try {
    $query = $db->query($sql);
    $stations = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch only associative arrays
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>




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
                <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu fade-up m-0">
                        <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                        <a href="frontparking.php" class="dropdown-item">Parking</a>
                        <a href="Stations.php" class="dropdown-item">Velos et Stations</a>
                        <a href="team.html" class="dropdown-item">Recharge Electrique</a>
                        
                    </div>

                </div>
                <a href="user_profile.php" class="nav-item nav-link">
                <i class="fa fa-user text-primary me-3"></i>
                <?php

                if (isset($_SESSION['user_email'])){
                    $user_email = $_SESSION['user_email']; 
                $userC = new userC();
                $user = $userC->getUserByEmail($user_email);
                if ($user && isset($user['username'])) {
                    echo htmlspecialchars($user['username']);
                } else {
                 echo "Profile"; 
    }
} else {
    echo "Profile"; 
}
?>
</a>
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <li><a href="../backoffice/dashboard.php" class="nav-item nav-link ">Dashboard</a></li>
<?php endif; ?>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+012 345 6789</h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Bikes</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Stations</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Bike </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Stations Start -->
   
<!-- Search and Sort Controls -->
<div class="w-100 d-flex justify-content-center mb-4">
    <div class="d-flex align-items-center">
        <label for="bike-search" class="me-2 mb-0 small">Search Bike:</label>
        <input type="text" id="bike-search" class="form-control form-control-sm me-3" placeholder="Search by ID" onkeyup="filterBikes()" style="width: 200px;">
        
        <label for="sort-status" class="me-2 mb-0 small">Sort by Status:</label>
        <select id="sort-status" class="form-select form-select-sm" onchange="sortBikes()" style="width: 150px;">
            <option value="all">All</option>
            <option value="active">Active First</option>
            <option value="inactive">Inactive First</option>
        </select>
    </div>
</div>

<!-- Bike Cards -->
<div class="container d-flex flex-wrap justify-content-center mt-3" id="bike-container">
    <?php foreach ($bikes as $bike): ?>
        <div class="flip-card bike-card" data-bike-id="<?= strtolower($bike['id_bike']) ?>" data-status="<?= strtolower($bike['status']) ?>">
            <div class="flip-card-inner">
                <div class="flip-card-front"></div>
                <div class="flip-card-back">
                    <h5 class="bike-id">Bike #<?= htmlspecialchars($bike['id_bike']) ?></h5>
                    <p class="bike-km"><?= htmlspecialchars($bike['total_kilometers']) ?> km</p>
                    <span class="status-badge <?= $bike['status'] === 'Active' ? 'status-active' : 'status-inactive' ?>">
                        <?= $bike['status'] ?>
                    </span>

                    <?php if ($bike['status'] === 'Inactive'): ?>
                        <a href="#" 
                            class="btn-details rent-btn" 
                            data-bike-id="<?= $bike['id_bike'] ?>" 
                            data-station-id="<?= $bike['station_id'] ?>" 
                            data-user-id="<?= $_SESSION['user_id'] ?>">
                            Rent
                            </a>

                    <?php else: ?>
                        <p></p>
                        <span class="error-message" style="color: red; font-weight: bold;">This bike is already rented.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>






















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


    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
    <style>
    .flip-card {
    background-color: transparent;
    width: 320px;
    height: 220px;
    perspective: 1200px;
    margin: 1.5rem;
    border-radius: 20px;
    transition: transform 0.3s ease-in-out;
}

.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
    transition: transform 0.8s ease;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
}

.flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 20px;
    backface-visibility: hidden;
    overflow: hidden;
}

.flip-card-front {
    background-image: url('assets/img/veloG.png');
    background-size: cover;
    background-position: center;
    filter: brightness(0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.4s ease;
}

.flip-card:hover .flip-card-front {
    transform: scale(1.05);
}

.flip-card-back {
    background: linear-gradient(135deg, #ffffff, #f1f1f1);
    color: #16875f;
    transform: rotateY(180deg);
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    animation: fadeIn 1s ease-in-out;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.06);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 10px;
    animation: pulse 2s infinite;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}
.status-rent {
    background-color: #e53935; /* Red for active */
    color: white;
}
.status-active {
    background-color: #e53935; /* Red for active */
    color: white;
}

.status-inactive {
    background-color: #43a047; /* Green for inactive */
    color: white;
}


@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.5); }
    70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

.btn-details {
    margin-top: 15px;
    background-color: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: #16875f;
    border: 2px solid #16875f;
    padding: 8px 16px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-details:hover {
    background-color: #16875f;
    color: white;
}
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Rubik:wght@500&display=swap');

.bike-id {
    font-family: 'Orbitron', sans-serif;
    font-size: 1.4rem;
    color: #1e3d59;
    margin-bottom: 0.5rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.bike-km {
    font-family: 'Rubik', sans-serif;
    font-size: 1.2rem;
    color: #3a665c;
    margin-bottom: 1rem;
}






.modal {
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
 
  height: 100vh;
  width: 100vw;
  background-color: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;   
  justify-content: center;  
}

.modal-content {
  background-color: #ffffff;
  border-radius: 15px;
  padding: 30px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  animation: fadeIn 0.3s ease-in-out;
  position: relative;
}


@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-content h3 {
  margin-bottom: 20px;
  color: #333;
  font-size: 24px;
  text-align: center;
}

.close {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 22px;
  color: #888;
  cursor: pointer;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-weight: bold;
  color: #444;
  margin-bottom: 5px;
}

.info-value {
  font-size: 16px;
  color: #333;
  background-color: #f4f4f4;
  padding: 8px 12px;
  border-radius: 6px;
  display: inline-block;
}

select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
  font-size: 16px;
}

.btn-confirm {
  background-color: #3f51b5;
  color: white;
  border: none;
  padding: 12px 25px;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease;
}

.btn-confirm:hover {
  background-color: #303f9f;
}



</style>
<!-- Modal Overlay -->
<div id="rentModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>🚲 Confirmer votre location</h3>

    <form action="rentBike.php" method="POST">
      <input type="hidden" name="user_id" id="modal-user-id">
      <input type="hidden" name="bike_id" id="modal-bike-id">

      <div class="form-group">
        <label>🔢 ID du vélo :</label>
        <span id="display-bike-id" class="info-value"></span>
      </div>

      <div class="form-group">
        <label>📍 Station de départ :</label>
        <span id="display-station-id" class="info-value"></span>
      </div>

      <div class="form-group">
        <label>🎯 Choisissez la station de destination :</label>
        <select name="end_station" required>
          <?php foreach ($stations as $station): ?>
            <option value="<?= $station['id_station'] ?>">
              <?= htmlspecialchars($station['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>⏰ Heure de début :</label>
        <span id="current-time" class="info-value"></span>
        <input type="hidden" name="start_time" id="hidden-time">
      </div>

      <button type="submit" class="btn-confirm">✅ Confirmer la location</button>
    </form>
  </div>
</div>


  

</body>
<script>
  document.querySelectorAll('.rent-btn').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      // Get values
      const bikeId = this.getAttribute('data-bike-id');
      const stationId = this.getAttribute('data-station-id');
      const userId = this.getAttribute('data-user-id');

      // Fill modal fields
      document.getElementById('modal-bike-id').value = bikeId;
      document.getElementById('modal-user-id').value = userId;
      document.getElementById('display-bike-id').innerText = bikeId;

      fetch(`get_station_name.php?station_id=${stationId}`)
        .then(response => response.json())
        .then(data => {
        if (data.name) {
            document.getElementById('display-station-id').innerText = data.name;
        } else {
            document.getElementById('display-station-id').innerText = "Station name not found";
        }
        })
        .catch(error => console.error('Error:', error));


      // Get current time
      const now = new Date().toISOString().slice(0, 19).replace("T", " ");
      document.getElementById('current-time').innerText = now;
      document.getElementById('hidden-time').value = now;

      // Show modal
      document.getElementById('rentModal').style.display = 'block';
    });
  });

  // Close modal
  document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('rentModal').style.display = 'none';
  });

  // Optional: close modal when clicking outside
  window.onclick = function (event) {
    const modal = document.getElementById('rentModal');
    if (event.target === modal) {
      modal.style.display = "none";
    }
  }
</script>

<script>
function filterBikes() {
    var input = document.getElementById('bike-search').value.toLowerCase();
    var cards = document.querySelectorAll('.bike-card');
    
    cards.forEach(function(card) {
        var bikeId = card.getAttribute('data-bike-id');
        if (bikeId.includes(input)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

function sortBikes() {
    var sortType = document.getElementById('sort-status').value;
    var container = document.getElementById('bike-container');
    var cards = Array.from(document.querySelectorAll('.bike-card'));

    cards.sort(function(a, b) {
        var statusA = a.getAttribute('data-status');
        var statusB = b.getAttribute('data-status');

        if (sortType === 'active') {
            return (statusA === 'active' ? -1 : 1) - (statusB === 'active' ? -1 : 1);
        } else if (sortType === 'inactive') {
            return (statusA === 'inactive' ? -1 : 1) - (statusB === 'inactive' ? -1 : 1);
        } else {
            return 0; // No sorting
        }
    });

    // Re-append cards in new order
    cards.forEach(function(card) {
        container.appendChild(card);
    });
}
</script>





</html>
