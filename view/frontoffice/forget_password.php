<?php
session_start(); 
$message = '';  
$user = null;    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';  
    if ($email) {
        include '../../controller/userC.php';
        $userC = new userC();
        $user = $userC->getUserByEmail($email); 

        if ($user) {
            $_SESSION['email'] = $email;
            $maskedPhone = '+********' . substr($user['phone'], -2);
        } else {
            $message = "Aucun compte trouvé pour cet email.";
        }
    } else {
        $message = "Veuillez entrer un email valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser votre mot de passe</title>
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

        input[type="email"], input[type="password"] {
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

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
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

        .hidden {
            display: none;
            margin-top: 15px;
        }

        .error {
            color: red;
            text-align: center;
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
    <?php if (!$user): ?>
        <h2>Réinitialiser votre mot de passe</h2>
        <p>Entrez votre email pour commencer :</p>
        <form method="post" action="">
            <label for="email">Email</label>
            <input type="email" name="email" required>
            <button type="submit">Continuer</button>
        </form>
        <?php if ($message): ?><p style="color:red;"><?= $message ?></p><?php endif; ?>
    <?php else: ?>
        <h2>Réinitialisation du mot de passe</h2>
        <p>Comment souhaitez-vous recevoir le code ?</p>
        <form method="post" action="send_code.php">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <label><input type="radio" name="method" value="sms" required> SMS à <?= $maskedPhone ?></label><br>
            <label><input type="radio" name="method" value="email" required> Email à <?= htmlspecialchars($email) ?></label><br>
            <button type="submit">Envoyer le code</button>
        </form>

        
    <?php endif; ?>
</div>
</body>
</html>
