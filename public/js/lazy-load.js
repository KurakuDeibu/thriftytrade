document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = document.querySelectorAll('.lazy-load');

    const lazyLoadOptions = {
        root: null, // viewport
        rootMargin: '0px',
        threshold: 0.1 // 10% of the image is visible
    };

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const image = entry.target;
                const dataSrc = image.getAttribute('data-src');

                if (dataSrc) {
                    image.src = dataSrc;
                    image.classList.remove('lazy-load');
                    image.classList.add('lazy-loaded');
                }

                observer.unobserve(image);
            }
        });
    }, lazyLoadOptions);

    lazyImages.forEach(image => {
        imageObserver.observe(image);
    });
});
