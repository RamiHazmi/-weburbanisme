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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];
    $newAddress = $_POST['address'];
    $newPhone = $_POST['phone'];
    $newEmail = $_POST['email'];
    $user_id = $_POST['user_id'];

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    $user = $userC->getUserById($user_id);

    if (!password_verify($currentPassword, $user['password'])) {
        echo "<script>
            alert('Le mot de passe actuel est incorrect.');
            window.history.back(); 
        </script>";
        exit;
    }

    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = $user['password'];
    }

    $userC->updateUser($user_id, $newUsername, $newEmail, $newAddress, $newPhone, $hashedPassword);

    $_SESSION['user_email'] = $newEmail;

    $user = $userC->getUserById($user_id);


    echo "<script>
    alert('Vos informations ont été mises à jour avec succès.');
    window.location.href = 'user_profile.php';
</script>";
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
                        <a href="team.html" class="dropdown-item">Recharge Electrique</a>
                        
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
	
    <div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center py-3 rounded-top">
            <h3 style="color: white;"><i class="fas fa-user-circle"></i> Détails de votre compte</h3>

        </div>
        <div class="card-body px-5 py-4">
            <div class="mb-3 d-flex align-items-center">
                <i class="fa fa-user fa-lg text-primary me-3"></i>
                <strong>Nom d'utilisateur :</strong> &nbsp;<?php echo htmlspecialchars($user['username']); ?>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <i class="fa fa-envelope fa-lg text-primary me-3"></i>
                <strong>Email :</strong> &nbsp;<?php echo htmlspecialchars($user['email']); ?>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <i class="fa fa-map-marker-alt fa-lg text-primary me-3"></i>
                <strong>Adresse :</strong> &nbsp;<?php echo htmlspecialchars($user['address']); ?>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <i class="fa fa-phone-alt fa-lg text-primary me-3"></i>
                <strong>Téléphone :</strong> &nbsp;<?php echo htmlspecialchars($user['phone']); ?>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <!-- Bouton qui ouvre le modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal">
                <i class="fas fa-edit me-2"></i>Modifier mon compte
            </button>

                <a href="delete_user.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <i class="fas fa-trash-alt me-2"></i>Supprimer mon compte
                </a>
                <a href="logout.php" class="btn btn-secondary" onclick="return confirmerDeconnexion();">
    <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
</a>

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
   
<!-- Modal de modification -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="" id="form" onsubmit="return verif()">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Modifier mes informations</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs à modifier -->
          <div class="mb-3">
            <label style="color: black;" for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" >
          </div>
          <div class="mb-3">
            <label style="color: black;" for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" >
          </div>
          <div class="mb-3">
            <label style="color: black;" for="phone" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" >
          </div>
          <div class="mb-3">
            <label style="color: black;" for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" >
          </div>
          <div class="mb-3">
            <label style="color: black;" for="current_password" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Entrez votre mot de passe actuel" >
          </div>
          <div class="mb-3">
            <label style="color: black;" for="new_password" class="form-label">Nouveau mot de passe (optionnel)</label>
            <input type="password" class="form-control" id="password" name="new_password" placeholder="Laissez vide si vous ne voulez pas le changer">
          </div>

          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
        </div>

        <div id="errorMsg" style="color: red; padding: 10px;"></div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" name="update_user" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?onload=QuformRecaptchaLoadedamp;render=explicit" async defer></script>
 
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
<script>
function verif() {
    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let current_password = document.getElementById("current_password").value;
    let address = document.getElementById("address").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let errorMsg = document.getElementById("errorMsg");

    errorMsg.innerHTML = ""; // Clear previous messages

    if (current_password === "") 
    {
         displayMessage("current_password", "Le mot de passe actuel est obligatoire "); 
         return false; 
    }

    if (username === "" || email === "" || address === "" || phone === "") {
        errorMsg.innerHTML = "Tous les champs obligatoires doivent être remplis.";
        return false;
    }

    let usernameRegex = /^[a-zA-Z_.-]{3,}$/;
    if (!usernameRegex.test(username)) {
        displayMessage("username", "Le nom d'utilisateur doit contenir au moins 3 caractères sans espace.");
        return false;
    }

   
    // Validation de l'email
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        displayMessage("email", "L'email est invalide.");
        return false;
    } 

    // Validation du mot de passe
    if (password && password.length < 6) {
        displayMessage("password", "Le mot de passe doit contenir au moins 6 caractères.");
        return false;
    }

    // Validation de l'adresse
    let addressPattern = /^[A-Za-z\s]{3,}$/;
    if (!addressPattern.test(address)) {
        displayMessage("address", "L'adresse doit contenir uniquement des lettres et des espaces, avec au moins 3 caractères.");
        return false;
    }

    // Validation du téléphone
    let phonePattern = /^[0-9]{8}$/;
    if (!phonePattern.test(phone)) {
        displayMessage("phone", "Le téléphone doit contenir exactement 8 chiffres.");
        return false;
    }

    // Si tout est valide, soumettre le formulaire
    return true;
}

function displayMessage(field, message) {
    let errorMsg = document.getElementById("errorMsg");
    errorMsg.innerHTML = `<p><strong>Erreur:</strong> ${message}</p>`;
    document.getElementById(field).style.borderColor = "red"; // Ajouter une bordure rouge pour le champ incorrect
}

</script>
<script>
function confirmerDeconnexion() {
    return confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
}
</script>

</body>
</html>
