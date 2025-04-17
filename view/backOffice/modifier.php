<?php
// Inclusion du fichier de configuration et du contrôleur
include '../../controller/userC.php';
include '../../model/user.php';

$userC = new userC();

// Vérifie si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupération des données de l'utilisateur via l'ID
    $user = $userC->rechercher($_GET['id']);

    if (!$user) {
        // Si l'utilisateur n'est pas trouvé
        die('Utilisateur non trouvé');
    }
}

// Traitement du formulaire lorsqu'il est soumis
if (isset($_POST['modifier'])) {
    // Récupération des nouvelles données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    

    // Création d'un objet user avec les nouvelles données
    $user = new user($username, $email, $password, $address, $phone, $role);

    // Appel de la fonction modifier pour mettre à jour les données de l'utilisateur
    $userC->modifier($user, $id);

    // Redirection vers la page afficher.php après la mise à jour
    header("Location: afficher.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <style>
        /* Style global de la page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Style du formulaire */
        .form-container {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 0.8em;
            margin-bottom: 15px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.8em; 
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.8em;
            box-sizing: border-box;
        }
        span{
            font-size: 0.8em; 
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
            box-sizing: border-box;
        }

        .submit-button{
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .cancel-button {
            background-color: #f44336; /* Rouge */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #e53935; /* Rouge plus foncé */
        }

        /* Ajouter un effet de focus aux champs de formulaire */
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Modifier l'utilisateur</h2>

    <!-- Affichage direct du formulaire -->
    <form id="form" method="POST" action="modifier.php?id=<?= $user['id'] ?>">

        <label>Username:</label>
        <input type="text" name="username" id="username" value="<?= $user['username'] ?>" required><br>
        <span id="username_error"></span><br>

        <label>Email:</label>
        <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required><br>
        <span id="email_error"></span><br>

        <label>Password:</label>
        <input type="password" name="password" id="password" value="<?= $user['password'] ?>"><br>
        <span id="password_error"></span><br>

        <label>Address:</label>
        <input type="text" name="address" id="address" value="<?= $user['address'] ?>" required><br>
        <span id="address_error"></span><br>

        <label>Phone:</label>
        <input type="text" name="phone" id="phone" value="<?= $user['phone'] ?>" required><br>
        <span id="phone_error"></span><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="client" <?= ($user['role'] == 'client') ? 'selected' : '' ?>>User</option>
        </select><br>

        <button type="submit" class="submit-button" name="modifier">modifier</button>
        <button type="button" onclick="closeModal()" class="cancel-button">Annuler</button>
    </form>

    <!-- Bouton Annuler -->
    <a href="afficher.php">
        <button class="cancel-button">Annuler</button>
    </a>
    <!-- section footer start -->
    <div class="section_footer ">
      <div class="container">
          <div class="footer_section_2">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                  <h2 class="account_text">Addresse</h2>
                  <p class="ipsum_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, </p>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                  <h2 class="account_text">Links</h2>
                  <div class="image-icon"><img src="images/bulit-icon.png"><span class="fb_text"><a href="azeaze.html">Home</span></a></div>
                <div class="image-icon"><img src="images/bulit-icon.png"><span class="fb_text"><a href="#">About</span></a></div>
                <div class="image-icon"><img src="images/bulit-icon.png"><span class="fb_text"><a href="#">car</span></a></div>
                <div class="image-icon"><img src="images/bulit-icon.png"><span class="fb_text"><a href="#">Booking</span></a></div>
                <div class="image-icon"><img src="images/bulit-icon.png"><span class="fb_text"><a href="#">Contact Us</span></a></div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                <h2 class="account_text">Follow Us</h2>
                <div class="image-icon"><img src="images/fb-icon.png"><span class="fb_text"><a href="#">Facebook</a></span></div>
                <div class="image-icon"><img src="images/twitter-icon.png"><span class="fb_text"><a href="#">Twitter</a></span></div>
                <div class="image-icon"><img src="images/in-icon.png"><span class="fb_text"><a href="#">Linkedin</a></span></div>
                <div class="image-icon"><img src="images/youtube-icon.png"><span class="fb_text"><a href="#">Youtube</a></span></div>
                <div class="image-icon"><img src="images/instagram-icon.png"><span class="fb_text"><a href="#">Instagram</a></span></div>
                </div>
          <div class="col-sm-6 col-md-6 col-lg-3">
            <h2 class="adderess_text">Newsletter</h2>
            <input type="" class="email_text" placeholder="Enter Your Email" name="Enter Your Email">
            <button class="subscribr_bt">SUBSCRIBE</button>
          </div>
          </div>
          </div>
          </div>
      </div>
    </div>
  <!-- section footer end -->
</div>
<script src="Js/validation.js"></script>


</body>
</html>
