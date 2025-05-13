<?php
session_start();

require_once __DIR__ . '/../../Controller/ControllerBorne.php';
include '../../model/user.php';
include '../../controller/userC.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) &&  isset($_SESSION['user_username'])) {
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

            <!-- cssreservation -->
    <link rel="stylesheet" href="stylereservation.css">


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
    <a href="index.php" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
        <!--<h2 class="mb-2 text-white">Logistica</h2>-->
        <img class="img-fluid" src="img/logosansnom.png" alt="" width=250px height=200px >

    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Acceuil</a>
           <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
            <div class="nav-item dropdown">
               <a href="#" class="nav-item nav-link active" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu fade-up m-0">
                    <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                    <a href="frontparking.php" class="dropdown-item">Parking</a>
                    <a href="Stations.php" class="dropdown-item">Velos et Stations</a>
                    <a href="ReservationBorne.php" class="dropdown-item active">Recharge Electrique</a>
                    
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
        <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 20 265 186</h4>
    </div>
</nav>
<!-- Navbar End -->



    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Services</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Borne Electrique</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
<!-- ReservationBorne.php -->

<div style="max-width: 750px; margin: 40px auto; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
    <h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; font-size: 26px; color: #00796b; margin-bottom: 20px; text-shadow: 1px 1px 2px #ccc;">
        ⚡ Visualisation des bornes électriques en 3D ⚡
    </h2>
    <div id="3d-container" style="width: 100%; height: 400px; border-radius: 15px; overflow: hidden; box-shadow: inset 0 0 10px rgba(0,0,0,0.1);"></div>
    <div id="borne-info" style="margin-top: 20px; text-align: center; font-family: 'Segoe UI', sans-serif; color: #00796b; font-size: 20px;"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, 700 / 400, 0.1, 1000);
    var renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(700, 400);
    renderer.setClearColor(0xe0f7fa); // couleur identique au fond du div (dégradé début)
    document.getElementById("3d-container").appendChild(renderer.domElement);

    var light = new THREE.AmbientLight(0x404040);
    scene.add(light);
    var dirLight = new THREE.DirectionalLight(0xffffff, 1);
    dirLight.position.set(5, 10, 5).normalize();
    scene.add(dirLight);

    // Fonction de création de la base de la borne
    function createBaseWithHole(textureUrl) {
        var loader = new THREE.TextureLoader();
        var baseTexture = loader.load(textureUrl);
        var geometry = new THREE.BoxGeometry(1.5, 0.3, 1);
        var material = new THREE.MeshPhongMaterial({ map: baseTexture });
        var base = new THREE.Mesh(geometry, material);
        base.position.y = -1;
        return base;
    }

    // Fonction pour créer le corps de la borne
    function createBody(color) {
        var body = new THREE.Mesh(new THREE.BoxGeometry(1, 3, 0.5), new THREE.MeshPhongMaterial({ color: color }));
        body.position.y = 1.5;
        var decor = new THREE.Mesh(new THREE.BoxGeometry(0.6, 0.4, 0.05), new THREE.MeshPhongMaterial({ color: 0x555555 }));
        decor.position.set(0, 2.2, 0.28);
        var group = new THREE.Group();
        group.add(body);
        group.add(decor);

        var colors = [0xff0000, 0xffff00, 0x00ff00];
        for (let i = 0; i < colors.length; i++) {
            var button = new THREE.Mesh(
                new THREE.CylinderGeometry(0.08, 0.08, 0.02, 32),
                new THREE.MeshPhongMaterial({ color: colors[i] })
            );
            button.rotation.x = Math.PI / 2;
            button.position.set(0.3, 1.8 - i * 0.4, 0.28);
            group.add(button);
        }

        return group;
    }

    // Fonction pour créer le câble de la borne
    function createCable() {
        var curve = new THREE.QuadraticBezierCurve3(
            new THREE.Vector3(0, 3, 0),
            new THREE.Vector3(1, 2, 0),
            new THREE.Vector3(2, 0.2, 0)
        );
        var cableGeometry = new THREE.TubeGeometry(curve, 20, 0.05, 8, false);
        var cableMaterial = new THREE.MeshPhongMaterial({ color: 0x000000 });
        var cable = new THREE.Mesh(cableGeometry, cableMaterial);

        var start = new THREE.Mesh(new THREE.BoxGeometry(0.3, 0.3, 0.3), new THREE.MeshPhongMaterial({ color: 0x333333 }));
        start.position.set(0, 3, 0);

        var end = new THREE.Mesh(new THREE.BoxGeometry(0.3, 0.3, 0.3), new THREE.MeshPhongMaterial({ color: 0x333333 }));
        end.position.set(2, 0.2, 0);

        var connector = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.02, 1.35, 8), new THREE.MeshPhongMaterial({ color: 0x000000 }));
        connector.position.set(1, 1, 0);
        connector.rotation.z = -Math.atan2(2, 2);

        var group = new THREE.Group();
        group.add(cable);
        group.add(start);
        group.add(end);
        group.add(connector);
        return group;
    }

    // Fonction pour créer la tête de la borne
    function createTopHead() {
        var geometry = new THREE.BoxGeometry(1.5, 0.1, 1);
        var material = new THREE.MeshPhongMaterial({ color: 0x666666 });
        var head = new THREE.Mesh(geometry, material);
        head.position.y = 2.7;
        return head;
    }

    // Fonction pour afficher les informations de la borne
    function displayBorneInfo(typeBorne) {
        var infoElement = document.getElementById("borne-info");
        
        // Envoi de la requête pour récupérer les données de la borne
        fetch('/getBorneInfo?type=' + typeBorne) // Modifiez cette URL selon votre backend
            .then(response => response.json())
            .then(data => {
                infoElement.innerHTML = `
                    <strong>Type de Borne:</strong> ${data.type_bornes} <br>
                    <strong>Localisation:</strong> ${data.localisation} <br>
                    <strong>Puissance:</strong> ${data.puissance} <br>
                    <strong>Etat:</strong> ${data.etat_bornes} <br>
                    <strong>Nombre de Ports:</strong> ${data.nombre_ports} <br>
                    <strong>Date d'installation:</strong> ${data.date_installation} <br>
                `;
            })
            .catch(error => {
                infoElement.innerHTML = "Erreur lors de la récupération des données de la borne.";
                console.error(error);
            });
    }

    const colors = [0x3366ff, 0x00cc66, 0x666666, 0xcc0000]; // bleu, vert, gris, rouge
    const positionsX = [-4.5, -1.5, 1.5, 4.5];

    // Ajout des bornes 3D avec gestion des clics
    for (let i = 0; i < colors.length; i++) {
        let base = createBaseWithHole("https://threejsfundamentals.org/threejs/resources/images/wall.jpg"); // texture
        let body = createBody(colors[i]);
        let cable = createCable();
        let top = createTopHead();
        let lightEffect = new THREE.PointLight(0xffffff, 1, 2);
        lightEffect.position.set(0, 3.5, 0);

        let borne = new THREE.Group();
        borne.add(base);
        borne.add(body);
        borne.add(cable);
        borne.add(top);
        borne.add(lightEffect);

        borne.position.x = positionsX[i];
        scene.add(borne);

        // Ajouter un événement de clic sur chaque borne pour afficher les informations correspondantes
        borne.userData = { color: colors[i] };  // Associer une couleur pour identifier la borne

        borne.onClick = function () {
            switch (this.userData.color) {
                case 0x3366ff:
                    displayBorneInfo('Rapide');
                    break;
                case 0x00cc66:
                    displayBorneInfo('Accélérée');
                    break;
                case 0x666666:
                    displayBorneInfo('Lente');
                    break;
                case 0xcc0000:
                    displayBorneInfo('Ultra Rapide');
                    break;
            }
        };
    }

    // Ajouter un écouteur d'événement de clic
    renderer.domElement.addEventListener('click', function (event) {
        var mouse = new THREE.Vector2();
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        var raycaster = new THREE.Raycaster();
        raycaster.setFromCamera(mouse, camera);

        var intersects = raycaster.intersectObjects(scene.children);
        if (intersects.length > 0) {
            intersects[0].object.onClick();  // Appeler la fonction onClick de la borne cliquée
        }
    });

    camera.position.z = 6;

    function animate() {
        requestAnimationFrame(animate);
        scene.traverse(function (object) {
            if (object instanceof THREE.Group) {
                object.rotation.y += 0.01;
            }
        });
        renderer.render(scene, camera);
    }

    
    
    animate();
    
    

