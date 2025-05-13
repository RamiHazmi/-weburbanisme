<?php 
session_start();

include '../../Model/ModelBorne.php';
include '../../Controller/ControllerBorne.php';

$ControllerBorneElectrique = new ControllerBorneElectrique(); 

if (
    isset($_POST["id_borne"]) &&
    isset($_POST["localisation"]) &&
    isset($_POST["type_bornes"]) &&
    isset($_POST["etat_bornes"]) &&
    isset($_POST["puissance"]) &&
    isset($_POST["nombre_ports"]) &&
	isset($_POST["date_installation"]) &&
	isset($_POST["operateur"]) 
)
{
    $s = 1;
if ($s == 1) 
{
    $ModelBorneElectrique = new ModelBorneElectrique(
		$_POST["id_borne"],
		$_POST["localisation"], 
		$_POST["type_bornes"], 
		$_POST["etat_bornes"], 
		$_POST["puissance"],
		$_POST["nombre_ports"],
		$_POST["date_installation"], 
		$_POST["operateur"]
    );

	$resultat = $ControllerBorneElectrique->ajouter($ModelBorneElectrique);

	if ($resultat) {
		header("Location: TableBorneElectrique.php");
		exit;
	} else {
		echo "Erreur lors de l'ajout.";
	}
	
}
}
?>
<?php
// Vérifiez si l'ID de la borne est passé via GET
$id_borne = isset($_GET['id_borne']) ? $_GET['id_borne'] : null;
$borne = null;

if ($id_borne) {
    // Chercher les détails de la borne en utilisant cet ID (vous devrez probablement interroger votre base de données ici)
    // Exemple de récupération avec PDO (remplacez par votre propre requête)
    $stmt = $pdo->prepare("SELECT * FROM borneelectrique WHERE id_borne = ?");
    $stmt->execute([$id_borne]);
    $borne = $stmt->fetch();
}
?>

<!doctype html>
<html class="fixed">
	<head>
	<script src="controleSaisie.js"></script>
	<link rel="stylesheet" href="errorMessage.css">
	<script src="assets/vendor/modernizr/modernizr.js"></script>

        <script src="IdBorne.js"></script>
        <link rel="stylesheet" href="IdBorne.css">

        <!-- Leaflet CSS pour la carte -->
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <!-- Lien vers le fichier JS externe -->
        <script src="map.js"></script>

        <!-- Leaflet JS pour la carte -->
		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <link rel="stylesheet" href="map.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
											<li class="nav-active">
												<a href="FormBorneElectrique.php">
													Form borne electrique
												</a>
											</li>
											<li>
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

				<section role="main" class="content-body" >
					<header class="page-header">
						<h2>Form borne Electrique</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Borne Electrique</span></li>
								<li><span>Form borne Electrique</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
						<div class="panel-body">
                        <form id="form" action="" method="POST">
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>
			<h2 class="panel-title">Ajouter une Borne</h2>
		</header>
        <input type="hidden" name="action" value="createBorne">
        <form action="/../../controller/ControllerBorne.php" method="POST" id="formBorne">
    <div class="panel-body">
        <!-- ID de la borne avec génération aléatoire -->
        <div class="input-group input-group-icon">
    <span class="input-group-addon">
        <span class="icon"><i class="fa fa-id-badge"></i></span>
    </span>
    <input class="form-control" placeholder="ID Borne" name="id_borne" id="id_borne" value="<?= $borne['id_borne'] ?? '' ?>" required>
    <span class="input-group-btn">
        <button type="button" class="btn btn-default" onclick="generateRandomID()" id="generateBtn">Générer</button>
    </span>
</div>
<span class="error-message" id="id_borne_error" style="color: red;"></span> <!-- Message d'erreur -->

        <br>

<!-- Localisation avec option de choisir sur la carte -->

    <div class="input-group input-group-icon">
        <input class="form-control" type="text" placeholder="Localisation" name="localisation" id="localisation" 
            value="<?= isset($borne['localisation']) ? $borne['localisation'] : '' ?>" required>
        
        <button type="button" class="btn btn-default" id="choose_map_btn" onclick="openMap()">📍 Choisir sur la carte</button>
        
        <!-- Carte masquée au départ -->
        <div id="map"></div>
    </div>
    <span class="error-message" id="localisation_error"></span>



