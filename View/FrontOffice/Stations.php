<?php
include __DIR__ . '/../../Controller/BikeStationController.php';

$controller = new BikeStationController();
$stations = $controller->listStations();
// Function to get station by name
function getStationByName($station_name)
{
    $sql = 'SELECT * FROM bikestation WHERE name LIKE :station_name';
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        // Use LIKE for partial match (case-insensitive)
        $query->execute(['station_name' => '%' . $station_name . '%']);
        return $query->fetchAll(PDO::FETCH_ASSOC); // Return all stations that match the name
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Logistica - Shipping Company Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">


  

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">

    





</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">Logistica</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="Rentals.php" class="nav-item nav-link">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="price.html" class="dropdown-item">Pricing Plan</a>
                        <a href="feature.html" class="dropdown-item">Features</a>
                        <a href="Stations.php" class="dropdown-item active">Free Quote</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+012 345 6789</h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Stations</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Stations</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Stations Start -->
    <div class="container d-flex flex-wrap justify-content-center mt-5">
    <h2>Bike Stations</h2>

    <!-- Search bar for filtering stations by name -->
    <div class="mb-3 w-100 d-flex justify-content-center">
        <input type="text" id="station-search" class="form-control w-50" placeholder="Search Stations by Name" onkeyup="filterStations()">
        <button id="start-voice-button" class="btn btn-primary">Start Voice Command</button>
    </div>
 
    <!-- Station Cards -->
    <?php foreach ($stations as $station): ?>
        <div class="flip-card station-card" data-station-name="<?= strtolower($station['name']) ?>">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <h4><i class="fa fa-bicycle me-2"></i><?= htmlspecialchars($station['name']) ?></h4>
                    <p><i class="fa fa-map-marker-alt me-2"></i><?= htmlspecialchars($station['location']) ?></p>
                </div>
                <div class="flip-card-back">
                    <p>Total Bikes: <?= $station['total_bikes'] ?></p>
                    <p>Available: <?= $station['available_bikes'] ?></p>
                    <span class="status-badge <?= $station['status'] > 0 ? 'status-active' : 'status-inactive' ?>">
                        <?= $station['status'] > 0 ? 'Active' : 'Inactive' ?>
                    </span>
                    <button class="btn-details" onclick="window.location.href='Bikesfront.php?station_id=<?= $station['id_station'] ?>';">Show Bikes</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    

    <!-- Quote End -->
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="">Air Freight</a>
                    <a class="btn btn-link" href="">Sea Freight</a>
                    <a class="btn btn-link" href="">Road Freight</a>
                    <a class="btn btn-link" href="">Logistic Solutions</a>
                    <a class="btn btn-link" href="">Industry solutions</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>












<!-- Voice assistant -->

    
  <script>
// Check if the browser supports the Web Speech API
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
let recognition;
if (SpeechRecognition) {
    recognition = new SpeechRecognition();
    recognition.lang = 'en-US'; // Set language to English
    recognition.interimResults = false; // No interim results
    recognition.maxAlternatives = 1; // Only return the best match
}

// Function to start voice recognition
function startVoiceRecognition() {
    console.log("Voice recognition started...");
    recognition.start();  // Start the voice recognition process
}

// Event listener to handle the result of speech recognition
recognition.onresult = function(event) {
    const command = event.results[0][0].transcript.toLowerCase(); // Get the speech command and convert to lowercase
    console.log('Speech recognized:', command);  // Log the recognized speech

    // Check if the command includes "find station"
    if (command.includes('find station')) {
        const stationName = command.replace('find station', '').trim(); // Extract station name from command
        console.log('Searching for station:', stationName);  // Log the station name extracted
        filterStations(stationName);  // Filter stations based on the spoken name
    } else {
        console.log('No valid command detected.');  // Log if no valid command is detected
    }
};

// Handle any errors in speech recognition
recognition.onerror = function(event) {
    console.error('Error occurred in speech recognition: ', event.error);  // Log any errors
};
// Function to get station by name



// Function to filter stations based on voice command or search input
function filterStations(stationName = '') {
    var input = document.getElementById('station-search');
    var filter = stationName || input.value.toLowerCase(); // Use voice command or manual input
    var cards = document.querySelectorAll('.station-card');

    cards.forEach(function(card) {
        var stationCardName = card.getAttribute('data-station-name');
        if (stationCardName.indexOf(filter) > -1) {
            card.style.display = ''; // Show matching cards
            console.log(`Showing station card: ${stationCardName}`); // Log when a card is shown
        } else {
            card.style.display = 'none'; // Hide non-matching cards
            console.log(`Hiding station card: ${stationCardName}`); // Log when a card is hidden
        }
    });
}

// Event listener for the start voice button
document.getElementById('start-voice-button').addEventListener('click', function() {
    startVoiceRecognition();  // Start voice recognition when the button is clicked
});


  </script>
  

</body>
<style>
.flip-card {
    background-color: transparent;
    width: 320px;
    height: 220px;
    perspective: 1200px;
    margin: 1rem;
    border-radius: 20px;
}

.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.9s cubic-bezier(0.4, 0.2, 0.2, 1);
    transform-style: preserve-3d;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border-radius: 20px;
}

.flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 20px;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.flip-card-front {
    background: url('assets/img/station1.png') center center / cover no-repeat;
    color: white;
    font-weight: bold;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
}
.flip-card-front h4 {
    background-color: rgba(0, 0, 0, 0.4);
    padding: 6px 12px;
    border-radius: 10px;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    margin: 5px 0;
    color: white;
    font-family: 'Poppins', sans-serif;
    font-size: 1.3rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-align: center;
}

.flip-card-front p {
    background-color: rgba(0, 0, 0, 0.3);
    padding: 5px 10px;
    border-radius: 10px;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    margin: 5px 0;
    color: white;
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 400;
    text-align: center;
}



.flip-card-back {
    background: #f1f8f4;
    color: rgb(24, 158, 104);
    transform: rotateY(180deg);
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
}

.status-badge {
    padding: 0.5em 1em;
    border-radius: 30px;
    font-size: 0.85em;
    font-weight: bold;
    letter-spacing: 1px;
    display: inline-block;
    margin-top: 10px;
}

.status-active {
    background-color: rgb(24, 158, 104);
    color: white;
}

.status-inactive {
    background-color: #d32f2f;
    color: white;
}

.btn-details {
    margin-top: 15px;
    background-color: rgb(24, 158, 104);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-details:hover {
    background-color: rgb(17, 117, 77);
}



</style>
<script>
function filterStations() {
    var input = document.getElementById('station-search');
    var filter = input.value.toLowerCase();
    var cards = document.querySelectorAll('.station-card');
    
    cards.forEach(function(card) {
        var stationName = card.getAttribute('data-station-name');
        if (stationName.indexOf(filter) > -1) {
            card.style.display = ''; // Show matching cards
        } else {
            card.style.display = 'none'; // Hide non-matching cards
        }
    });
}
</script>


</html>