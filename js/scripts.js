document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    var modal = document.getElementById('contactModal');
    var openBtn = document.getElementById('contactButton');
    var closeBtn = modal.querySelector('.close');

    // Fonction pour le fade-in
    function fadeIn(element, duration) {
        element.style.opacity = 0;
        element.style.display = "block";

        var last = +new Date();
        var tick = function() {
            element.style.opacity = +element.style.opacity + (new Date() - last) / duration;
            last = +new Date();

            if (+element.style.opacity < 1) {
                requestAnimationFrame(tick);
            }
        };
        tick();
    }

    // Fonction pour le fade-out
    function fadeOut(element, duration) {
        element.style.opacity = 1;

        var last = +new Date();
        var tick = function() {
            element.style.opacity = +element.style.opacity - (new Date() - last) / duration;
            last = +new Date();

            if (+element.style.opacity > 0) {
                requestAnimationFrame(tick);
            } else {
                element.style.display = "none";
            }
        };
        tick();
    }

    // Ouvrir la modale avec fade-in
    openBtn.addEventListener('click', function() {
        fadeIn(modal, 500); // 500ms pour le fade-in
    });

    // Fermer la modale avec fade-out
    closeBtn.addEventListener('click', function() {
        fadeOut(modal, 500); // 500ms pour le fade-out
    });

    // Fermer la modale en cliquant en dehors du contenu, avec fade-out
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            fadeOut(modal, 500); // 500ms pour le fade-out
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var contactButton = document.getElementById('contactButton');
    var contactPopup = document.getElementById('contactPopup');
    var closeButton = document.getElementById('closePopupButton'); // Assurez-vous d'avoir un bouton de fermeture dans votre pop-up

    // Afficher le pop-up avec effet fade-in
    contactButton.addEventListener('click', function() {
        contactPopup.style.display = 'block';
        contactPopup.style.opacity = 0;
        var fadeIn = setInterval(function() {
            if (contactPopup.style.opacity < 1) {
                contactPopup.style.opacity = parseFloat(contactPopup.style.opacity) + 0.1;
            } else {
                clearInterval(fadeIn);
            }
        }, 50);
    });

    // Masquer le pop-up avec effet fade-out
    closeButton.addEventListener('click', function() {
        var fadeOut = setInterval(function() {
            if (contactPopup.style.opacity > 0) {
                contactPopup.style.opacity = parseFloat(contactPopup.style.opacity) - 0.1;
            } else {
                clearInterval(fadeOut);
                contactPopup.style.display = 'none';
            }
        }, 50);
    });
});



        $(document).ready(function() {
            $.ajax({
                url: 'get_images.php', // Le fichier PHP qui retourne la liste des images
                method: 'GET',
                success: function(data) {
                    // Convertir la réponse JSON en tableau
                    var images = JSON.parse(data);

                    // Sélectionner une image aléatoire
                    var randomImage = images[Math.floor(Math.random() * images.length)];

                    // Créer un élément img et l'ajouter au conteneur
                    var imgElement = $('<img>').attr('src', randomImage);
                    $('#image-container').append(imgElement);
                },
                error: function() {
                    $('#image-container').text('Erreur lors du chargement des images.');
                }
            });
        });
