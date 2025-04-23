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
            $updateBike = $pdo->prepare("UPDATE Bike SET status = 'Inactive', station_id = :station_id WHERE id_bike = :bike_id");
            $updateBike->execute([
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
















       /* $rental_id = $_POST['rental_id'];
        $new_end_station = $_POST['new_end_station'];
    
        // Mise à jour de la station de retour dans la location
        $updateRental = $pdo->prepare("UPDATE BikeRental SET end_station = :new_end_station WHERE id_rental = :rental_id");
        $updateResult = $updateRental->execute([
            'new_end_station' => $new_end_station,
            'rental_id' => $rental_id
        ]);
    
        if ($updateResult) {
            echo "La station de retour a été mise à jour avec succès dans la base de données.<br>";
        } else {
            echo "Erreur lors de la mise à jour de la station de retour dans la base de données.<br>";
        }
    
        // Décrémenter l'ancienne station de retour (si elle est différente de la nouvelle)
        $stmt = $pdo->prepare("SELECT end_station FROM BikeRental WHERE id_rental = :rental_id");
        $stmt->execute(['rental_id' => $rental_id]);
        $rental = $stmt->fetch();
    
        if ($rental && $rental['end_station'] != $new_end_station) {
            $old_station_id = $rental['end_station'];
            
            // Décrémenter l'ancienne station
            $decreaseOldStation = $pdo->prepare("UPDATE BikeStation SET total_bikes = total_bikes - 1, available_bikes = available_bikes - 1 WHERE id_station = :old_station_id");
            if ($decreaseOldStation->execute(['old_station_id' => $old_station_id])) {
                echo "Ancienne station décrémentée.<br>";
            } else {
                echo "Erreur lors de la décrémentation de l'ancienne station.<br>";
            }
    
            // Incrémenter la nouvelle station
            $increaseNewStation = $pdo->prepare("UPDATE BikeStation SET total_bikes = total_bikes + 1, available_bikes = available_bikes + 1 WHERE id_station = :new_end_station");
            if ($increaseNewStation->execute(['new_end_station' => $new_end_station])) {
                echo "Nouvelle station incrémentée.<br>";
            } else {
                echo "Erreur lors de l'incrémentation de la nouvelle station.<br>";
            }
        }
    
        // Rediriger après la modification
        header('Location: Rentals.php');
        exit;*/ 
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
    <tbody>
        <?php foreach ($rentals as $rental): ?>
            <tr>
                <td><?= htmlspecialchars($rental['id_bike']) ?></td>
                <td><?= htmlspecialchars($rental['start_time']) ?></td>
                <td><?= $rental['end_time'] ?? 'En cours...' ?></td>
                <td><?= htmlspecialchars($rental['start_station']) ?></td>
                <td><?= htmlspecialchars($rental['end_station_name']) ?></td>
                <td><?= htmlspecialchars($rental['feedback'] ?? '-') ?></td>
                <td>
  <div class="dropdown">
    <button class="btn action-menu">⚙️ Actions</button>
    <div class="dropdown-content">
      <?php if (!$rental['end_time']): ?>
        <!-- ✏️ Modifier la station de retour -->
        <button type="button" class="dropdown-item show-edit-form-btn" data-rental-id="<?= $rental['id_rental'] ?>">✏️ Modifier la destination</button>

        <!-- ✔️ Terminer (affiche le formulaire de feedback) -->
        <button type="button" class="dropdown-item show-feedback-btn" data-rental-id="<?= $rental['id_rental'] ?>">✔️ Terminer</button>
      <?php endif; ?>

      <!-- 🗑️ Supprimer -->
      <form method="POST">
        <input type="hidden" name="rental_id" value="<?= $rental['id_rental'] ?>">
        <button type="submit" name="delete_rental" class="dropdown-item">🗑️ Supprimer</button>
      </form>
    </div>
  </div>

  <!-- 🔒 Formulaire de feedback caché -->
  <?php if (!$rental['end_time']): ?>
    <div class="feedback-popup" id="feedback-form-<?= $rental['id_rental'] ?>" style="display: none;">
      <form method="POST" class="feedback-form">
        <input type="hidden" name="rental_id" value="<?= $rental['id_rental'] ?>">
        <input type="hidden" name="start_station" value="<?= htmlspecialchars($rental['start_station']) ?>">
        <textarea name="feedback" placeholder="Ajoutez un retour..."></textarea>
        <div style="display: flex; gap: 10px; justify-content: center; margin-top: 5px;">
          <button type="submit" name="checkout_rental" class="btn checkout-btn">✔️ Terminer</button>
          <button type="button" class="btn cancel-btn" data-rental-id="<?= $rental['id_rental'] ?>">❌ Annuler</button>
        </div>
      </form>
    </div>
  <?php endif; ?>
<!-- Formulaire de modification de station de retour -->
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

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>



  

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





</html>