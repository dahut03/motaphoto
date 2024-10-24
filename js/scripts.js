document.addEventListener('DOMContentLoaded', function() {
    // --- Variables communes ---
    const modal = document.getElementById('lightbox-modal');
    const modal5 = document.getElementById('modal-5');
    const contactModal = document.getElementById('contactModal');
    
    const closeBtns = document.querySelectorAll('.close, .close-modal');
    const openBtns = document.querySelectorAll('#contactButton1, #contactButton2, .contact-button-menu2, #open-modal-5');

    // --- Variables spécifiques à la Lightbox ---
let currentIndex = 0;
const baseURL = window.location.origin;  // Récupère l'URL de base actuelle (local ou en ligne)
const imageFolder = '/wp-content/themes/oceanwp-child/images/photos/';  // Chemin relatif vers le dossier d'images

const images = [
    baseURL + imageFolder + 'nathalie-0.webp',
    baseURL + imageFolder + 'nathalie-1.webp',
    baseURL + imageFolder + 'nathalie-2.webp',
    baseURL + imageFolder + 'nathalie-3.webp',
    baseURL + imageFolder + 'nathalie-4.webp',
    baseURL + imageFolder + 'nathalie-5.webp',
    baseURL + imageFolder + 'nathalie-6.webp',
    baseURL + imageFolder + 'nathalie-7.webp',
    baseURL + imageFolder + 'nathalie-8.webp',
    baseURL + imageFolder + 'nathalie-9.webp',
    baseURL + imageFolder + 'nathalie-10.webp',
    baseURL + imageFolder + 'nathalie-11.webp',
    baseURL + imageFolder + 'nathalie-12.webp',
    baseURL + imageFolder + 'nathalie-13.webp',
    baseURL + imageFolder + 'nathalie-14.webp',
    baseURL + imageFolder + 'nathalie-15.webp',
    // Ajoutez les autres chemins d'images ici
];

    const modalImg = document.getElementById("lightbox-image");
    const captionText = document.getElementById("caption");

    // --- Fonctions communes ---
    function closeLightbox() {
        modal.style.display = "none";
        contactModal.style.display = "none";
        modal5.style.display = "none";
    }

    function openLightbox(index) {
        currentIndex = index;
        modal.style.display = "block";
        modalImg.src = images[currentIndex];
    
        const imgElement = document.querySelector(`.elementor-image-carousel img[data-index="${index}"]`);
        const reference = imgElement ? imgElement.getAttribute('data-reference') : 'Référence non disponible';
        const categories = imgElement ? imgElement.getAttribute('data-categories') : 'Catégorie non disponible';
    
        captionText.innerHTML = `<span style="float: left;">Référence : ${reference}</span><span style="float: right;">Catégories : ${categories}</span>`;
    }
    
    function changeImage(direction) {
        currentIndex = (currentIndex + direction + images.length) % images.length;
        modalImg.src = images[currentIndex];
        
        // Mettre à jour la légende en changeant d'image
        const imgElement = document.querySelector(`.elementor-image-carousel img[data-index="${currentIndex}"]`);
        const reference = imgElement ? imgElement.getAttribute('data-reference') : 'Référence non disponible';
        const categories = imgElement ? imgElement.getAttribute('data-categories') : 'Catégorie non disponible';
        
        captionText.innerHTML = `<span style="float: left;">Référence : ${reference}</span><span style="float: right;">Catégories : ${categories}</span>`;
    }

    function fadeIn(element, duration) {
        element.style.opacity = 0;
        element.style.display = "block";

        let last = +new Date();
        let tick = function() {
            element.style.opacity = +element.style.opacity + (new Date() - last) / duration;
            last = +new Date();

            if (+element.style.opacity < 1) {
                requestAnimationFrame(tick);
            }
        };
        tick();
    }

    function fadeOut(element, duration) {
        element.style.opacity = 1;

        let last = +new Date();
        let tick = function() {
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

    function openModal(modal) {
        fadeIn(modal, 500);
    }

    function closeModal(modal) {
        fadeOut(modal, 500);
    }

    //--- Événements pour Lightbox --->
    document.querySelectorAll('.elementor-image-carousel img').forEach((img, index) => {
        img.addEventListener('click', function(event) {
            event.preventDefault();
            openLightbox(index);
        });
    });

    document.querySelector('.prev').addEventListener('click', function() {
        changeImage(-1);
    });

    document.querySelector('.next').addEventListener('click', function() {
        changeImage(1);
    });

    // --- Événements pour Modales ---
    openBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (btn.id === 'open-modal-5') {
                openModal(modal5);
            } else {
                openModal(contactModal);
            }
        });
    });

    closeBtns.forEach(function(btn) {
        btn.addEventListener('click', closeLightbox);
    });

    // Fermeture en cliquant en dehors de la modale
    window.addEventListener('click', function(event) {
        if (event.target === modal || event.target === contactModal || event.target === modal5) {
            closeLightbox();
        }
    });
});

