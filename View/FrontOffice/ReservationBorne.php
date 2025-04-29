<?php
include '../../Controller/ControllerBorne.php';
$ControllerBorneElectrique = new ControllerBorneElectrique();
$liste = $ControllerBorneElectrique->afficher();
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
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!--Template type de borne electrique-->
    <link href="css/TypeBorneElectrique.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- borne Electrique-->
    <script src="js/BorneElectrique.js"></script>
    <!--Temps Estimé-->
    <script src="js/tempsEstime.js"></script>
    
 

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
                <a href="service.html" class="nav-item nav-link">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="price.html" class="dropdown-item">Pricing Plan</a>
                        <a href="feature.html" class="dropdown-item">Features</a>
                        <a href="AffichageReservation.php" class="dropdown-item">Affichage de réservation</a>
                        <a href="ReservationBorne.php" class="dropdown-item active">Faire une réservation</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <h5 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+012 345 6789</h5>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header-rechage-electrique py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Recharge Electrique</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Recharge Electrique</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<!-- Ici on ajoute ton code 3D -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        var renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0xFFFFFF, 1);
        document.body.appendChild(renderer.domElement);

        var light = new THREE.AmbientLight(0x404040);
        scene.add(light);
        var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(5, 10, 5).normalize();
        scene.add(directionalLight);

        function createBaseWithHole(color, textureUrl) {
            var loader = new THREE.TextureLoader();
            var baseTexture = loader.load(textureUrl);
            var baseGeometry = new THREE.BoxGeometry(1.5, 0.3, 1);

            var holeGeometry = new THREE.CylinderGeometry(0.2, 0.2, 0.3, 32);
            holeGeometry.rotateX(Math.PI / 2);
            holeGeometry.translate(0, 0, 0);

            var baseMaterial = new THREE.MeshPhongMaterial({ map: baseTexture });
            var base = new THREE.Mesh(baseGeometry, baseMaterial);

            var hole = new THREE.Mesh(holeGeometry, new THREE.MeshBasicMaterial({ color: 0xFFFFFF }));

            var baseWithHole = new THREE.Group();
            baseWithHole.add(base);
            baseWithHole.add(hole);

            base.position.y = -1;
            hole.position.set(0, -0.1, 0);

            return baseWithHole;
        }
        
        function createBody(color) {
    // Créer le corps principal
    var bodyGeometry = new THREE.BoxGeometry(1, 3, 0.5);
    var bodyMaterial = new THREE.MeshPhongMaterial({ color: color });
    var body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    body.position.y = 1.5;

    // Créer un petit décor (ex: écran ou trappe)
    var decorGeometry = new THREE.BoxGeometry(0.6, 0.4, 0.05); // Petit rectangle
    var decorMaterial = new THREE.MeshPhongMaterial({ color: 0x555555 }); // Gris foncé
    var decor = new THREE.Mesh(decorGeometry, decorMaterial);
    decor.position.set(0, 2.2, 0.28); // Collé à l'avant du body

    // Créer un groupe pour tout rassembler
    var group = new THREE.Group();
    group.add(body);
    group.add(decor);

    // Fonction pour créer un bouton
    function createButton(color) {
        var buttonGeometry = new THREE.CylinderGeometry(0.08, 0.08, 0.02, 32); // petit bouton rond
        var buttonMaterial = new THREE.MeshPhongMaterial({ color: color });
        var button = new THREE.Mesh(buttonGeometry, buttonMaterial);
        button.rotation.x = Math.PI / 2; // Face vers l'avant
        return button;
    }

    // Ajouter trois boutons colorés sous le décor
    var colors = [0xff0000, 0xffff00, 0x00ff00]; // rouge, jaune, vert

    for (var i = 0; i < colors.length; i++) {
        var button = createButton(colors[i]);
        button.position.set(0.3, 1.8 - i * 0.4, 0.28); // positionné sur la droite, descendu progressivement
        group.add(button);
    }

    return group;
}


