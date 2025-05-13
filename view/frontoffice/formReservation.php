<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../model/ModelReservation.php';
require_once __DIR__ .'/../../controller/ControllerReservation.php';
// 🔌 Connexion à la base de données
require_once __DIR__ . '/../../database.php';

$ControllerReservationElectrique = new ControllerReservationElectrique();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $champs = [
        "nomClient", "emailClient", "date_reservation",
        "heure_debut", "heure_fin", "duree_charge", "tarif_estime", "id_borne", "mode_paiement", "pourcentage_charge", "qr_code"
    ];

    $donnees_incompletes = false;
    $champ_incomplet = '';
    foreach ($champs as $champ) {
        if (empty($_POST[$champ])) {
            $donnees_incompletes = true;
            $champ_incomplet = $champ;
            break;
        }
    }

    if (!$donnees_incompletes) {
        $ModelReservationBorne = new ModelReservationBorne(
            $_SESSION['user_username'],
            $_SESSION['user_email'],
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

        $resultat = $ControllerReservationElectrique->ajouterReservation($ModelReservationBorne);

        if ($resultat) {
            // ✔ Redirection selon mode de paiement
            if ($_POST["mode_paiement"] === "sur_place") {
                $_SESSION['client_info'] = [
                    'nom' => $_POST["nomClient"],
                    'email' => $_POST["emailClient"],
                    'id_borne' => $_POST["id_borne"]
                ];
                header("Location: AffichageReservation.php");
                exit;
            } else {
                header("Location: AffichageReservation.php");
                exit;
            }
        } else {
            echo "❌ Erreur : La réservation n’a pas pu être ajoutée.";
        }
    } else {
        echo "❗ Erreur : Le champ '" . htmlspecialchars($champ_incomplet) . "' est manquant ou vide.";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
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
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <!--<h2 class="mb-2 text-white">Logistica</h2>-->
            <img class="img-fluid" src="img/logosansnom.png" alt="" width=250px height=200px >

        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link ">Acceuil</a>
                <a href="about.html" class="nav-item nav-link">À Propos</a>
               <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
                <div class="nav-item dropdown">
                   <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                        <a href="frontparking.php" class="dropdown-item">Parking</a>
                        <a href="quote.html" class="dropdown-item">Transport Public</a>
                        <a href="AffichageReservation.php" class="dropdown-item">Recharge Electrique</a>
                        
                    </div>
                
                </div>
                <a href="user_profile.php" class="nav-item nav-link active">
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
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 26 253 807</h4>
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
    <h2>Formulaire de Réservation de Borne</h2>
  
<form id="formReservation" action="formReservation.php" method="POST">
    <input type="hidden" name="id_borne" value="<?= htmlspecialchars($_GET['id_borne'] ?? '') ?>">

    <div class="form-group">
        <label for="nom_client">Prénom et Nom :</label>
        <input type="text" id="nomClient" name="nomClient" value="<?= htmlspecialchars($user_username) ?>" readonly>
        <span id="nomClient_error" class="error"></span>
    </div>

    <div class="form-group">
        <label for="email_client">Email :</label>
        <input type="email" id="emailClient" name="emailClient" value="<?= htmlspecialchars($user_email) ?>" readonly>
        <span class="error" id="emailClient_error"></span>
    </div>

    <div class="form-group">
        <label for="date_reservation">Date de Réservation :</label>
        <input type="date" name="date_reservation" id="date_reservation" required>
        <span class="error" id="date_reservation_error"></span>
    </div>

    <div class="form-group">
        <label for="heure_debut">Heure de Début :</label>
        <input type="time" name="heure_debut" id="heure_debut" required>
        <span class="error" id="heure_debut_error"></span>
    </div>

    <div class="form-group">
        <label for="heure_fin">Heure de Fin :</label>
        <input type="time" name="heure_fin" id="heure_fin" required>
        <span class="error" id="heure_fin_error"></span>
    </div>

    <div class="form-group">
        <label for="duree_charge">Durée de Charge (en heures) :</label>
        <input type="text" id="duree_charge" name="duree_charge" required>
        <span id="duree_charge_error" class="error"></span>
    </div>

    <div class="form-group">
        <label for="pourcentage_charge">Pourcentage de Charge Souhaité :</label>
        <input type="range" name="pourcentage_charge" id="pourcentage_charge" min="20" max="100" step="20" value="100" oninput="outputPourcentage.value = this.value + '%'">
        <output id="outputPourcentage">100%</output>
        <span id="pourcentage_charge_error" class="error"></span>
    </div>

    <div class="form-group">
        <label for="tarif_estime">Tarif Estimé :</label>
        <input type="text" name="tarif_estime" id="tarif_estime" readonly>
        <span class="error" id="tarif_estime_error"></span>
    </div>

    <div class="form-group">
        <label>Mode de Paiement :</label>
        <div class="radio-group">
            <label><input type="radio" name="mode_paiement" value="en_ligne" required> Paiement en ligne</label>
            <label><input type="radio" name="mode_paiement" value="sur_place" required> Paiement sur place</label>
        </div>
        <span class="error" id="mode_paiement_error"></span>
    </div>

    <div class="online-payment-info" id="online-payment-info" style="display: none;">
        <p>💳 Vous avez choisi le paiement en ligne !</p>
        <p>Une fois le formulaire soumis, vous serez redirigé vers une page sécurisée pour finaliser votre paiement.</p>
        <p>✅ Votre place sera automatiquement réservée après le paiement.</p>
    </div>

    <input type="hidden" name="qr_code" id="qr_code" value="QR_CODE_GENERATED_VALUE">
    <input type="hidden" name="id_borne" value="<?= htmlspecialchars($_GET['id_borne']) ?>">

    <button type="submit" id="btnSoumettre" class="formeSpecial">Soumettre</button>

    <button type="button" id="paymentButton"
        onclick="window.location.href='processPayment.php?id_borne=' 
            + encodeURIComponent(document.querySelector('input[name=id_borne]').value) 
            + '&tarif_estime=' + encodeURIComponent(document.querySelector('input[name=tarif_estime]').value);">
        Passer au paiement en ligne
    </button>
</form>

</div>

<style>
    input[type="date"] {
    appearance: auto;
    -webkit-appearance: auto;
    -moz-appearance: auto;
    font-size: 15px;
    background: #fff;
    border: 1px solid #ccc;
    padding: 12px;
    border-radius: 10px;
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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px 40px;
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

    .error {
        font-size: 13px;
        color: #d32f2f;
        margin-top: 5px;
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

    #paymentButton {
        background-color: #00acc1;
    }

    #paymentButton:hover {
        background-color: #00838f;
    }




    .online-payment-info {
        background-color: #e0f2f1;
        padding: 15px;
        border-left: 5px solid #00796b;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 14px;
        color: #004d40;
        grid-column: span 2;
    }

    .formeSpecial {
        grid-column: span 2;
    }
</style>


    <script src="OnlinePayment.js"></script>
    <script src="pourcentage.js"></script>
    <script src="controleSaisie3.js"></script>
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