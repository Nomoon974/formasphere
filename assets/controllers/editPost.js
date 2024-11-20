import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function editPost() {
    const editButton = document.querySelector('.edit-btn');

    if (!editButton) {
        console.error('Bouton "Edit" introuvable.');
        return;
    }

    editButton.addEventListener('click', function () {
        const postId = this.getAttribute('data-post-id');
        console.log('Post ID trouvé :', postId);

        const postBox = document.querySelector('.post_box'); // Conteneur principal du post
        console.log('Post box trouvé :', postBox);

        const editorContainer = postBox?.querySelector(`#editor-${postId}`);
        console.log('Editor container trouvé :', editorContainer);

        const originalContentElement = postBox?.querySelector(`#edit-content-${postId}`);
        console.log('Original content element trouvé :', originalContentElement);

        // Si l'un des éléments est introuvable, arrête l'exécution
        if (!editorContainer || !originalContentElement) {
            console.error('Éléments requis pour l\'édition introuvables.');
            return;
        }

        // Initialisation de Quill
        if (!editorContainer.quill) {
            const quill = new Quill(editorContainer, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['code-block']
                    ]
                }
            });
            editorContainer.quill = quill;
            editorContainer.quill.root.innerHTML = originalContentElement.value;
        } else {
            // Si Quill est déjà initialisé, met à jour le contenu
            editorContainer.quill.root.innerHTML = originalContentElement.value;
        }

        // Affiche l'éditeur et masque le texte du post
        postBox.querySelector('.post-edit-form').style.display = 'block';
        postBox.querySelector('.post-text').style.display = 'none';

        // Gestion du bouton "Sauvegarder"
        const saveButton = postBox.querySelector('.save-btn');
        saveButton.onclick = function(event) {
            const textArea = postBox.querySelector('textarea[name="posts[editContent]"]');
            textArea.value = editorContainer.quill.root.innerHTML;

            let htmlContent = editorContainer.quill.root.innerHTML.trim();

            if (!htmlContent || htmlContent === '<p><br></p>' || !htmlContent.replace(/<(.|\n)*?>/g, '').trim()) {
                event.preventDefault();
                alert('Le contenu ne peut pas être vide.');
                return false;
            }
        };

        // Gestion du bouton "Annuler"
        const cancelButton = postBox.querySelector('.cancel-btn');
        cancelButton.onclick = function () {
            // Masque l'éditeur et rétablit l'affichage du texte original
            postBox.querySelector('.post-edit-form').style.display = 'none';
            postBox.querySelector('.post-text').style.display = 'block';

            // Réactive le bouton "Edit"
            editButton.disabled = false;
        };

        // Désactive le bouton "Edit" pendant l'édition
        editButton.disabled = true;
    });
}

// Initialise l'éditeur une fois le DOM chargé
document.addEventListener('DOMContentLoaded', () => {
    editPost();
});

export default editPost;
