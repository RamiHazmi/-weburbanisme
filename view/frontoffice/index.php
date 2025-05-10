<?php
session_start(); 
include '../../controller/userC.php';
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
    <style> 
    .user-image {
    position: fixed; /* Fixe la position */
    top: 10px; /* Distance du bord supérieur de la fenêtre */
    right: 10px; /* Distance du bord droit de la fenêtre */
    width: 50px; /* Largeur de l'image */
    height: 50px; /* Hauteur de l'image */
    border-radius: 50%; /* Pour arrondir l'image */
    cursor: pointer; /* Change le curseur pour un pointeur */
    z-index: 9999; /* Assure que l'image est au-dessus des autres éléments */
    }
    </style>
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
            <!--<h2 class="mb-2 text-white">Logistica</h2>-->
            <img class="img-fluid" src="img/logosansnom.png" alt="" width=250px height=200px >

        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Acceuil</a>
                <a href="about.html" class="nav-item nav-link">À Propos</a>
               <!---- <a href="service.html" class="nav-item nav-link">Services</a> -->
                <div class="nav-item dropdown">
                   <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="covoituragefront.php" class="dropdown-item">Covoiturage</a>
                        <a href="frontparking.php" class="dropdown-item">Parking</a>
                        <a href="Stations.php" class="dropdown-item">Velos et Stations</a>
                        <a href="team.html" class="dropdown-item">Recharge Electrique</a>
                        
                    </div>
                
                </div>
                <a href="user_profile.php" class="nav-item nav-link ">
                <i class="fa fa-user text-primary me-3"></i>
              <?php

                if (isset($_SESSION['user_email'])) 
                {
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

            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+216 27 118 673</h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5">
        <div class="owl-carousel header-carousel position-relative mb-5">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(6, 3, 21, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Solutions de Mobilité Partagée</h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">
                                    Votre Partenaire Fiable pour le 
                                    <span class="text-primary">Covoiturage</span>, le 
                                    <span class="text-primary">Parking</span>, le
                                  
                                </h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Chez Ride4All, nous facilitons vos déplacements quotidiens en offrant des solutions de transport partagées, écologiques et économiques, adaptées à vos besoins.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Nos Services</a>
                                <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Nos Tarifs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(6, 3, 21, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Systèmes de Mobilité Collaborative
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">
                                    Votre Partenaire Fiable pour le 
                                    <span class="text-primary">Velos et Stations</span> et la     
                                    <span class="text-primary">Recharge Electrique</span>
                                </h1> 
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Chez Ride4All, nous facilitons vos déplacements quotidiens en offrant des solutions de transport partagées, écologiques et économiques, adaptées à vos besoins.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Nos Services</a>
                                <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Nos Tarifs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container about py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeInLeft" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/about.jpg" style="object-fit: cover;" alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="text-secondary text-uppercase mb-3">À Propos</h6>
                    <h1 class="mb-5">Solutions de Transport et Logistique Rapides</h1>
                    <p class="mb-5">Nous offrons des services de transport et de logistique efficaces, assurant des livraisons rapides et fiables pour répondre à vos besoins.
                    </p>
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <i class="fa fa-globe fa-3x text-primary mb-3"></i>
                            <h5>Couverture Mondiale</h5>
                            <p class="m-0">Grâce à notre présence dans 49 pays, dont 47 en Afrique, nous garantissons une couverture mondiale pour vos expéditions. 
                            </p>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                            <i class="fa fa-shipping-fast fa-3x text-primary mb-3"></i>
                            <h5>Livraison Ponctuelle</h5>
                            <p class="m-0">Notre engagement envers la ponctualité assure que vos marchandises arrivent à destination dans les délais impartis, contribuant ainsi à la satisfaction de vos clients.
                            </p>
                        </div>
                    </div>
                    <a href="" class="btn btn-primary py-3 px-5">Plus d'informations</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Fact Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Quelques faits</h6>
                    <h1 class="mb-5">#1 La plateforme idéale pour organiser vos trajets partagés</h1>
                    <p class="mb-5">Ride4All facilite l'organisation de covoiturages, pédibus et vélobus pour vos déplacements quotidiens, réduisant ainsi le nombre de véhicules sur les routes et contribuant à une mobilité plus durable.
                    </p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                        <div class="ps-4">
                            <h6>Appelez-nous pour toute question !</h6>
                            <h3 class="text-primary m-0">+216 20 265 186</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <div class="bg-primary p-4 mb-4 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-users fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">Clients satisfaits</p>
                            </div>
                            <div class="bg-secondary p-4 wow fadeIn" data-wow-delay="0.5s">
                                <i class="fa fa-ship fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">Expéditions complètes</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-success p-4 wow fadeIn" data-wow-delay="0.7s">
                                <i class="fa fa-star fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">Avis des clients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Nos Services</h6>
                <h1 class="mb-5">Explorer Nos Services</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-3.jpg" alt="">
                        </div>
                        <h4 class="mb-3">Covoiturage</h4>
                        <p> Organisation et supervision des trajets partagés entre conducteurs et passagers pour optimiser les déplacements.</p>
                        <a class="btn-slide mt-2" href="covoituragefront.php"><i class="fa fa-arrow-right"></i><span>Lire Plus</span></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-2.jpg" alt="">
                        </div>
                        <h4 class="mb-3">Parking</h4>
                        <p>Supervision des disponibilités, abonnements et tarifications des espaces de stationnement.
                        </p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Lire Plus</span></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-1.jpg" alt="">
                        </div>
                        <h4 class="mb-3">Velos et Stations</h4>
                        <p>Suivi des lignes, horaires, états du trafic et services associés aux transports en commun.</p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Lire Plus</span></a>
                    </div>
                </div>
               
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-5.jpg" alt="">
                        </div>
                        <h4 class="mb-3">Recharge Electrique</h4>
                        <p> Contrôle des stations de recharge pour véhicules électriques, incluant leur disponibilité et tarification.</p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Lire Plus</span></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Feature Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container feature py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 feature-text wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Nos Fonctionnalités</h6>
                    <h1 class="mb-5">Plateforme de Mobilité de Confiance depuis 2025</h1>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Service Communautaire</h5>
                            <p class="mb-0">Ride4All favorise une communauté engagée, connectant des utilisateurs partageant des trajets similaires pour renforcer les liens sociaux et promouvoir une mobilité solidaire.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-shipping-fast text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Flexibilité des Trajets</h5>
                            <p class="mb-0">Notre plateforme offre une flexibilité totale, permettant aux utilisateurs de planifier des trajets ponctuels ou réguliers selon leurs besoins spécifiques.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-0 wow fadeInUp" data-wow-delay="0.7s">
                        <i class="fa fa-headphones text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Assistance 24/7</h5>
                            <p class="mb-0">Notre équipe de support est disponible 24h/24 et 7j/7 pour répondre à vos questions et assurer une expérience utilisateur optimale.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0 wow fadeInRight" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/feature.jpg" style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Pricing Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Nos Tarifs</h6>
                <h1 class="mb-5">Des plans tarifaires adaptés à vos besoins</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item">
                        <div class="border-bottom p-4 mb-4">
                            <h5 class="text-primary mb-1">Covoiturages</h5>
                           
                        </div>
                        <div class="p-4 pt-0">
                            <p><i class="fa fa-check text-success me-3"></i>Trajets partagés sécurisés 🚗</p>
                            <p><i class="fa fa-check text-success me-3"></i>Application mobile intuitive 📱</p>
                            <p><i class="fa fa-check text-success me-3"></i>Réduction des frais de transport 💸</p>
                            <p><i class="fa fa-check text-success me-3"></i>Respect de l’environnement 🌱</p>
                            <p><i class="fa fa-check text-success me-3"></i>Assistance et support 24/7 📞</p>
                            <a class="btn-slide mt-2" href="covoituragefront.php"><i class="fa fa-arrow-right"></i><span >👉 Réservez maintenant !</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="price-item">
                        <div class="border-bottom p-4 mb-4">
                            <h5 class="text-primary mb-1">Parking</h5>
                            <h1 class="display-5 mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;">$</small>29.00<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Month</small>
                            </h1>
                        </div>
                        <div class="p-4 pt-0">
                            <p><i class="fa fa-check text-success me-3"></i>Stationnement sécurisé 🚗🔒</p>
                            <p><i class="fa fa-check text-success me-3"></i>Accès 24/7 🕒</p>
                            <p><i class="fa fa-check text-success me-3"></i>Surveillance vidéo 📹</p>
                            <p><i class="fa fa-check text-success me-3"></i>Emplacements couverts 🏢</p>
                            <p><i class="fa fa-check text-success me-3"></i>Réservation en ligne facile 📲</p>
                            <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span >👉 Réservez maintenant !</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="price-item">
                        <div class="border-bottom p-4 mb-4">
                            <h5 class="text-primary mb-1">Recharge Electrique</h5>
                            <h1 class="display-5 mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;">$</small>69.00<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Month</small>
                            </h1>
                        </div>
                        <div class="p-4 pt-0">
                            <p><i class="fa fa-check text-success me-3"></i>Bornes de recharge rapides ⚡🔋</p>
                            <p><i class="fa fa-check text-success me-3"></i>Compatibilité avec tous les véhicules électriques 🚗</p>
                            <p><i class="fa fa-check text-success me-3"></i>Accès 24/7 🕒</p>
                            <p><i class="fa fa-check text-success me-3"></i>Paiement simple et sécurisé 💳</p>
                            <p><i class="fa fa-check text-success me-3"></i>Stations éco-responsables 🌱</p>
                            <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span >👉 Réservez maintenant !</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pricing End -->


    <!-- Quote Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Demandez un devis personnalisé</h6>
                    <h1 class="mb-5">Obtenez une estimation gratuite !</h1>
                    <p class="mb-5">Vous souhaitez organiser des trajets partagés adaptés à vos besoins ? Contactez-nous dès maintenant pour recevoir une estimation gratuite et personnalisée de nos services. Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans la mise en place de solutions de mobilité partagée efficaces et conviviales.</p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                        <div class="ps-4">
                            <h6>Appelez-nous pour toute question !</h6>
                            <h3 class="text-primary m-0">+216 27 118 673 </h3>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                  <!--  <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">-->
                        <!--<form>
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control border-0" placeholder="Your Name" style="height: 55px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="email" class="form-control border-0" placeholder="Your Email" style="height: 55px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control border-0" placeholder="Your Mobile" style="height: 55px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <select class="form-select border-0" style="height: 55px;">
                                        <option selected>Select A Freight</option>
                                        <option value="1">Freight 1</option>
                                        <option value="2">Freight 2</option>
                                        <option value="3">Freight 3</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control border-0" placeholder="Special Note"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>-->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quote End -->
<!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="text-center">
                <h6 class="text-secondary text-uppercase">Témoignages</h6>
                <h1 class="mb-0">Ce que disent nos clients !</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="img/testimonial-3.jpg" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Youssef Rabai</h5>
                            <p class="m-0">Entrepreneur</p>
                        </div>
                    </div>
                    <p class="mb-0">Grâce à Ride4All, j'ai trouvé des covoitureurs fiables pour mes trajets quotidiens, rendant mes déplacements plus agréables et économiques
                    </p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="img/testimonial-2.jpg" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Rami Snoussi</h5>
                            <p class="m-0">Entrepreneur</p>
                        </div>
                    </div>
                    <p class="mb-0">Grâce à Ride4All, j'ai trouvé des covoitureurs fiables pour mes trajets quotidiens, rendant mes déplacements plus agréables et économiques
                    </p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="img/testimonial-1.jpg" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Duaa Limem</h5>
                            <p class="m-0">Entrepreneur</p>
                        </div>
                    </div>
                    <p class="mb-0">Grâce à Ride4All, j'ai trouvé des covoitureurs fiables pour mes trajets quotidiens, rendant mes déplacements plus agréables et économiques
                    </p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="img/testimonial-4.jpg" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Sarra Ben Attia</h5>
                            <p class="m-0">Entrepreneur</p>
                        </div>
                    </div>
                    <p class="mb-0">Grâce à Ride4All, j'ai trouvé des covoitureurs fiables pour mes trajets quotidiens, rendant mes déplacements plus agréables et économiques
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


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


