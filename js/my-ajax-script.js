document.addEventListener("DOMContentLoaded", function() {
    console.log("SCRIPT CHARGÉ : my-ajax-script.js"); // Vérifier si le script est chargé plusieurs fois

    const categoryFilter = document.getElementById('category-filter');
    const formatFilter = document.getElementById('format-filter');
    const dateFilter = document.getElementById('date-filter');
    const loadMoreButton = document.getElementById('second-next-button');
    const imageGallery = document.getElementById('image-gallery');

    let currentPage = 1;

    // Utiliser window.isLoading pour éviter la redéclaration globale
    if (typeof window.isLoading === "undefined") {
        window.isLoading = false;
    }

    // Vérification de la disponibilité de ajax_params
    if (typeof ajax_params === 'undefined') {
        console.error("ERREUR : ajax_params n'est pas défini.");
        return;
    }

    function loadImages(page = 1) {
        if (window.isLoading) {
            console.warn("⏳ Requête AJAX ignorée (déjà en cours)");
            return;
        }
        window.isLoading = true;

        // Définir les variables uniquement si les éléments existent
        const category = categoryFilter ? categoryFilter.value : '';
        const format = formatFilter ? formatFilter.value : '';
        const date = dateFilter ? dateFilter.value : '';

        console.log(`🔄 Appel AJAX #${page} - Catégorie: ${category}, Format: ${format}, Date: ${date}`);
        console.log(ajax_params.nonce); // Affichage du nonce pour la vérification dans la console

        // Appel AJAX pour récupérer les images filtrées
        jQuery.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_filtered_images',
                security: ajax_params.nonce, // Utilisation du nonce pour sécuriser la requête
                category: category,
                format: format,
                date: date,
                page: page
            },
            success: function(response) {
                if (response.success) {
                    console.log("✅ Images chargées !");
                    // Traitez les images reçues ici (par exemple, afficher les images dans l'interface)
                } else {
                    console.warn("⚠️ Aucune image trouvée.");
                }
            },
            error: function() {
                console.error("❌ Erreur lors du chargement des images.");
            },
            complete: function() {
                window.isLoading = false;
            }
        });
    }

    function filterImages(page = 1) {
        console.log("🛠 Filtrage des images...");
        currentPage = page;
        loadImages(page);
    }

    if (loadMoreButton) {
        loadMoreButton.addEventListener("click", function() {
            console.log("📥 Bouton 'Charger plus' cliqué");
            currentPage++;
            filterImages(currentPage);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function() {
            console.log("🎛 Changement de catégorie détecté");
            filterImages(1);
        });
    }

    if (formatFilter) {
        formatFilter.addEventListener("change", function() {
            console.log("📷 Changement de format détecté");
            filterImages(1);
        });
    }

    if (dateFilter) {
        dateFilter.addEventListener("change", function() {
            console.log("📅 Changement de date détecté");
            filterImages(1);
        });
    }

    console.log("🖼 Chargement initial des images...");
    loadImages(1);
});
