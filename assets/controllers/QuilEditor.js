import Quill from 'quill';
import 'quill/dist/quill.snow.css'; // Assurez-vous que le chemin est correct

function initializeQuill() {
    const editor = document.getElementById('editor');
    if (editor) {
        new Quill('#editor', {
            theme: 'snow' // ou 'bubble'
        });
    }
}

export default initializeQuill;
