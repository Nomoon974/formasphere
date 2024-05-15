import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function initializeQuill() {
    const editor = document.getElementById('editor');
    if (editor) {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Compose an epic...'
        });

        let form = document.getElementById('postForm');
        form.onsubmit = function (e) {
            // Get the Quill editor's content as plain text
            let textContent = quill.getText().trim();
            let delta = quill.getContents();

            // Validate the content
            if (!isValidContent(textContent, delta)) {
                e.preventDefault(); // Prevent form submission
                alert('Le contenu ne peut pas être vide ou invalide.');
                return false;  // Stop execution
            }

            // Assign the purified content to the hidden textarea
            document.querySelector('textarea[name="content"]').value = quill.root.innerHTML.trim();
        };
    }
}

function isValidContent(textContent, delta) {
    // Check if the text content is empty or contains only whitespace
    if (textContent.length === 0) {
        return false;
    }

    // Check if Delta contains meaningful content
    let hasMeaningfulContent = false;
    delta.ops.forEach(op => {
        if (op.insert && typeof op.insert === 'string' && op.insert.trim().length > 0) {
            hasMeaningfulContent = true;
        }
    });

    return hasMeaningfulContent;
}

// Initialize Quill when the document is ready
// document.addEventListener('DOMContentLoaded', initializeQuill);

export default initializeQuill;
