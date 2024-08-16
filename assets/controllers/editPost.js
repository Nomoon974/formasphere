import Quill from 'quill';
import 'quill/dist/quill.snow.css';

function editPost() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const postBox = this.closest('.container-post');
            const editorContainer = postBox.querySelector(`#editor-${postId}`);
            const originalContentElement = document.getElementById(`edit-content-${postId}`);

            // Initialize Quill only when the edit button is clicked
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
                // If Quill is already initialized, just update the content
                editorContainer.quill.root.innerHTML = originalContentElement.value;
            }

            postBox.querySelector('.post-edit-form').style.display = 'block';
            postBox.querySelector('.post-text').style.display = 'none';

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

            const cancelButton = postBox.querySelector('.cancel-btn');
            cancelButton.onclick = function() {
                postBox.querySelector('.post-edit-form').style.display = 'none';
                postBox.querySelector('.post-text').style.display = 'block';
                button.disabled = false;
                postBox.querySelector('.delete-btn').disabled = false;
                const readMoreButton = postBox.querySelector('.read-more-btn');
                if (readMoreButton) {
                    readMoreButton.disabled = false;
                }
            };

            // Disable the Edit, Delete, and Read More buttons
            button.disabled = true;
            postBox.querySelector('.delete-btn').disabled = true;
            const readMoreButton = postBox.querySelector('.read-more-btn');
            if (readMoreButton) {
                readMoreButton.disabled = true;
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    editPost();
});

export default editPost;
