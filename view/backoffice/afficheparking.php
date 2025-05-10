<?php
session_start();

require_once 'C:/xampp/htdocs/urbanisme/model/parking.php';
 
$parkings = Parking::getAllParkings();
?>

<!doctype html>
<html class="fixed">
	<head>
	<script src="validation.js" defer></script>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Basic Tables | Okler Themes | Porto-Admin</title>
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
						<img src="assets/images/logosansnom.png" height="35" alt="Porto Admin" />
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
											<li >
												<a href="indexparking.php">
													 form parking
												</a>
											</li>
											<li class="nav-active">
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
										<a href="http://localhost/urbanisme/view/frontoffice/index.php" target="_blank">
											<i class="fa fa-external-link" aria-hidden="true"></i>
											<span>Front-End <em class="not-included">(Not Included)</em></span>
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
						<h2>Basic Tables</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Tables</span></li>
								<li><span>Basic</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<h2 style="font-family: Arial, sans-serif;">Liste des Parkings</h2>
					<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
						<thead>
							<tr style="background-color: #2c3e50; color: white;">
								<th style="padding: 12px; border: 1px solid #ddd;">Nom</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Localisation</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Ville</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Capacité Totale</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Places Disponibles</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Tarif Horaire (€)</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Sécurisé</th>
								<th style="padding: 12px; border: 1px solid #ddd;">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($parkings as $parking): ?>
								<tr style="background-color: #f9f9f9; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d6eaf8';" onmouseout="this.style.backgroundColor='#f9f9f9';">
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['nom_parking']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['localisation']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['ville']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['capacite_totale']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['places_dispo']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($parking['tarif_horaire']) ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $parking['securise'] ? 'Oui' : 'Non' ?></td>
									<td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
										<form class="form_suppression" method="POST" onsubmit="return validerFormulaire();">
											<input type="hidden" name="id_parking" value="<?= $parking['id_parking'] ?>">
											<button type="submit" class="delete-btn" style="padding: 6px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
												Supprimer
											</button>
										</form>
										<button class="modify-btn" style="padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;" data-id="<?= $parking['id_parking'] ?>" data-nom="<?= $parking['nom_parking'] ?>" data-localisation="<?= $parking['localisation'] ?>" data-ville="<?= $parking['ville'] ?>" data-capacite="<?= $parking['capacite_totale'] ?>" data-places="<?= $parking['places_dispo'] ?>" data-tarif="<?= $parking['tarif_horaire'] ?>" data-securise="<?= $parking['securise'] ? '1' : '0' ?>">
                        				Modifier
                    					</button>
									</td>
								</tr>
								

							<?php endforeach; ?>
							<div id="modal-suppression" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
									<div style="background: white; padding: 20px; border-radius: 5px; width: 350px;">
										<h4>Confirmation</h4>
										<p>Voulez-vous vraiment supprimer ce parking ?</p>
										<form id="form-confirm-supp" method="post">
										<input type="hidden" name="id_parking" id="id-parking-supp">
										<button type="submit" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Supprimer</button>
										<button type="button" onclick="$('#modal-suppression').hide();" style="margin-left: 10px; padding: 10px 20px;">Annuler</button>
										</form>
									</div>
								</div>
						</tbody>
					</table>
					<!-- Fenêtre modale de modification -->
					<div id="modal-modifier" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
						<div style="background: white; padding: 20px; border-radius: 5px; width: 400px; max-height: 90vh; overflow-y: auto;" >
							<h3>Modifier Parking</h3>
							<form id="form-modifier">
								<input type="hidden" id="parking-id" name="id_parking">
								<div style="margin-bottom: 10px;">
									<label for="nom_parking">Nom:</label>
									<input type="text" id="nom_parking" name="nom_parking"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="localisation">Localisation:</label>
									<input type="text" id="localisation" name="localisation"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="ville">Ville:</label>
									<input type="text" id="ville" name="ville"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="capacite_totale">Capacité Totale:</label>
									<input type="number" id="capacite_totale" name="capacite_totale"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="places_dispo">Places Disponibles:</label>
									<input type="number" id="places_dispo" name="places_dispo"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="tarif_horaire">Tarif Horaire (€):</label>
									<input type="number" step="0.01" id="tarif_horaire" name="tarif_horaire"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
								</div>
								<div style="margin-bottom: 10px;">
									<label for="securise">Sécurisé:</label>
									<select id="securise" name="securise"  style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
										<option value="1">Oui</option>
										<option value="0">Non</option>
									</select>
								</div>
								<button type="submit" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Modifier</button>
								<button type="button" onclick="closeModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Annuler</button>
							</form>

						</div>
					</div>

				 

					 
					<button onclick="exporterPDF()"style="margin: 20px; padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
						Exporter PDF
					</button>
					 

					<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

					<script>
						async function exporterPDF() {
							const container = document.createElement("div");
							container.innerHTML = `
								<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 30px; background-color: #e0e3e7;">
									<div style="text-align: center;">
										<img src="assets/images/logosansnom555.png" alt="Logo" style="width: 250px; margin-bottom: 30px;">
									</div>
									<h2 style="text-align: center; color: #1a1a1a; margin-bottom: 30px;">Liste des parkings</h2>
									<table style="width: 100%; border-collapse: separate; border-spacing: 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
										<thead>
											<tr style="background-color: #34495e; color: #ffffff;">
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Nom</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Localisation</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Ville</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Capacité Totale</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Places Disponibles</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Tarif Horaire (€)</th>
												<th style="padding: 14px; border-bottom: 3px solid #2c3e50;">Sécurisé</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($parkings as $index => $parking): ?>
											<tr style="background-color: <?= $index % 2 === 0 ? '#f8f9fa' : '#ecf0f1' ?>; transition: background-color 0.3s;">
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['nom_parking']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['localisation']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['ville']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['capacite_totale']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['places_dispo']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= htmlspecialchars($parking['tarif_horaire']) ?></td>
												<td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;"><?= $parking['securise'] ? 'Oui' : 'Non' ?></td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							`;

							document.body.appendChild(container);

							setTimeout(() => {
								html2canvas(container).then(canvas => {
									const imgData = canvas.toDataURL("image/png");
									const pdf = new jspdf.jsPDF("p", "mm", "a4");
									const pageWidth = pdf.internal.pageSize.getWidth();
									const imgWidth = pageWidth - 20;
									const imgHeight = (canvas.height * imgWidth) / canvas.width;

									pdf.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
									pdf.save("liste_parkings.pdf");

									document.body.removeChild(container);
								});
							}, 300);
						}
						</script>




					


					<!-- jQuery -->
					<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
					
					<script>
						function closeModal() {
							$("#modal-modifier").css("display", "none");
						}
					$(document).ready(function() {
						// Ouvrir la fenêtre modale
						$(".modify-btn").click(function() {
							var parkingId = $(this).data('id');
							var nom = $(this).data('nom');
							var localisation = $(this).data('localisation');
							var ville = $(this).data('ville');
							var capacite = $(this).data('capacite');
							var places = $(this).data('places');
							var tarif = $(this).data('tarif');
							var securise = $(this).data('securise');

							// Remplir les champs avec les données actuelles
							$("#parking-id").val(parkingId);
							$("#nom_parking").val(nom);
							$("#localisation").val(localisation);
							$("#ville").val(ville);
							$("#capacite_totale").val(capacite);
							$("#places_dispo").val(places);
							$("#tarif_horaire").val(tarif);
							$("#securise").val(securise);

							// Afficher la fenêtre modale
							$("#modal-modifier").css("display", "flex");
						});

						 
						

						// Soumettre le formulaire de modification
						$("#form-modifier").submit(function(event) {
							event.preventDefault();
							if (!validerFormulaire()) {
								return;
							}

							var formData = $(this).serialize();

							$.ajax({
								type: "POST",
								url: "../../controller/modparking.php",  
								data: formData,
								success: function(response) {
									 
									closeModal();
									 
									$("#message").html(response);
									setTimeout(function() {
										location.reload();
									}, 1500);
								},
								error: function() {
									$("#message").html("<span style='color:red;'>Erreur lors de la modification.</span>");
								}
							});
						});
					});
					</script> 

					 


					<!-- Zone d'affichage du message -->
					<div id="message" style="margin-top: 10px; color: green; font-weight: bold;"></div>

					<!-- jQuery -->
					<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

					<script>
					$(".form_suppression").submit(function(e) {
					e.preventDefault();  
					var id = $(this).find('input[name="id_parking"]').val();
					$("#id-parking-supp").val(id);
					$("#modal-suppression").show();
					});

					$("#modal-suppression").on("click", function(e) {
						if (e.target === this) {
							$(this).hide();
						}
					});



					$(".form_suppression").submit(function(event) {
						event.preventDefault();
						var id = $(this).find("input[name='id_parking']").val();
						$("#id-parking-supp").val(id);  
						$("#modal-suppression").css("display", "flex");  
					});

					 
					$("#form-confirm-supp").submit(function(e) {
						e.preventDefault();
						var formData = $(this).serialize();

						$.ajax({
							type: "POST",
							url: "../../controller/suppparking.php",
							data: formData,
							success: function(response) {
								$("#modal-suppression").hide();
								$("#message").html(response);
								 
								$("tr[data-id='" + $("#id-parking-supp").val() + "']").fadeOut();

								 
								setTimeout(function() {
									location.reload();
								}, 1000);
							},
							error: function() {
								$("#message").html("<span style='color:red;'>Erreur lors de la suppression.</span>");
							}
						});
					});

					</script>

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
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>