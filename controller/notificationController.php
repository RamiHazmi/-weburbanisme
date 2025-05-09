<?php
require_once 'C:/xampp/htdocs/urbanisme/Model/abonnement.php';
require_once 'C:/xampp/htdocs/urbanisme/database.php';
require_once 'C:/xampp/htdocs/urbanisme/Model/notification.php';

function notifierEtAfficher()
{
    // Initialiser les objets nécessaires
    $abonnementModel = new Abonnement();
    $notification = new Notification();

    // Récupérer tous les abonnements expirés
    $abonnements = $abonnementModel->getAbonnementsExpires();

    // Vérifier s'il y a des abonnements expirés
    if (empty($abonnements)) {
        echo "Aucun abonnement expiré à notifier.";
        return;
    }

    // Pour chaque abonnement expiré
    foreach ($abonnements as $abonnement) {
        // Récupérer les informations nécessaires
        $phone = (int) $abonnement['phone'];  
        $username = $abonnement['username'];
        $nomParking = $abonnement['nom_parking']; // Nom du parking
        $dateExpiration = $abonnement['date_fin']; // Date d'expiration de l'abonnement

        // Créer un message personnalisé
        $message = "Bonjour $username, votre abonnement au parking '$nomParking' a expiré le $dateExpiration. Veuillez le renouveler.";

        // Formater le numéro de téléphone pour l'envoi (ajouter l'indicatif international)
        $phoneFormatted = '+216' . $phone;

        // Envoyer le message via la méthode d'envoi SMS
        $notification->sendSMS($phoneFormatted, $message);
        
        // Optionnel: Affichage pour débogage
        echo "Message envoyé à $username ($phoneFormatted) pour le parking $nomParking avec expiration le $dateExpiration.<br>";
    }
}

// Appel de la fonction pour exécuter la notification
notifierEtAfficher();

?>
