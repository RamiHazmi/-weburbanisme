<?php
session_start();

include '../../Model/ModelBorne.php';
include '../../Controller/ControllerBorne.php';

$ControllerBorneElectrique = new ControllerBorneElectrique();
$liste = $ControllerBorneElectrique->afficher();

// Suppression
if (isset($_GET['id_borne']) && !empty($_GET['id_borne'])) {
    $id_borne = $_GET['id_borne'];
    $resultat = $ControllerBorneElectrique->supprimer($id_borne);

    if ($resultat) {
        header('Location: TableBorneElectrique.php?success=1');
        exit();
    } else {
        header('Location: TableBorneElectrique.php?error=1');
        exit();
    }
}
var_dump($_POST);  // Affiche le contenu de $_POST pour vérifier que les données sont envoyées


// Traitement du formulaire de modification
if (isset($_POST['modifier'])) {
    $id_borne = $_POST['id_borne'];  // Corrigé ici
    // Récupération des autres données
    $localisation = $_POST['localisation'];
    $type_bornes = $_POST['type_bornes'];
    $etat_bornes = $_POST['etat_bornes'];
    $puissance = $_POST['puissance'];
    $nombre_ports = $_POST['nombre_ports'];  // Corrigé ici (et non "honombre_ports")
    $date_installation = $_POST['date_installation'];
    $operateur = $_POST['operateur'];

    // Création de l'objet Model
    $ModelBorneElectrique = new ModelBorneElectrique(
        $id_borne, $localisation, $type_bornes, $etat_bornes, 
        $puissance, $nombre_ports, $date_installation, $operateur
    );

    // Appel de la fonction modifier
    $ControllerBorneElectrique->modifier($db,$ModelBorneElectrique, $id_borne);

    // Rafraîchir la page après modification
    header("Location: afficherslouma.php");
    exit;
}


// Chargement de la liste des utilisateurs
$liste = $ControllerBorneElectrique->afficher();

?>


<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Dashboard | JSOFT Themes | JSOFT-Admin</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="JSOFT.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="../frontoffice/img/53a05df8-1974-4df6-b98f-ad661231eddd.JPEG" height="45" alt="JSOFT Admin" />
					</a>

					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					
			
						
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
								
							<?php if (isset($_SESSION['user_username'])): ?>
								<span class="name"><?= htmlspecialchars($_SESSION['user_username']) ?></span>
							<?php endif; ?>
								<span class="role">administrator</span>
							</div>
							<i class="fa custom-caret"></i>
					
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="../frontoffice/logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
											<span>Dashboard</span>
										</a>
									</li>
									
									<li class="nav-parent">
										<a>
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											<span>User</span>
										</a>
										<ul class="nav nav-children">
										<li>
												<a href="ajouter.php">
													form User
												</a>
											</li>
											<li>
												<a href="afficher.php">
													table User
												</a>
											</li>
											
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-table" aria-hidden="true"></i>
											<span>Covoiturage</span>
										</a>
										<ul class="nav nav-children">
										<li>
												<a href="indexc.php">
													 form covoiturage
												</a>
											</li>
											<li>
												<a href="tablec.php">
													 table covoiturage
												</a>
											</li>
											<li>
												<a href="tablecreservation.php">
													 reservation covoiturage
												</a>
											</li>
											
										</ul>
									</li>
									<li class="nav-parent"  >
										<a>
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											<span>Parking</span>
										</a>
										<ul class="nav nav-children">
											<li  >
												<a href="indexparking.php">
													 form parking
												</a>
											</li>
											<li >
												<a href="afficheparking.php">
													 table parking
												</a>
											</li>
											<li >
												<a href="afficheabonnement.php">
													 table abonnements
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-columns" aria-hidden="true"></i>
											<span>SmartBikeRental</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="Bikes.php">
													 Form Bike
												</a>
											</li>
											<li>
												<a href="Bike.php">
													 Form Station
												</a>
											</li>
											<li>
												<a href="addMapStation.php">
													 Form Location Station
												</a>
											</li>
											<li>
												<a href="BikeList.php">
													 Table Bikes
												</a>
											</li>
											<li>
												<a href="TableBike.php">
													 Table Stations
												</a>
											</li>
											<li>
												<a href="showRentals.php">
													 Table Rentals
												</a>
											</li></a>
										</ul>
									</li>
									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-align-left" aria-hidden="true"></i>
											<span>Borne Electrique</span>
										</a>
										<ul class="nav nav-children">
											<li >
												<a href="FormBorneElectrique.php">
													Form borne electrique
												</a>
											</li>
											<li class="nav-active">
												<a href="TableBorneElectrique.php">
													Table borne electrique
												</a>
											</li>
											<li>
												<a href="Reservation.php">
													Table reservation borne electrique
												</a>
											</li>
											<li>
												<a href="calendrier.php">
													Calendrier borbe electrique
												</a>
											</li>
											
										</ul>
									</li>
									<li>
									<a href="../frontoffice/index.php" target="_blank">
											<i class="fa fa-external-link" aria-hidden="true"></i>
											<span>Front-End <em class="not-included">(Not Included)</em></span>
										</a>
									</li>
								</ul>
							</nav>
				
						
				
							
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Tableau Borne Electrique</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span> Borne Electrique</span></li>
								<li><span>Tableau Borne Electrique</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
					<!-- start: page -->
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
						
								<h2 class="panel-title">Borne Electrique</h2>
							</header>
							<div class="panel-body">

							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
    <thead style="background-color:rgb(6, 48, 70); color: white;">
        <tr>
            <th>ID Borne</th>
            <th>Localisation</th>
            <th>Type</th>
            <th>État</th>
            <th>Puissance</th>
            <th>Nombre de ports</th>
            <th>Date Installation</th>
            <th>Opérateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($liste as $borne) { ?>
            <tr id="row-<?= $borne['id_borne']; ?>">
                <td class="editable" data-column="id_borne"><?= $borne['id_borne']; ?></td>
                <td class="editable" data-column="localisation"><?= $borne['localisation']; ?></td>
                <td class="editable" data-column="type_bornes"><?= $borne['type_bornes']; ?></td>
                <td class="editable" data-column="etat_bornes"><?= $borne['etat_bornes']; ?></td>
                <td class="editable" data-column="puissance"><?= $borne['puissance']; ?></td>
                <td class="editable" data-column="nombre_ports"><?= $borne['nombre_ports']; ?></td>
                <td class="editable" data-column="date_installation"><?= $borne['date_installation']; ?></td>
                <td class="editable" data-column="operateur"><?= $borne['operateur']; ?></td>
                <td class="actions">
					
				<a href="afficherslouma.php?id_borne=<?= $borne['id_borne']; ?>" class="on-default edit-row">
   				 <i class="fa fa-pencil"></i>
				</a>

                    <a href="TableBorneElectrique.php?id_borne=<?= $borne['id_borne']; ?>" class="on-default remove-row" onclick="return confirm('Voulez-vous vraiment supprimer la borne ID <?= $borne['id_borne']; ?> ?');">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


					<!-- end: page -->
				</section>
</div>						
        </section>
    

</div>

	
	
	</body>
</html>