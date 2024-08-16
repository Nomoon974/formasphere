import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function initializeQuill() {
    if (window.quillInitialized) {
        console.log('Quill editor already initialized, Posts creator editor');
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

            let htmlContent = quill.root.innerHTML.trim();

            if (!htmlContent || htmlContent === '<p><br></p>' || !htmlContent.replace(/<(.|\n)*?>/g, '').trim()) {
                e.preventDefault();
                alert('Le contenu ne peut pas être vide.');
                return false;
            }

            if (!isValidContent(content.value)) {
                e.preventDefault();
                return false;
            }

            document.querySelector('textarea[name="content"]').value = htmlContent;
        };

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

        function isValidContent(content) {
            let div = document.createElement('div');
            div.innerHTML = content;
            return div.textContent.trim().length > 0;
        }

        window.quillInitialized = true;
    }
}

function isValidContent(content) {
    let textContent = content.replace(/<(.|\n)*?>/g, '').trim();

    if (textContent.length < 5) {
        alert('Le contenu doit comporter au moins 5 caractères.');
        return false;
    }

    if (content.length > 5000) {
        alert('Le contenu ne doit pas dépasser 5000 caractères.');
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', initializeQuill);

export default initializeQuill;
