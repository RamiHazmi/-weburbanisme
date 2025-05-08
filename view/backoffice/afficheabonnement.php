<?php
require_once 'C:/xampp/htdocs/Urbanisme/db_connect.php';
require_once 'C:/xampp/htdocs/Urbanisme/Model/abonnement.php';
<<<<<<< HEAD
require_once 'C:/xampp/htdocs/Urbanisme/Controller/notificationController.php';

 

$conn = config::getConnexion();

$sql = "SELECT a.*, p.nom_parking, u.username, u.phone
=======

$conn = config::getConnexion();

$sql = "SELECT a.*, p.nom_parking, u.username 
>>>>>>> origin/parking
        FROM abonnement a
        JOIN parking p ON a.id_parking = p.id_parking
        JOIN user u ON a.id_user = u.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$abonnements = $stmt->fetchAll();


 
?>

<<<<<<< HEAD
  
=======

>>>>>>> origin/parking

<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Default Layout | Okler Themes | Porto-Admin</title>
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

<<<<<<< HEAD
	 


=======
>>>>>>> origin/parking
	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
<<<<<<< HEAD
						<img src="assets/images/logosansnom555.png" height="35" alt="Porto Admin" />
=======
						<img src="assets/images/logo.png" height="35" alt="Porto Admin" />
>>>>>>> origin/parking
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
												<a href="forms-basic.html">
													 User
												</a>
											</li>
											<li>
												<a href="forms-advanced.html">
													 Recharge Electrique
												</a>
											</li>
											<li>
												<a href="forms-validation.html">
													 Covoiturage
												</a>
											</li>
											<li>
												<a href="forms-layouts.html">
													 Transport Electrique
												</a>
											</li>
											<li>
<<<<<<< HEAD
												<a href="http://localhost/Urbanisme/view/backoffice/indexparking.php">
=======
												<a href="http://localhost/Urbanisme/view/backoffice/index.php">
>>>>>>> origin/parking
													 Parking
												</a>
											</li>
											<li>
												<a href="forms-code-editor.html">
													 Code Editor
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-table" aria-hidden="true"></i>
											<span>Tables</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="tables-basic.html">
													 Basic
												</a>
											</li>
											<li>
												<a href="tables-advanced.html">
													 Advanced
												</a>
											</li>
											<li>
<<<<<<< HEAD
                                                <a href="http://localhost/Urbanisme/view/backoffice/afficheparking.php">
=======
                                                <a href="http://localhost/Urbanisme/view/backoffice/affiche.php">
>>>>>>> origin/parking
													 affiche parking
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
									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-columns" aria-hidden="true"></i>
											<span>Layouts</span>
										</a>
										<ul class="nav nav-children">
											<li class="nav-active">
                                                <a href="http://localhost/Urbanisme/view/backoffice/afficheabonnement.php">
													 affiche reservation 
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
										<a href="http://localhost/Urbanisme/view/frontoffice/frontparking.php"  target="_blank">
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
						<h2>Default Layout</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Layouts</span></li>
								<li><span>Default</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
                    <h2 style="font-family: Arial, sans-serif;">Liste des Abonnements</h2>
<<<<<<< HEAD
					 

						
=======
>>>>>>> origin/parking
                        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
                            <thead>
                                <tr style="background-color: #2c3e50; color: white;">
                                    <th style="padding: 12px; border: 1px solid #ddd;">Nom Client</th>
<<<<<<< HEAD
									<th style="padding: 12px; border: 1px solid #ddd;">Num Client</th>
=======
>>>>>>> origin/parking
                                    <th style="padding: 12px; border: 1px solid #ddd;">Parking</th>
                                    <th style="padding: 12px; border: 1px solid #ddd;">Date Début</th>
                                    <th style="padding: 12px; border: 1px solid #ddd;">Date Fin</th>
                                    <th style="padding: 12px; border: 1px solid #ddd;">Places Réservées</th>
<<<<<<< HEAD
									<th style="padding: 12px; border: 1px solid #ddd;">statut</th>
=======
>>>>>>> origin/parking
                                    <th style="padding: 12px; border: 1px solid #ddd;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($abonnements as $abonnement): ?>
                                    <tr style="background-color: #f9f9f9; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d6eaf8';" onmouseout="this.style.backgroundColor='#f9f9f9';">
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['username']) ?></td>
<<<<<<< HEAD
										<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['phone']) ?></td>
