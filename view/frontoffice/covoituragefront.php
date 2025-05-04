<?php
session_start(); // IMPORTANT : Pour utiliser $_SESSION

include('../../controller/controllercovoiturage.php');
include __DIR__ . '/../../controller/controllercovoituragereservation.php';
include '../../model/user.php';
include '../../controller/userC.php';
$covoiturageController = new controllercovoiturage();
$covoiturages = $covoiturageController->listCovoituragesFrontoffice();

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
    <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
        <!--<h2 class="mb-2 text-white">Logistica</h2>-->
        <img class="img-fluid" src="img/logosansnom.png" alt="" width=250px height=200px >

    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Acceuil</a>
            <a href="about.html" class="nav-item nav-link">À Propos</a>
           <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
            <div class="nav-item dropdown">
               <a href="#" class="nav-item nav-link active" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu fade-up m-0">
                    <a href="covoituragefront.php" class="dropdown-item active">Covoiturage</a>
                    <a href="feature.html" class="dropdown-item">Parking</a>
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
                    <li class="breadcrumb-item text-white active" aria-current="page">Covoiturages</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
   
    <div class="container-xxl py-5">
    <div class="container py-5">
    <div class="row mb-4">
            <div class="col-12 text-center">
                <input type="text" id="destination-filter" class="form-control" placeholder="Entrez votre destination" />
            </div>
        </div>
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="text-secondary text-uppercase">Our Services</h6>
            <h1 class="mb-5">Explore Our Covoiturages</h1>
        </div>

        <div class="row" id="covoiturages-list">
            <!-- Loop through each Covoiturage and display it as a block -->
            <?php foreach ($covoiturages as $covoiturage): ?>
                <div class="col-lg-3 col-md-6 mb-4 covoiturage-item" data-destination="<?= htmlspecialchars($covoiturage['destination']) ?>">
                    <div class="service-item">
                        <!-- Image -->
                        <img src="http://localhost/urbanisme/view/backoffice/<?php echo htmlspecialchars($covoiturage['image']); ?>" 
                             alt="Covoiturage Image" 
                             width="300" height="200">
                        <div class="service-text mt-3">
                            <!-- Depart and Destination -->
                            <h4><?= htmlspecialchars($covoiturage['depart']) ?> -> <?= htmlspecialchars($covoiturage['destination']) ?></h4>
                            
                            <!-- Tarif -->
                            <p><strong>Tarif: </strong><?= htmlspecialchars($covoiturage['tarif']) ?> DT</p>
                            
                            <!-- Button to show more details -->
                            <button class="btn btn-primary show-more-btn" data-id="<?= $covoiturage['id_trajet'] ?>">Show More</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        

    </div>
</div>

