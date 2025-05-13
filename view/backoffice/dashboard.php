<?php
session_start();
include('../../controller/controllercovoituragereservation.php');
include'../../controller/userC.php';
$controller = new ReservationController();
$stats = $controller->getReservationStats();

$statusLabels = array_keys($stats['statusData']);
$statusCounts = array_values($stats['statusData']);

$dateLabels = array_column($stats['dateData'], 'date');
$dateCounts = array_column($stats['dateData'], 'count');

include_once __DIR__.'/../../database.php';

$userC = new userC();
$userStats = $userC->getUserStats();
$userRegistrations = $userC->getUserRegistrationsPerDay();
$registrationDates = array_column($userRegistrations, 'date');
$registrationCounts = array_column($userRegistrations, 'count');


// Traduire les clés anglais → français
$statusLabelsUser = ['Actif', 'Bloqué'];
$statusCountsUser = [
    $userStats['active'],
    $userStats['blocked']
];

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
					<header class="page-header active">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Dashboard</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
		<!-- malek -->
		<div style="margin-bottom: 30px;">
    <h2 style="font-family: 'Jost', sans-serif; font-weight: bold; text-align: center; color: #2c3e50;">
        Statistiques User
    </h2>
</div>

<div class="row">
    <!-- Statut des Utilisateurs -->
    <div class="col-md-6">
        <section class="panel" style="min-height: 360px;">
            <header class="panel-heading">
                <h2 class="panel-title">Statut des Utilisateurs</h2>
                <p class="panel-subtitle">Répartition des utilisateurs actifs et bloqués</p>
            </header>
            <div class="panel-body d-flex justify-content-center align-items-center">
                <canvas id="userStatusChart" width="200" height="300" style="display: block; margin: 0 auto;"></canvas>
            </div>
        </section>
    </div>

    <!-- Inscriptions des Utilisateurs (Par Jour) -->
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Inscriptions des Utilisateurs (Par Jour)</h2>
                <p class="panel-subtitle">Évolution quotidienne des nouvelles inscriptions</p>
            </header>
            <div class="panel-body">
                <canvas id="userRegistrationsChart" width="800" height="300"></canvas>
            </div>
        </section>
    </div>
</div>


    <script>
const donutData = {
    labels: <?= json_encode($statusLabelsUser) ?>,
    datasets: [{
        data: <?= json_encode($statusCountsUser) ?>,
        backgroundColor: ['#2ecc71', '#e74c3c'],
        borderColor: ['#27ae60', '#c0392b'],
        borderWidth: 2
    }]
};


        new Chart(document.getElementById('userStatusChart'), {
            type: 'doughnut', // Type de graphique donut
            data: donutData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

<script>
const userRegistrationData = {
    labels: <?= json_encode($registrationDates) ?>,
    datasets: [{
        label: 'Inscriptions par jour',
        data: <?= json_encode($registrationCounts) ?>,
        borderColor: '#8e44ad',
        backgroundColor: 'rgba(142, 68, 173, 0.2)',
        fill: true,
        tension: 0.4
    }]
};

new Chart(document.getElementById('userRegistrationsChart'), {
    type: 'line',
    data: userRegistrationData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>
		<!-- malek -->

		<div style="margin-bottom: 30px;">
  <h2 style="font-family: 'Jost', sans-serif; font-weight: bold; text-align: center; color: #2c3e50;">
    Statistiques Covoiturage
  </h2>
</div>


<div class="row" id="statistiquesCovoiturage">
    <!-- Pie Chart -->
    <div class="col-md-6">
        <section class="panel" style="min-height: 360px;">
            <header class="panel-heading">
                <h2 class="panel-title">Statut des Réservations</h2>
                <p class="panel-subtitle">Distribution des réservations par statut</p>
            </header>
            <div class="panel-body d-flex justify-content-center align-items-center">
                <canvas id="reservationStatusChart" width="200" height="300" style="display: block; margin: 0 auto;"></canvas>
            </div>
        </section>
    </div>

    <!-- Line Chart -->
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Nombre de Réservations (Par Jour)</h2>
                <p class="panel-subtitle">Tendances quotidiennes des réservations</p>
            </header>
            <div class="panel-body">
			<canvas id="lineReservationsOverTime" width="500" height="300" style="display: block; margin: 0 auto;"></canvas>
            </div>
        </section>
    </div>
</div>

<!-- Chart.js Script -->
<script>
    const pieData = {
        labels: <?= json_encode($statusLabels) ?>,
        datasets: [{
            data: <?= json_encode($statusCounts) ?>,
            backgroundColor: ['#e74c3c', '#2ecc71']
        }]
    };

    const lineData = {
        labels: <?= json_encode($dateLabels) ?>,
        datasets: [{
            label: 'Réservations par jour',
            data: <?= json_encode($dateCounts) ?>,
            borderColor: '#8e44ad',
            backgroundColor: 'rgba(142, 68, 173, 0.2)',
            tension: 0.4,
            fill: true,
            pointRadius: 3,
            pointBackgroundColor: '#8e44ad'
        }]
    };

    let hasAnimated = false;

    function renderCharts() {
        if (hasAnimated) return; // prevent re-initialization
        hasAnimated = true;

        new Chart(document.getElementById('reservationStatusChart'), {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeInOutCirc'
                },
                plugins: {
                    legend: { position: 'bottom' },
                    title: {
                        display: true,
                        text: 'Répartition des Réservations'
                    }
                }
            }
        });

        new Chart(document.getElementById('lineReservationsOverTime'), {
            type: 'line',
            data: lineData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0
                },
                animations: {
                    borderDashOffset: {
                        from: 1000,
                        to: 0,
                        duration: 2000,
                        easing: 'linear'
                    }
                },
                elements: {
                    line: {
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(52, 152, 219, 0.2)',
                        borderDash: [1000],
                        borderDashOffset: 1000
                    },
                    point: {
                        radius: 3,
                        backgroundColor: '#3498db',
                        borderColor: '#fff',
                        borderWidth: 2
                    }
                },
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date de Réservation'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de Réservations'
                        }
                    }
                }
            }
        });
    }

    // Observer to trigger chart rendering when section is visible
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                renderCharts();
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.3 // triggers when 30% of the section is visible
    });

    observer.observe(document.getElementById('statistiquesCovoiturage'));
