<?php
    include '../../Controller/ControllerBorne.php';
	include '../../Model/ModelBorne.php';
    $ControllerBorneElectrique = new ControllerBorneElectrique();
    $liste = $ControllerBorneElectrique->afficher();

// Traitement du formulaire de modification
    if (isset($_POST['modifier'])) {
        $localisation = $_POST['localisation'];
        $type_bornes = $_POST['type_bornes'];
        $etat_bornes = $_POST['etat_bornes'];
        $puissance = $_POST['puissance'];
        $nombre_ports = $_POST['nombre_ports'];
        $date_installation = $_POST['date_installation'];
        $operateur = $_POST['operateur'];
        $id_borne = $_POST['id_borne'];
        
        // Créer un objet modèle
        $ModelBorneElectrique = new ModelBorneElectrique(
            $id_borne, $localisation, $type_bornes, $etat_bornes,
            $puissance, $nombre_ports, $date_installation, $operateur
        );
                // Connexion à la base de données
try {
    $db = new PDO("mysql:host=localhost;dbname=urbanisme", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

        $ControllerBorneElectrique->modifier($db,$ModelBorneElectrique, $id_borne);

    // Rafraîchir la page après modification
		header("Location: afficher.php");
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

		<title>USER LIST </title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

			<style>
		#editModal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}

		#editModal > div {
			background: white;
			padding: 20px;
			border-radius: 10px;
			max-width: 450px;
			width: 90%;
			max-height: 90%;
			overflow-y: auto;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
		}

		#editModal h3 {
			text-align: center;
			margin-top: 0;
			margin-bottom: 15px;
			font-size: 20px;
		}

		#editModal label {
			font-size: 14px;
			display: block;
			margin-bottom: 4px;
			margin-top: 10px;
		}

		#editModal input,
		#editModal select {
			width: 100%;
			padding: 6px;
			font-size: 14px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		.submit-button {
			background-color: #007bff;
			color: white;
			padding: 10px;
			width: 100%;
			border: none;
			font-size: 14px;
			border-radius: 4px;
			cursor: pointer;
		}

		.submit-button:hover {
			background-color: #0056b3;
		}

		.cancel-button {
			background-color: red;
			color: white;
			padding: 10px;
			width: 100%;
			border: none;
			font-size: 14px;
			border-radius: 4px;
			cursor: pointer;
			margin-top: 8px;
		}

		.cancel-button:hover {
			background-color: darkred;
		}
	</style>


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
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

         <!-- Leaflet CSS pour la carte -->
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <!-- Lien vers le fichier JS externe -->
        <script src="map.js"></script>

        <!-- Leaflet JS pour la carte -->
		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <link rel="stylesheet" href="map.css">
        <script src="controleSaisie2.js"></script>

	</head>

	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/logo.png" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>
			
					<ul class="notifications">
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-tasks"></i>
								<span class="badge">3</span>
							</a>
			
							<div class="dropdown-menu notification-menu large">
								<div class="notification-title">
									<span class="pull-right label label-default">3</span>
									Tasks
								</div>
			
								<div class="content">
									<ul>
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Generating Sales Report</span>
												<span class="message pull-right text-dark">60%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
											</div>
										</li>
			
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Importing Contacts</span>
												<span class="message pull-right text-dark">98%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
											</div>
										</li>
			
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Uploading something big</span>
												<span class="message pull-right text-dark">33%</span>
											</p>
											<div class="progress progress-xs light mb-xs">
												<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-envelope"></i>
								<span class="badge">4</span>
							</a>
			
							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default">230</span>
									Messages
								</div>
			
								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Doe</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joe Junior" class="img-circle" />
												</figure>
												<span class="title">Joe Junior</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
											</a>
										</li>
									</ul>
			
									<hr />
			
									<div class="text-right">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="badge">3</span>
							</a>
			
							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default">3</span>
									Alerts
								</div>
			
								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-thumbs-down bg-danger"></i>
												</div>
												<span class="title">Server is Down!</span>
												<span class="message">Just now</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-lock bg-warning"></i>
												</div>
												<span class="title">User Locked</span>
												<span class="message">15 minutes ago</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-signal bg-success"></i>
												</div>
												<span class="title">Connection Restaured</span>
												<span class="message">10/10/2014</span>
											</a>
										</li>
									</ul>
			
									<hr />
			
									<div class="text-right">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">John Doe Junior</span>
								<span class="role">administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="fa fa-power-off"></i> Logout</a>
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
										<a href="index.html">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									<li>
										<a href="mailbox-folder.html">
											<span class="pull-right label label-primary">182</span>
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>Mailbox</span>
										</a>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Pages</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="pages-signup.html">
													 Sign Up
												</a>
											</li>
											<li>
												<a href="pages-signin.html">
													 Sign In
												</a>
											</li>
											<li>
												<a href="pages-recover-password.html">
													 Recover Password
												</a>
											</li>
											<li>
												<a href="pages-lock-screen.html">
													 Locked Screen
												</a>
											</li>
											<li>
												<a href="pages-user-profile.html">
													 User Profile
												</a>
											</li>
											<li>
												<a href="pages-session-timeout.html">
													 Session Timeout
												</a>
											</li>
											<li>
												<a href="pages-calendar.html">
													 Calendar
												</a>
											</li>
											<li>
												<a href="pages-timeline.html">
													 Timeline
												</a>
											</li>
											<li>
												<a href="pages-media-gallery.html">
													 Media Gallery
												</a>
											</li>
											<li>
												<a href="pages-invoice.html">
													 Invoice
												</a>
											</li>
											<li>
												<a href="pages-blank.html">
													 Blank Page
												</a>
											</li>
											<li>
												<a href="pages-404.html">
													 404
												</a>
											</li>
											<li>
												<a href="pages-500.html">
													 500
												</a>
											</li>
											<li>
												<a href="pages-log-viewer.html">
													 Log Viewer
												</a>
											</li>
											<li>
												<a href="pages-search-results.html">
													 Search Results
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>UI Elements</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="ui-elements-typography.html">
													 Typography
												</a>
											</li>
											<li>
												<a href="ui-elements-icons.html">
													 Icons
												</a>
											</li>
											<li>
												<a href="ui-elements-tabs.html">
													 Tabs
												</a>
											</li>
											<li>
												<a href="ui-elements-panels.html">
													 Panels
												</a>
											</li>
											<li>
												<a href="ui-elements-widgets.html">
													 Widgets
												</a>
											</li>
											<li>
												<a href="ui-elements-portlets.html">
													 Portlets
												</a>
											</li>
											<li>
												<a href="ui-elements-buttons.html">
													 Buttons
												</a>
											</li>
											<li>
												<a href="ui-elements-alerts.html">
													 Alerts
												</a>
											</li>
											<li>
												<a href="ui-elements-notifications.html">
													 Notifications
												</a>
											</li>
											<li>
												<a href="ui-elements-modals.html">
													 Modals
												</a>
											</li>
											<li>
												<a href="ui-elements-lightbox.html">
													 Lightbox
												</a>
											</li>
											<li>
												<a href="ui-elements-progressbars.html">
													 Progress Bars
												</a>
											</li>
											<li>
												<a href="ui-elements-sliders.html">
													 Sliders
												</a>
											</li>
											<li>
												<a href="ui-elements-carousels.html">
													 Carousels
												</a>
											</li>
											<li>
												<a href="ui-elements-accordions.html">
													 Accordions
												</a>
											</li>
											<li>
												<a href="ui-elements-nestable.html">
													 Nestable
												</a>
											</li>
											<li>
												<a href="ui-elements-tree-view.html">
													 Tree View
												</a>
											</li>
											<li>
												<a href="ui-elements-grid-system.html">
													 Grid System
												</a>
											</li>
											<li>
												<a href="ui-elements-charts.html">
													 Charts
												</a>
											</li>
											<li>
												<a href="ui-elements-animations.html">
													 Animations
												</a>
											</li>
											<li>
												<a href="ui-elements-extra.html">
													 Extra
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											<span>Forms</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="ajouter.php">
													 user
												</a>
											</li>
											<li>
												<a href="forms-advanced.html">
													 Advanced
												</a>
											</li>
											<li>
												<a href="forms-validation.html">
													 Validation
												</a>
											</li>
											<li>
												<a href="forms-layouts.html">
													 Layouts
												</a>
											</li>
											<li>
												<a href="forms-wizard.html">
													 Wizard
												</a>
											</li>
											<li>
												<a href="forms-code-editor.html">
													 Code Editor
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-table" aria-hidden="true"></i>
											<span>Tables</span>
										</a>
										<ul class="nav nav-children">
											<li class="nav-active">
												<a href="afficher.php">
													 user
												</a>
											</li>
											<li>
												<a href="tables-advanced.html">
													 Advanced
												</a>
											</li>
											<li>
												<a href="tables-responsive.html">
													 Responsive
												</a>
											</li>
											<li>
												<a href="tables-editable.html">
													 Editable
												</a>
											</li>
											<li>
												<a href="tables-ajax.html">
													 Ajax
												</a>
											</li>
											<li>
												<a href="tables-pricing.html">
													 Pricing
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											<span>Maps</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="maps-google-maps.html">
													 Basic
												</a>
											</li>
											<li>
												<a href="maps-google-maps-builder.html">
													 Map Builder
												</a>
											</li>
											<li>
												<a href="maps-vector.html">
													 Vector
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-columns" aria-hidden="true"></i>
											<span>Layouts</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="layouts-default.html">
													 Default
												</a>
											</li>
											<li>
												<a href="layouts-boxed.html">
													 Boxed
												</a>
											</li>
											<li>
												<a href="layouts-menu-collapsed.html">
													 Menu Collapsed
												</a>
											</li>
											<li>
												<a href="layouts-scroll.html">
													 Scroll
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-align-left" aria-hidden="true"></i>
											<span>Menu Levels</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a>First Level</a>
											</li>
											<li class="nav-parent">
												<a>Second Level</a>
												<ul class="nav nav-children">
													<li class="nav-parent">
														<a>Third Level</a>
														<ul class="nav nav-children">
															<li>
																<a>Third Level Link #1</a>
															</li>
															<li>
																<a>Third Level Link #2</a>
															</li>
														</ul>
													</li>
													<li>
														<a>Second Level Link #1</a>
													</li>
													<li>
														<a>Second Level Link #2</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li>
										<a href="../frontOffice/index.php" target="_blank">
											<i class="fa fa-external-link" aria-hidden="true"></i>
											<span>Front-End </span>
										</a>
									</li>
								</ul>
							</nav>
				
							<hr class="separator" />
				
							<div class="sidebar-widget widget-tasks">
								<div class="widget-header">
									<h6>Projects</h6>
									<div class="widget-toggle">+</div>
								</div>
								<div class="widget-content">
									<ul class="list-unstyled m-none">
										<li><a href="#">Porto HTML5 Template</a></li>
										<li><a href="#">Tucson Template</a></li>
										<li><a href="#">Porto Admin</a></li>
									</ul>
								</div>
							</div>
				
							<hr class="separator" />
				
							<div class="sidebar-widget widget-stats">
								<div class="widget-header">
									<h6>Company Stats</h6>
									<div class="widget-toggle">+</div>
								</div>
								<div class="widget-content">
									<ul>
										<li>
											<span class="stats-title">Stat 1</span>
											<span class="stats-complete">85%</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
													<span class="sr-only">85% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">Stat 2</span>
											<span class="stats-complete">70%</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
													<span class="sr-only">70% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">Stat 3</span>
											<span class="stats-complete">2%</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
													<span class="sr-only">2% Complete</span>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>User Table</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Tables</span></li>
								<li><span>Bornes</span></li>
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
						
								<h2 class="panel-title">User list </h2>
							</header>
							<div class="panel-body">
								<div class="row">
								</div>
								<table class="table table-bordered table-striped mb-none" id="datatable-editable">
									<thead style="background-color:rgb(6, 48, 70); color: white;">
										<tr>
											<th>ID borne</th>
                                            <th>Localisation</th>
                                            <th>Type bornes</th>
                                            <th>Etat bornes</th>
                                            <th>Puissance</th>
                                            <th>Nombre ports</th>
                                            <th>Date installation</th>
                                            <th>Operateur</th>
                                            <th>Actions</th>
										</tr>
									</thead>
									<tbody>
			<?php
			foreach ($liste as $borne) {
			?>
			<tr>
			<td><?php echo $borne['id_borne']; ?></td> <!-- Utilisation directe des indices du tableau associatif -->
            <td><?php echo $borne['localisation']; ?></td>
            <td><?php echo $borne['type_bornes']; ?></td>
			<td><?php echo $borne['etat_bornes']; ?></td>
            <td><?php echo $borne['puissance']; ?></td>
            <td><?php echo $borne['nombre_ports']; ?></td>
            <td><?php echo $borne['date_installation']; ?></td>
            <td><?php echo $borne['operateur']; ?></td>
            <td class="actions">
			<a href="#" class="on-default edit-row" onclick='openModal(<?= json_encode($borne) ?>)'>
    		<i class="fa fa-pencil"></i>
			</a>

                <a href="supp.php?id=<?php echo $borne['id_borne']; ?>" class="on-default remove-row" 
                onclick="return confirm('Voulez-vous vraiment supprimer <?php echo $borne['localisation'];?>?');">
                <i class="fa fa-trash-o"></i>
                </a>
            </td>

			</tr>
			<?php
			}
			?>
                                    </tbody>
								</table>
							</div>
						</section>
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

		<div id="dialog" class="modal-block mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Are you sure?</h2>
				</header>
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="modal-text">
							<p>Are you sure that you want to delete this row?</p>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button id="dialogConfirm" class="btn btn-primary">Confirm</button>
							<button id="dialogCancel" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/tables/examples.datatables.basic.js"></script>
		<!-- Fenêtre modale -->
		<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    	background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
    		<div style="background:white; padding:20px; border-radius:10px; max-width:400px; width:90%;">
        		<h3>Modifier Borne Electrique</h3>
				<form method="POST" id="form">
					<input type="hidden" name="id" id="id">

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
<div class="form-container">
    <div class="input-group input-group-icon">
        <input class="form-control" type="text" placeholder="Localisation" name="localisation" id="localisation" 
            value="<?= isset($borne['localisation']) ? $borne['localisation'] : '' ?>" required>
        
        <button type="button" class="btn btn-default" onclick="openMap()">📍 Choisir sur la carte</button>
        
        <div id="map"></div>
    </div>
    <span class="error-message" id="localisation_error" style="color: red;" ></span>
