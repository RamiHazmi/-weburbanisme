<?php
include_once __DIR__ . '/../Config/config.php';


class ControllerBorneElectrique {
    

public function ajouter($ModelBorneElectrique)
{
    $sql = "INSERT INTO borneelectrique (id_borne, localisation, type_bornes, etat_bornes, puissance, nombre_ports, date_installation, operateur) 
            VALUES (:id_borne, :localisation, :type_bornes, :etat_bornes, :puissance, :nombre_ports, :date_installation, :operateur)";

    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);


        $query->execute([
            'id_borne' => $ModelBorneElectrique->getIdBorne(),
            'localisation' => $ModelBorneElectrique->getLocalisation(),
            'type_bornes' => $ModelBorneElectrique->getTypeBornes(),
            'etat_bornes' => $ModelBorneElectrique->getEtatBornes(),
            'puissance' => $ModelBorneElectrique->getPuissance(),
            'nombre_ports' => $ModelBorneElectrique->getNombrePorts(),
            'date_installation' => $ModelBorneElectrique->getDateInstallation(),
            'operateur' => $ModelBorneElectrique->getOperateur(),

        ]);

        return true; 
    } catch (Exception $e) 
    {
        echo 'Erreur: ' . $e->getMessage();
        return false; 
    }
}
public function afficher(){
    $sql="SELECT * FROM borneelectrique";
    $db = config::getConnexion();
    try
    {
        $liste = $db->query($sql);
        return $liste;
    }
    catch(Exception $e){
        die('Erreur:'. $e->getMessage());
    }
}

public function modifier($db,$ModelBorneElectrique, $id_borne) {
    echo "Modification en cours pour ID: $id_borne";  // Affiche un message de débogage

    try {
        // Préparez la requête
        $query = $db->prepare("UPDATE borneelectrique SET localisation = :localisation, 
                               type_bornes = :type_bornes, etat_bornes = :etat_bornes, 
                               puissance = :puissance, nombre_ports = :nombre_ports, 
                               date_installation = :date_installation, operateur = :operateur 
                               WHERE id_borne = :id_borne");

        // Exécutez la requête
        $query->execute([
            'localisation' => $ModelBorneElectrique->getLocalisation(),
            'type_bornes' => $ModelBorneElectrique->getTypeBornes(),
            'etat_bornes' => $ModelBorneElectrique->getEtatBornes(),
            'puissance' => $ModelBorneElectrique->getPuissance(),
            'nombre_ports' => $ModelBorneElectrique->getNombrePorts(),
            'date_installation' => $ModelBorneElectrique->getDateInstallation(),
            'operateur' => $ModelBorneElectrique->getOperateur(),
            'id_borne' => $id_borne
        ]);

        echo "Modification réussie !";  // Message de succès pour confirmer que la requête a été exécutée

    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage(); // Affiche l'erreur si une exception est levée
    }
}


public function supprimer($id_borne)
{
    $sql = "DELETE FROM borneelectrique WHERE id_borne = :id_borne";
    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->bindParam(':id_borne', $id_borne);
        return $query->execute();
    } catch (Exception $e) {
        echo 'Erreur lors de la suppression : ' . $e->getMessage();
        return false;
    }
}



}

?>
