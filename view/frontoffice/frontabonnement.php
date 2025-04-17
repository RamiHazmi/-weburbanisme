<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';

$conn = config::getConnexion();

$sql = "SELECT a.*, p.nom_parking, u.username 
        FROM abonnement a
        JOIN parking p ON a.id_parking = p.id_parking
        JOIN user u ON a.id_user = u.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$abonnements = $stmt->fetchAll();
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
        <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">Logistica</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Acceuil</a>
                <a href="about.html" class="nav-item nav-link active"> A propos</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="price.html" class="dropdown-item">Recharge Electrique</a>
                        <a href="feature.html" class="dropdown-item">Parking</a>
                        <a href="quote.html" class="dropdown-item">Covoiturage</a>
                        <a href="team.html" class="dropdown-item">Vélos</a>
                         
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 95 023 331</h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Parking</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Acceuil</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Parking</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <h2 style="font-family: Arial, sans-serif;">Liste des Abonnements</h2>
<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
    <thead>
        <tr style="background-color: #2c3e50; color: white;">
            <th style="padding: 12px; border: 1px solid #ddd;">Nom Client</th>
            <th style="padding: 12px; border: 1px solid #ddd;">Parking</th>
            <th style="padding: 12px; border: 1px solid #ddd;">Date Début</th>
            <th style="padding: 12px; border: 1px solid #ddd;">Date Fin</th>
            <th style="padding: 12px; border: 1px solid #ddd;">Places Réservées</th>
            <th style="padding: 12px; border: 1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($abonnements as $abonnement): ?>
            <tr style="background-color: #f9f9f9; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d6eaf8';" onmouseout="this.style.backgroundColor='#f9f9f9';">
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['username']) ?></td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['nom_parking']) ?></td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_debut']) ?></td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_fin']) ?></td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['places_reservees']) ?></td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                    <!-- Exemple de bouton de suppression ou modification -->
                    <form method="POST" action="controller/SupprimerAbonnement.php" style="display: inline;">
                        <input type="hidden" name="id_abonnement" value="<?= $abonnement['id_abonnement'] ?>">
                        <button type="submit" style="padding: 6px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Supprimer</button>
                    </form>
                    <!-- Tu peux ajouter ici un bouton Modifier avec une modale si besoin -->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <!-- Team End -->
        

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
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>