<br>

 <!-- Type de Borne -->
<div class="input-group input-group-icon">
    <select class="select" name="type_bornes" id="type_bornes" style="width: 100%;">
        <option value="TypeBorne">-- Type de Borne --</option>
        <option value="Lente" <?= (isset($borne['type_bornes']) && $borne['type_bornes'] == 'Lente') ? 'selected' : '' ?>>Lente</option>
        <option value="Accélérée" <?= (isset($borne['type_bornes']) && $borne['type_bornes'] == 'Accélérée') ? 'selected' : '' ?>>Accélérée</option>
        <option value="Rapide" <?= (isset($borne['type_bornes']) && $borne['type_bornes'] == 'Rapide') ? 'selected' : '' ?>>Rapide</option>
        <option value="Ultra Rapide" <?= (isset($borne['type_bornes']) && $borne['type_bornes'] == 'Ultra Rapide') ? 'selected' : '' ?>>Ultra Rapide</option>
    </select>
</div>

<span class="error-message" id="type_bornes_error" style="color: red;"></span>


        <br>

        <!-- État de la Borne -->
<div class="input-group input-group-icon">
    <select class="select" name="etat_bornes" id="etat_borne" style="width: 100%;">
        <option value="">-- État de la Borne --</option>
        <option value="Disponible" <?= (isset($borne['etat_bornes']) && $borne['etat_bornes'] == 'Disponible') ? 'selected' : '' ?>>Disponible</option>
        <option value="En maintenance" <?= (isset($borne['etat_bornes']) && $borne['etat_bornes'] == 'En maintenance') ? 'selected' : '' ?>>En maintenance</option>
        <option value="Occupée" <?= (isset($borne['etat_bornes']) && $borne['etat_bornes'] == 'Occupée') ? 'selected' : '' ?>>Occupée</option>
    </select>
</div>
<span class="error-message" id="etat_borne_error" style="color: red;"></span>



        <br>

      <!-- Puissance (kW) -->
<div class="input-group input-group-icon">
    <input class="form-control" type="number" placeholder="Puissance (kW)" name="puissance" id="puissance" required>
</div>
<span class="error-message" id="power-error-message" style="color: red;"></span>

<br>

<!-- Nombre de ports -->
<div class="input-group input-group-icon">
<input class="form-control" type="number" placeholder="Nombre de ports" name="nombre_ports" id="nombre_ports" required
>
</div>
<span class="error-message" id="nombre_ports_error" style="color: red;"></span>
<br>





<!-- Date d'installation -->
<div class="input-group input-group-icon">
    <input class="form-control" type="date" name="date_installation" id="date_installation" 
        value="<?= isset($borne['date_installation']) ? $borne['date_installation'] : '' ?>" required>
</div>
<span class="error-message" id="date_installation_error" style="color: red;"></span>

<br>


<!-- Opérateur responsable -->
<div class="select" style="width: 100%;">
    <select class="form-control" name="operateur" id="operateur" required>
        <option value="">-- Sélectionner l'opérateur responsable --</option>
        <option value="TotalEnergies" <?= (isset($borne['operateur']) && $borne['operateur'] == 'TotalEnergies') ? 'selected' : '' ?>>TotalEnergies</option>
        <option value="Ola Energie" <?= (isset($borne['operateur']) && $borne['operateur'] == 'Ola Energie') ? 'selected' : '' ?>>Ola Energie</option>
    </select>
</div>
<span class="error-message" id="operateur_error" style="color: red;"></span>


  
<div class="row">
    <div class="col-sm-9 text-right">
	<button class="btn-custom" type="submit">Soumettre</button>
<button type="reset" class="btn-custom">Réinitialiser</button>
    </div>
</div>

 
</form>
<style>
    .btn-custom {
        border-radius: 4px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }
</style>

					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>

</html>