<?php
include_once __DIR__ . '/../Config/config.php';

class ModelBorneElectrique {
    // Attributs
    private $id_borne;
    private $localisation;
    private $type_bornes;
    private $etat_bornes;
    private $puissance;
    private $nombre_ports;
    private $date_installation;
    private $operateur;
    // Constructeur
    public function __construct($id_borne, $localisation, $type_bornes, $etat_bornes, $puissance, $nombre_ports, $date_installation, $operateur) {
    $this->id_borne = $id_borne;
    $this->localisation = $localisation;
    $this->type_bornes = $type_bornes;
    $this->etat_bornes = $etat_bornes;
    $this->puissance = $puissance;
    $this->nombre_ports = $nombre_ports;
    $this->date_installation = $date_installation;
    $this->operateur = $operateur;
}
    // Getters & Setters
    public function getIdBorne() {
        return $this->id_borne;
    }

    public function setIdBorne($id_borne) {
        $this->id_borne = $id_borne;
    }

    public function getLocalisation() {
        return $this->localisation;
    }

    public function setLocalisation($localisation) {
        $this->localisation = $localisation;
    }

    public function getTypeBornes() {
        return $this->type_bornes;
    }

    public function setTypeBornes($type_borne) {
        $this->type_bornes = $type_borne;
    }

    public function getEtatBornes() {
        return $this->etat_bornes;
    }

    public function setEtatBornes($etat_borne) {
        $this->etat_bornes = $etat_borne;
    }

    public function getPuissance() {
        return $this->puissance;
    }

    public function setPuissance($puissance) {
        $this->puissance = $puissance;
    }

    public function getNombrePorts() {
        return $this->nombre_ports;
    }

    public function setNombrePorts($nombre_ports) {
        $this->nombre_ports = $nombre_ports;
    }

    public function getDateInstallation() {
        return $this->date_installation;
    }

    public function setDateInstallation($date_installation) {
        $this->date_installation = $date_installation;
    }

    public function getOperateur() {
        return $this->operateur;
    }

    public function setOperateur($operateur) {
        $this->operateur = $operateur;
    }

       
}
?>