=======
>>>>>>> origin/parking
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['nom_parking']) ?></td>
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_debut']) ?></td>
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_fin']) ?></td>
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['places_reservees']) ?></td>
<<<<<<< HEAD
										<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['status']) ?></td>
=======
>>>>>>> origin/parking
                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                            <!-- Exemple de bouton de suppression ou modification -->
                                            <form class="form_supp_abonnement" method="POST" onsubmit="return false;" style="display: inline;">
												<input type="hidden" name="id_abonnement" value="<?= $abonnement['id_abonnement'] ?>">
												<button type="button" class="btn-delete-abonnement" data-id="<?= $abonnement['id_abonnement'] ?>" style="padding: 6px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
													Supprimer
												</button>
											</form>

											<button class="btn-edit-abonnement" data-id="<?= $abonnement['id_abonnement'] ?>" data-username="<?= htmlspecialchars($abonnement['username']) ?>" data-parking="<?= htmlspecialchars($abonnement['nom_parking']) ?>" data-debut="<?= $abonnement['date_debut'] ?>" data-fin="<?= $abonnement['date_fin'] ?>" data-places="<?= $abonnement['places_reservees'] ?>" style="padding: 6px 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
												Modifier
											</button>
<<<<<<< HEAD
											
											 



=======
>>>>>>> origin/parking


                                            <!-- Tu peux ajouter ici un bouton Modifier avec une modale si besoin -->
                                        </td>
                                    </tr>
									<div id="modal-supp-abonnement" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
										<div style="background: white; padding: 20px; border-radius: 5px; width: 350px;">
											<h4>Confirmation</h4>
											<p>Voulez-vous vraiment supprimer cet abonnement ?</p>
											<form id="form-confirm-supp-abonnement" method="POST" action="../../controller/suppabonnement.php">
												<input type="hidden" name="id_abonnement" id="id-abonnement-supp">  <!-- ID caché -->
												<button type="submit" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Supprimer</button>
												<button type="button" onclick="$('#modal-supp-abonnement').hide();" style="margin-left: 10px; padding: 10px 20px;">Annuler</button>
											</form>
										</div>
									</div>

									


									

                                <?php endforeach; ?>
								<div id="modal-edit-abonnement" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
									<div style="background: white; padding: 20px; border-radius: 5px; width: 400px;">
										<h4>Modifier l'abonnement</h4>
										<form id="form-edit-abonnement" method="POST" action="../../controller/modifierabonnement.php">
											<input type="hidden" name="id_abonnement" id="edit-id-abonnement">
											
											<label>Nom Client :</label>
											<input type="text" name="username" id="edit-username" style="width: 100%; padding: 8px; margin-bottom: 10px;" readonly>

											<label>Parking :</label>
											<input type="text" name="nom_parking" id="edit-parking" style="width: 100%; padding: 8px; margin-bottom: 10px;" readonly>

											<label>Date Début :</label>
<<<<<<< HEAD
											<input type="datetime-local" name="date_debut" id="edit-date-debut" style="width: 100%; padding: 8px; margin-bottom: 10px;">
											<span id="erreur_nom" class="erreur-message"></span>

											<label>Date Fin :</label>
											<input type="datetime-local"name="date_fin" id="edit-date-fin" style="width: 100%; padding: 8px; margin-bottom: 10px;">
=======
											<input type="date" name="date_debut" id="edit-date-debut" style="width: 100%; padding: 8px; margin-bottom: 10px;">
											<span id="erreur_nom" class="erreur-message"></span>

											<label>Date Fin :</label>
											<input type="date" name="date_fin" id="edit-date-fin" style="width: 100%; padding: 8px; margin-bottom: 10px;">
>>>>>>> origin/parking

											<label>Places Réservées :</label>
											<input type="number" name="places_reservees" id="edit-places" style="width: 100%; padding: 8px; margin-bottom: 10px;">

											<!-- ✅ Champ caché pour stocker l’ancienne valeur des places -->
											<input type="hidden" id="edit-old-places" name="old_places_reservees">

											<div id="error-message" class="erreur-message" style="color: red; margin-bottom: 10px;"></div>

											<button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Enregistrer</button>
											<button type="button" onclick="$('#modal-edit-abonnement').hide();" style="margin-left: 10px; padding: 10px 20px;">Annuler</button>
										</form>
									</div>
								</div>

