<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';
require_once 'C:/xampp/htdocs/Urbanisme/Model/abonnement.php';

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
                        <a href="http://localhost/Urbanisme/view/frontoffice/frontparking.php" class="dropdown-item">Parking</a>
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
    <h2 style="font-family: Arial, sans-serif; text-align: center; color: #34495e;">Liste des Abonnements</h2>

<div class="abonnement-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-evenly; padding: 20px;">
    <?php foreach ($abonnements as $abonnement): ?>
        <div class="abonnement-card" style="
            background-color: #fff; 
            border-radius: 12px; 
            width: 300px; 
            padding: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; 
            margin-bottom: 20px; 
            text-align: center;
            display: flex; 
            flex-direction: column;
            align-items: center;
        ">
            <div style="font-weight: bold; font-size: 18px; color: #2c3e50; margin-bottom: 10px;">
                <?= htmlspecialchars($abonnement['username']) ?>
            </div>
            <div style="font-size: 14px; color: #7f8c8d; margin-bottom: 10px;">
                <strong>Parking :</strong> <?= htmlspecialchars($abonnement['nom_parking']) ?>
            </div>
            <div style="font-size: 14px; color: #7f8c8d; margin-bottom: 10px;">
                <strong>Date Début :</strong> <?= htmlspecialchars($abonnement['date_debut']) ?>
            </div>
            <div style="font-size: 14px; color: #7f8c8d; margin-bottom: 10px;">
                <strong>Date Fin :</strong> <?= htmlspecialchars($abonnement['date_fin']) ?>
            </div>
            <div style="font-size: 14px; color: #7f8c8d; margin-bottom: 20px;">
                <strong>Places Réservées :</strong> <?= htmlspecialchars($abonnement['places_reservees']) ?>
            </div>

            <div style="display: flex; justify-content: space-between; width: 100%;">
                <form class="form_supp_abonnement" method="POST" onsubmit="return false;" style="display: inline;">
                    <input type="hidden" name="id_abonnement" value="<?= $abonnement['id_abonnement'] ?>">
                    <button type="button" class="btn-delete-abonnement" data-id="<?= $abonnement['id_abonnement'] ?>" style="
                        background-color: #e74c3c; 
                        color: white; 
                        border: none; 
                        padding: 8px 16px; 
                        border-radius: 5px; 
                        cursor: pointer;
                        font-size: 14px;
                        transition: background-color 0.3s ease;
                    ">
                        Supprimer
                    </button>
                </form>
                <button class="btn-edit-abonnement" data-id="<?= $abonnement['id_abonnement'] ?>" data-username="<?= htmlspecialchars($abonnement['username']) ?>" data-parking="<?= htmlspecialchars($abonnement['nom_parking']) ?>" data-debut="<?= $abonnement['date_debut'] ?>" data-fin="<?= $abonnement['date_fin'] ?>" data-places="<?= $abonnement['places_reservees'] ?>" style="
                    background-color: #27ae60; 
                    color: white; 
                    border: none; 
                    padding: 8px 16px; 
                    border-radius: 5px; 
                    cursor: pointer;
                    font-size: 14px;
                    transition: background-color 0.3s ease;
                ">
                    Modifier
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modales de confirmation et modification -->
<div id="modal-supp-abonnement" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 5px; width: 350px;">
        <h4 style="font-family: Arial, sans-serif;">Confirmation</h4>
        <p>Voulez-vous vraiment supprimer cet abonnement ?</p>
        <form id="form-confirm-supp-abonnement" method="POST" action="../../controller/suppabonnement.php">
            <input type="hidden" name="id_abonnement" id="id-abonnement-supp">
            <button type="submit" style="background-color: #e74c3c; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Supprimer</button>
            <button type="button" onclick="$('#modal-supp-abonnement').hide();" style="margin-left: 10px; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 5px;">Annuler</button>
        </form>
    </div>
</div>

<div id="modal-edit-abonnement" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 5px; width: 400px;">
        <h4 style="font-family: Arial, sans-serif;">Modifier l'abonnement</h4>
        <form id="form-edit-abonnement" method="POST" action="../../controller/modabonnement.php">
            <input type="hidden" name="id_abonnement" id="edit-id-abonnement">
            <label>Nom Client :</label>
            <input type="text" name="username" id="edit-username" style="width: 100%; padding: 8px; margin-bottom: 10px;" readonly>

            <label>Parking :</label>
            <input type="text" name="nom_parking" id="edit-parking" style="width: 100%; padding: 8px; margin-bottom: 10px;" readonly>

            <label>Date Début :</label>
            <input type="date" name="date_debut" id="edit-date-debut" style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Date Fin :</label>
            <input type="date" name="date_fin" id="edit-date-fin" style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Places Réservées :</label>
            <input type="number" name="places_reservees" id="edit-places" style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <input type="hidden" id="edit-old-places" name="old_places_reservees">

            <div id="error-message" class="erreur-message" style="color: red; margin-bottom: 10px;"></div>

            <button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Enregistrer</button>
            <button type="button" onclick="$('#modal-edit-abonnement').hide();" style="margin-left: 10px; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 5px;">Annuler</button>
        </form>
    </div>
