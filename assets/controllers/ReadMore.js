function toggleReadMore() {
    const readMoreBtns = document.querySelectorAll('.read-more-btn');

    readMoreBtns.forEach(btn => {
        const postBox = btn.closest('#post_box'); // Trouve le conteneur parent #post_box
        const postText = postBox.querySelector('.post-text');

        // Vérifie si le contenu dépasse la hauteur maximale
        if (postText.scrollHeight <= 100) {
            btn.style.display = 'none'; // Masque le bouton si le texte ne dépasse pas
        }

        btn.addEventListener('click', function() {
            if (postText.classList.contains('expanded')) {
                postText.style.maxHeight = '100px';
                postText.classList.remove('expanded');
                btn.textContent = 'Lire plus';
            } else {
                postText.style.maxHeight = postText.scrollHeight + 'px';
                postText.classList.add('expanded');
                btn.textContent = 'Lire moins';
            }

            // Attendre que la transition se termine avant de faire défiler
            setTimeout(() => {
                postBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500); // Délai correspondant à la durée de la transition CSS
        });
    });
}

export default toggleReadMore;
