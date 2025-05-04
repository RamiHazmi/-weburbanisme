document.getElementById("form").addEventListener("submit", function (event) {
    let isValid = true;

    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let address = document.getElementById("address").value.trim();
    let phone = document.getElementById("phone").value.trim();

    function displayMessage(id, message, isError) {
        var element = document.getElementById(id + "_error");
        element.style.color = isError ? "red" : "green";
        element.innerText = message;
    }

    if (!username || !email || !password || !address || !phone) {
        alert("Tous les champs obligatoires doivent être remplis");
        isValid = false;
    }

    let usernameRegex = /^[a-zA-Z_.-]{3,}$/;
    if (!usernameRegex.test(username)) {
        displayMessage("username", "Le nom d'utilisateur doit contenir au moins 3 caractères sans espace.", true);
        isValid = false;
    } else {
        displayMessage("username", "Correct", false);
    }

    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        displayMessage("email", "L'email est invalide.", true);
        isValid = false;
    } else {
        displayMessage("email", "Correct", false);
    }

    if (password.length < 6) {
        displayMessage("password", "Le mot de passe doit contenir au moins 6 caractères.", true);
        isValid = false;
    } else {
        displayMessage("password", "Correct", false);
    }

    let addressPattern = /^[A-Za-z\s]{3,}$/;
    if (!addressPattern.test(address)) {
        displayMessage("address", "L'adresse doit contenir uniquement des lettres et des espaces, avec au moins 3 caractères.", true);
        isValid = false;
    } else {
        displayMessage("address", "Correct", false);
    }

    let phonePattern = /^[0-9]{8}$/;
    if (!phonePattern.test(phone)) {
        displayMessage("phone", "Le téléphone doit contenir exactement 8 chiffres.", true);
        isValid = false;
    } else {
        displayMessage("phone", "Correct", false);
    }

    if (!isValid) 
        event.preventDefault();
});
