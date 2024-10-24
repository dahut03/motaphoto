document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelector('.slides');
    const slideCount = slides ? slides.children.length : 0;
    let currentSlideIndex = 0;

    if (slideCount === 0) return;

    function changeSlide(direction) {
        currentSlideIndex += direction;
        if (currentSlideIndex < 0) {
            currentSlideIndex = slideCount - 1;
        } else if (currentSlideIndex >= slideCount) {
            currentSlideIndex = 0;
        }

        const offset = -currentSlideIndex * 100;
        slides.style.transform = `translateX(${offset}%)`;
    }

    document.querySelector('.prev')?.addEventListener('click', () => changeSlide(-1));
    document.querySelector('.next')?.addEventListener('click', () => changeSlide(1));

    document.querySelectorAll('.slide img').forEach(img => {
        img.addEventListener('click', function () {
            const index = parseInt(this.dataset.index);
            const imageUrl = this.dataset.url;
            const reference = this.dataset.reference;
            const categories = this.dataset.categories;
            viewFullscreenCarousel(index, imageUrl, reference, categories);
        });
    });

    function viewFullscreenCarousel(index, imageUrl, reference, categories) {
        let lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.style.position = 'fixed';
        lightbox.style.top = '0';
        lightbox.style.left = '0';
        lightbox.style.width = '100%';
        lightbox.style.height = '100%';
        lightbox.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        lightbox.style.display = 'flex';
        lightbox.style.flexDirection = 'column';
        lightbox.style.alignItems = 'center';
        lightbox.style.justifyContent = 'center';
        lightbox.style.zIndex = '1000';

        let fullImage = document.createElement('img');
        fullImage.src = imageUrl;
        fullImage.style.maxWidth = 'auto';
        fullImage.style.maxHeight = '70%';
        lightbox.appendChild(fullImage);

        let detailsContainer = document.createElement('div');
        detailsContainer.style.marginTop = '20px';
        detailsContainer.style.color = 'white';
        detailsContainer.style.textAlign = 'center';

        let referenceDiv = document.createElement('div');
        referenceDiv.textContent = 'Référence : ' + reference;
        detailsContainer.appendChild(referenceDiv);

        let categoriesDiv = document.createElement('div');
        categoriesDiv.textContent = 'Catégories liées : ' + categories;
        detailsContainer.appendChild(categoriesDiv);

        lightbox.appendChild(detailsContainer);

        let closeButton = document.createElement('div');
        closeButton.className = 'close';
        closeButton.innerHTML = '&times;';
        closeButton.style.position = 'absolute';
        closeButton.style.top = '10px';
        closeButton.style.right = '20px';
        closeButton.style.color = 'white';
        closeButton.style.fontSize = '30px';
        closeButton.style.cursor = 'pointer';
        closeButton.onclick = () => document.body.removeChild(lightbox);
        lightbox.appendChild(closeButton);

        let prevButton = document.createElement('div');
        prevButton.innerHTML = '← Précédente';
        prevButton.style.position = 'absolute';
        prevButton.style.left = '20px';
        prevButton.style.top = '50%';
        prevButton.style.transform = 'translateY(-50%)';
        prevButton.style.color = 'white';
        prevButton.style.fontSize = '30px';
        prevButton.style.cursor = 'pointer';
        prevButton.onclick = function () {
            currentSlideIndex = (currentSlideIndex > 0) ? currentSlideIndex - 1 : slideCount - 1;
            updateLightboxContent(currentSlideIndex);
        };
        lightbox.appendChild(prevButton);

        let nextButton = document.createElement('div');
        nextButton.innerHTML = 'Suivante →';
        nextButton.style.position = 'absolute';
        nextButton.style.right = '20px';
        nextButton.style.top = '50%';
        nextButton.style.transform = 'translateY(-50%)';
        nextButton.style.color = 'white';
        nextButton.style.fontSize = '30px';
        nextButton.style.cursor = 'pointer';
        nextButton.onclick = function () {
            currentSlideIndex = (currentSlideIndex < slideCount - 1) ? currentSlideIndex + 1 : 0;
            updateLightboxContent(currentSlideIndex);
        };
        lightbox.appendChild(nextButton);

        document.body.appendChild(lightbox);

        function updateLightboxContent(index) {
            const selectedSlide = slides.children[index].querySelector('img');
            fullImage.src = selectedSlide.dataset.url;
            referenceDiv.textContent = 'Référence : ' + selectedSlide.dataset.reference;
            categoriesDiv.textContent = 'Catégories liées : ' + selectedSlide.dataset.categories;
        }
    }
});