<<<<<<< HEAD
								 


								 

                            </tbody>
                        </table>
						 
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
									<h2 style="text-align: center; color: #1a1a1a; margin-bottom: 30px;">Liste des abonnements</h2>
									<table style="width: 100%; border-collapse: separate; border-spacing: 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
										<thead>
											<tr style="background-color: #34495e; color: #ffffff;">
												<th style="padding: 12px; border: 1px solid #ddd;">Nom Client</th>
												<th style="padding: 12px; border: 1px solid #ddd;">Num Client</th>
												<th style="padding: 12px; border: 1px solid #ddd;">Parking</th>
												<th style="padding: 12px; border: 1px solid #ddd;">Date Début</th>
												<th style="padding: 12px; border: 1px solid #ddd;">Date Fin</th>
												<th style="padding: 12px; border: 1px solid #ddd;">Places Réservées</th>
												<th style="padding: 12px; border: 1px solid #ddd;">statut</th>
											</tr>
										</thead>
										<tbody>
											 <?php foreach ($abonnements as $abonnement): ?>
												<tr style="background-color: #f9f9f9; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d6eaf8';" onmouseout="this.style.backgroundColor='#f9f9f9';">
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['username']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['phone']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['nom_parking']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_debut']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['date_fin']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['places_reservees']) ?></td>
													<td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= htmlspecialchars($abonnement['status']) ?></td>
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
									pdf.save("liste_abonnements.pdf");

									document.body.removeChild(container);
								});
							}, 300);
						}
						</script>

						 

						 
						 

						<?php require_once 'C:/xampp/htdocs/Urbanisme/controller/dashboardControlleromar.php'; ?>

						 

						<?php
							// Générer les données pour le diagramme circulaire
							$donneesCamembert = [];
							foreach ($taux as $row) {
								$donneesCamembert[] = [
									'nom' => $row['nom_parking'],
        							'nb' => (int)$row['total_places_reservees']
								];
							}
							?>
						
=======
                            </tbody>
                        </table>
>>>>>>> origin/parking
						
						<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

						<script>
							$(document).ready(function() {
								// Ouvrir la modale lors du clic sur le bouton de suppression
								$(".btn-delete-abonnement").click(function() {
									var id = $(this).data('id');  // Récupère l'ID depuis l'attribut data-id
									$("#id-abonnement-supp").val(id);  // Remplir l'input caché avec l'ID
									$("#modal-supp-abonnement").css("display", "flex");  // Affiche la modale
								});

								// Fermeture de la modale si on clique en dehors de la boîte
								$("#modal-supp-abonnement").on("click", function(e) {
									if (e.target === this) {
										$(this).hide();
									}
								});

								// Soumission du formulaire de confirmation de suppression (AJAX)
								$("#form-confirm-supp-abonnement").submit(function(e) {
									e.preventDefault();  // Empêche la soumission classique du formulaire
									var formData = $(this).serialize();  // Sérialise les données du formulaire

									// Envoi de la requête AJAX
									$.ajax({
										type: "POST",
										url: "../../controller/suppabonnement.php",  // Le fichier PHP pour traiter la suppression
										data: formData,  // Données à envoyer (ID de l'abonnement)
										success: function(response) {
											console.log(response);  // Affiche la réponse pour le debug

											if (response === "success") {  // Si la suppression a réussi
												$("#modal-supp-abonnement").hide();  // Cache la modale
												$("tr[data-id='" + $("#id-abonnement-supp").val() + "']").fadeOut();  // Masque l'élément correspondant à l'ID dans le tableau

												// Recharge la page après un court délai (1 seconde ici)
												setTimeout(function() {
													location.reload();
												}, 1000);
											} else {
												// Si la suppression échoue, affiche un message d'erreur
												$("#message").html("<span style='color:red;'>Erreur lors de la suppression de l'abonnement.</span>");
											}
										},
										error: function() {
											// En cas d'erreur AJAX
											$("#message").html("<span style='color:red;'>Erreur lors de la suppression.</span>");
										}
									});
								});
							});

						</script>
					<script>
						function afficherErreurModal(message) {
							$("#error-message").text(message);
						}

						$(document).ready(function () {

							// Afficher le formulaire de modification rempli avec les données
							$(".btn-edit-abonnement").click(function () {
								var id = $(this).data('id');
								var username = $(this).data('username');
								var parking = $(this).data('parking');
								var debut = $(this).data('debut');
								var fin = $(this).data('fin');
								var places = $(this).data('places');

								$("#edit-id-abonnement").val(id);
								$("#edit-username").val(username);
								$("#edit-parking").val(parking);
								$("#edit-date-debut").val(debut);
								$("#edit-date-fin").val(fin);
								$("#edit-places").val(places);
								$("#edit-old-places").val(places); // important pour la logique de comparaison

								$("#modal-edit-abonnement").css("display", "flex");
							});

							// Formulaire de modification
							$("#form-edit-abonnement").submit(function (e) {
								e.preventDefault();

								if (!validerFormulaire()) {
									return;
								}

								var formData = $(this).serialize();

								$.ajax({
									type: "POST",
									url: "../../controller/modabonnement.php",
									data: formData,
									success: function(response) {
										try {
											var data = JSON.parse(response);

											if (data.status === "success") {
												// Remplacer l'alerte par un message dans une modale ou un autre feedback
												// alert(data.message); // Supprimer ou commenter cette ligne
												$("#notification").text(data.message).fadeIn().delay(2000).fadeOut(); // Afficher un message discret
												location.reload();
											} else {
												// Si c'est une erreur, l'afficher proprement
												$('#error-message').text(data.message); // ce div existe déjà dans ton formulaire
											}
										} catch (e) {
											console.error("Erreur de parsing JSON :", e, response);
											$('#error-message').text("Erreur inattendue. Veuillez réessayer.");
										}
									}
								});
							});

							// Fermer la modale si on clique à l'extérieur
							$("#modal-edit-abonnement").on("click", function (e) {
								if (e.target === this) {
									$(this).hide();
								}
							});

						});
					</script>



