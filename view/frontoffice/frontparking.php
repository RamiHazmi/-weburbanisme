<?php
session_start();
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

require_once 'C:/xampp/htdocs/urbanisme/controller/AbonnementController.php';
$abonnementController = new AbonnementController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $abonnementController->ajouterAbonnement();
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
            <img class="img-fluid" src="img/logosansnom.png" alt="" width=250px height=200px >
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Acceuil</a>
                <a href="quote.html" class="nav-item nav-link">A propos</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link active" data-bs-toggle="dropdown">Services</a>
                        <div class="dropdown-menu fade-up m-0">
                            <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                            <a href="frontparking.php" class="dropdown-item active">Parking</a>
                            <a href="quote.html" class="dropdown-item">Transport Public</a>
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


    <!-- Fact Start -->
    <div class="container py-5">
        <h2 class="mb-4">Rechercher un parking par ville</h2>
 

        <!-- Formulaire de filtre par sécurité -->
        <form id="form-filtre" class="d-flex mb-5">
            <input type="text" class="form-control me-2" name="ville_filtre" id="ville" placeholder="Entrez la ville">
            <select name="securite" id="securite" class="form-select me-2">
                <option value="tous">Tous</option>
                <option value="securise">Sécurisé</option>
                <option value="non_securise">Non Sécurisé</option>
            </select>
           <!-- Bouton de recherche -->
            <button type="submit" class="btn btn-primary" style="font-size: 16px; padding: 12px 25px; border: none; 
                    background-color: #007bff; color: white; cursor: pointer; border-radius: 8px; transition: background-color 0.3s;">
                Rechercher
            </button>

            <!-- Bouton annuler avec la fonction de rechargement -->
            <button onclick="reloadPage()" style="font-size: 16px; padding: 12px 25px; border: none; 
                    background-color: #dc3545; color: white; cursor: pointer; border-radius: 8px; transition: background-color 0.3s;">
                Annuler
            </button>

        </form>
        <script>
            function reloadPage() {
                location.reload(); // Recharge la page
            }
        </script>

         
            <!-- MODAL DE RÉSERVATION -->
            <div class="modal fade" id="modalReservation" tabindex="-1" aria-labelledby="modalReservationLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form-modal-reservation" class="form-reservation" method="POST" action="AbonnementController.php" onsubmit="return validerFormulaire(event)">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalReservationLabel">Réserver un parking</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_user" value="<?= $_SESSION['user_id'] ?>">
                                <input type="hidden" name="id_parking" id="modal-id-parking">
                                <p><strong>Parking :</strong> <span id="modal-nom-parking"></span></p>
                                <p><strong>Ville :</strong> <span id="modal-ville-parking"></span></p>

                                <label>Date de début :</label>
                                <input type="datetime-local" id="modal-date-debut" name="date_debut" class="form-control">

                                <label>Date de fin :</label>
                                <input type="datetime-local" id="modal-date-fin" name="date_fin" class="form-control">

                                <label>Places à réserver :</label>
                                <input type="number" id="modal-places-reservees" name="places_reservees" class="form-control" min="1">

                                <div id="modal-erreur-message" class="text-danger mt-2" style="display:none;"></div>
                            </div>
                            <div class="modal-footer">
                                <div id="error-message" style="color: red; font-weight: bold; margin-bottom: 10px;"></div>
                                <button type="submit" class="btn btn-primary">Réserver</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        <!-- Résultats -->
        <div id="resultats-parkings" class="row g-4">
            <!-- Les parkings disponibles s'afficheront ici -->
        </div>

        <!-- Message de réservation -->
        <div id="message" class="mt-3 text-success fw-bold"></div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function () {
        // Charger tous les parkings au démarrage
        $.ajax({
            url: "../../controller/rechercheparking.php",
            method: "POST",
            data: { action: "afficher_tous_les_parkings" },
            success: function (response) {
                $("#resultats-parkings").html(response);
                
            },
            error: function () {
                $("#resultats-parkings").html("<p class='text-danger'>Erreur lors du chargement des parkings.</p>");
            }
        });

       
        // Recherche par ville
        $("#recherche-ville").submit(function (e) {
            e.preventDefault();
            const ville = $("input[name='ville_recherche']").val();
            $("#ville").val(ville);  

            $.ajax({
                url: "../../controller/rechercheparking.php",
                method: "POST",
                data: { action: "rechercher_par_ville", ville: ville },
                success: function (response) {
                    $("#resultats-parkings").html(response);
                },
                error: function () {
                    $("#resultats-parkings").html("<p class='text-danger'>Erreur lors de la recherche.</p>");
                }
            });
        });


        // Filtrage par sécurité + ville
        $("#form-filtre").submit(function (e) {
            e.preventDefault();
            const securite = $("#securite").val();
            const ville = $("#ville").val().trim();

            $.ajax({
                url: "../../controller/rechercheparking.php",
                method: "POST",
                data: {
                    action: "rechercher_par_securite",
                    securite: securite,
                    ville: ville
                },
                success: function (response) {
                    $("#resultats-parkings").html(response);
                },
                error: function () {
                    $("#resultats-parkings").html("<p class='text-danger'>Erreur lors du filtrage par sécurité.</p>");
                }
            });
        });

        // Affichage du modal de réservation
        $(document).on("click", ".btn-reserver", function () {
            const id = $(this).data("id");
            const nom = $(this).data("nom");
            const ville = $(this).data("ville");

            $("#modal-id-parking").val(id);
            $("#modal-nom-parking").text(nom);
            $("#modal-ville-parking").text(ville);

            $("#modalReservation").modal("show");
        });

        // Traitement de la réservation
         



    });
    </script>
    <script>
       $(document).ready(function () {
    // Affichage du modal de réservation
            $(document).on("click", ".btn-reserver", function () {
                const id = $(this).data("id");
                const nom = $(this).data("nom");
                const ville = $(this).data("ville");

                $("#modal-id-parking").val(id);
                $("#modal-nom-parking").text(nom);
                $("#modal-ville-parking").text(ville);

                $("#modalReservation").modal("show");
            });

            $("#form-modal-reservation").submit(function (e) {
                e.preventDefault();

                if (!validerFormulaire()) {
                    return;  
                }

                $("#error-message").text("");  
                const formData = $(this).serialize();

                $.ajax({
                    url: "../../controller/AbonnementController.php",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.includes("succès") || response.includes("réussi")) {
                            $("#modalReservation").modal("hide");
                            $("#form-modal-reservation")[0].reset();
                            $("#error-message").text("");

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            $("#error-message").text(response);
                        }
                    },
                    error: function() {
                        $("#error-message").text("Erreur lors de la réservation.");
                    }
                });
            });

        });

        </script>
        <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <script>
             $(document).ready(function() {
                $("#modalReservation").modal("hide");
                
            });
        </script>
        <?php endif; ?>

        <a href="frontabonnement.php" style="
            display: inline-block;
                padding: 14px 32px;
                font-size: 18px;
                color: white;
                background: linear-gradient(135deg, #6a11cb, #2575fc);
                border: none;
                border-radius: 50px;
                text-decoration: none;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                position: absolute;
                left: 50%;
                transform: translate(-50%, -50%);
                " onmouseover="this.style.boxShadow='0 8px 20px rgba(0,0,0,0.3)'; this.style.transform='translate(-50%, -53%)'"
                onmouseout="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'; this.style.transform='translate(-50%, -50%)'">
                voir vos abonnements
                </a>





    <!-- Feature End -->
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Esprit Street, Tunis, TUNISIA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+216 95 023 331</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>ride4all@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="">Covoiturage</a>
                    <a class="btn btn-link" href="">parking</a>
                    <a class="btn btn-link" href="">recharge electrique</a>
                    <a class="btn btn-link" href="">vélos</a>
                     
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
                    <p>veulliez entrer votre email</p>
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
    <script src="../backoffice/validation_abonnement.js"></script>

</body>

</html>