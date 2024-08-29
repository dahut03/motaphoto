document.addEventListener('DOMContentLoaded', function() {
    // --- Variables communes ---
    const modal = document.getElementById('lightbox-modal');
    const modal5 = document.getElementById('modal-5');
    const contactModal = document.getElementById('contactModal');
    
    const closeBtns = document.querySelectorAll('.close, .close-modal');
    const openBtns = document.querySelectorAll('#contactButton1, #contactButton2, .contact-button-menu2, #open-modal-5');

    // --- Variables spécifiques à la Lightbox ---
    let currentIndex = 0;
    const images = [
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-0.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-1.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-2.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-3.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-4.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-5.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-6.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-7.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-8.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-9.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-10.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-11.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-12.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-13.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-14.jpeg',
        'http://localhost/motaphoto.com2/wp-content/themes/oceanwp-child/images/photos/nathalie-15.jpeg',
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

    // --- Événements pour Lightbox ---
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
