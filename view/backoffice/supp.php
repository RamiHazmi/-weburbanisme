<?php
	include '../../controller/userC.php';
	$userC=new userC();
	$userC->supprimer($_GET["id"]);
	header('Location:afficher.php');
?>