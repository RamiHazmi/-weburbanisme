<?php 
session_start();
?>
<?php
require_once __DIR__ . '/../../Controller/RentalController.php';
require_once __DIR__ . '/../../Controller/BikeStationController.php';
require_once __DIR__ . '/../../controller/userC.php';

$stationController = new BikeStationController();
$rentalController = new BikeRentalController();
$userController = new userC();
$rentals = $rentalController->listRentals();

// Group rentals by user ID
$users = [];
foreach ($rentals as $rental) {
    $id_user = $rental['id_user'];
	$rental['end_station_name'] = $stationController->getStationNameById($rental['end_station']);
    $rental['username'] = $userController->getUsernameById($id_user);

    $users[$id_user][] = $rental;
}
?>


<!doctype html>
<html class="fixed">
	<head>

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
		<link rel="stylesheet" href="assets/stylesheets/popUp.css"> <!-- Path to your CSS file -->


		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        




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
											<li class="nav-active">
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
						<h2>Rentals</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>SmartBikeRental</span></li>
								<li><span>Table Rentals</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
                    <h2>Rentals By User</h2>

<?php foreach ($users as $userId => $userRentals): ?>
    <div class="user-block" onclick="toggleRentals(<?= $userId ?>)">
        <strong>User:</strong> <?= htmlspecialchars($userRentals[0]['username'] ?? 'Unknown User') ?>
    </div>

    <div class="rental-table table-responsive" id="rentals-<?= $userId ?>" style="display: none;">
        
        <!-- 🚀 Add the search and sort controls here -->
        <div class="rental-controls">
            <input type="text" class="rental-search" placeholder="Search Rentals..." onkeyup="filterRentals(<?= $userId ?>)">
            <select class="rental-sort" onchange="sortRentals(<?= $userId ?>)">
                <option value="">Sort By</option>
                <option value="end_time_asc">End Time (Asc)</option>
                <option value="end_time_desc">End Time (Desc)</option>
            </select>
        </div>

        <table class="table" id="rental-table-<?= $userId ?>">
            <thead>
                <tr>
                    <th>Rental ID</th>
                    <th>Bike ID</th>
                    <th>Start Station</th>
                    <th>End Station</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userRentals as $rental): ?>
                    <tr>
                        <td><?= $rental['id_rental'] ?></td>
                        <td><?= $rental['id_bike'] ?></td>
                        <td><?= $rental['start_station'] ?></td>
                        <td><?= $rental['end_station_name'] ?? 'Unknown' ?></td>
                        <td><?= $rental['start_time'] ?></td>
                        <td><?= $rental['end_time'] ?></td>
                        <td><?= $rental['feedback'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

					




						
						
						
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
        <style>
    .user-block {
        background-color:rgb(77, 88, 95);
        color: white;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 18px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
    }

    .user-block:hover {
        background-color:rgb(202, 222, 235);
    }

    .rental-table {
        margin-bottom: 30px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 10px;
        background: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .rental-table table {
        margin-top: 10px;
    }

    .rental-table th {
        background-color: #f1f1f1;
        font-weight: 600;
    }

    .rental-table td, .rental-table th {
        padding: 10px;
        text-align: center;
    }
</style>
<style>
.rental-controls {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 10px;
    gap: 10px;
}

.rental-controls input.rental-search,
.rental-controls select.rental-sort {
    width: 180px;
    height: 32px;
    font-size: 14px;
    padding: 4px 8px;
}
</style>



<script>
function toggleRentals(userId) {
    const section = document.getElementById("rentals-" + userId);
    if (section.style.display === "none" || section.style.display === "") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
}
</script>
<script>
function filterRentals(userId) {
    var input = document.querySelector('#rentals-' + userId + ' .rental-search');
    var filter = input.value.toUpperCase();
    var table = document.getElementById('rental-table-' + userId);
    var tr = table.getElementsByTagName('tr');

    for (var i = 1; i < tr.length; i++) { // start from 1 to skip table headers
        var tdArray = tr[i].getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < tdArray.length; j++) {
            if (tdArray[j]) {
                if (tdArray[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}

function sortRentals(userId) {
    var select = document.querySelector('#rentals-' + userId + ' .rental-sort');
    var table = document.getElementById('rental-table-' + userId).getElementsByTagName('tbody')[0];
    var rows = Array.from(table.getElementsByTagName('tr'));
    var direction = select.value.includes('asc') ? 1 : -1;

    rows.sort(function(a, b) {
        var timeA = a.cells[5].innerText;
        var timeB = b.cells[5].innerText;
        return (timeA > timeB ? 1 : -1) * direction;
    });

    rows.forEach(function(row) {
        table.appendChild(row);
    });
}
</script>

	</body>
    <!-- Modal -->

    


	







</html>



