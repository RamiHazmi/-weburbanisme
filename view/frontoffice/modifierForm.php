<?php
require_once __DIR__ . '/../../model/ModelReservation.php';
require_once __DIR__ .'/../../controller/ControllerReservation.php';

$ControllerReservationElectrique = new ControllerReservationElectrique();

// Vérification de l'ID de réservation dans l'URL
$reservationData = null;
if (isset($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation']; // Récupère l'ID depuis l'URL
    // Appel de la méthode pour récupérer les données de réservation
    $reservationData = $ControllerReservationElectrique->recupererReservation($id_reservation);
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["nomClient"]) &&
        isset($_POST["emailClient"]) &&
        isset($_POST["date_reservation"]) &&
        isset($_POST["heure_debut"]) &&
        isset($_POST["heure_fin"]) &&
        isset($_POST["duree_charge"]) &&
        isset($_POST["tarif_estime"]) &&
        isset($_POST["id_borne"]) &&
        isset($_POST["mode_paiement"]) &&
        isset($_POST["pourcentage_charge"])&&
        isset($_POST["qr_code"])

    ) {
        // Création de l'objet de réservation
        $ModelReservationBorne = new ModelReservationBorne(
            $_POST["nomClient"],
            $_POST["emailClient"],
            $_POST["date_reservation"],
            $_POST["heure_debut"],
            $_POST["heure_fin"],
            $_POST["duree_charge"],
            $_POST["tarif_estime"],
            $_POST["id_borne"],
            $_POST["mode_paiement"],
            $_POST["pourcentage_charge"],
            $_POST["qr_code"]

        );

        if ($id_reservation) {
            // Appel à la méthode du contrôleur pour modifier la réservation
            $resultat = $ControllerReservationElectrique->modifierReservation($ModelReservationBorne, $id_reservation);

            // Vérification du résultat
            if ($resultat) {
                // Redirection après la modification
                header("Location: AffichageReservation.php");
                exit;
            } else {
                echo "Erreur lors de la modification.";
            }
        }
    } else {
        echo "Certains champs sont manquants.";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Réservation de Borne</title>
    <link rel="stylesheet" href="Reservation.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

<!--Template type de borne electrique-->
<link href="css/TypeBorneElectrique.css" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- borne Electrique-->
<script src="js/BorneElectrique.js"></script>
<!--Temps Estimé-->
<script src="js/tempsEstime.js"></script>



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
                        <a href="AffichageReservation.php" class="dropdown-item">Affichage de réservation</a>
                        <a href="ReservationBorne.php" class="dropdown-item active">Faire une réservation</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <h5 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+012 345 6789</h5>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header-rechage-electrique py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Recharge Electrique</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Recharge Electrique</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="form-wrapper">
    <h2>Modifier Réservation</h2>
    <form id="formReservation" action="" method="POST">
       <div class="form-group">
    <label>Nom et Prénom :</label>
    <!-- Adding readonly to prevent modification -->
    <input type="text" name="nomClient" id="nomClient" required value="<?= htmlspecialchars($reservationData['nomClient'] ?? '') ?>" readonly>
    <div id="nomClient_error" class="error-message" style="color: red;"></div>
</div>

<!-- Ligne unique pour l'email -->
<div class="form-group">
    <label>Email :</label>
    <!-- Adding readonly to prevent modification -->
    <input type="email" name="emailClient" id="emailClient" required value="<?= htmlspecialchars($reservationData['emailClient'] ?? '') ?>" readonly>
    <div class="error-message" id="emailClient_error" style="color: red;"></div>
</div>

        <!-- Ligne unique pour la date de réservation -->
        <div class="form-group">
            <label>Date de Réservation :</label>
            <input type="date" name="date_reservation" id="date_reservation" required value="<?= htmlspecialchars($reservationData['date_reservation'] ?? '') ?>">
            <div class="error-message" id="date_reservation_error"  style="color: red;"></div>
        </div>

        <!-- Heure de début, heure de fin et durée de charge dans une même ligne -->
        <div class="form-row">
            <div class="form-group">
                <label>Heure de Début :</label>
                <input type="time" name="heure_debut" id="heure_debut" required value="<?= htmlspecialchars($reservationData['heure_debut'] ?? '') ?>">
                <div class="error-message" id="heure_debut_error"  style="color: red;"></div>
            </div>

            <div class="form-group">
                <label>Heure de Fin :</label>
                <input type="time" name="heure_fin" id="heure_fin" required value="<?= htmlspecialchars($reservationData['heure_fin'] ?? '') ?>">
                <div class="error-message" id="heure_fin_error"  style="color: red;"> </div>
            </div>

            <div class="form-group">
                <label>Durée de Charge :</label>
                <input type="text" id="duree_charge" name="duree_charge" readonly value="<?= htmlspecialchars($reservationData['duree_charge'] ?? '') ?>">
                <div id="duree_charge_error" style="color: red;" class="error-message" ></div>
            </div>
        </div>

        <!-- Pourcentage de charge et tarif estimé dans la même ligne -->
        <div class="form-row">
            <div class="form-group">
                <label>Pourcentage de Charge :</label>
                <input type="range" name="pourcentage_charge" id="pourcentage_charge" min="20" max="100" step="20"
                       value="<?= htmlspecialchars($reservationData['pourcentage_charge'] ?? 100) ?>"
                       oninput="outputPourcentage.value = this.value + '%'">
                <output id="outputPourcentage"><?= htmlspecialchars($reservationData['pourcentage_charge'] ?? 100) ?>%</output>
                <div id="pourcentage_charge_error" style="color: red;" class="error-message"></div>
            </div>

            <div class="form-group">
                <label>Tarif Estimé :</label>
                <input type="text" name="tarif_estime" id="tarif_estime" readonly value="<?= htmlspecialchars($reservationData['tarif_estime'] ?? '') ?>">
                <div class="error-message"  id="tarif_estime_error" style="color: red;" > </div>
            </div>
        </div>

        <!-- Mode de paiement dans une ligne unique avec les radios côte à côte -->
        <div class="form-group">
            <label>Mode de Paiement :</label>
            <div class="radio-group">
                <label><input type="radio" name="mode_paiement" value="en_ligne" <?= (isset($reservationData['mode_paiement']) && $reservationData['mode_paiement'] === 'en_ligne') ? 'checked' : '' ?>> En ligne</label>
                <label><input type="radio" name="mode_paiement" value="sur_place" <?= (isset($reservationData['mode_paiement']) && $reservationData['mode_paiement'] === 'sur_place') ? 'checked' : '' ?>> Sur place</label>
            </div>
            <div  class="error-message" id="mode_paiement_error"  style="color: red;"></div>
        </div>

        <input type="hidden" name="id_borne" value="<?= htmlspecialchars($reservationData['id_borne'] ?? '') ?>">

        <button type="submit" class="formeSpecial">Modifier Réservation</button>
    </form>
</div>

<style>
.error-message {
  color: red;
  font-size: 0.85em;
  margin-top: 5px;
  display: none; /* Caché par défaut */
}

.error-message.active::before {
  content: "⚠️ ";
  margin-right: 5px;
}

.shake {
  animation: shake 0.3s ease-in-out;
}

@keyframes shake {
  0% { transform: translateX(0px); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
  100% { transform: translateX(0px); }
}



.input-error {
  border: 2px solid red;
  background-color: #ffe6e6;
}


    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-wrapper {
        max-width: 1000px;
        margin: 40px auto;
        padding: 30px;
        background: #f8f9fa;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #00796b;
    }

    .form-group, .formeSpecial {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="time"],
    select {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        font-size: 15px;
        background: #fff;
    }

    input:focus, select:focus {
        border-color: #00796b;
        box-shadow: 0 0 5px rgba(0,121,107,0.3);
    }

    input[type="range"] {
        accent-color: #00796b;
    }

    output {
        margin-left: 10px;
        font-weight: bold;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .radio-group label {
        font-weight: normal;
    }



    button {
        padding: 12px 20px;
        background-color: #00796b;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
    }

    button:hover {
        background-color: #004d40;
    }

    .formeSpecial {
        grid-column: span 2;
    }
</style>



    <script src="OnlinePayment.js"></script>
    <script src="pourcentage.js"></script>
    <script src="saisieModifier.js"></script>
    <script src="qrCode.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  
<!--stripe-->
<script src="https://js.stripe.com/v3/"></script>
<script src="ButtonPaiement.js"></script>
<script src="stripe.js"></script>
<script src="OnlinePayment.js"></script>



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
                    <h4 class="text-light mb-4">Reservation</h4>
                    <a class="btn btn-link" href="">Reservation Client</a>
                  
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