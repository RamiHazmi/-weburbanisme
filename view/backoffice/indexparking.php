<?php
session_start();

// Include the controllercovoiturage file
include __DIR__ . '/../../controller/parkingController.php';


// Instantiate the controllercovoiturage class

// Check if the form is submitted

?>

<!doctype html>
<html class="fixed">
	<head>


		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Form Validation | Okler Themes | Porto-Admin</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		

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
				<!-- start: sidebar -->
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
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home" aria-hidden="true"></i>
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
									<li class="nav-parent  ">
										<a>
											<i class="fa fa-table" aria-hidden="true"></i>
											<span>Covoiturage</span>
										</a>
										<ul class="nav nav-children">
										<li >
												<a href="indexc.php">
													form Covoiturage
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
									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											<span>Parking</span>
										</a>
										<ul class="nav nav-children">
											<li class="nav-active">
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
									<li class="nav-parent">
										<a>
											<i class="fa fa-align-left" aria-hidden="true"></i>
											<span>Borne Electrique</span>
										</a>
										<ul class="nav nav-children">
											<li>
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
										<a href="http://localhost/urbanisme/view/frontoffice/index.php" target="_blank">
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
						<h2>Form parking</h2>
						<form  action="../../controller/parkingController.php" method="POST" onsubmit="return validerFormulaire();">
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Parking</span></li>
								<li><span>Form parking</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
						<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
					
										<h2 class="panel-title">Parking Form</h2>
										<p class="panel-subtitle">
											Remplissez les informations sur le parking
										</p>
									</header>
									 
								
									<div class="panel-body">
										
									 <!-- Nom du Parking -->
									<div class="form-group">
										<label for="nom_parking" class="col-sm-3 control-label">Nom du Parking</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-building"></i></span>
												</span>
												<input type="text" id="nom_parking" name="nom_parking" class="form-control" placeholder="Ex : Parking Central" />
											</div>
										</div>
									</div>
									<br>

									<!-- Localisation -->
									<div class="form-group">
										<label for="localisation" class="col-sm-3 control-label">Localisation</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-map-marker"></i></span>
												</span>
												<input type="text" id="localisation" name="localisation" class="form-control" placeholder="Adresse du parking" />
											</div>
										</div>
									</div>
									<br>

									<!-- Capacité Totale -->
									<div class="form-group">
										<label for="capacite_totale" class="col-sm-3 control-label">Capacité Totale</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-users"></i></span>
												</span>
												<input type="number" id="capacite_totale" name="capacite_totale" class="form-control" placeholder="Ex : 100" />
											</div>
										</div>
									</div>
									<br>

									<!-- Places Disponibles -->
									<div class="form-group">
										<label for="places_dispo" class="col-sm-3 control-label">Places Disponibles</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-users"></i></span>
												</span>
												<input type="number" id="places_dispo" name="places_dispo" class="form-control" placeholder="Ex : 25" />
											</div>
										</div>
									</div>
									<br>

									<!-- Tarif Horaire -->
									<div class="form-group">
										<label for="tarif_horaire" class="col-sm-3 control-label">Tarif Horaire (€)</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-euro"></i></span>
												</span>
												<input type="number" step="0.01" id="tarif_horaire" name="tarif_horaire" class="form-control" placeholder="Ex : 2.50" />
											</div>
										</div>
									</div>
									<br>

									<!-- Sécurisé -->
									<div class="form-group">
										<label for="securise" class="col-sm-3 control-label">Sécurisé</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<i class="fa fa-lock"></i>
												</span>
												<select id="securise" name="securise" class="form-control">
													<option value="">-- Sélectionner --</option>
													<option value="1">Oui</option>
													<option value="0">Non</option>
												</select>
											</div>
										</div>
									</div>

									<!-- Ville -->
									<div class="form-group">
										<label for="ville" class="col-sm-3 control-label">Ville</label>
										<div class="col-sm-9">
											<div class="input-group input-group-icon">
												<span class="input-group-addon">
													<span class="icon"><i class="fa fa-building"></i></span>
												</span>
												<input type="text" id="ville" name="ville" class="form-control" placeholder="Ville du parking" />
											</div>
										</div>
									</div>
									<br>

											
										
									</div>
									
									<footer class="panel-footer">
											<div class="row">
												<div class="col-sm-9 col-sm-offset-3">
													<button class="btn btn-primary" type="submit">Ajouter</button>
													<button type="reset" class="btn btn-default">Réinitialiser</button>
												</div>
											</div>
									</footer>

										
									</form>		
									<div id="message" style="margin-top: 10px; color: green; font-weight: bold;"></div>

										<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
										<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
										<script>
										$(document).ready(function() {
											$("form").submit(function(event) {
												event.preventDefault();

												if (!validerFormulaire()) {
													return;
												}

												var formData = $(this).serialize();

												$.ajax({
													type: "POST",
													url: "../../controller/parkingController.php",
													data: formData,
													success: function(response) {
														$("#message").html(response);
														$("form")[0].reset();
													},
													error: function() {
														$("#message").html("<span style='color:red;'>Une erreur s'est produite.</span>");
													}
												});
											});
										});
										</script>

					
			</aside>
		</section>
		<style>
			.col-md-6 {
				width: 80%; 
				padding: 20px;  
			
			}
		</style>
		
		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<script src="validation.js"></script>

		<!-- Examples -->
		<script src="assets/javascripts/forms/examples.validation.js"></script>
		
	</body>
</html>