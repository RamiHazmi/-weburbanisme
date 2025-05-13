<?php
require_once 'C:/xampp/htdocs/urbanisme/database.php';
require_once 'C:/xampp/htdocs/urbanisme/model/StripeModel.php';  
require_once 'C:/xampp/htdocs/urbanisme/vendor/Stripe/init.php';  

 class StripeController {
    private $model;

    public function __construct() {
        $this->model = new StripeModel(config::getConnexion());
    }

    public function checkout($id_abonnement) {
        $prix = $this->model->calculerPrixAbonnement($id_abonnement);

        if ($prix === false) {
            echo json_encode(['success' => false, 'message' => 'Abonnement introuvable']);
            exit();
        }

        echo json_encode(['success' => true, 'price' => $prix]);
        exit();
    }

    // Fonction pour mettre à jour le statut après paiement réussi
    public function updateAbonnementStatusAfterPayment($id_abonnement) {
        if ($this->model->updateAbonnementStatus($id_abonnement)) {
            echo json_encode(['success' => true, 'message' => 'Abonnement mis à jour à "payé"']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut']);
        }
    }

    

    public function createCheckoutSession($id_abonnement) {
        $prix = $this->model->calculerPrixAbonnement($id_abonnement);  

        if ($prix === false) {
            echo json_encode(['success' => false, 'message' => 'Abonnement introuvable']);
            exit();
        }

        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Abonnement #' . $id_abonnement,
                        ],
                        'unit_amount' => intval($prix * 100), // Montant en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/urbanisme/view/frontoffice/frontabonnement.php?payment=success&id_abonnement=' . $id_abonnement,
                'cancel_url' => 'http://localhost/urbanisme/view/frontoffice/frontabonnement.php?payment=cancel&id_abonnement=' . $id_abonnement,
            ]);
        
            // Log de la session pour vérifier qu'elle a bien été créée
            error_log("Session créée avec succès : " . print_r($session, true));
        
            echo json_encode(['sessionId' => $session->id]);
        } catch (Exception $e) {
            // Log de l'erreur si exception
            error_log("Erreur lors de la création de la session Stripe : " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
        
    }
}

// Gérer l'appel AJAX
if (isset($_GET['action']) && $_GET['action'] === 'checkout' && isset($_GET['id_abonnement'])) {
    $controller = new StripeController();
    $controller->checkout($_GET['id_abonnement']);
}

if (isset($_GET['action']) && $_GET['action'] === 'create' && isset($_GET['id_abonnement'])) {
    $controller = new StripeController();
    $controller->createCheckoutSession($_GET['id_abonnement']);
}
?>