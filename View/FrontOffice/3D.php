<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width: device-width, initial-scale=1.0">
    <title>Modèle 3D Borne Électrique Détails</title>
    <style>
        body { margin: 0; }
        canvas { display: block; }
        #3d-container { position: absolute; width: 100%; height: 100%; }
    </style>
</head>
<body>
    <div id="3d-container"></div>

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
</body>
</html>  