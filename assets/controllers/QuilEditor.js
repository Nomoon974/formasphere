import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function initializeQuill() {
    // Vérifie si Quill est déjà initialisé
    if (window.quillInitialized) {
        return;
    }

    const editor = document.getElementById('editor');
    if (editor) {
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        let form = document.getElementById('postForm');
        form.onsubmit = function (e) {
            let content = document.querySelector('textarea[name="content"]');
            content.value = quill.root.innerHTML;

            let htmlContent = quill.root.innerHTML.trim();  // Nettoie les espaces vides

            // Vérifie si le contenu est vide ou ne contient que des balises HTML vides
            if (!htmlContent || htmlContent === '<p><br></p>' || !htmlContent.replace(/<(.|\n)*?>/g, '').trim()) {
                e.preventDefault();  // Empêche la soumission du formulaire
                alert('Le contenu ne peut pas être vide.');
                return false;  // Arrête l'exécution
            }

            // Validation du contenu
            if (!isValidContent(content.value)) {
                e.preventDefault(); // Empêche la soumission du formulaire
                return false;
            }

            // Assigner le contenu purifié au champ caché du formulaire
            document.querySelector('textarea[name="content"]').value = htmlContent;
        };

        // Événements focus et blur pour agrandir et réduire la zone de texte
        quill.on('editor-change', (eventName) => {
            if (eventName === 'selection-change') {
                if (quill.hasFocus()) {
                    quill.root.style.minHeight = '300px'; // Définir la nouvelle hauteur sur focus
                } else {
                    quill.root.style.minHeight = '150px'; // Réduire la hauteur sur blur
                }
            }
        });

        // Ajouter un gestionnaire d'événements pour détecter les clics en dehors de l'éditeur
        document.addEventListener('click', (event) => {
            if (!editorContainer.contains(event.target) && document.activeElement !== quill.root) {
                quill.root.style.minHeight = '150px'; // Réduire la hauteur si le clic est en dehors
            }
        });

        function isValidContent(content) {
            // Vérifie si le contenu n'est pas vide
            let div = document.createElement('div');
            div.innerHTML = content;
            return div.textContent.trim().length > 0;
        }

        // Marque Quill comme initialisé
        window.quillInitialized = true;
    }
}

function isValidContent(content) {
    // Supprime les balises HTML pour ne garder que le texte
    let textContent = content.replace(/<(.|\n)*?>/g, '').trim();

    // Vérifie si le contenu texte n'est pas vide et a une longueur minimale
    if (textContent.length < 5) { // Remplacez 5 par le nombre minimum de caractères souhaité
        alert('Le contenu doit comporter au moins 5 caractères.');
        return false;
    }

    // Vérifie la longueur du contenu avec les balises
    if (content.length > 5000) {
        alert('Le contenu ne doit pas dépasser 5000 caractères.');
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', initializeQuill);

export default initializeQuill;
