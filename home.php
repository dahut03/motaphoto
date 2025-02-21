<?php
/*
Template Name: Homepage
*/

// Commencez à personnaliser votre template ici

$categories = get_terms(array(
    'taxonomy' => 'categorie',
    'hide_empty' => false,
));

$formats = get_terms(array(
    'taxonomy' => 'format',
    'hide_empty' => false,
));

// Obtenir les publications du type 'photo'
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => -1, // Récupérer toutes les publications
    'orderby' => 'date',
    'order' => 'DESC',
);
$query = new WP_Query($args);

$images = array();
while ($query->have_posts()) {
    $query->the_post();
    $image_id = get_the_ID();
    $image_src = get_the_post_thumbnail_url($image_id, 'full');
    $title = get_the_title($image_id);
    $categories_list = wp_get_post_terms($image_id, 'categorie', array('fields' => 'slugs'));
    $formats_list = wp_get_post_terms($image_id, 'format', array('fields' => 'slugs'));
    $date = get_the_date('Y-m-d', $image_id);
    $page_url = get_permalink($image_id); // URL de la page du post

    $reference = get_field('reference', $image_id); // Obtenez la référence à partir d'ACF

    $images[] = array(
        'id' => $image_id,
        'src' => $image_src,
        'title' => $title,
        'category' => !empty($categories_list) ? $categories_list[0] : 'default-category',
        'format' => !empty($formats_list) ? $formats_list[0] : 'default-format',
        'date' => $date,
        'pageUrl' => $page_url,
        'reference' => $reference // Ajoutez la référence
    );
}
wp_reset_postdata();

get_header(); // Inclut le header du thème
?>