</script>

<?php require_once 'C:/xampp/htdocs/urbanisme/controller/dashboardControlleromar.php'; ?>

						 

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


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<!-- Graphique Taux d'occupation par parking -->
				<!-- Header for the section -->
<div style="margin-bottom: 30px;">
  <h2 style="font-family: 'Jost', sans-serif; font-weight: bold; text-align: center; color: #2c3e50;">
    Statistiques Parking
  </h2>
</div>

<!-- Wrapper for the Bar Chart -->
<div id="chart_taux_wrapper">
  <div id="chart_taux_graph" style="width: 800px; height: 500px; margin: 40px auto; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px;"></div>
</div>

<!-- Wrapper for the Pie Chart -->
<div id="piechart" style="width: 600px; height: 400px; margin: 40px auto; border: 2px solid #ccc; border-radius: 15px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: #fdfdfd;"></div>

<!-- Google Charts Loader -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  // Load Google Charts library
  google.charts.load('current', { packages: ['corechart', 'bar'] });

  // Prepare chart drawing function for Bar Chart
  function drawTauxOccupationChart() {
    var data = google.visualization.arrayToDataTable([
      ['Parking', 'Taux d\'occupation (%)'],
      <?php foreach ($taux as $row): ?>
        ['<?= addslashes($row["nom_parking"]) ?>', <?= (float)$row["taux"] ?>],
      <?php endforeach; ?>
    ]);

    var options = {
      title: 'Taux d\'occupation des parkings',
      hAxis: { title: 'Taux d\'occupation (%)', minValue: 0 },
      vAxis: { title: 'Nom du parking' },
      legend: 'none',
      bars: 'horizontal',
      colors: ['#2ecc71'],
      animation: {
        startup: true,
        duration: 1000,
        easing: 'out'
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_taux_graph'));
    chart.draw(data, options);
  }

  // Prepare chart drawing function for Pie Chart
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
      chartArea: { width: '100%', height: '80%' },
      colors: ['#8e44ad', '#9b59b6', '#af7ac5', '#bb8fce', '#d2b4de', '#e8daef'],
      backgroundColor: 'transparent',
      titleTextStyle: { fontSize: 20, bold: true, color: '#2c3e50' },
      animation: {
        startup: true,
        duration: 1000,
        easing: 'out'
      }
    };

    const chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }

  // Use Intersection Observer to detect scroll into view for the Bar Chart
  document.addEventListener("DOMContentLoaded", function () {
    let chartDrawn = false;

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !chartDrawn) {
          chartDrawn = true; // Prevent redrawing
          google.charts.setOnLoadCallback(drawTauxOccupationChart);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 }); // 30% visibility before triggering

    const chartElement = document.getElementById('chart_taux_wrapper');
    if (chartElement) {
      observer.observe(chartElement);
    }
  });

  // Use Intersection Observer to detect scroll into view for the Pie Chart
  document.addEventListener("DOMContentLoaded", function () {
    let pieChartDrawn = false;

    const pieChartObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !pieChartDrawn) {
          pieChartDrawn = true; // Prevent redrawing
          google.charts.setOnLoadCallback(drawChart);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 }); // 30% visibility before triggering

    const pieChartElement = document.getElementById('piechart');
    if (pieChartElement) {
      pieChartObserver.observe(pieChartElement);
    }
  });
</script>

<style>
  /* Animation for Pie Chart */
  #piechart svg {
    animation: rotatePie 1s ease-out;
    transform-origin: center center;
  }

  @keyframes rotatePie {
    from {
      transform: rotateX(90deg);
      opacity: 0;
    }
    to {
      transform: rotateX(0deg);
      opacity: 1;
    }
  }
</style>



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
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>
	</body>
</html>