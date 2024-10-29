document.addEventListener('DOMContentLoaded', function () {
    // Variables communes
    const modal = document.getElementById('lightbox-modal');
    const modal5 = document.getElementById('modal-5');
    const contactModal = document.getElementById('contactModal');

    const closeBtns = document.querySelectorAll('.close, .close-modal');
    const openBtns = document.querySelectorAll('#contactButton1, #contactButton2, .contact-button-menu2, #open-modal-5');

    // Variables spécifiques à la Lightbox
    let currentIndex = 0;
    const baseURL = window.location.origin;  
    const imageFolder = '/wp-content/themes/oceanwp-child/images/photos/';  

    document.addEventListener('DOMContentLoaded', function() {
    const baseURL = window.location.origin; // URL de base
    const modal = document.getElementById('lightbox-modal');
    const modalImg = document.getElementById("lightbox-image");
    const captionText = document.getElementById("caption");
    let images = [];
    let currentIndex = 0;

    // Fonction pour récupérer les images depuis le PHP
    fetch(baseURL + '/wp-content/themes/oceanwp-child/get-images.php')
        .then(response => response.json())
        .then(data => {
            images = data; // Liste des images
        })
        .catch(error => console.error("Erreur lors de la récupération des images :", error));

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
        
        const imgElement = document.querySelector(`.elementor-image-carousel img[data-index="${currentIndex}"]`);
        const reference = imgElement ? imgElement.getAttribute('data-reference') : 'Référence non disponible';
        const categories = imgElement ? imgElement.getAttribute('data-categories') : 'Catégorie non disponible';
        
        captionText.innerHTML = `<span style="float: left;">Référence : ${reference}</span><span style="float: right;">Catégories : ${categories}</span>`;
    }

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
});


    const modalImg = document.getElementById("lightbox-image");
    const captionText = document.getElementById("caption");

    // Fonctions communes
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
        
        const imgElement = document.querySelector(`.elementor-image-carousel img[data-index="${currentIndex}"]`);
        const reference = imgElement ? imgElement.getAttribute('data-reference') : 'Référence non disponible';
        const categories = imgElement ? imgElement.getAttribute('data-categories') : 'Catégorie non disponible';
        
        captionText.innerHTML = `<span style="float: left;">Référence : ${reference}</span><span style="float: right;">Catégories : ${categories}</span>`;
    }

    // Chargement d'images
    let loadedImages = [];
    let currentPage = 1;
    const loadMoreButton = document.getElementById('second-next-button');
    let noMoreImagesMessage;

    // Fonction pour charger plus d'images avec Ajax
    function loadMoreImagesAjax() {
        console.log("Chargement de plus d'images..."); // Debug
        let xhr = new XMLHttpRequest();
        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        let params = 'action=load_more_images&currentPage=' + currentPage + '&loadedImages=' + JSON.stringify(loadedImages);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                console.log("Réponse du serveur:", response); // Debug
                if (response.success) {
                    appendImages(response.data.images);

                    // Ajouter les nouveaux IDs des images chargées à la liste
                    response.data.images.forEach(function (image) {
                        loadedImages.push(image.id);
                    });

                    currentPage++; 
                } else {
                    if (!noMoreImagesMessage) {
                        noMoreImagesMessage = document.createElement('div');
                        noMoreImagesMessage.id = 'no-more-images';
                        noMoreImagesMessage.innerText = "Il n'y a plus d'images à charger";
                        noMoreImagesMessage.style.textAlign = 'center'; 
                        noMoreImagesMessage.style.marginTop = '20px'; 
                        document.body.appendChild(noMoreImagesMessage);
                    }
                }
            }
        };

        xhr.send(params);
    }

    // Événements pour Lightbox
    document.querySelectorAll('.elementor-image-carousel img').forEach((img, index) => {
        img.addEventListener('click', function (event) {
            event.preventDefault();
            openLightbox(index);
        });
    });

    document.querySelector('.prev').addEventListener('click', function () {
        changeImage(-1);
    });

    document.querySelector('.next').addEventListener('click', function () {
        changeImage(1);
    });

    // Événements pour Modales
    openBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (btn.id === 'open-modal-5') {
                openModal(modal5);
            } else {
                openModal(contactModal);
            }
        });
    });

    closeBtns.forEach(function (btn) {
        btn.addEventListener('click', closeLightbox);
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal || event.target === contactModal || event.target === modal5) {
            closeLightbox();
        }
    });

    document.addEventListener('click', function () {
        if (noMoreImagesMessage) {
            noMoreImagesMessage.remove();
            noMoreImagesMessage = null; 
        }
    });

    // Fonction de tri des images
    function sortImages() {
        console.log("Tri des images..."); // Debug
        // Logique pour trier les images
        // ...

        // Désactiver le bouton "Charger plus"
        loadMoreButton.disabled = true; 
        loadMoreButton.classList.add('inactive'); 

        // Afficher le message "Il n'y a plus d'images à charger"
        if (!noMoreImagesMessage) {
            noMoreImagesMessage = document.createElement('div');
            noMoreImagesMessage.id = 'no-more-images';
            noMoreImagesMessage.innerText = "Il n'y a plus d'images à charger";
            noMoreImagesMessage.style.textAlign = 'center'; 
            noMoreImagesMessage.style.marginTop = '-70px'; 
            noMoreImagesMessage.style.position = 'relative';
            document.body.appendChild(noMoreImagesMessage);
        }
    }

    // Fonction pour annuler le tri et réinitialiser les images
    function resetImages() {
        console.log("Réinitialisation des images..."); // Debug
        // Réinitialiser les IDs des images chargées
        loadedImages = [];
        currentPage = 1; // Réinitialiser la page

        // Supprimer toutes les images actuellement affichées
        const imagesContainer = document.querySelector('.elementor-image-carousel');
        while (imagesContainer.firstChild) {
            imagesContainer.removeChild(imagesContainer.firstChild);
        }

        // Réactiver le bouton "Charger plus"
        loadMoreButton.disabled = false; 
        loadMoreButton.classList.remove('inactive'); 

        // Supprimer le message "Il n'y a plus d'images à charger"
        if (noMoreImagesMessage) {
            noMoreImagesMessage.remove();
            noMoreImagesMessage = null; 
        }

        // Charger de nouveau les images initiales ou effectuer une nouvelle requête Ajax pour les images
        loadMoreImagesAjax(); // Ou une autre fonction pour recharger les images
    }

    // Lier le bouton "Charger plus" à la fonction
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            loadMoreImagesAjax();
        });
    }

    // Ajoutez un écouteur d'événements pour la réinitialisation du tri
    const resetButton = document.getElementById('reset-button');
    if (resetButton) {
        resetButton.addEventListener('click', resetImages);
    }
});