</div>


<!-- Message d'erreur en rouge -->
<span class="error-message" id="localisation_error" style="color: red;"></span>
<br>

 <!-- Type de Borne -->
<div class="input-group input-group-icon">
    <select class="form-control" name="type_bornes" id="type_bornes">
        <option value="">-- Type de Borne --</option>
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
    <select class="form-control" name="etat_bornes" id="etat_borne" required>
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
    <input class="form-control" type="number" placeholder="Nombre de ports" name="nombre_ports" id="nombre_ports" 
        value="<?= isset($borne['nombre_ports']) ? $borne['nombre_ports'] : '' ?>" required>
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
<div class="input-group input-group-icon">
    <select class="form-control" name="operateur" id="operateur" required>
        <option value="">-- Sélectionner l'opérateur responsable --</option>
        <option value="TotalEnergies" <?= (isset($borne['operateur']) && $borne['operateur'] == 'TotalEnergies') ? 'selected' : '' ?>>TotalEnergies</option>
        <option value="Ola Energie" <?= (isset($borne['operateur']) && $borne['operateur'] == 'Ola Energie') ? 'selected' : '' ?>>Ola Energie</option>
    </select>
</div>
<span class="error-message" id="operateur_error" style="color: red;"></span>


    
					<button type="submit" name="modifier" class="submit-button">Modifier</button>
					<button type="button" onclick="closeModal()" class="cancel-button">Annuler</button>
				</form>
    </div>
</div>
<script>

function openModal(ModelBorneElectrique) {
    document.getElementById("editModal").style.display = "flex";

	document.getElementById("id_borne").value = ModelBorneElectrique.id_borne; //important!!!!!!!!!
    document.getElementById("localisation").value = ModelBorneElectrique.localisation;
    document.getElementById("type_bornes").value = ModelBorneElectrique.type_bornes;
    document.getElementById("etat_bornes").value = ModelBorneElectrique.etat_bornes;
    document.getElementById("puissance").value = ModelBorneElectrique.puissance;
    document.getElementById("nombre_ports").value = ModelBorneElectrique.nombre_ports;
    document.getElementById("date_installation").value = ModelBorneElectrique.date_installation;
    document.getElementById("operateur").value = ModelBorneElectrique.operateur;
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}
</script>
<script src="Js/validation.js"></script>
	</body>
</html>