<!-- Hidden details div, initially hidden, will show when "Show More" is clicked -->
<?php foreach ($covoiturages as $covoiturage): 
//integration
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] :$_SESSION['user_id'] ; 
        ?>

    <div class="covoiturage-details" id="details-<?= $covoiturage['id_trajet'] ?>" style="display:none;">
        <div class="details-content">
            <button id="annuler" class="annuler-btn">&times;</button>

            <div class="close-btn" id="close-btn-<?= $covoiturage['id_trajet'] ?>">&times;</div>
            <div class="modal-content">
                <!-- Covoiturage Image -->
                <img src="http://localhost/urbanisme/view/backoffice/<?php echo htmlspecialchars($covoiturage['image']); ?>" 
                     alt="Covoiturage Image" 
                     id="modal-img" width="700px" style="max-height: 350px; object-fit: cover;">
                
                <!-- Covoiturage Info -->
                <h4 id="modal-title"><?= htmlspecialchars($covoiturage['depart']) ?> -> <?= htmlspecialchars($covoiturage['destination']) ?></h4>
                <p><strong>Tarif: </strong><span id="modal-tarif"><?= htmlspecialchars($covoiturage['tarif']) ?> DT</span></p>
                <p><strong>Date & Time:</strong> <span id="modal-date"><?= htmlspecialchars($covoiturage['date_heure']) ?></span></p>
                <p><strong>Places Available:</strong> <span id="modal-places"><?= htmlspecialchars($covoiturage['places_dispo']) ?></span></p>
                <p><strong>Matricule Voiture:</strong> <span id="modal-matricule"><?= htmlspecialchars($covoiturage['matricule_voiture']) ?></span></p>
                <p><strong>Marque:</strong> <span id="modal-marque"><?= htmlspecialchars($covoiturage['marque']) ?></span></p>
                <p><strong>Couleur:</strong> <span id="modal-couleur"><?= htmlspecialchars($covoiturage['couleur']) ?></span></p>

                <!-- Reservation Info -->
                <?php if ($covoiturage['places_dispo'] > 0): ?>
                    <button id="reserver-form" data-id="<?= $covoiturage['id_trajet'] ?>">Reserver</button>
                <?php else: ?>
                    <p style="color: red; font-weight: bold;">Complet</p>
                <?php endif; ?>

                <div class="reservation-form" style="display: none; margin-top: 20px;">
                    <form>
                        <h5>Réservation</h5>
                        <label for="nbr_place">Nombre de places :</label>
                        <input type="number" id="nbr_place_<?= $covoiturage['id_trajet'] ?>" name="nbr_place" min="1"><br><br> 

                        <label for="commentaire">Commentaire :</label><br>
                        <textarea id="commentaire_<?= $covoiturage['id_trajet'] ?>" name="commentaire" rows="3" placeholder="Pas Obligatoire"></textarea><br><br>

                        <input type="hidden" id="id_utilisateur_<?= $covoiturage['id_trajet'] ?>" value="<?= $user_id ?>">

                        <button type="submit" class="btn btn-success">Confirmer</button>
                        <button type="button" class="btn btn-danger cancel-reservation">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="detailsajout.js"></script>





    <!-- Service End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-secondary text-uppercase"></h6>
            <h1 class="mb-0">VOTRE RÉSERVATION DE COVOITURAGE</h1>
        </div>

        <div class="row">
    <?php 
    
    // Instantiate the controller
    $covoiturageControllerreservation = new ReservationController();
    // Fetch reservations for the specified user ID
    $reservations = $covoiturageControllerreservation->listreservationcovoiturage($user_id);
    ?>

<?php if (isset($reservations) && !empty($reservations)) : ?>
    <?php foreach ($reservations as $res) : ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow p-3 rounded h-100">
                <div class="card-body">
                <div class="card-content">

                    <h5 class="card-title">Trajet</h5>
                    <p><strong>Départ :</strong> <?= htmlspecialchars($res['depart']) ?></p>
                    <p><strong>Destination :</strong> <?= htmlspecialchars($res['destination']) ?></p>
                    <p><strong>Places réservées :</strong> <?= $res['nbr_place'] ?></p>
                    <p><strong>Date réservation :</strong> <?= date('d-m-Y H:i', strtotime($res['date_reservation'])) ?></p>
                    <?php if (isset($res['statut']) && $res['statut'] == 'confirmée') : ?>
                        <span style="color: green;">Confirmée</span>