<<<<<<< HEAD
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<!-- Graphique Taux d'occupation par parking -->
					<h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; color: #333; margin-top: 40px; font-size: 24px; border-bottom: 2px solid #4CAF50; padding-bottom: 10px;">
						Taux d'occupation par parking
					</h2>
					<div id="chart_taux_graph" style="width: 800px; height: 500px; margin: 40px auto; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px;"></div>

 

					<script type="text/javascript">
						google.charts.load('current', { packages: ['corechart', 'bar'] });
						google.charts.setOnLoadCallback(drawTauxOccupationChart);

						function drawTauxOccupationChart() {
							var data = google.visualization.arrayToDataTable([
								['Parking', 'Taux d\'occupation (%)'],
								<?php foreach ($taux as $row): ?>
									['<?= addslashes($row["nom_parking"]) ?>', <?= (float)$row["taux"] ?>],
								<?php endforeach; ?>
							]);

							var options = {
								title: 'Taux d\'occupation des parkings',
								hAxis: { title:'Taux d\'occupation (%)', minValue: 0 },
								vAxis: { title: 'Nom du parking'  },
								legend: 'none',
								bars: 'vertical', // Changer la direction en vertical
								colors: ['#4CAF50']
							};

							var chart = new google.visualization.BarChart(document.getElementById('chart_taux_graph'));
							chart.draw(data, options);
						}
					</script>

					 



					 

					
					<script type="text/javascript">
						google.charts.load('current', {packages: ['corechart']});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							const data = google.visualization.arrayToDataTable([
								['Parking', 'Nombre d\'abonnements'],
								<?php foreach ($donneesCamembert as $row): ?>
									['<?= addslashes($row['nom']) ?>', <?= $row['nb'] ?>],
								<?php endforeach; ?>
							]);

							const options = {
								title: 'Répartition des abonnements par parking',
								is3D: true,
								legend: { position: 'right', textStyle: { fontSize: 14, bold: true } },
								chartArea: {width: '100%', height: '80%'},
								colors: ['#8e44ad', '#9b59b6', '#af7ac5', '#bb8fce', '#d2b4de', '#e8daef'],
								backgroundColor: 'transparent',
								titleTextStyle: { fontSize: 20, bold: true, color: '#2c3e50' }
							};

							const chart = new google.visualization.PieChart(document.getElementById('piechart'));
							chart.draw(data, options);
						}
					</script>

					<div id="piechart" style="width: 600px; height: 400px; margin: 40px auto; border: 2px solid #ccc; border-radius: 15px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: #fdfdfd;"></div>

					 
											



				 
=======

>>>>>>> origin/parking


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

			<!-- Vendor -->
			<script src="assets/vendor/jquery/jquery.js"></script>
			<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
			<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
			<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
			<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
			<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
			<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
			
			<!-- Specific Page Vendor -->
			
			<!-- Theme Base, Components and Settings -->
			<script src="assets/javascripts/theme.js"></script>
			
			<!-- Theme Custom -->
			<script src="assets/javascripts/theme.custom.js"></script>
			
			<!-- Theme Initialization Files -->
			<script src="assets/javascripts/theme.init.js"></script>
			<script src="validationmodabonnement.js"></script>

		</section>
	</body>
</html>