function resetServerResponse() {
    console.log("Réinitialisation de la réponse du serveur...");
    
    // Réinitialisez les variables de suivi des images et de pagination
    loadedImages = []; // Vide la liste des images déjà chargées
    currentPage = 1; // Remet à la première page

    // Supprimez toutes les images actuellement affichées
    const imagesContainer = document.querySelector('.elementor-image-carousel');
    while (imagesContainer.firstChild) {
        imagesContainer.removeChild(imagesContainer.firstChild);
    }

    // Supprimez le message "Il n'y a plus d'images à charger", s'il est affiché
    if (noMoreImagesMessage) {
        noMoreImagesMessage.remove();
        noMoreImagesMessage = null;
    }

    // Réactivez le bouton "Charger plus" pour autoriser le chargement
    loadMoreButton.disabled = false;
    loadMoreButton.classList.remove('inactive');

    // Chargez de nouveau les images initiales
    loadMoreImagesAjax();
}

// Exemple d'ajout de l'événement pour réinitialiser la réponse lors de la sortie d'un tri
const resetButton = document.getElementById('reset-button');
if (resetButton) {
    resetButton.addEventListener('click', resetServerResponse);
}




function filterImagesList(images) {
    let category = document.getElementById('category-filter').value;
    let format = document.getElementById('format-filter').value;
    let date = document.getElementById('date-filter').value;

    // Filtrage des images par catégorie et format
    let filteredImages = images.filter(image => {
        return (category === 'all' || image.category === category) &&
               (format === 'all' || image.format === format);
    });

    // Affichage des dates pour vérifier leur format
    filteredImages.forEach(image => console.log('Date avant conversion:', image.date, 'Date après conversion:', new Date(image.date)));

    // Tri des images par date si une option de tri est sélectionnée
    if (date === 'newest') {
        filteredImages.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else if (date === 'oldest') {
        filteredImages.sort((a, b) => new Date(a.date) - new Date(b.date));
    }

    return filteredImages;
}
