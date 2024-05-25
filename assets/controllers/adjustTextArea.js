function adjustTextArea() {
    const commentInput = document.querySelector('.comment-input');

    if (commentInput) {
        commentInput.addEventListener('input', function() {
            console.log('Input event triggered'); // Vérifie que l'événement est bien attaché
            this.style.height = 'auto'; // Réinitialise la hauteur pour recalculer la nouvelle hauteur
            console.log('New height:', this.scrollHeight); // Vérifie la nouvelle hauteur calculée
            this.style.height = this.scrollHeight + 'px'; // Définit la hauteur à la hauteur du contenu
        });
    }
}

export default adjustTextArea;