<?php
$lifetime = 86400 * 7; 
session_set_cookie_params($lifetime, "/");
session_start();

include '../../model/user.php';
include '../../controller/userC.php';

$userC = new userC();

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = $userC->getUserByEmail($_POST['email']);

    if ($user && $user['status'] !== 'blocked' && password_verify($_POST['password'], $user['password'])) 
	{
        $_SESSION['user_id'] = $user['id'];
		setcookie(session_name(), session_id(), time() + $lifetime, "/");

        $_SESSION['user_email'] = $user['email'];

        echo "<script>alert('Connexion réussie. Bienvenue !');</script>";
        echo "<script>window.location.href='user_profile.php';</script>";
        exit;
    } 
	elseif ($user && $user['status'] === 'blocked') {
		$_SESSION['error'] = "Votre compte est bloqué. Veuillez contacter l'administration.";
		header("Location: connexion.php");
		exit;
	}
	else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
		header("Location: connexion.php");

        exit;
    }
}






if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['address']) &&
    isset($_POST['phone']) && isset($_POST['action']) && $_POST['action'] == 'register'
) {
    $existingUser = $userC->getUserByEmail($_POST['email']);
	
    if ($existingUser) {
        echo "<script>alert('Cet email est déjà utilisé. Veuillez en choisir un autre.'); 
		window.location.href='connexion.php';</script>";
        exit;
    } else {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user = new user(
            $_POST['username'],
            $_POST['email'],
            $hashedPassword,
            $_POST['address'],
            $_POST['phone'],
            "client" ,
			"active"  
        );
        $userC->ajouter($user);

        $user_id = $userC->getUserByEmail($_POST['email'])['id']; 

        $_SESSION['user_id'] = $user_id;
		setcookie(session_name(), session_id(), time() + $lifetime, "/");

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
body {
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	background: linear-gradient(90deg, #e2e2e2, #c9d6ff);
}

.container {
	position: relative;
	width: 950px;
	height: 600px;
	background: #fff;
	border-radius: 30px;
	box-shadow: 0 0 30px rgba(0, 0, 0, .2);
	overflow: hidden;

}
.form-box{
	right: 0;
	position: absolute;
	width: 50%;
	height: 100%;
	background: #fff;
	display: flex;
	align-items: center;
	color: #333;
	text-align: center;
	padding: 40px;
	z-index: 1;
	transition: .6s ease-in-out 1.2s, visibility 0s 1s;
}
.container.active .form-box{
	right: 50%;
}
form {
	width: 100%;
}

.container h1{
	font-size: 36px;
	margin: -10px 0;
}
.input-box{
	position: relative;
	margin: 15px 0;
	max-width: 300px;
    margin-left: auto;
    margin-right: auto;
	
}
.input-box input{
	width: 100%;
	max-width: 300px;
	margin: 0 auto;
	padding: 13px 50px 13px 20px;
	background: #eee;
	border-radius: 8px;
	border: none;
	outline: none;
	font-size: 16px;
	color: #333;
	font-weight: 500;
	box-sizing: border-box;
}
.input-box input :placeholder {
	color: #888;
	font-weight: 400;
}
.input-box i {
	position: absolute;
	right: 15px;
	top: 50%;
	transform: translateY(-50%);
	font-size: 20px;
	color:#888 ;
	pointer-events: none;
}
.forget-link {
	margin: -15px 0 15px;
}
.forget-link a{
	font-weight: 14.5px;
	color: #333;
	text-decoration: none;

}
.btn{
	width: 100%;
	height: 48px;
	background: #7494ec;
	border-radius: 8px;
	box-shadow: 0 0 10px rgba(0, 0, 0, .1);
	border: none;
	cursor: pointer;
	font-size: 16px;
	color: #fff;
	font-weight: 600;
	max-width: 300px;
	margin: 0 auto;
}


.form-box.register {
	visibility: hidden;
	top: -20px
}

.container.active .form-box.register{
	visibility: visible;
}
.register-btn {
	background: transparent;
	width: 100%;
	height: 48px;
	border: 2px solid #fff;
	box-shadow: none;
}
.toggle-box{
	position: absolute;
	width: 100%;
	height: 100%;
}
.toggle-box::before{
	content: '';
	position: absolute;
	left: -250%;
	width: 300%;
	height: 100%;
	background: #7494ec;
	border-radius: 150px;
	z-index: 2;
	transition: 1.8s ease-in-out;
}


.container.active .toggle-box::before{
	left: 50%;

}

.toggle-panel{
	position: absolute;
	width: 50%;
	height: 100%;
	color: #fff;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	z-index: 2;
	transition: .6s ease-in-out;
}
.toggle-panel.toggle-right
{
	right: -50%;
	transition-delay: .6s;
}
.toggle-panel.toggle-left
{
	left: 0;
	transition-delay: .6s;
}
.container.active .toggle-panel.toggle-left{
	left: -50%;
	transition-delay: .6s;
}
.container.active .toggle-panel.toggle-right{
	right: 0;
	transition-delay: 1.2s;
}
.btn:hover {
    background: #6e82c0;
    transform: scale(1.05);
    transition: 0.3s;
}
.input-box input:focus {
    transform: scale(1.05);
    border: 2px solid #7494ec;
    transition: all 0.3s ease;
}
.toggle-panel p{
	margin-bottom: 20px;
}
.toggle-panel .btn{
	width: 160px;
	height: 46px;
	background: transparent;
	border: 2px solid #fff;
	box-shadow: none;
}
.quform-element-recaptcha .quform-input {
    display: flex;
    justify-content: center;
    align-items: center;
}


</style>

	
    
</head>
<body>
    
	<div class="container">  
		<div class="form-box login"> 
				
            <form name="frmUser" method="post" action="">
					<h1>Connexion</h1>
					<div class="input-box">
						<input type="email" name="email" placeholder="Email@email.com" class="login-input">
						<i class='bx bxs-envelope'></i>
					</div>
					<div class="input-box">
						<input type="password" name="password" placeholder="Password" class="login-input">
						<i class='bx bxs-lock-alt'></i>
					</div>
					<div class="forgot-link">
						<a href="forget_password.php">mot de passe oublié ?</a> 
					</div>

					<input type="hidden" name="action" value="login">
					<input type="submit" name="submit" value="login" class="btn">




					<?php
if (isset($_SESSION['error'])) {
    echo "<p style='color: red'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); 
}
?>


				</form>

				

			</div>

		


	<div class="form-box register">
	
		<form id="form" action="" method="POST">
			<h1>inscription</h1>
			<div class="input-box">
				<i class="fa fa-user icon"></i>
                <input type="text" id="username" name="username" class="input-with-icon" placeholder="Username">
            </div>

			<div class="input-box">
					<i class="fa fa-envelope icon"></i>
                    <input type="email" id="email" name="email" class="input-with-icon" placeholder="email@email.com">
            </div>

			<div class="input-box">
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
				<div class="input-box">
				<i class="fa fa-map-marker icon"></i>
                                    <input type="text" id="address" name="address" class="input-with-icon" placeholder="address">
                                </div>

				<div class="input-box">
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

						<input type="submit" name="submit" value="register" class="btn" onclick="return verif()" >
						<input type="hidden" name="action" value="register">
		

		</form>
		
	</div>



<div class="toggle-box">
	<div class="toggle-panel toggle-left">
					<h1>Hello! welcome!</h1>
					<p>Vous n’avez pas encore de compte ?</p>
					<button class="btn register-btn">S'incrire</button>
				
			</div>
			<div class="toggle-panel toggle-right">
					<h1> welcome back!</h1>
					<p>Vous avez deja un compte ?</p>
					<button class="btn login-btn">Se connecter</button>
				
			</div>
				</div>
				</div>
<script src="script.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=QuformRecaptchaLoaded&amp;render=explicit" async defer></script>
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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
function verif() {
    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let recaptcha = grecaptcha.getResponse();
    let errorMsg = document.getElementById("errorMsg");

    errorMsg.innerHTML = ""; 

    if (username === "" || email === "" || password === "" || address === "" || phone === "") {
        errorMsg.innerHTML = "Tous les champs sont obligatoires.";
        return false;
    }

    let usernameRegex = /^[a-zA-Z_.-]{3,}$/;
    if (!usernameRegex.test(username)) {
        errorMsg.innerHTML = "Le nom d'utilisateur doit contenir au moins 3 caractères sans espace";
        return false;
    }

    let emailRegex =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email)) {
        errorMsg.innerHTML = "Email invalide.";
        return false;
    }


    if (password.length < 6) {
        errorMsg.innerHTML = "Le mot de passe doit contenir au moins 6 caractères.";
        return false;
    }

	let phoneRegex = /^[0-9]{8}$/;
    if (!phoneRegex.test(phone)) {
        errorMsg.innerHTML = "Numéro de téléphone invalide. Il doit contenir 8.";
        return false;
    }

    if (recaptcha.length === 0) {
        errorMsg.innerText = "Veuillez confirmer que vous n'êtes pas un robot.";
        return false;
    }

    return true; 
}
</script>
</body>
</html>