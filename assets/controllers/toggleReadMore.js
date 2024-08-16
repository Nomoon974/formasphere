function toggleReadMore() {
    const readMoreButtons = document.querySelectorAll('.read-more-btn');

    readMoreButtons.forEach(button => {
        const postBox = button.closest('#post_box');
        const postTextContainer = postBox.querySelector('.post-text');

        // Vérifie si le contenu dépasse la hauteur maximale
        if (postTextContainer.scrollHeight <= 100) {
            button.style.display = 'none'; // Masque le bouton si le texte ne dépasse pas
        }
        button.addEventListener('click', function() {
            if (postTextContainer.classList.contains('expanded')) {
                postTextContainer.style.maxHeight = '100px';
                postTextContainer.classList.remove('expanded');
                button.textContent = 'Lire plus';
            } else {
                postTextContainer.style.maxHeight = postTextContainer.scrollHeight + 'px';
                postTextContainer.classList.add('expanded');
                button.textContent = 'Lire moins';
            }

            // Attendre que la transition se termine avant de faire défiler
            setTimeout(() => {
                postBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500); // Délai correspondant à la durée de la transition CSS
        });
    });
}

export default toggleReadMore;
