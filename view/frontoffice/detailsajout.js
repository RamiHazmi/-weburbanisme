$(document).ready(function() {
    $("#destination-filter").on("input", function() {
        var filterValue = $(this).val().toLowerCase(); // Get the filter input, convert to lowercase

        $(".covoiturage-item").each(function() {
            var destination = $(this).data("destination").toLowerCase(); // Get the destination data attribute
            
            // If the input matches the destination or if the input is empty, show the item
            if (destination.indexOf(filterValue) !== -1 || filterValue === "") {
                $(this).show(); // Show the item
            } else {
                $(this).hide(); // Hide the item
            }
        });
    });
    $(".show-more-btn").click(function() {
        var id_trajet = $(this).data("id");  
        $("#covoiturages-list").css("filter", "blur(5px)");

        $("#details-" + id_trajet).fadeIn().css({
            "position": "fixed",
            "top": "50%",
            "left": "50%",
            "transform": "translate(-50%, -50%)",
            "z-index": "9999",
            "background-color": "rgba(0, 0, 0, 0.8)", 
            "padding": "20px",
            "border-radius": "10px",
            "box-shadow": "0 10px 20px rgba(0, 0, 0, 0.5)"
        });
    });

    $("button#annuler").click(function() {
        $("#covoiturages-list").css("filter", "none");

        $(".covoiturage-details").fadeOut();
    });
    

    $("[id^='close-btn-']").click(function() {
        var id_trajet = $(this).attr("id").replace("close-btn-", "");
        
        $("#covoiturages-list").css("filter", "none");

        $("#details-" + id_trajet).fadeOut();
    });
   
    
});
$(document).on("click", "#reserver-form", function () {
    const modal = $(this).closest(".modal-content");
    modal.children().not(".reservation-form").css("filter", "blur(4px)");
    const $formContainer = modal.find(".reservation-form");
    $formContainer.fadeIn();

    const id_trajet = $(this).data("id");
    
    // Clear previous event to avoid multiple bindings
    $formContainer.find("form").off("submit").on("submit", function (event) {
        event.preventDefault();

        const nbr_place = parseInt($(`#nbr_place_${id_trajet}`).val());
        const commentaire = $(`#commentaire_${id_trajet}`).val();
        const id_utilisateur = parseInt($(`#id_utilisateur_${id_trajet}`).val());

        if (isNaN(nbr_place) || nbr_place <= 0) {
            alert("Le nombre de places est requis et doit être supérieur à 0.");
            return;
        }

        fetch('../../controller/controllercovoituragereservation.php?action=ajouterReservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id_trajet=${id_trajet}&nbr_place=${nbr_place}&commentaire=${encodeURIComponent(commentaire)}&id_utilisateur=${id_utilisateur}`
        })
        .then(response => response.text())
        .then(text => {
            console.log("Reservation response (raw):", text);
            let result;
            try {
                result = JSON.parse(text);
            } catch (e) {
                console.error("Erreur de parsing JSON:", e);
                alert("Erreur serveur: réponse invalide.");
                return;
            }

            if (result.success) {
                alert("Réservation effectuée avec succès.");
                $formContainer.slideUp();
                modal.children().not(".reservation-form").css("filter", "none");
            } else {
                alert(result.message || "Erreur lors de la réservation.");
            }
        })
        .catch(error => {
            console.error("Erreur AJAX:", error);
            alert("Erreur réseau. Veuillez réessayer.");
        });
    });
});

$(document).on("click", ".cancel-reservation", function () {
    const modal = $(this).closest(".modal-content");
    modal.find(".reservation-form").fadeOut();
    modal.children().not(".reservation-form").css("filter", "none"); 
});


        