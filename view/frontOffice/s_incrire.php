<?php
session_start(); 

include '../../model/user.php';
include '../../controller/userC.php';

$userC = new userC();
$message = "";

if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['address']) &&
    isset($_POST['phone'])
) {
    $existingUser = $userC->getUserByEmail($_POST['email']);

    if ($existingUser) {
        $message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user = new user(
            $_POST['username'],
            $_POST['email'],
            $hashedPassword,
            $_POST['address'],
            $_POST['phone'],
            "client"
        );
        $userC->ajouter($user);

        $user_id = $userC->getUserByEmail($_POST['email'])['id']; 

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $_POST['email'];


        echo "<script>alert('Vous avez ajouté un utilisateur avec succès');</script>";
        echo "<script>window.location.href='user_profile.php';</script>"; 
        exit;
    }
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
<style>
.input-container {
  position: relative;
  width: 100%;
  display: flex;
  align-items: center;
}

.input-with-icon {
  width: 100%;
  padding-left: 30px;
  padding-top: 8px;
  padding-bottom: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.input-container .icon {
  position: absolute;
  left: 10px;
  font-size: 18px;
  color: black;
}

.carousel-item {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
   
    padding: 40px 0;
}

.card {
    background-color: #f0f8ff; 
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 1000px;
}

.booking_text, .request_text {
    text-align: center;
    color: #333;
}




</style>
</head>
 <body style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
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
                <a href="index.html" class="nav-item nav-link ">Acceuil</a>
                <a href="about.html" class="nav-item nav-link">À Propos</a>
               <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
                <div class="nav-item dropdown">
                   <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="price.html" class="dropdown-item">Covoiturage</a>
                        <a href="feature.html" class="dropdown-item">Parking</a>
                        <a href="quote.html" class="dropdown-item">Transport Public</a>
                        <a href="team.html" class="dropdown-item">Recharge Electrique</a>
                        
                    </div>
                
                </div>
                <a href="connexion.php" class="nav-item nav-link active">connexion</a>
                <a href="user_profile.php" class="nav-item nav-link"><i class="fa fa-user text-primary me-3"></i>Profile</a>

            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 95 023 331</h4>
        </div>
    </nav>
    <!-- Navbar End -->
	
    <div class="banner_section">
      <div class="container-fluid">
        <div id="main_slider" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
    <div class="row justify-content-center align-items-center w-100">
      <div class="col-md-6 d-flex justify-content-center align-items-center">
      <div class="card p-4 shadow-lg mx-auto" >
    
            <div class="contact_bg">
            <div class="input_main">
              <div class="container">
                <h2 class="request_text" style="color: #198754;" >Formulaire d'inscription</h2>
                <br>
                <div class="panel-body">
						<?php if (!empty($message)): ?>
    					<p style="color: red; font-weight: bold;"><?php echo $message; ?></p>
						<?php endif; ?>
				        <form id="form" action="" method="POST">
						<section class="panel">
								<div class="panel-body">
                        
                                <div class="input-container">
                                    <i class="fa fa-user icon"></i>
                                    <input type="text" id="username" name="username" class="input-with-icon" placeholder="Username">
                                </div>


                                <div class="input-container">
                                    <i class="fa fa-envelope icon"></i>
                                    <input type="email" id="email" name="email" class="input-with-icon" placeholder="email@email.com">
                                </div>

                                <div class="input-container">
                                    <i class="fa fa-key icon"></i>
                                    <input type="password" id="password" name="password" class="input-with-icon" placeholder="Password">
                                </div>
                <input type="checkbox" onclick="Afficher()"> Afficher le mot de passe
<script>
                  function Afficher()
                  { 
                  var input = document.getElementById("password"); 
                  if (input.type === "password")
                  { 
                        input.type = "text"; 
                  } 
                  else
                  { 
                        input.type = "password"; 
                  } 
                  } 
                  </script>


                                <div class="input-container">
                                    <i class="fa fa-map-marker icon"></i>
                                    <input type="text" id="address" name="address" class="input-with-icon" placeholder="address">
                                </div>

                        
                        <div class="input-container">
                                    <i class="fa fa-phone icon"></i>
                                    <input class="input-with-icon" type="text" placeholder="Phone :(+216)" name="phone" id="phone">
                                    </div>

                        <div class="quform-element quform-element-recaptcha">
                            <div class="quform-spacer">
                                <label>Are you human? <span class="quform-required">*</span></label>
                                <div class="quform-input">
                                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                                    <noscript>Please enable JavaScript to submit this form.</noscript>
                                </div>
                            </div>
                        </div>
                        <p id="errorMsg" style="color: red;"></p>
                            <input type="submit" value="Envoyer" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" onclick="return verif()">
                            <input type="reset" value="Annuler" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">
                    </form>

                       		
					</div>

						
                  </div>
                  </div>

          </div>
          </div>
        </div>
    </div>



  </div>

</div>

      </div>
    </div>
    </div>
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
                    <a class="btn btn-link" href="">connexion</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
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

    <!-- Javascript files-->
    <script>
function verif() {
    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let recaptcha = grecaptcha.getResponse();
    let errorMsg = document.getElementById("errorMsg");

    errorMsg.innerHTML = ""; // Clear previous messages

    // Contrôle : champs obligatoires
    if (username === "" || email === "" || password === "" || address === "" || phone === "") {
        errorMsg.innerHTML = "Tous les champs sont obligatoires.";
        return false;
    }

    let usernameRegex = /^[a-zA-Z_.-]{3,}$/;
    if (!usernameRegex.test(username)) {
        errorMsg.innerHTML = "Le nom d'utilisateur doit contenir au moins 3 caractères sans espace";
        return false;
    }

    // Vérification email
    let emailRegex =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email)) {
        errorMsg.innerHTML = "Email invalide.";
        return false;
    }

    // Vérification mot de passe
    if (password.length < 6) {
        errorMsg.innerHTML = "Le mot de passe doit contenir au moins 6 caractères.";
        return false;
    }

    // Vérification téléphone : que des chiffres, 8 à 15 caractères
    let phoneRegex = /^[0-9]{8}$/;
    if (!phoneRegex.test(phone)) {
        errorMsg.innerHTML = "Numéro de téléphone invalide. Il doit contenir 8.";
        return false;
    }

    if (recaptcha.length === 0) {
        errorMsg.innerText = "Veuillez confirmer que vous n'êtes pas un robot.";
        return false;
    }

    return true; // Tout est ok, on peut envoyer le formulaire
}
</script>

    
    <script type="text/javascript" src="quform/js/scripts.js"></script>
    <script>
    window.QuformRecaptchaLoaded = function () {
        if (window.grecaptcha && window.jQuery) {
            jQuery('.g-recaptcha').each(function () {
                var $recaptcha = jQuery(this);
 
                if ($recaptcha.is(':empty')) {
                    $recaptcha.data('recaptcha-id', grecaptcha.render($recaptcha[0]));
                }
            });
        }
    };
</script>
    <script src="https://www.google.com/recaptcha/api.js?onload=QuformRecaptchaLoaded&amp;render=explicit" async defer></script>
 
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <!-- Script Fancybox + Zoom -->

<!-- Ton fichier de validation de formulaire -->
<script src="formV.js"></script>

 
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