function createCable() {
    // Créer la courbe du câble
    var curve = new THREE.QuadraticBezierCurve3(
        new THREE.Vector3(0, 3, 0),        // Départ du haut du body
        new THREE.Vector3(1, 2, 0),         // Contrôle de la courbe
        new THREE.Vector3(2, 0.2, 0)        // Arrivée au cadre
    );

    var cableGeometry = new THREE.TubeGeometry(curve, 20, 0.05, 8, false);
    var cableMaterial = new THREE.MeshPhongMaterial({ color: 0x000000 });
    var cable = new THREE.Mesh(cableGeometry, cableMaterial);

    // Créer le petit cadre au début (haut de la borne)
    var startFrameGeometry = new THREE.BoxGeometry(0.3, 0.3, 0.3);
    var startFrameMaterial = new THREE.MeshPhongMaterial({ color: 0x333333 });
    var startFrame = new THREE.Mesh(startFrameGeometry, startFrameMaterial);
    startFrame.position.set(0, 3, 0); // Position exacte du départ

    // Créer le petit cadre à la fin (près du sol)
    var endFrameGeometry = new THREE.BoxGeometry(0.3, 0.3, 0.3);
    var endFrameMaterial = new THREE.MeshPhongMaterial({ color: 0x333333 });
    var endFrame = new THREE.Mesh(endFrameGeometry, endFrameMaterial);
    endFrame.position.set(2, 0.2, 0); // Position de l'arrivée du câble

    // Créer la liaison (ligne droite)
    var connectorGeometry = new THREE.CylinderGeometry(0.05, 0.02, 1.35, 8);
    var connectorMaterial = new THREE.MeshPhongMaterial({ color: 0x000000 });
    var connector = new THREE.Mesh(connectorGeometry, connectorMaterial);

    // Positionner la tige correctement
    connector.position.set(1, 1, 0); // milieu entre (0,3,0) et (2,0.2,0)
    connector.rotation.z = -Math.atan2(2, 2); // inclinaison correcte

    // Grouper tout ensemble
    var returnGroup = new THREE.Group();
    returnGroup.add(cable);
    returnGroup.add(startFrame); // petit cadre au début
    returnGroup.add(endFrame);   // petit cadre à la fin
    returnGroup.add(connector);

    return returnGroup;
}


        function createTopHead() {
            var geometry = new THREE.BoxGeometry(1.5, 0.1, 1);
            var material = new THREE.MeshPhongMaterial({ color: 0x666666 });
            var head = new THREE.Mesh(geometry, material);
            head.position.y = 2.7;
            return head;
        }

        function createChargingStation(type) {
            var baseColor, bodyColor, lightColor, textureUrl;

            switch(type) {
                case 'lente':
                    baseColor = 0x888888;
                    bodyColor = 0xcccccc;
                    lightColor = 0xdddddd;
                    textureUrl = "https://example.com/metal-texture.jpg";
                    break;
                case 'accélérée':
                    baseColor = 0x777777;
                    bodyColor = 0x0099ff;
                    lightColor = 0x00ffff;
                    textureUrl = "https://example.com/plastic-texture.jpg";
                    break;
                case 'rapide':
                    baseColor = 0x666666;
                    bodyColor = 0x00ff00;
                    lightColor = 0x00ff00;
                    textureUrl = "https://example.com/steel-texture.jpg";
                    break;
                case 'ultra-rapide':
                    baseColor = 0x333333;
                    bodyColor = 0xff0000;
                    lightColor = 0xff0000;
                    textureUrl = "https://example.com/carbon-texture.jpg";
                    break;
                default:
                    baseColor = 0x555555;
                    bodyColor = 0xcccccc;
                    lightColor = 0xdddddd;
                    textureUrl = "https://example.com/default-texture.jpg";
                    break;
            }

            var base = createBaseWithHole(baseColor, textureUrl);
            var body = createBody(bodyColor);
            var cable = createCable();
            var topHead = createTopHead();
            var lightEffect = new THREE.PointLight(lightColor, 1, 2);
            lightEffect.position.set(0, 3.5, 0);

            var chargingStation = new THREE.Group();
            chargingStation.add(base);
            chargingStation.add(body);
           chargingStation.add(cable);
            chargingStation.add(topHead);
            chargingStation.add(lightEffect);

            return chargingStation;
        }

        var lenta = createChargingStation('lente');
        var acceleree = createChargingStation('accélérée');
        var rapide = createChargingStation('rapide');
        var ultraRapide = createChargingStation('ultra-rapide');

        lenta.position.x = -6;
        acceleree.position.x = -2;
        rapide.position.x = 2;
        ultraRapide.position.x = 6;

        scene.add(lenta);
        scene.add(acceleree);
        scene.add(rapide);
        scene.add(ultraRapide);

        camera.position.z = 10;

        var animate = function () {
            requestAnimationFrame(animate);

            lenta.rotation.y += 0.01;
            acceleree.rotation.y += 0.01;
            rapide.rotation.y += 0.01;
            ultraRapide.rotation.y += 0.01;

            renderer.render(scene, camera);
        };

        animate();
    </script>
    
  <!-- Bornes Disponibles -->
<div class="container-xxl py-5">
    <div class="container py-5">
    <table class="table table-bordered text-center">
    <thead class="table-light">
        <tr>
            <th>Localisation</th>
            <th>Type de borne</th>
            <th>Puissance</th>
            <th>Nombre de ports</th>
            <th>Date d'installation</th>
            <th>Opérateur</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($liste as $borne) {
        ?>
            <tr>
                <td><?php echo $borne['localisation']; ?></td>
                <td><?php echo $borne['type_bornes']; ?></td>
                <td><?php echo $borne['puissance']; ?></td>
                <td><?php echo $borne['nombre_ports']; ?></td>
                <td><?php echo $borne['date_installation']; ?></td>
                <td><?php echo $borne['operateur']; ?></td>
                <td>
                    <a href="formReservation.php?id=<?= $borne['id_borne'] ?>">
                        <button class="btn btn-primary btn-sm">Réserver</button>
                    </a>
                </td>
            </tr>
        <?php
        } // <-- ici la bonne fermeture
        ?>
    </tbody>
</table>

<div id="map-container" style="height: 400px; margin-top: 30px;">
</div>



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
                    <h4 class="text-light mb-4">Reservation</h4>
                    <a class="btn btn-link" href="">Reservation Client</a>
                  
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
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>





</body>

</html>