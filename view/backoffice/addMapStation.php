<?php 
session_start();
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Form Layouts | Okler Themes | Porto-Admin</title>
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
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


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
									<li class="nav-parent ">
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
									<li class="nav-parent nav-expanded nav-active">
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
											<li class="nav-active">
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
						<h2>Form Location Station</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>SmartBikeRental</span></li>
								<li><span>Form Location Station</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->


					





                    <section class="content-with-menu" data-theme-gmap-builder>
                    <div class="content-with-menu-container">

<div class="inner-menu-toggle">
    <a href="#" class="inner-menu-expand" data-open="inner-menu">
        Show Options <i class="fa fa-chevron-right"></i>
    </a>
</div>

<menu id="content-menu" class="inner-menu" role="menu">
    <div class="nano">
        <div class="nano-content">

            <div class="inner-menu-toggle-inside">
                <a href="#" class="inner-menu-collapse">
                    <i class="fa fa-chevron-up visible-xs-inline"></i><i class="fa fa-chevron-left hidden-xs-inline"></i> Hide Options
                </a>
                <a href="#" class="inner-menu-expand" data-open="inner-menu">
                    Show Options <i class="fa fa-chevron-down"></i>
                </a>
            </div>


                <p class="title">Configuration</p>

                <div class="form-group">
                    <div class="row">
                        <label class="col-xs-12 control-label" for="stationSelect">Select a Bike Station</label>
                        <div class="col-xs-12">
                            <select id="stationSelect" name="stationSelect" class="form-control">
                                <?php
                                require_once __DIR__ . '/../../Controller/BikeStationController.php'; // Nouveau contrôleur à créer

                                $stationController = new BikeStationController();
                                $stations = $stationController->listStations();

                                foreach ($stations as $station) {
                                    echo '<option value="' . $station['id_station'] . '">' . htmlspecialchars($station['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

            

                <hr class="separator" />

                <p class="title">Map Center</p>

                <div class="form-group">
                    <div class="row">
                        <label class="col-xs-12 control-label" for="latitude">Latitude</label>
                        <div class="col-xs-12">
                            <input id="latitude" name="latitude" class="form-control" type="text" data-builder-field="latlng">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-xs-12 control-label" for="longitude">Longitude</label>
                        <div class="col-xs-12">
                            <input id="longitude" name="longitude" class="form-control" type="text" data-builder-field="latlng">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-xs-12 control-label" for="zoomLevel">Zoom Level</label>
                        <div class="col-xs-12">
                            <select id="zoomLevel" class="form-control mb-md" data-plugin-selectTwo data-plugin-options='{ "minimumResultsForSearch": -1 }' data-builder-field="zoomlevel">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="separator" />
                <div class="form-group">
                    <ul id="MarkersList" class="list-markers list-unstyled mb-lg hidden">
                    </ul>
                    <div class="col-sm-12 text-center">
    <button id="saveCoordinates" class="btn btn-primary">Add</button>
</div>

                    <div>
                        '  
                    </div>
                    <div class="col-sm-12">
    <button id="showStationsBtn" class="btn btn-success btn-block mb-lg" type="button">Show All Stations</button>
</div>


                    
                </div>


                

                
            </div>
        </div>
    </div>
</menu>
<div class="inner-body">
    <div id="gmap"></div>
    

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



        <script>
    let map;
    let marker; // Only one marker at a time

    function initMap() {
        map = L.map('gmap').setView([36.8065, 10.1815], 13); // Centered at Tunis for example

        // Add OpenStreetMap tiles (free)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // On map click, add a marker
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;

            // If marker already exists, remove it
            if (marker) {
                map.removeLayer(marker);
            }

            // Create new marker
            marker = L.marker([lat, lng]).addTo(map);

            // Fill latitude and longitude inputs
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        });
    }

    window.onload = initMap;
</script>
<script>
    document.getElementById('saveCoordinates').addEventListener('click', function() {
        const stationId = document.getElementById('stationSelect').value;
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (!stationId || !latitude || !longitude) {
            alert('Please select a station and place a marker on the map.');
            return;
        }

        // Send the data to PHP using Fetch API (AJAX)
        fetch('save_coordinates.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `stationId=${stationId}&latitude=${latitude}&longitude=${longitude}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Success message from server
            // Optionally, clear fields or refresh page
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
<script>
    document.getElementById('showStationsBtn').addEventListener('click', function() {
    fetch('get_stations.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(station => {
                if (station.latitude && station.longitude) {
                    L.marker([station.latitude, station.longitude])
                        .addTo(map)
                        .bindPopup(`<b>${station.name}</b>`);
                }
            });
        })
        .catch(error => console.error('Error fetching stations:', error));
});

</script>


	</body>
</html>