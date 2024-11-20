function adjustTextArea() {
    const commentInput = document.querySelector('.comment-input');

    if (commentInput) {
        // Redimensionne au clic (focus) et lors de la saisie (input)
        const resizeTextArea = function () {
            this.style.height = 'auto'; // Réinitialise la hauteur pour recalculer correctement
            this.style.height = this.scrollHeight + 'px'; // Ajuste à la hauteur du contenu
        };

        commentInput.addEventListener('focus', resizeTextArea); // Quand l'utilisateur clique dans le champ
        commentInput.addEventListener('input', resizeTextArea); // Quand l'utilisateur tape dans le champ
    }
}

export default adjustTextArea;
