document.addEventListener('DOMContentLoaded', function() {
    // --- Variables communes ---
    const modal = document.getElementById('lightbox-modal');
    const modal5 = document.getElementById('modal-5');
    const contactModal = document.getElementById('contactModal');
    const overlay = document.getElementById('contact-popup-overlay');
    const closeBtns = document.querySelectorAll('.close, .close-modal');
    const openBtns = document.querySelectorAll('#contactButton1, #contactButton2, .contact-button-menu2, #open-modal-5');

    // --- Variables spécifiques à la Lightbox ---
    let currentIndex = 0;
    const baseURL = window.location.origin;  // Récupère l'URL de base actuelle (local ou en ligne)
    const imageFolder = '/wp-content/uploads/';  // Chemin relatif vers le dossier d'images

    // Récupérer dynamiquement les images mises en avant
    const images = [];
    const featuredImages = document.querySelectorAll('.elementor-image-carousel img'); // Sélectionnez les images dans votre carousel

    featuredImages.forEach(img => {
        const src = img.src; // Récupère la source de chaque image
        images.push(src); // Ajoute à la liste des images
    });

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

// Reste du code inchangé...


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











function sortImages() {
    // Logique pour trier les images
    // ...

    // Rendre le bouton "Charger plus" inactif
    loadMoreButton.disabled = true; // Désactive le bouton
    loadMoreButton.classList.add('inactive'); // Ajoute une classe pour styliser le bouton si nécessaire

    // Afficher le message "Il n'y a plus d'images à charger"
    const message = document.createElement('div');
    message.id = 'no-more-images';
    message.innerText = 'Il n\'y a plus d\'images à charger';
    message.style.textAlign = 'center'; // Centrer le texte
    message.style.marginTop = '20px'; // Ajouter un espace au-dessus du message
    document.body.appendChild(message); // Ajoute le message au corps de la page

    // Optionnel : Masquer le message lorsque vous rechargez des images
    // Vous pouvez ajouter un code pour masquer ce message si nécessaire
}

// Appelez cette fonction chaque fois que vous souhaitez trier les images


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










jQuery(document).ready(function($) {
    // Ouvrir la lightbox
    $('.open-contact-popup').on('click', function(e) {
        e.preventDefault();
        $('#contact-popup-overlay').fadeIn(); // Afficher l'overlay avec le formulaire
    });

    // Fermer la lightbox en cliquant sur la croix ou l'overlay
    $('#close-popup, #contact-popup-overlay').on('click', function(e) {
        if ($(e.target).is('#close-popup') || $(e.target).is('#contact-popup-overlay')) {
            $('#contact-popup-overlay').fadeOut(); // Masquer l'overlay
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('contact-popup-overlay');
    const closeOverlayButton = document.getElementById('close-popup-overlay');

    // Fermer la lightbox en cliquant sur la croix
    closeOverlayButton.addEventListener('click', function () {
        overlay.style.display = 'none';
    });

    // Fermer la lightbox en cliquant sur le fond noir (overlay)
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('contact-popup-overlay');
    const closeOverlayButton = document.getElementById('close-popup-overlay');
    const openPopupButton = document.getElementById('open-contact-popup');

    // Vérifiez si l'élément "overlay" existe
    if (overlay) {
        // Fonction pour désactiver le défilement
        function disablePageScroll() {
            document.body.style.overflow = 'hidden';
        }

        // Fonction pour réactiver le défilement
        function enablePageScroll() {
            document.body.style.overflow = '';
        }

        // Ouvrir la modale
        if (openPopupButton) {
            openPopupButton.addEventListener('click', function (e) {
                e.preventDefault();
                overlay.style.display = 'flex'; // Afficher l'overlay
                disablePageScroll(); // Désactiver le défilement
            });
        }

        // Fermer la modale en cliquant sur la croix
        if (closeOverlayButton) {
            closeOverlayButton.addEventListener('click', function () {
                overlay.style.display = 'none'; // Masquer l'overlay
                enablePageScroll(); // Réactiver le défilement
            });
        }

        // Fermer la modale en cliquant sur l'overlay
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.style.display = 'none'; // Masquer l'overlay
                enablePageScroll(); // Réactiver le défilement
            }
        });
    } else {
        console.error("L'élément #contact-popup-overlay est introuvable.");
    }
});

jQuery(document).ready(function($) {
    $('select').select2();
});






function filterImages() {
    // Réinitialiser currentPage à 1
    currentPage = 1;
    document.getElementById('image-gallery').innerHTML = ''; // Réinitialiser la galerie

    // Charger les images après filtrage
    loadImages();

    // Vérifier si plus d'images sont disponibles
    let filteredImages = filterImagesList(images);
    let totalItems = filteredImages.length;
    let totalPages = Math.ceil(totalItems / itemsPerPage);

    if (currentPage >= totalPages) {
        // Si nous avons atteint la dernière page, masquer le bouton
        document.getElementById('second-next-button').style.display = 'none';
        document.getElementById('no-more-images').style.display = 'block'; // Afficher le message "Il n'y a plus d'images à charger"
    } else {
        // Sinon, afficher le bouton "Charger plus"
        document.getElementById('second-next-button').style.display = 'inline-block';
        document.getElementById('no-more-images').style.display = 'none'; // Masquer le message
    }
}

function loadImages() {
    let gallery = document.getElementById('image-gallery');
    let filteredImages = filterImagesList(images);

    let totalItems = filteredImages.length;
    let totalPages = Math.ceil(totalItems / itemsPerPage);

    let startIndex = (currentPage - 1) * itemsPerPage;
    let endIndex = startIndex + itemsPerPage;
    let imagesToDisplay = filteredImages.slice(startIndex, endIndex);

    imagesToDisplay.forEach((image) => {
        let div = document.createElement('div');
        div.className = 'image-item';
        div.style.backgroundImage = 'url("' + image.src + '")';
        div.style.backgroundSize = 'cover';
        div.style.backgroundPosition = 'center';
        div.style.height = '495px';
        div.innerHTML = `
            <div class="image-title">${image.title}</div>
            <div class="image-category">${image.category}</div>
            <div class="fullscreen-icon" onclick="openLightbox(${image.id})">⛶</div>
            <a href="${image.pageUrl}" class="eye-icon" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Eye.png" alt="Eye Icon" class="eye-image">


            </a>
        `;
        gallery.appendChild(div);
    });

    let observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.image-item').forEach(item => {
        observer.observe(item);
    });
}

function loadMoreImagesAjax() {
    // Vérifier s'il reste des pages
    let filteredImages = filterImagesList(images);
    let totalItems = filteredImages.length;
    let totalPages = Math.ceil(totalItems / itemsPerPage);

    if (currentPage < totalPages) {
        currentPage++; // Incrémenter la page pour charger plus d'images
        loadImages(); // Charger plus d'images
    }

    // Si nous avons atteint la dernière page, masquer le bouton
    if (currentPage >= totalPages) {
        document.getElementById('second-next-button').style.display = 'none';
        document.getElementById('no-more-images').style.display = 'block'; // Afficher "Il n'y a plus d'images"
    }
}

