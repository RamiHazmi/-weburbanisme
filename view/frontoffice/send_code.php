<?php
session_start();
require_once __DIR__ . '/../src/Twilio/autoload.php';
require '../../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require_once '../../controller/userC.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Twilio\Rest\Client;

$mail = new PHPMailer(true);

$userC = new userC();


if (!isset($_SESSION['email'])) {
    echo "Erreur : aucun email trouvé dans la session.";
    exit;
}

$email = $_SESSION['email'];
$method = $_POST['method'] ?? null;

if (!$method || !in_array($method, ['sms', 'email'])) {
    echo "Erreur : méthode de vérification invalide.";
    exit;
}

$user = $userC->getUserByEmail($email);

if (!$user) {
    echo "Erreur : utilisateur introuvable.";
    exit;
}

$username = $user['username'];
$phone = $user['phone'];

if (strpos($phone, '+') !== 0) {
    $phone = '+216' . ltrim($phone, '0');
}

$code = rand(100000, 999999);
$_SESSION['verification_code'] = $code;

$siteName = "Ride4All";

if ($method === 'sms') {
   
    $twilio = new Client($sid, $token);

    try {
        $twilio->messages->create(
            $phone,
            [
                'from' => '+15707554818',
                'body' => "Bonjour $username de la part de $siteName ! Voici votre code de vérification : $code"
            ]
        );
        header("Location: verify_code.php");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du SMS : " . $e->getMessage();
    }

}  elseif ($method === 'email') 
{
    $mail = new PHPMailer(true);

    try {
        header('Content-Type: text/html; charset=UTF-8');

        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = "malaksaadaoui786@gmail.com";
        $mail->Password = 'dnvl uddq aeve ijal'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $qrCode = new QrCode((string) $code);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrTempPath = __DIR__ . '/temp_qr_' . uniqid() . '.png';
        $logoTempPath = 'C:/xampp/htdocs/malouka/view/frontOffice/img/logo.png';
        $result->saveToFile($qrTempPath);

        $mail->addEmbeddedImage($qrTempPath, 'qrcode', 'qrcode.png', 'base64', 'image/png');
        $mail->addEmbeddedImage($logoTempPath, 'logo', 'logo.png', 'base64', 'image/png');

        $emailBody = '
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f7fb;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }

                .email-container {
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                .header {
                    color: #3498db;
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px solid #3498db;
                    padding-bottom: 15px;
                }

                .content {
                    color: #34495e;
                    font-size: 16px;
                    line-height: 1.6;
                    margin-bottom: 20px;
                }

                .content img {
                    max-width: 120px;
                    display: block;
                    margin: 0 auto 20px;
                    width: 120px;
                    height: auto;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                .qr-code {
                    text-align: center;
                    margin: 20px 0;
                }

                .qr-code img {
                    max-width: 150px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    width: 150px;
                    height: auto;
                }



                .footer {
                    font-size: 12px;
                    color: #aaa;
                    text-align: center;
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid #e5e5e5;
                }

                .footer p {
                    margin: 5px 0;
                }

                .footer a {
                    color: #3498db;
                    text-decoration: none;
                }

        
            </style>
        </head>
        <body>
            <div class="email-container fade-in">
                <div class="header">
                    Code de Réinitialisation de Mot de Passe
                </div>
                <div class="content">
                    <img src="cid:logo" alt="Logo" width="120" height="auto" />
                    <p>Bonjour <b>' . $username . '</b>,</p>
                    <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte <b>Ride4All</b>.</p>
                    <p>Pour réinitialiser votre mot de passe, veuillez scanner le QR Code ci-dessous afin d obtenir un code de vérification : </p>
                </div>
                <div class="qr-code">
                    <img src="cid:qrcode" alt="Code QR de réinitialisation de mot de passe" width="150" height="auto">
                </div>
                <div class="content">
                    <p>Une fois que vous avez scanné le QR Code, vous recevrez un code que vous pourrez utiliser pour réinitialiser votre mot de passe et accéder à votre compte.</p>
                </div>
                <div class="footer">
                    <p>Si vous n êtes pas à l origine de cette demande, veuillez ignorer ce message. Si vous avez des questions, n\'hésitez pas à nous contacter à <a href="mailto:support@ride4all.com">support@ride4all.com</a>.</p>
                    <p>Envoyé le ' . date('d/m/Y à H:i') . '</p>
                    <p>© ' . date('Y') . ' <b>Ride4All</b>. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>';
        // Email content
        $mail->setFrom('malaksaadaoui786@gmail.com', 'Ride4All');
        $mail->addAddress($email, $username); 
        $mail->isHTML(true);
        $mail->addReplyTo('malaksaadaoui786@gmail.com', 'Service Client');
        $mail->Subject = "Code de vérification - $siteName";
        $mail->Body = $emailBody;

        $mail->send();
        unlink($qrTempPath); 
        header("Location: verify_code.php");
        exit;
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