<div id="image-gallery-container" class="image-gallery">
    <!-- Champs de tri -->
    <div class="filters">
        <!-- Catégorie -->
        <div class="filter-group-categorie">
            <div>Catégorie</div> <!-- Titre au-dessus -->
            <select id="category-filter" onchange="filterImages()">
                <option value="all"></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Format -->
        <div class="filter-group-format">
            <div>Format</div> <!-- Titre au-dessus -->
            <select id="format-filter" onchange="filterImages()">
                <option value="all"></option>
                <?php foreach ($formats as $format) : ?>
                    <option value="<?php echo esc_attr($format->slug); ?>">
                        <?php echo esc_html($format->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date -->
        <div class="filter-group date-filter">
            <div>Date</div> <!-- Titre au-dessus -->
            <select id="date-filter" onchange="filterImages()">
                <option value="newest"></option>
                <option value="newest">Les plus récentes</option>
                <option value="oldest">Les plus anciennes</option>
            </select>
        </div>
    </div>

    <!-- Galerie d'images -->
    <div id="image-gallery" class="image-grid">
        <!-- Les images seront chargées ici -->
    </div>
</div>

<!-- Pagination -->
<div class="pagination">
    <button id="second-next-button" class="ajax-button-secondary">Charger plus</button>
    <div id="no-more-images" style="display:none; text-align:center; margin-top:10px;">
        Il n'y a plus d'images à charger
    </div>
</div>




<script>
document.getElementById('second-next-button').addEventListener('click', function() {
    loadMoreImagesAjax();
});

function appendImages(images) {
    let gallery = document.getElementById('image-gallery');
    images.forEach((image) => {
        let div = document.createElement('div');
        div.className = 'image-item visible';
        div.style.backgroundImage = 'url("' + image.url + '")';
        div.style.backgroundSize = 'cover';
        div.style.backgroundPosition = 'center';
        div.style.height = '495px';
        div.innerHTML = `
            <div class="image-item image-title ">${image.title}</div>
            <div class="image-category">${image.categorie}</div>
            <div class="fullscreen-icon" onclick="openLightbox(${image.id})">⛶</div>
            <a href="${image.pageUrl}" class="eye-icon" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Eye.png" alt="Eye Icon" class="eye-image">
            </a>
        `;
        gallery.appendChild(div);
    });
}

const images = <?php echo json_encode($images); ?>; // Utilisation de const ici
let currentPage = 1;
const itemsPerPage = 8;

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

function filterImages() {
    currentPage = 1;
    document.getElementById('image-gallery').innerHTML = '';
    loadImages();
}

function filterImagesList(images) {
    let category = document.getElementById('category-filter').value;
    let format = document.getElementById('format-filter').value;
    let date = document.getElementById('date-filter').value;

    let filteredImages = images.filter(image => {
        return (category === 'all' || image.category === category) &&
               (format === 'all' || image.format === format);
    });

    if (date === 'newest') {
        filteredImages.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else {
        filteredImages.sort((a, b) => new Date(a.date) - new Date(b.date));
    }

    return filteredImages;
}

function openLightbox(id) {
    let filteredImages = filterImagesList(images);
    let index = filteredImages.findIndex(img => img.id === id);
    if (index >= 0) {
        showImageInLightbox(index, filteredImages);
    }
}

function showImageInLightbox(index, filteredImages) {
    closeLightbox();

    if (index < 0 || index >= filteredImages.length) {
        return;
    }

    const currentImage = filteredImages[index];

    let overlay = document.createElement('div');
    overlay.id = 'lightbox-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    overlay.style.zIndex = '999';
    overlay.onclick = closeLightbox;

    let fullImage = document.createElement('img');
    fullImage.src = currentImage.src;
    fullImage.id = 'lightbox-image';
    fullImage.style.position = 'fixed';
    fullImage.style.top = '50%';
    fullImage.style.left = '50%';
    fullImage.style.transform = 'translate(-50%, -50%)';
    fullImage.style.maxWidth = '80%';
    fullImage.style.maxHeight = '80%';
    fullImage.style.zIndex = '1000';

    let imageInfoContainer = document.createElement('div');
    imageInfoContainer.id = 'lightbox-image-info';  // Ajoutez un ID unique
    imageInfoContainer.style.position = 'fixed';
    imageInfoContainer.style.bottom = '20px';
    imageInfoContainer.style.left = '50%';
    imageInfoContainer.style.transform = 'translateX(-50%)';
    imageInfoContainer.style.color = 'white';
    imageInfoContainer.style.textAlign = 'center';
    imageInfoContainer.style.zIndex = '1001';
    imageInfoContainer.innerHTML = `
        <div class="mobil-ref" style="float: left; margin-right: 95px;">
            Référence: ${currentImage.reference}
        </div>
        <div class="mobil-cat" style="float: right;">
            Catégorie: ${currentImage.category}
        </div>
    `;

    let prevButton = document.createElement('div');
    prevButton.id = 'lightbox-prev';
    prevButton.innerHTML = '← Précédente';
    prevButton.style.position = 'fixed';
    prevButton.style.top = '50%';
    prevButton.style.left = '20px';
    prevButton.style.fontSize = '30px';
    prevButton.style.color = 'white';
    prevButton.style.cursor = 'pointer';
    prevButton.style.zIndex = '1001';
    prevButton.onclick = function(event) {
        event.stopPropagation();
        showImageInLightbox(index - 1, filteredImages);
    };

    let nextButton = document.createElement('div');
    nextButton.id = 'lightbox-next';
    nextButton.innerHTML = 'Suivante →';
    nextButton.style.position = 'fixed';
    nextButton.style.top = '50%';
    nextButton.style.right = '20px';
    nextButton.style.fontSize = '30px';
    nextButton.style.color = 'white';
    nextButton.style.cursor = 'pointer';
    nextButton.style.zIndex = '1001';
    nextButton.onclick = function(event) {
        event.stopPropagation();
        showImageInLightbox(index + 1, filteredImages);
    };

    let closeButton = document.createElement('div');
    closeButton.id = 'lightbox-close';
    closeButton.innerHTML = '&times;';
    closeButton.style.position = 'fixed';
    closeButton.style.top = '20px';
    closeButton.style.right = '35px';
    closeButton.style.fontSize = '50px';
    closeButton.style.color = 'white';
    closeButton.style.cursor = 'pointer';
    closeButton.style.zIndex = '1001';
    closeButton.onclick = closeLightbox;

    document.body.appendChild(overlay);
    document.body.appendChild(fullImage);
    document.body.appendChild(imageInfoContainer); // Ajoutez les infos sous l'image
    document.body.appendChild(prevButton);
    document.body.appendChild(nextButton);
    document.body.appendChild(closeButton);
}

function closeLightbox() {
    let overlay = document.getElementById('lightbox-overlay');
    if (overlay) {
        overlay.remove();
    }
}

function loadMoreImagesAjax() {
    currentPage++;
    loadImages();
}
function closeLightbox() {
    const elementsToRemove = ['lightbox-overlay', 'lightbox-image', 'lightbox-prev', 'lightbox-next', 'lightbox-close'];

    // Ajoutez l'ID du conteneur d'infos à la liste des éléments à supprimer
    elementsToRemove.push('lightbox-image-info');

    elementsToRemove.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.remove();  // Supprimer l'élément s'il existe
        }
    });
}
loadImages(); // Charger les images initialement
</script>

<?php
get_footer(); // Inclut le footer du thème
