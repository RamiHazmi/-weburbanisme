<?php
session_start(); // Démarre la session

include '../../model/user.php';
include '../../controller/userC.php';

$userC = new userC();
$message = "";

if (
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    $user = $userC->getUserByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user['password'])) 
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        echo "<script>alert('Connexion réussie. Bienvenue !');</script>";
        echo "<script>window.location.href='user_profile.php';</script>";  
        exit;
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
body {
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background: linear-gradient(to bottom, rgb(16, 68, 63), rgb(51, 68, 85));
}

.main {
	width: 350px;
	height: 500px;
	background: #198754;
	overflow: hidden;
	background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/cover;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}

#chk {
	display: none;
}

.signup {
	height: 460px;
	background: #198754; /* vert au lieu de #eee */
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}

.login {
    position: relative;
    width: 100%;
    height: 100%;
    background: #eee; /* Fond clair pour la connexion */
    transition: transform .8s ease-in-out; /* Animation lors du changement de position */
}

label {
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}

/* Couleurs inversées ici */
.login label {
	color: #0e6844; /* Vert foncé */
	transform: scale(1);
}

.signup label {
	color: #fff; /* Blanc */
	transform: scale(0.6);
}

#chk:checked ~ .signup {
	transform: translateY(-500px);
}

#chk:checked ~ .signup label {
	transform: scale(1);
}

#chk:checked ~ .login label {
	transform: scale(0.6);
}
input {
	width: 60%;
	height: 20px;
	background: rgb(6, 31, 19);
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
	color: white;
}

.btnSubmit {
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #189e68;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}

.btnSubmit:hover {
	background: #157c52;
}

.login-input {
	color: white;
}
</style>

	
    
</head>
<body>
    
	<div class="main">  
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="login">
				
            <form name="frmUser" method="post" action="">
           
					<label for="chk" aria-hidden="true">Se connecter</label>
					<input type="email" name="email" placeholder="Email@email.com" class="login-input">
					<input type="password" name="password" placeholder="Password" class="login-input">
					<input type="submit" name="submit" value="Se connecter" class="btnSubmit">

				</form>
				<?php if ($message != ""): ?>
    			<div style="color: red; text-align:center; font-weight:bold; font-family:'Jost', sans-serif;">
        		<?php echo htmlspecialchars($message); ?>
    			</div>
				<?php endif; ?>

			</div>

			<div class="signup">
				<form action="s_incrire.php">
				
					<label for="chk" aria-hidden="true">S'inscrire</label>

					<button class="btnSubmit">S'incrire</button>
				</form>
			</div>

			
	</div>

<script>
window.onload = () => {
	<?php if ($message != ""): ?>
		document.getElementById("chk").checked = false; 
	<?php endif; ?>
};
</script>

</body>
</html>