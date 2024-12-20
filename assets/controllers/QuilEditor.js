import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function initializeQuill() {
    const editor = document.getElementById('editor');

    if (!editor || editor.dataset.quillInitialized) {
        return; // Stoppe si l'éditeur est introuvable ou déjà initialisé
    }

    const quill = new Quill('#editor', { theme: 'snow' });
    editor.dataset.quillInitialized = true;

    quill.on('editor-change', (eventName) => {
        if (eventName === 'selection-change') {
            quill.root.style.minHeight = quill.hasFocus() ? '300px' : '150px';
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

    const addButton = document.querySelector('.add-doc-btn');
    if (addButton) {
        addButton.addEventListener('click', () => fileInput.click());
    }

    fileInput.addEventListener('change', updateFileList);

    function updateFileList() {
        fileList.innerHTML = '';
        Array.from(fileInput.files).forEach((file) => {
            const listItem = document.createElement('li');
            listItem.innerText = `${file.name} (${Math.round(file.size / 1024)} KB)`;
            fileList.appendChild(listItem);
        });
    }

    form.onsubmit = function (e) {
        e.preventDefault();
        const htmlContent = quill.root.innerHTML.trim();
        contentInput.value = htmlContent;

        if (htmlContent.length < 5 || htmlContent.length > 5000) {
            return alert('Le contenu doit contenir entre 5 et 5000 caractères.');
        }

        const formData = new FormData();
        formData.append('content', htmlContent);
        Array.from(fileInput.files).forEach(file => {
            formData.append('document[]', file);
        });

        fetch(form.action, { method: 'POST', body: formData })
            .then(response => {
                if (response.ok) {
                    form.reset();
                    fileList.innerHTML = '';
                    window.location.reload();
                } else {
                    alert('Erreur lors de la soumission.');
                }
            })
            .catch(error => console.error('Erreur réseau/fetch :', error));
    };
}

document.addEventListener('DOMContentLoaded', initializeQuill);
export default initializeQuill;