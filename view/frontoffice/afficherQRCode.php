

<?php
session_start();


include '../../model/user.php';
include '../../controller/userC.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) &&  isset($_SESSION['user_username'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];
    $user_username = $_SESSION['user_username'];


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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Logistica - Shipping Company Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

            <!-- cssreservation -->
    <link rel="stylesheet" href="stylereservation.css">


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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
<a href="index.php" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
        <!--<h2 class="mb-2 text-white">Logistica</h2>-->
        <img class="img-fluid" src="img/logo.png" alt="" width=250px height=200px >

    </a>
   
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Acceuil</a>
           <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
            <div class="nav-item dropdown">
               <a href="#" class="nav-item nav-link active" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu fade-up m-0">
                    <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                    <a href="frontparking.php" class="dropdown-item">Parking</a>
                    <a href="Stations.php" class="dropdown-item">Velos et Stations</a>
                    <a href="ReservationBorne.php" class="dropdown-item active">Recharge Electrique</a>
                    
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
        <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 20 265 186</h4>
    </div>
</nav>
<!-- Navbar End -->



    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Services</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Borne electrique</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Page Header End -->

      <style>

.center-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
    box-sizing: border-box;
    background-color: #f5f5f5;
}

img {
    border: 2px solid #333;
    background-color: #fff;
    width: 256px;
    height: 256px;
    padding: 20px;
}

h2, p, .qr-text {
    text-align: center;
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    max-width: 80%;
    margin: 10px 0;
}

h2 {
    color: #2c3e50;
    padding: 10px;
}

p {
    color: #555;
    font-size: 16px;
}

.qr-text {
    font-weight: bold;
    color: #000;
    word-break: break-word;
    padding: 10px;
}

    </style>

    <?php
$id_reservation = $_GET['id_reservation'] ?? null;

if (!$id_reservation) {
    echo 'ID de réservation manquant.';
    exit;
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
    $stmt = $pdo->prepare("SELECT nomClient, emailClient, id_borne FROM reservationborne WHERE id_reservation = ?");
    $stmt->execute([$id_reservation]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}

if (!$reservation) {
    echo 'Réservation introuvable.';
    exit;
}

$qrText = "Nom: " . $reservation['nomClient'] . "\n" .
          "Email: " . $reservation['emailClient'] . "\n" .
          "Borne ID: " . $reservation['id_borne'];
?>

<div class="center-container">
    <h2>Votre QR Code personnalisé</h2>
    <img src="qr_image.php?id_reservation=<?= urlencode($id_reservation) ?>" alt="QR Code">
    <p>📱 Scannez ce QR Code avec l'appareil photo de votre téléphone</p>
    <p class="qr-text"><?= nl2br(htmlspecialchars($qrText)) ?></p>
</div>





 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Esprit Ariana Soghra</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+216 27 118 673</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>Ride4ALL@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="covoituragefront.php">Covoiturage</a>
                    <a class="btn btn-link" href="frontparking.php">Parking</a>
                    <a class="btn btn-link" href="Stations.php">Velos et Stations</a>
                    <a class="btn btn-link" href="ReservationBorne.php">Borne Electrique</a>
                </div>
                <div class="col-lg-6 col-md-12 d-flex align-items-center">

                <img class="img-fluid" src="img/equipe.JPEG " alt="" width=5000px height=1000px >
                </div>

            </div>

        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Ride4ALL</a>, All Right Reserved.
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
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>





</body>

</html>