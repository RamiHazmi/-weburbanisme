<?php
session_start();  

$method = $_SESSION['verification_method'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verification_code'])) {
        $submittedCode = trim($_POST['verification_code']); 

        $correctCode = $_SESSION['verification_code'] ?? null;

        if ($submittedCode == $correctCode) {
            echo "
            <script>
            alert('Le code est correct ! Vous êtes maintenant vérifié.');
            window.location.href = 'update_password.php';
            </script>";
            exit();
        } else {
            $errorMessage = "Code incorrect. Veuillez réessayer.";
        }
    } else {
        $errorMessage = "Aucun code de vérification n'a été soumis.";
    }
}

$methodMessage = ($method === 'sms') ? "par SMS" : "par email";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Code</title>
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

        input[type="text"] {
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
    <h2>Vérification du Code <?php echo $methodMessage; ?></h2>
    <p>Entrez le code reçu <?php echo $methodMessage; ?> :</p>

    <?php if (isset($errorMessage)): ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form action="verify_code.php" method="POST">
        <label for="verification_code">Code de Vérification :</label>
        <input type="text" name="verification_code" id="verification_code" required>
        <button type="submit">Vérifier le code</button>
    </form>
    
    <a href="send_code.php">Envoyer à nouveau le code</a>
</div>
</body>
</html>
