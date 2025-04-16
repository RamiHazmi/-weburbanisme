<?php
include_once __DIR__.'/../database.php';  
include(__DIR__ . '/../model/modelcovoiturage.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['action']) && $_POST['action'] === 'deleteCovoiturage') {
        $controller = new ControllerCovoiturage();
        $controller->deleteCovoiturage();
        exit();
    }

    elseif (isset($_POST['action']) && $_POST['action'] === 'addCovoiturage') {
        $controller = new ControllerCovoiturage();
        echo $controller->addCovoiturage();
        exit();
    }
    elseif (isset($_POST['action']) && $_POST['action'] === 'modifyCovoiturage') {
        $controller = new ControllerCovoiturage();
        echo $controller->updateCovoiturage();
        exit();
    }

}

class ControllerCovoiturage {
    public function addCovoiturage() {
        error_log("addCovoiturage function is called.");
        error_log('POST data: ' . print_r($_POST, true));

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            error_log("Request method: " . $_SERVER["REQUEST_METHOD"]);
    
            $conn = config::getConnexion();
            $errors = [];
    
            // Sanitize & Validate Inputs
            $depart = isset($_POST['depart']) ? htmlspecialchars(trim($_POST['depart'])) : null;
            $destination = isset($_POST['destination']) ? htmlspecialchars(trim($_POST['destination'])) : null;
            $date_heure = isset($_POST['date_heure']) ? trim($_POST['date_heure']) : null;
            $tarif = isset($_POST['tarif']) ? filter_var($_POST['tarif'], FILTER_VALIDATE_FLOAT) : null;
            $places_dispo = isset($_POST['places_dispo']) ? filter_var($_POST['places_dispo'], FILTER_VALIDATE_INT) : null;
            $conducteur_id = isset($_POST['conducteur_id']) ? filter_var($_POST['conducteur_id'], FILTER_VALIDATE_INT) : null;
            $matricule = isset($_POST['matricule_voiture']) ? htmlspecialchars(trim($_POST['matricule_voiture'])) : null;
            $marque = isset($_POST['marque']) ? htmlspecialchars(trim($_POST['marque'])) : null;
            $couleur = isset($_POST['couleur']) ? htmlspecialchars(trim($_POST['couleur'])) : null;
    
            error_log("POST Data: Depart: $depart, Destination: $destination, Date_heure: $date_heure, Tarif: $tarif, Places Dispo: $places_dispo, Conducteur_id: $conducteur_id, Matricule: $matricule, Marque: $marque, Couleur: $couleur");
    
            if (!$depart) $errors[] = "Le lieu de départ est obligatoire.";
            if (!$destination) $errors[] = "Le lieu de destination est obligatoire.";
            if (!$date_heure || strtotime($date_heure) < strtotime(date("Y-m-d H:i:s"))) $errors[] = "La date et l'heure du départ doivent être un moment valide et supérieur ou égal à aujourd'hui."; 
            if (!$tarif || $tarif <= 0) $errors[] = "Le tarif doit être un nombre valide et supérieur à 0.";
            if (!$places_dispo || $places_dispo <= 0) $errors[] = "Le nombre de places disponibles doit être valide.";
if (!$matricule) {
    $errors[] = "Le matricule du véhicule est obligatoire.";
} else {
    if (!preg_match('/^[a-zA-Z0-9]{2,3}Tunis\d{4}$/', $matricule)) {
        $errors[] = "Le matricule doit être sous la forme xxTunis1234 ou xxxTunis1234.";
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM covoiturage WHERE matricule_voiture = ?");
        $stmt->execute([$matricule]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $errors[] = "Ce matricule existe déjà. Veuillez en choisir un autre.";
        }
    }
}
            if (!$marque) $errors[] = "La marque du véhicule est obligatoire.";
            if (!$couleur) $errors[] = "La couleur du véhicule est obligatoire.";
    
            if (!$conducteur_id) {
                $errors[] = "L'ID du conducteur est obligatoire.";
            } else {
                $checkUser = $conn->prepare("SELECT COUNT(id) FROM user WHERE id = ?");
                $checkUser->execute([$conducteur_id]);
                $userExists = $checkUser->fetchColumn();
                error_log("Conducteur ID Check: " . ($userExists ? "Found" : "Not Found"));
                if ($userExists == 0) {
                    $errors[] = "L'ID du conducteur n'existe pas.";
                }
            }

            $imageUrl = "";
            if (!empty($_FILES["image"]["name"])) {
                $targetDir = "view/images/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    
                $imageFileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $imageFileName;
                $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    
                error_log("Uploaded image file type: $imageFileType, Size: " . $_FILES["image"]["size"]);
    
                if (!in_array($imageFileType, $allowedTypes)) {
                    $errors[] = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                } elseif ($_FILES["image"]["size"] > 5000000) {
                    $errors[] = "Le fichier est trop volumineux (max: 5 Mo).";
                } elseif ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
                    $errors[] = "Erreur lors du téléchargement de l'image.";
                } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    error_log("Failed to move uploaded file to: " . $targetFilePath);
                    $errors[] = "Failed to move uploaded file.";
                } else {
                    $imageUrl = $targetFilePath;
                }
            }
    
            if (empty($errors)) {
                error_log("Final data to insert: Depart: $depart, Destination: $destination, Date_heure: $date_heure, Tarif: $tarif, Places_dispo: $places_dispo, Conducteur_id: $conducteur_id, Matricule: $matricule, Marque: $marque, Couleur: $couleur, Image URL: $imageUrl");
    
                $covoiturage = new Covoiturage($depart, $destination, $date_heure, $tarif, $places_dispo, $conducteur_id, $matricule, $marque, $couleur, $imageUrl);
                if ($covoiturage->register()) {
                    return "<p style='color:green;'>Covoiturage ajouté avec succès !</p>";
                } else {
                    return "<p style='color:red;'>Erreur lors de l'ajout du covoiturage.</p>";
                }
            } else {
                error_log("Errors: " . implode(", ", $errors));
                return "<p style='color:red;'>" . implode("<br>", $errors) . "</p>";
            }
        } else {
            error_log("Request is not POST.");
        }
    }    

    public function listCovoiturages() {
        return Covoiturage::getAllCovoiturages();
    }

    public function deleteCovoiturage() {
        header('Content-Type: application/json');
    
        // Debugging: Log the received raw POST data
        $data = json_decode(file_get_contents('php://input'), true);
        error_log("Received POST data: " . json_encode($data));
    
        // Check if the ID is set in the decoded JSON data
        if (!isset($data['id_trajet'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
            exit;
        }
    
        $id_trajet = intval($data['id_trajet']);  // Convert to integer
    
        // Log the ID being deleted for debugging purposes
        error_log("Attempting to delete covoiturage with ID: " . $id_trajet);
    
        // Assuming your model and delete function are correct
        $model = new Covoiturage("", "", "", "", "", "", "", "", "", "");
        $deleteSuccess = $model->deleteCovoiturage($id_trajet);
    
        if ($deleteSuccess) {
            echo json_encode(['status' => 'success', 'message' => 'Covoiturage deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete the covoiturage.']);
        }
        exit;
    }

       
    public function updateCovoiturage() {
        error_log("modifyCovoiturage function is called.");
        error_log('POST data: ' . print_r($_POST, true));
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            error_log("Request method: " . $_SERVER["REQUEST_METHOD"]);
    
            $conn = config::getConnexion();
            $errors = [];
    
            // Sanitize & Validate Inputs
            $id_trajet = isset($_POST['id_trajet']) ? filter_var($_POST['id_trajet'], FILTER_VALIDATE_INT) : null;
            $depart = isset($_POST['depart']) ? htmlspecialchars(trim($_POST['depart'])) : null;
            $destination = isset($_POST['destination']) ? htmlspecialchars(trim($_POST['destination'])) : null;
            $date_heure = isset($_POST['date_heure']) ? trim($_POST['date_heure']) : null;
            $tarif = isset($_POST['tarif']) ? filter_var($_POST['tarif'], FILTER_VALIDATE_FLOAT) : null;
            $places_dispo = isset($_POST['places_dispo']) ? filter_var($_POST['places_dispo'], FILTER_VALIDATE_INT) : null;
            $conducteur_id = isset($_POST['conducteur_id']) ? filter_var($_POST['conducteur_id'], FILTER_VALIDATE_INT) : null;
            $matricule = isset($_POST['matricule_voiture']) ? htmlspecialchars(trim($_POST['matricule_voiture'])) : null;
            $marque = isset($_POST['marque']) ? htmlspecialchars(trim($_POST['marque'])) : null;
            $couleur = isset($_POST['couleur']) ? htmlspecialchars(trim($_POST['couleur'])) : null;
            $existingImage = isset($_POST['existing_image']) ? $_POST['existing_image'] : null;
    
            error_log("POST Data: ID_trajet: $id_trajet, Depart: $depart, Destination: $destination, Date_heure: $date_heure, Tarif: $tarif, Places Dispo: $places_dispo, Conducteur_id: $conducteur_id, Matricule: $matricule, Marque: $marque, Couleur: $couleur");
    
            // Validate Inputs
            if (!$id_trajet) {
                $errors[] = "ID du trajet invalide.";
            }
    
            if (!$depart) $errors[] = "Le lieu de départ est obligatoire.";
            if (!$destination) $errors[] = "Le lieu de destination est obligatoire.";
            if (!$date_heure) $errors[] = "La date et l'heure du départ sont obligatoires.";
            if (!$tarif || $tarif <= 0) $errors[] = "Le tarif doit être un nombre valide et supérieur à 0.";
            if (!$places_dispo || $places_dispo <= 0) $errors[] = "Le nombre de places disponibles doit être valide.";
            if (!$matricule) {
                $errors[] = "Le matricule du véhicule est obligatoire.";
            } else {
                if (!preg_match('/^[a-zA-Z0-9]{2,3}Tunis\d{4}$/', $matricule)) {
                    $errors[] = "Le matricule doit être sous la forme xxTunis1234 ou xxxTunis1234.";
                } else {
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM covoiturage WHERE matricule_voiture = ? AND id_trajet != ?");
                    $stmt->execute([$matricule, $id_trajet]);
                    $count = $stmt->fetchColumn();
                    
            
                    if ($count >0 ) {
                        $errors[] = "Ce matricule existe déjà. Veuillez en choisir un autre.";
                    }
                }
            }            if (!$marque) $errors[] = "La marque du véhicule est obligatoire.";
            if (!$couleur) $errors[] = "La couleur du véhicule est obligatoire.";
    
            if (!$conducteur_id) {
                $errors[] = "L'ID du conducteur est obligatoire.";
            } else {
                $checkUser = $conn->prepare("SELECT COUNT(id) FROM user WHERE id = ?");
                $checkUser->execute([$conducteur_id]);
                $userExists = $checkUser->fetchColumn();
                error_log("Conducteur ID Check: " . ($userExists ? "Found" : "Not Found"));
                if ($userExists == 0) {
                    $errors[] = "L'ID du conducteur n'existe pas.";
                }
            }
            $uploadDir = "../view/backoffice/view/images/"; // Actual directory for saving

            if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
                $uniqueName = uniqid() . "_" . basename($_FILES['imageUpload']['name']);
                $targetPath = $uploadDir . $uniqueName;
            
                if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $targetPath)) {
                    if (!empty($existingImage) && file_exists("../view/backoffice/" . $existingImage)) {
                        unlink("../view/backoffice/" . $existingImage);
                    }
            
                    $imagePath = "view/images/" . $uniqueName;
            
                    error_log("New image uploaded: " . $imagePath);
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $imagePath = $existingImage;
            }
            
               
            if (empty($errors)) {
                $updateStmt = $conn->prepare("UPDATE covoiturage SET depart = ?, destination = ?, date_heure = ?, tarif = ?, places_dispo = ?, conducteur_id = ?, matricule_voiture = ?, marque = ?, couleur = ?, image = ? WHERE id_trajet = ?");
                $updateResult = $updateStmt->execute([$depart, $destination, $date_heure, $tarif, $places_dispo, $conducteur_id, $matricule, $marque, $couleur, $imagePath, $id_trajet]);
                
    
                if ($updateResult) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Covoiturage modifié avec succès !"
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Erreur lors de la modification du covoiturage."
                    ]);
                }
            } else {
                error_log("Errors: " . implode(", ", $errors));
                echo json_encode(["status" => "error", "message" => implode("<br>", $errors)]);
            }
        } else {
            error_log("Request is not POST.");
            echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        }
    }
    
    
    public function listCovoituragesFrontoffice() {
        $covoiturages = Covoiturage::getAllCovoituragesfront();

        return $covoiturages;

    }
    

   
    
}
    
    