function openFullscreen(element) {
    var img = element.parentElement.querySelector('img');
    if (img.requestFullscreen) {
        img.requestFullscreen();
    } else if (img.webkitRequestFullscreen) { /* Safari */
        img.webkitRequestFullscreen();
    } else if (img.msRequestFullscreen) { /* IE11 */
        img.msRequestFullscreen();
    }
}

function viewFullscreen(src) {
    let img = new Image();
    img.src = src;
    let viewer = document.createElement('div');
    viewer.style.position = 'fixed';
    viewer.style.top = '0';
    viewer.style.left = '0';
    viewer.style.width = '100%';
    viewer.style.height = '100%';
    viewer.style.background = "rgba(0, 0, 0, 0.9) url('" + src + "') no-repeat center center";
    viewer.style.backgroundSize = 'contain';
    viewer.style.zIndex = '9999';
    viewer.style.cursor = 'pointer';
    viewer.onclick = function() {
        document.body.removeChild(viewer);
    };
    document.body.appendChild(viewer);
}


function nextPageSecondary() {
    currentPage++;
    loadImages();  // Appelle la fonction pour charger les images

    // Ajoute une classe spécifique au bouton pour identifier qu'il est en Ajax
    document.getElementById('second-next-button').classList.add('ajax-active');
}







let loadedImages = ['nathalie-0.webp',
                    'nathalie-1.webp',
                    'nathalie-2.webp',
                    'nathalie-3.webp',
                    'nathalie-4.webp',
                    'nathalie-5.webp',
                    'nathalie-6.webp',
                    'nathalie-7.webp',
                    'nathalie-8.webp',
                    'nathalie-9.webp',
                    'nathalie-10.webp',
                    'nathalie-11.webp',
                    'nathalie-12.webp',
                    'nathalie-13.webp',
                    'nathalie-14.webp',
                    'nathalie-15.webp']; // Stocker les IDs des images déjà chargées

function loadMoreImagesAjax() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', ajax_object.ajax_url, true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    // Ajout des IDs des images déjà chargées dans les paramètres
    let params = 'action=load_more_images&currentPage=' + currentPage + '&loadedImages=' + JSON.stringify(loadedImages);

    xhr.onload = function() {
        if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            console.log(xhr.responseText);
            if (response.success) {
                appendImages(response.data.images);

                // Ajouter les nouveaux IDs des images chargées à la liste
                response.data.images.forEach(function(image) {
                    loadedImages.push(image.id);
                });

                currentPage++; // Incrémenter la page
            }
        }
    };

    xhr.send(params);
}






// Fonction pour afficher l'image en plein écran dans une lightbox
function viewFullscreen(imageUrl) {
    // Créer un conteneur pour la lightbox
    var lightbox = document.createElement('div');
    lightbox.id = 'lightbox';
    lightbox.style.position = 'fixed';
    lightbox.style.top = '0';
    lightbox.style.left = '0';
    lightbox.style.width = '100%';
    lightbox.style.height = '100%';
    lightbox.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    lightbox.style.display = 'flex';
    lightbox.style.justifyContent = 'center';
    lightbox.style.alignItems = 'center';
    lightbox.style.zIndex = '1000';

    // Créer l'élément image
    var img = document.createElement('img');
    img.src = imageUrl;
    img.style.maxWidth = '90%';
    img.style.maxHeight = '90%';
    img.style.boxShadow = '0 0 15px rgba(255, 255, 255, 0.5)';
    
    // Ajouter l'image à la lightbox
    lightbox.appendChild(img);

    // Ajouter la lightbox au body
    document.body.appendChild(lightbox);

    // Fermer la lightbox lorsqu'on clique en dehors de l'image
    lightbox.onclick = function() {
        document.body.removeChild(lightbox);
    };
}



document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.oceanwp-mobile-menu-icon.clr.mobile-right');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            menuToggle.classList.toggle('is-active');
        });
    }
});




document.addEventListener('DOMContentLoaded', function() {
    const burgerIcon = document.querySelector('.oceanwp-mobile-menu-icon');
    const mobileMenu = document.querySelector('#site-navigation'); // Ajuste ce sélecteur selon ton menu
    
    if (burgerIcon && mobileMenu) {
        burgerIcon.addEventListener('click', function() {
            // Toggle la classe 'menu-opened' sur le body ou l'élément parent
            document.body.classList.toggle('menu-opened');
        });
    }
});






















document.addEventListener('DOMContentLoaded', function() {
    const thumbnail = document.getElementById('thumbnail');
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        // Survol des flèches
        link.addEventListener('mouseenter', function() {
            const imgSrc = this.getAttribute('data-img');
            thumbnail.src = imgSrc;
            thumbnail.style.display = 'block'; // Afficher la miniature
        });

        // Sortie du survol
        link.addEventListener('mouseleave', function() {
            thumbnail.style.display = 'none'; // Cacher la miniature lorsque la souris quitte
        });

        // Clic sur les flèches
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const articleUrl = this.href;
            window.location.href = articleUrl; // Ouvre l'article lié
        });
    });
});








