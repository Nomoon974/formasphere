import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function initializeQuill() {
    const editor = document.getElementById('editor');

    // Vérifie si l'éditeur existe et s'il est déjà initialisé
    if (!editor) {
        console.warn('Éditeur introuvable.');
        return;
    }

    if (editor.dataset.quillInitialized) {
        console.log('Quill déjà initialisé pour cet éditeur.');
        return;
    }

    // Initialisation de Quill
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
    editor.dataset.quillInitialized = true; // Marque l'éditeur comme initialisé
    console.log('Quill initialisé pour cet éditeur.');

    // Ajustement visuel de l'éditeur Quill
    quill.on('editor-change', (eventName) => {
        if (eventName === 'selection-change') {
            if (quill.hasFocus()) {
                quill.root.style.minHeight = '300px';
            } else {
                quill.root.style.minHeight = '150px';
            }
        }
    });

    document.addEventListener('click', (event) => {
        if (!editor.contains(event.target) && document.activeElement !== quill.root) {
            quill.root.style.minHeight = '150px';
        }
    });

    const form = document.getElementById('postForm');
    const contentInput = document.querySelector('textarea[name="content"]');
    const fileInput = document.getElementById('document-input');
    const fileList = document.getElementById('file-list');

    // Stockage des fichiers sélectionnés
    let selectedFiles = [];

    // Bouton pour ajouter des fichiers
    const addButton = document.querySelector('.add-doc-btn');
    if (addButton) {
        addButton.addEventListener('click', () => {
            fileInput.click();
        });
    }

    // Gestion des fichiers sélectionnés
    fileInput.addEventListener('change', () => {
        Array.from(fileInput.files).forEach(file => {
            // Vérifie si le fichier n'est pas déjà présent
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
            }
        });
        fileInput.value = ''; // Réinitialise pour permettre une nouvelle sélection
        updateFileList();
    });


    function updateFileList() {
        fileList.innerHTML = ''; // Réinitialise la liste affichée

        // Affiche chaque fichier dans la liste
        selectedFiles.forEach((file, index) => {
            const listItem = document.createElement('li');
            listItem.classList.add('file-item');

            // Détermine l'icône ou le style selon le type de fichier
            const fileType = file.type;
            let iconHtml = '';

            if (fileType.includes('image')) {
                iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2v6a2 2 0 0 0 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm1.5.5V8a.5.5 0 0 0 .5.5h5.5z"/></svg>`;
            } else if (fileType.includes('pdf')) {
                iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"><path fill="currentColor" d="M44 120h168a4 4 0 0 0 4-4V88a8 8 0 0 0-2.34-5.66l-56-56A8 8 0 0 0 152 24H56a16 16 0 0 0-16 16v76a4 4 0 0 0 4 4m108-76l44 44h-44Zm72 108.53a8.18 8.18 0 0 1-8.25 7.47H192v16h15.73a8.17 8.17 0 0 1 8.25 7.47a8 8 0 0 1-8 8.53H192v15.73a8.17 8.17 0 0 1-7.47 8.25a8 8 0 0 1-8.53-8V152a8 8 0 0 1 8-8h32a8 8 0 0 1 8 8.53M64 144H48a8 8 0 0 0-8 8v55.73a8.17 8.17 0 0 0 7.47 8.27a8 8 0 0 0 8.53-8v-8h7.4c15.24 0 28.14-11.92 28.59-27.15A28 28 0 0 0 64 144m-.35 40H56v-24h8a12 12 0 0 1 12 13.16A12.25 12.25 0 0 1 63.65 184M128 144h-16a8 8 0 0 0-8 8v56a8 8 0 0 0 8 8h15.32c19.66 0 36.21-15.48 36.67-35.13A36 36 0 0 0 128 144m-.49 56H120v-40h8a20 20 0 0 1 20 20.77c-.42 10.82-9.66 19.23-20.49 19.23"/></svg>`;
            } else {
                iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2v6a2 2 0 0 0 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm1.5.5V8a.5.5 0 0 0 .5.5h5.5z"/></svg>`;
            }

            // Contenu de l'élément de liste
            listItem.innerHTML = `
            <span class="file-icon">${iconHtml}</span>
            <span class="file-name">${file.name}</span>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 3c-4.963 0-9 4.038-9 9s4.037 9 9 9s9-4.038 9-9s-4.037-9-9-9m0 16c-3.859 0-7-3.14-7-7s3.141-7 7-7s7 3.14 7 7s-3.141 7-7 7m.707-7l2.646-2.646a.5.5 0 0 0 0-.707a.5.5 0 0 0-.707 0L12 11.293L9.354 8.646a.5.5 0 0 0-.707.707L11.293 12l-2.646 2.646a.5.5 0 0 0 .707.708L12 12.707l2.646 2.646a.5.5 0 1 0 .708-.706z"/></svg>
            </button>
        `;

            // Supprime le fichier de la liste lorsqu'on clique sur "supprimer"
            listItem.querySelector('.remove-file-btn').addEventListener('click', () => {
                selectedFiles.splice(index, 1);
                updateFileList();
            });

            fileList.appendChild(listItem);
        });
    }


    function isValidContent(content) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        const textContent = tempDiv.textContent.trim();

        if (!textContent || textContent.length < 5) {
            alert('Le contenu doit contenir au moins 5 caractères.');
            return false;
        }

        if (textContent.length > 5000) {
            alert('Le contenu ne doit pas dépasser 5000 caractères.');
            return false;
        }

        return true;
    }

    // Gestion de la soumission du formulaire
    form.onsubmit = function (e) {
        e.preventDefault();

        if (!editor.dataset.quillInitialized) {
            console.warn('Quill n\'est pas initialisé.');
            return;
        }

        contentInput.value = quill.root.innerHTML.trim();

        if (!isValidContent(contentInput.value)) {
            return;
        }

        // Création de l'objet FormData
        const formData = new FormData(form);

        // Ajout des fichiers sélectionnés
        if (selectedFiles.length > 0) {
            selectedFiles.forEach(file => {
                formData.append('document[]', file);
            });
        }

        console.log('Fichiers sélectionnés actuellement :', selectedFiles);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Erreur lors de la soumission.');
                }
            })
            .catch(error => {
                console.error('Erreur réseau ou autre :', error);
            });
    };
}

document.addEventListener('DOMContentLoaded', initializeQuill);

export default initializeQuill;