</script>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1500px; margin: 40px auto;">
    <div id="borne-container-1" class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
        <h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; font-size: 26px; color: #00796b; margin-bottom: 20px; text-shadow: 1px 1px 2px #ccc;">
            ⚡ Type de borne est Lente ⚡
        </h2>
        
        <?php
        require_once __DIR__ . '/../../database.php';
        $sql = "SELECT * FROM borneelectrique WHERE type_bornes = 'Lente'";
        $db = config::getConnexion();
        $bornes = [];

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $bornes = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
        ?>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1500px; margin: 40px auto;">
    <?php foreach ($bornes as $borne): ?>
        <div class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
            <h3 style="text-align: center; color: #00796b;">⚡ Borne Lente ⚡</h3>
            <img src="images/Lente.jpg" alt="image de borne lente" style="width: 300px; display: block; margin: auto;">
            <ul style="list-style: none; padding: 0; font-family: 'Segoe UI'; margin-top: 20px;">
                <li><strong>Localisation:</strong> <?= htmlspecialchars($borne['localisation']) ?></li>
                <li><strong>Puissance:</strong> <?= htmlspecialchars($borne['puissance']) ?></li>
                <li><strong>Nombre de ports:</strong> <?= htmlspecialchars($borne['nombre_ports']) ?></li>
                <li><strong>Date d'installation:</strong> <?= htmlspecialchars($borne['date_installation']) ?></li>
                <li><strong>Opérateur:</strong> <?= htmlspecialchars($borne['operateur']) ?></li>
            </ul>
            <form action="formReservation.php" method="GET" style="text-align: center; margin-top: 20px;">
                <input type="hidden" name="id_borne" value="<?= $borne['id_borne'] ?>">
                <button type="submit" style="padding: 10px 20px; background-color: #00796b; color: white; border: none; border-radius: 10px; cursor: pointer;">
                    Réserver
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>


        </div>

        <div id="borne-container-2" class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
    <h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; font-size: 26px; color: #00796b; margin-bottom: 20px; text-shadow: 1px 1px 2px #ccc;">
        ⚡ Type de borne est Accélérée ⚡
    </h2>

    <?php
    require_once __DIR__ . '/../../database.php';
    $sql = "SELECT * FROM borneelectrique WHERE type_bornes = 'Accélérée'";
    $db = config::getConnexion();
    $bornes = [];

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $bornes = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1500px; margin: 40px auto;">
        <?php foreach ($bornes as $borne): ?>
            <div class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
                <h3 style="text-align: center; color: #00796b;">⚡ Borne Accélérée ⚡</h3>
                <img src="images/Accelerer.jpg" alt="image de borne Accélérée" style="width: 300px; display: block; margin: auto;">
                <ul style="list-style: none; padding: 0; font-family: 'Segoe UI'; margin-top: 20px;">
                    <li><strong>Localisation:</strong> <?= htmlspecialchars($borne['localisation']) ?></li>
                    <li><strong>Puissance:</strong> <?= htmlspecialchars($borne['puissance']) ?></li>
                    <li><strong>Nombre de ports:</strong> <?= htmlspecialchars($borne['nombre_ports']) ?></li>
                    <li><strong>Date d'installation:</strong> <?= htmlspecialchars($borne['date_installation']) ?></li>
                    <li><strong>Opérateur:</strong> <?= htmlspecialchars($borne['operateur']) ?></li>
                </ul>
                <form action="formReservation.php" method="GET" style="text-align: center; margin-top: 20px;">
                    <input type="hidden" name="id_borne" value="<?= $borne['id_borne'] ?>">
                    <button type="submit" style="padding: 10px 20px; background-color: #00796b; color: white; border: none; border-radius: 10px; cursor: pointer;">
                        Réserver
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="borne-container-3" class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
    <h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; font-size: 26px; color: #00796b; margin-bottom: 20px; text-shadow: 1px 1px 2px #ccc;">
        ⚡ Type de borne est Rapide ⚡
    </h2>

    <?php
    $sql = "SELECT * FROM borneelectrique WHERE type_bornes = 'Rapide'";
    $db = config::getConnexion();
    $bornes = [];

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $bornes = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1500px; margin: 40px auto;">
        <?php foreach ($bornes as $borne): ?>
            <div class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
                <h3 style="text-align: center; color: #00796b;">⚡ Borne Rapide ⚡</h3>
                <img src="images/Rapide.jpg" alt="image de borne Rapide" style="width: 300px; display: block; margin: auto;">
                <ul style="list-style: none; padding: 0; font-family: 'Segoe UI'; margin-top: 20px;">
                    <li><strong>Localisation:</strong> <?= htmlspecialchars($borne['localisation']) ?></li>
                    <li><strong>Puissance:</strong> <?= htmlspecialchars($borne['puissance']) ?></li>
                    <li><strong>Nombre de ports:</strong> <?= htmlspecialchars($borne['nombre_ports']) ?></li>
                    <li><strong>Date d'installation:</strong> <?= htmlspecialchars($borne['date_installation']) ?></li>
                    <li><strong>Opérateur:</strong> <?= htmlspecialchars($borne['operateur']) ?></li>
                </ul>
                <form action="formReservation.php" method="GET" style="text-align: center; margin-top: 20px;">
                    <input type="hidden" name="id_borne" value="<?= $borne['id_borne'] ?>">
                    <button type="submit" style="padding: 10px 20px; background-color: #00796b; color: white; border: none; border-radius: 10px; cursor: pointer;">
                        Réserver
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="borne-container-4" class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
    <h2 style="text-align: center; font-family: 'Segoe UI', sans-serif; font-size: 26px; color: #00796b; margin-bottom: 20px; text-shadow: 1px 1px 2px #ccc;">
        ⚡ Type de borne est Ultra Rapide ⚡
    </h2>

    <?php
    $sql = "SELECT * FROM borneelectrique WHERE type_bornes = 'Ultra Rapide'";
    $db = config::getConnexion();
    $bornes = [];

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $bornes = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1500px; margin: 40px auto;">
        <?php foreach ($bornes as $borne): ?>
            <div class="borne-container" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 30px; background: linear-gradient(135deg, #e0f7fa, #ffffff); border: 1px solid #b2ebf2; backdrop-filter: blur(10px);">
                <h3 style="text-align: center; color: #00796b;">⚡ Borne Ultra Rapide ⚡</h3>
                <img src="images/Ultra.jpg" alt="image de borne Ultra Rapide" style="width: 300px; display: block; margin: auto;">
                <ul style="list-style: none; padding: 0; font-family: 'Segoe UI'; margin-top: 20px;">
                    <li><strong>Localisation:</strong> <?= htmlspecialchars($borne['localisation']) ?></li>
                    <li><strong>Puissance:</strong> <?= htmlspecialchars($borne['puissance']) ?></li>
                    <li><strong>Nombre de ports:</strong> <?= htmlspecialchars($borne['nombre_ports']) ?></li>
                    <li><strong>Date d'installation:</strong> <?= htmlspecialchars($borne['date_installation']) ?></li>
                    <li><strong>Opérateur:</strong> <?= htmlspecialchars($borne['operateur']) ?></li>
                </ul>
                <form action="formReservation.php" method="GET" style="text-align: center; margin-top: 20px;">
                    <input type="hidden" name="id_borne" value="<?= $borne['id_borne'] ?>">
                    <button type="submit" style="padding: 10px 20px; background-color: #00796b; color: white; border: none; border-radius: 10px; cursor: pointer;">
                        Réserver
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</div>
<style>
.bouton-style {
    display: inline-block;
    padding: 14px 32px;
    font-size: 18px;
    color: white;
    background: linear-gradient(135deg, #00796b, #2575fc);
    border: none;
    border-radius: 50px;
    text-decoration: none;
    cursor: pointer;
    font-family: 'Segoe UI', sans-serif;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.bouton-style:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.center-btn {
    text-align: center;
    margin: 50px 0;
}
</style>

<!-- Bouton Retour à l'accueil -->

<!-- Bouton Voir vos abonnements -->
<div class="center-btn">
    <a href="AffichageReservation.php" class="bouton-style">Voir vos abonnements</a>
</div>

 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Esprit Ariana Soghra</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+216 27 118 673</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>Ride4ALL@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="covoituragefront.php">Covoiturage</a>
                    <a class="btn btn-link" href="frontparking.php">Parking</a>
                    <a class="btn btn-link" href="Stations.php">Velos et Stations</a>
                    <a class="btn btn-link" href="ReservationBorne.php">Borne Electrique</a>
                </div>
                <div class="col-lg-6 col-md-12 d-flex align-items-center">

                <img class="img-fluid" src="img/equipe.JPEG " alt="" width=5000px height=1000px >
                </div>

            </div>

        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Ride4ALL</a>, All Right Reserved.
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