<?php endif; ?>

                    <!-- Delete + Edit Buttons -->
                    <form method="POST" onsubmit="return confirmDelete(event);">
                        <input type="hidden" name="reservation_id" value="<?= $res['id_reservationc'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="openEditForm(this)"
                            data-id="<?= $res['id_reservationc'] ?>"
                            data-nbr="<?= $res['nbr_place'] ?>"
                            data-commentaire="<?= isset($res['commentaire']) ? htmlspecialchars($res['commentaire']) : '' ?>">
                            Modifier
                        </button>
                    </form>
                    </div>


                    <!-- Edit Form (initially hidden) -->
                    <div id="editFormContainer-<?= $res['id_reservationc'] ?>" style="display:none;" class="edit-form mt-3">
                        <div class="edit-form-animate">
                            <h6>Modifier la réservation</h6>
                            <form class="editReservationForm" data-id="<?= $res['id_reservationc'] ?>">
                                <input type="hidden" name="reservation_id" value="<?= $res['id_reservationc'] ?>">
                                <div class="form-group">
                                    <label>Nombre de places réservées</label>
                                    <input type="number" name="nbr_place" class="form-control" min="1" >
                                </div>
                                <div class="form-group mt-2">
                                    <label>Commentaire</label>
                                    <textarea name="commentaire" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditForm(this)">Annuler</button>
                                </div>
                                <div class="editMessage mt-2"></div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php else : ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                Vous n'avez pas encore effectué de réservation.
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- Edit Form (initially hidden) -->

<script>
function openEditForm(button) {
    const id = button.dataset.id;
    const nbr = button.dataset.nbr;
    const commentaire = button.dataset.commentaire;

    // Hide all edit forms
    document.querySelectorAll('.edit-form').forEach(form => {
        form.style.display = 'none';
    });

    // Show all card content sections in case others are hidden
    document.querySelectorAll('.card-content').forEach(content => {
        content.style.display = 'block';
    });

    // Find the card body and hide only the content section
    const cardBody = button.closest('.card-body');
    const cardContent = cardBody.querySelector('.card-content');
    if (cardContent) {
        cardContent.style.display = 'none';
    }

    // Find and show the correct edit form
    const formContainer = document.getElementById(`editFormContainer-${id}`);
    if (formContainer) {
        const form = formContainer.querySelector('form');

        // Populate the form fields
        form.querySelector('input[name="nbr_place"]').value = nbr;
        form.querySelector('textarea[name="commentaire"]').value = commentaire;

        // Show the form with animation
        cardBody.appendChild(formContainer);
        formContainer.style.display = 'block';
        formContainer.classList.add('edit-form-animate');
    }
}

function closeEditForm(button) {
    const form = button.closest('.edit-form');
    const formElement = form.querySelector('form');

    // Clean previous animations
    form.classList.remove('edit-form-animate');
    form.classList.remove('edit-form-close');

    // Add bubble animation class
    form.classList.add('edit-form-bubble-close');

    // After the animation ends, hide form and show card content
    form.addEventListener('animationend', function handler() {
        form.style.display = 'none';
        formElement.reset();
        form.classList.remove('edit-form-bubble-close');
        form.removeEventListener('animationend', handler);

        // Show the card content again
        const cardBody = form.closest('.card-body');
        const cardContent = cardBody.querySelector('.card-content');
        if (cardContent) {
            cardContent.style.display = 'block';
        }
    });
}



// Handle form submission
document.querySelectorAll('.editReservationForm').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const msgBox = this.querySelector('.editMessage');

        fetch('/urbanisme/controller/controllercovoituragereservation.php?action=updaterese', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            msgBox.textContent = data.message;
            msgBox.style.color = data.status === 'success' ? 'green' : 'red';
            if (data.status === 'success') {
                setTimeout(() => location.reload(), 1200); // Reload to reflect changes
            }
        })
        .catch(() => {
            msgBox.textContent = "Erreur lors de la modification.";
            msgBox.style.color = 'red';
        });
    });
});

</script>


<script src="supprimerreservation.js"></script>




    <!-- Testimonial End -->


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
            </div>+-
        </div>
    </div>
    <!-- Footer End -->-
    <div id="chatbot-button" onclick="toggleChat()">💬</div>

<div class="chat-container" id="chatContainer" style="display: none;">
    <div class="chat-header">🤖 chatbot</div>
    <div id="chat-messages" class="chat-messages"></div>
    <div class="chat-input-area">
        <input type="text" id="chat-input" placeholder="Pose votre question..." onkeydown="handleKeyDown(event)">
        <button onclick="sendMessage()">➤</button>-
    </div>
</div>


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
    <script src="chatbot.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>