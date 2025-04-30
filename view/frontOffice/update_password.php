<?php
session_start();
include '../../model/user.php';
include '../../controller/userC.php';

$errorMessage = "";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        $errorMessage = "Tous les champs doivent être remplis.";
    }

    if ($newPassword !== $confirmPassword) {
        $errorMessage = "Les nouveaux mots de passe ne correspondent pas.";
    }

    if (empty($errorMessage)) {
        $userC = new userC();
        $user = $userC->getUserByEmail($email);  

        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userC->modifierPassword($user['id'], $hashedPassword);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $email;

            echo "<script>
                alert('Votre mot de passe a été mis à jour avec succès.');
                window.location.href = 'user_profile.php';
            </script>";
        } else {
            echo "<script>
                alert('Aucun utilisateur trouvé avec cet email.');
                window.location.href='connexion.php';
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <style>
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
    }

    h2 {
        margin-top: 0;
        font-size: 22px;
        text-align: center;
        color: #333;
    }

    p {
        text-align: center;
        color: #555;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: 500;
        color: #333;
    }

    input[type="password"] {
        padding: 10px 12px;
        font-size: 16px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 15px;
        font-size: 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        text-align: center;
        font-size: 14px;
    }

    a {
        text-decoration: none;
        color: #007BFF;
        font-size: 15px;
        text-align: center;
        display: block;
        margin-top: 10px;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .container {
            padding: 20px;
        }

        h2 {
            font-size: 20px;
        }

        button {
            font-size: 15px;
        }
    }
    </style>
</head>
<body>

<div class="container">
    <h2>Réinitialiser votre mot de passe</h2>
    <form method="POST" action="">
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" name="new_password" id="new_password" >

        <label for="confirm_password">Confirmer le nouveau mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" >

        <button type="submit">Réinitialiser</button>
    </form>

    <?php if (!empty($errorMessage)): ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
