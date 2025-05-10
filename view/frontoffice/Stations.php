<?php
session_start(); // IMPORTANT : Pour utiliser $_SESSION


include '../../model/user.php';
include '../../controller/userC.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];
    $user_username = $_SESSION['user_username'];


    $userC = new userC();
    $user = $userC->getUserByEmail($user_email);
    

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit;
    }
} else {
    echo "<script>
    alert('Vous devez être connecté pour accéder à cette page.');
    window.location.href = 'connexion.php';
    </script>";
    exit;
}

?>
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

    <style>
        .siri-button {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #007AFF, #5856D6);
            border: none;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 122, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .siri-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #FF2D55, #FF9500);
            opacity: 0;
            animation: colorChange1 8s infinite;
        }

        .siri-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #5856D6, #007AFF);
            opacity: 0;
            animation: colorChange2 8s infinite;
        }

        @keyframes colorChange1 {
            0% {
                opacity: 0;
            }
            25% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
            75% {
                opacity: 0;
            }
            100% {
                opacity: 0;
            }
        }

        @keyframes colorChange2 {
            0% {
                opacity: 0;
            }
            25% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            75% {
                opacity: 0;
            }
            100% {
                opacity: 0;
            }
        }

        .siri-button .color-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #FF9500, #FF2D55);
            opacity: 0;
            animation: colorChange3 8s infinite;
        }

        @keyframes colorChange3 {
            0% {
                opacity: 0;
            }
            25% {
                opacity: 0;
            }
            50% {
                opacity: 0;
            }
            75% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        .siri-button .pulse-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,0.2) 0%, transparent 70%);
            animation: pulse 2s infinite;
        }

        .siri-button .center-dot {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
            animation: glow 2s infinite;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 10px rgba(255,255,255,0.5);
            }
            50% {
                box-shadow: 0 0 20px rgba(255,255,255,0.8);
            }
            100% {
                box-shadow: 0 0 10px rgba(255,255,255,0.5);
            }
        }

        .siri-button .wave {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            transform: scale(0);
            animation: wave 2s infinite;
        }

        .siri-button .wave:nth-child(1) {
            animation-delay: 0s;
        }

        .siri-button .wave:nth-child(2) {
            animation-delay: 0.5s;
        }

        .siri-button .wave:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }
            100% {
                transform: scale(1);
                opacity: 0.5;
            }
        }

        @keyframes wave {
            0% {
                transform: scale(0);
                opacity: 0.5;
            }
            50% {
                opacity: 0.2;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .siri-button:hover {
            transform: scale(1.1);
        }

        .siri-button:hover::before,
        .siri-button:hover::after,
        .siri-button:hover .color-overlay {
            animation-play-state: paused;
        }

        .siri-button:active {
            transform: scale(0.95);
        }

        .voice-command-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 20px;
        }

        .voice-command-text {
            color: #007AFF;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .siri-button:hover + .voice-command-text {
            opacity: 1;
        }
    </style>

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
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Services</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                        <a href="frontparking.php" class="dropdown-item">Parking</a>
                        <a href="Stations.php" class="dropdown-item">Velos et Stations</a>
                        <a href="team.html" class="dropdown-item">Recharge Electrique</a>
                        
                    </div>
                </div>
                <a href="user_profile.php" class="nav-item nav-link">
                <i class="fa fa-user text-primary me-3"></i>
                <?php

                if (isset($_SESSION['user_email'])){
                    $user_email = $_SESSION['user_email']; 
                $userC = new userC();
                $user = $userC->getUserByEmail($user_email);
                if ($user && isset($user['username'])) {
                    echo htmlspecialchars($user['username']);
                } else {
                 echo "Profile"; 
    }
} else {
    echo "Profile"; 
}
?>
</a>
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <li><a href="../backoffice/dashboard.php" class="nav-item nav-link ">Dashboard</a></li>
<?php endif; ?>
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
        <div class="voice-command-container">
            <button id="start-voice-button" class="siri-button">
                <div class="color-overlay"></div>
                <div class="pulse-overlay"></div>
                <div class="center-dot"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </button>
            <span class="voice-command-text">Start Voice Command</span>
        </div>
    </div>
 
    <!-- Station Cards -->
    <?php 
    // Debug station data
    error_log('Stations data: ' . print_r($stations, true));
    foreach ($stations as $station): 
        error_log('Processing station: ' . $station['name'] . ' (ID: ' . $station['id_station'] . ')');
    ?>
        <div class="flip-card station-card" data-station-name="<?= htmlspecialchars(strtolower($station['name'])) ?>">
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
                        <!--/*** This template is free as long as you keep the footer author's credit link/attribution link/backlink. If you'd like to use the template without the footer author's credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <!-- Back to Top Button (stays at bottom right) -->
<a href="#" 
   class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top" 
   style="position: fixed; bottom: 30px; right: 30px; z-index: 1050;">
   <i class="bi bi-arrow-up"></i>
</a>

<!-- Show Conversation Button (left of Back to Top) -->
<button id="show-conversation-btn" 
        class="btn btn-info" 
        style="position: fixed; bottom: 30px; right: 90px; z-index: 1050;">
    <i class="fas fa-comments"></i> Conversation
</button>

<!-- Rentals Button (left of Show Conversation) -->
<a href="Rentals.php" 
   class="btn btn-success" 
   style="position: fixed; bottom: 30px; right: 250px; z-index: 1050;">
    <i class="fas fa-bicycle"></i> Rentals
</a>


    <!-- Conversation Modal -->
    <div class="modal fade" id="conversationModal" tabindex="-1" aria-labelledby="conversationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="conversationModalLabel">Voice Assistant Conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="conversation-log" style="max-height: 400px; overflow-y: auto;">
                    <!-- Conversation will appear here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

   


        <!-- Button to open the modal -->

        



            <!-- Button to open the modal -->




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
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        let recognition, listeningForCommand = false;
        let isRecognitionRunning = false;
        let conversationLog = [];
        let awaitingWakeWord = true;

        // Function to update the conversation log
        function updateConversationLog(speaker, text) {
            conversationLog.push({ speaker, text });
            const logDiv = document.getElementById('conversation-log');
            if (logDiv) {
                logDiv.innerHTML = conversationLog.map(entry => `
                    <div style="margin-bottom: 10px;">
                        <strong style="color:${entry.speaker === 'You' ? '#007bff' : '#28a745'}">${entry.speaker}:</strong>
                        <span>${entry.text}</span>
                    </div>
                `).join('');
                logDiv.scrollTop = logDiv.scrollHeight;
            }
        }

        // Show modal when button is clicked
        document.getElementById('show-conversation-btn').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('conversationModal'));
            updateConversationLog('System', 'Conversation log opened');
            modal.show();
        });

        if (SpeechRecognition) {
            recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;
        }

        function speak(text) {
            const synth = window.speechSynthesis;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US';
            synth.speak(utterance);
            updateConversationLog('AI', text);
        }

        function startVoiceRecognition() {
            if (!isRecognitionRunning) {
                recognition.start();
                isRecognitionRunning = true;
                console.log('Voice recognition started...');
            }
        }

        recognition.onresult = async function(event) {
            const command = event.results[0][0].transcript.toLowerCase().trim();
            console.log('Speech recognized:', command);
            updateConversationLog('You', command);

            if (awaitingWakeWord) {
                if (command.includes('hi alexa')) {
                    let username = "<?= $_SESSION['user_username']; ?>";
                     speak("Hi " + username);
                    awaitingWakeWord = false;
                    setTimeout(() => {
                        if (!isRecognitionRunning) {
                            recognition.start();
                            isRecognitionRunning = true;
                            console.log('Voice recognition restarted after wake word...');
                        }
                    }, 1000);
                } else {
                    console.log('Waiting for wake word...');
                }
                return;
            }

            awaitingWakeWord = true;

            try {
                const response = await fetch('dialogflowHandler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `message=${encodeURIComponent(command)}`
                });

                const data = await response.json();
                
                if (data.error) {
                    console.error('Dialogflow error:', data.message);
                    speak('Sorry, I encountered an error: ' + data.message);
                    return;
                }
                
                speak(data.reply);

                if (data.action) {
                    switch(data.action) {
                        case 'find_station':
                            const searchName = data.parameters.station_name.toLowerCase().trim();
                            console.log('User requested station:', searchName);

                            try {
                                const response = await fetch('findStation.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `station_name=${encodeURIComponent(searchName)}`
                                });

                                const result = await response.json();
                                console.log('Database search result:', result);

                                if (result.success && result.station) {
                                    const stationId = result.station.id_station;
                                    const stationName = result.station.name;
                                    console.log('Found station:', stationName, 'ID:', stationId);
                                    speak(`Navigating to station ${stationName}`);
                                    window.location.href = `Bikesfront.php?station_id=${stationId}`;
                                } else {
                                    console.log('No matching station found');
                                    speak(`Sorry, I couldn't find station ${searchName}`);
                                }
                            } catch (error) {
                                console.error('Error searching for station:', error);
                                speak('Sorry, there was an error finding the station');
                            }
                            break;

                        case 'show_stations':
                            if (data.parameters && data.parameters.station_name) {
                                const searchInput = document.getElementById('station-search');
                                if (searchInput) {
                                    searchInput.value = data.parameters.station_name;
                                    filterStations();
                                    speak(`Showing station ${data.parameters.station_name}`);
                                }
                            }
                            break;

                        case 'show_all_stations':
                            const searchInput = document.getElementById('station-search');
                            if (searchInput) {
                                searchInput.value = '';
                                filterStations();
                                speak('Showing all stations');
                            }
                            break;
                    }
                }
            } catch (error) {
                console.error('Error communicating with Dialogflow:', error);
                speak('Sorry, I encountered an error processing your request.');
            }

            isRecognitionRunning = false;
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
        };

        recognition.onend = () => {
            isRecognitionRunning = false;
            console.log('Recognition ended. Restarting...');
            setTimeout(() => {
                startVoiceRecognition();
            }, 500);
        };

        document.getElementById('start-voice-button').addEventListener('click', () => {
            listeningForCommand = false;
            startVoiceRecognition();
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
        var stationName = card.getAttribute('data-station-name').toLowerCase();
        if (stationName.indexOf(filter) > -1) {
            card.style.display = ''; // Show matching cards
        } else {
            card.style.display = 'none'; // Hide non-matching cards
        }
    });
}
</script>


</html>