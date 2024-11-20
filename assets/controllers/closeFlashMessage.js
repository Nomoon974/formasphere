document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les messages flash existants
    const flashMessages = document.querySelectorAll('.flash-message');

    // Vérifier si des messages flash existent
    if (flashMessages.length > 0) {
        console.log('Messages flash détectés :', flashMessages.length);

        flashMessages.forEach(function(message) {
            const closeBttn = message.querySelector('.close-bttn');

            if (closeBttn) {
                console.log('Bouton de fermeture trouvé pour le message flash.');

                // Ajout de l'événement au clic sur le bouton
                closeBttn.addEventListener('click', function() {
                    console.log('Bouton de fermeture cliqué.');
                    message.classList.add('fade-out');

                    // Supprimer le message après la fin de l'animation
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                });
            } else {
                console.log('Pas de bouton de fermeture trouvé.');
            }

            // Fermeture automatique après 5 secondes
            setTimeout(function() {
                message.classList.add('fade-out');
                setTimeout(function() {
                    message.remove();
                }, 500); // Suppression après animation
            }, 5000); // 5 secondes de délai avant fermeture automatique
        });
    } else {
        console.log('Aucun message flash trouvé.');
    }
});