</div>


                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

						<script>
							$(document).ready(function() {
								// Ouvrir la modale lors du clic sur le bouton de suppression
								$(".btn-delete-abonnement").click(function() {
									var id = $(this).data('id');  // Récupère l'ID depuis l'attribut data-id
									$("#id-abonnement-supp").val(id);  // Remplir l'input caché avec l'ID
									$("#modal-supp-abonnement").css("display", "flex");  // Affiche la modale
								});

								// Fermeture de la modale si on clique en dehors de la boîte
								$("#modal-supp-abonnement").on("click", function(e) {
									if (e.target === this) {
										$(this).hide();
									}
								});

								// Soumission du formulaire de confirmation de suppression (AJAX)
								$("#form-confirm-supp-abonnement").submit(function(e) {
									e.preventDefault();  // Empêche la soumission classique du formulaire
									var formData = $(this).serialize();  // Sérialise les données du formulaire

									// Envoi de la requête AJAX
									$.ajax({
										type: "POST",
										url: "../../controller/suppabonnement.php",  // Le fichier PHP pour traiter la suppression
										data: formData,  // Données à envoyer (ID de l'abonnement)
										success: function(response) {
											console.log(response);  // Affiche la réponse pour le debug

											if (response === "success") {  // Si la suppression a réussi
												$("#modal-supp-abonnement").hide();  // Cache la modale
												$("tr[data-id='" + $("#id-abonnement-supp").val() + "']").fadeOut();  // Masque l'élément correspondant à l'ID dans le tableau

												// Recharge la page après un court délai (1 seconde ici)
												setTimeout(function() {
													location.reload();
												}, 1000);
											} else {
												// Si la suppression échoue, affiche un message d'erreur
												$("#message").html("<span style='color:red;'>Erreur lors de la suppression de l'abonnement.</span>");
											}
										},
										error: function() {
											// En cas d'erreur AJAX
											$("#message").html("<span style='color:red;'>Erreur lors de la suppression.</span>");
										}
									});
								});
							});

						</script>
                        <script>
						function afficherErreurModal(message) {
							$("#error-message").text(message);
						}

						$(document).ready(function () {

							// Afficher le formulaire de modification rempli avec les données
							$(".btn-edit-abonnement").click(function () {
								var id = $(this).data('id');
								var username = $(this).data('username');
								var parking = $(this).data('parking');
								var debut = $(this).data('debut');
								var fin = $(this).data('fin');
								var places = $(this).data('places');

								$("#edit-id-abonnement").val(id);
								$("#edit-username").val(username);
								$("#edit-parking").val(parking);
								$("#edit-date-debut").val(debut);
								$("#edit-date-fin").val(fin);
								$("#edit-places").val(places);
								$("#edit-old-places").val(places); // important pour la logique de comparaison

								$("#modal-edit-abonnement").css("display", "flex");
							});

							// Formulaire de modification
							$("#form-edit-abonnement").submit(function (e) {
								e.preventDefault();

								if (!validerFormulaire()) {
									return;
								}

								var formData = $(this).serialize();

								$.ajax({
									type: "POST",
									url: "../../controller/modabonnement.php",
									data: formData,
									success: function(response) {
										try {
											var data = JSON.parse(response);

											if (data.status === "success") {
												// Remplacer l'alerte par un message dans une modale ou un autre feedback
												// alert(data.message); // Supprimer ou commenter cette ligne
												$("#notification").text(data.message).fadeIn().delay(2000).fadeOut(); // Afficher un message discret
												location.reload();
											} else {
												// Si c'est une erreur, l'afficher proprement
												$('#error-message').text(data.message); // ce div existe déjà dans ton formulaire
											}
										} catch (e) {
											console.error("Erreur de parsing JSON :", e, response);
											$('#error-message').text("Erreur inattendue. Veuillez réessayer.");
										}
									}
								});
							});

							// Fermer la modale si on clique à l'extérieur
							$("#modal-edit-abonnement").on("click", function (e) {
								if (e.target === this) {
									$(this).hide();
								}
							});

						});
					</script>


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
    <script src="../backoffice/validationmodabonnement.js"></script>
</body>

</html>