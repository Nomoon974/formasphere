<template>
  <div id="compose_box">
    <form id="postForm" @submit.prevent="handleSubmit" enctype="multipart/form-data" :action="formAction" method="POST">
      <!-- Éditeur de contenu -->
      <div id="editor"></div>
      <textarea name="content" style="display: none;" id="content-textarea" v-model="content"></textarea>

      <div class="button-container">
        <div class="left-buttons">
          <input
              ref="fileInput"
              type="file"
              name="document[]"
              id="document-input"
              style="display: none;"
              multiple
              accept=".pdf, .docx, .pptx, .xlsx, .zip, .txt, .py, .java, .cpp, .jpg, .jpeg, .png, .gif, .svg"
              @change="updateFileList"
          />

        </div>
        <add-doc-btn file-input="file-input" @trigger-file="triggerFileInput" />
        <button type="submit" id="submit-button">Poster</button>
      </div>
    </form>
  </div>
</template>

<script>
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import AddDocBtn from './AddDocBtn.vue';
import DOMPurify from 'dompurify';

export default {
  name: 'QuilEditor',
  components: {AddDocBtn}, // Importez le composant AddDocBtn
  props: {
    formAction: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      quill: null, // Instance de Quill
      content: '', // Contenu écrit
      fileList: [], // Liste des fichiers sélectionnés
      submissionError: null,
      submissionSuccess: false,
    };
  },
  mounted() {
    this.initializeQuill(); // Initialisation de Quill au montage
  },
  methods: {
    /**
     * Initialisation de Quill
     */
    initializeQuill() {
      const editor = document.getElementById('editor');

      if (!editor || editor.dataset.quillInitialized) {
        return; // Stoppe si déjà initialisé ou non trouvé
      }

      // Liste blanche personnalisée pour Quill
      const Block = Quill.import('blots/block');
      Block.tagName = 'div'; // Définit "div" comme bloc principal au lieu de "p"
      Quill.register(Block, true);

      // Initialisation de Quill avec le "toolbar" configuré
      this.quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            [{'color': []}],
            ['blockquote', 'code-block'],
            [{'header': 1}, {'header': 2}],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            ['link'],
            ['clean']
          ]
        }
      });

      document.querySelectorAll('.ql-toolbar .ql-formats button').forEach((button) => {
        if (button.classList.contains('ql-bold')) {
          button.setAttribute('title', 'Mettre en gras');
        } else if (button.classList.contains('ql-italic')) {
          button.setAttribute('title', 'Mettre en italique');
        } else if (button.classList.contains('ql-underline')) {
          button.setAttribute('title', 'Souligner');
        } else if (button.classList.contains('ql-strike')) {
          button.setAttribute('title', 'Barré');
        } else if (button.classList.contains('ql-color-picker')) {
          button.setAttribute('title', 'Couleur du texte');
        } else if (button.classList.contains('ql-blockquote')) {
          button.setAttribute('title', 'Bloc de citation');
        } else if (button.classList.contains('ql-code-block')) {
          button.setAttribute('title', 'Bloc de code');
        } else if (button.classList.contains('ql-header') && button.value === '1') {
          button.setAttribute('title', 'En-tête 1');
        } else if (button.classList.contains('ql-header') && button.value === '2') {
          button.setAttribute('title', 'En-tête 2');
        } else if (button.classList.contains('ql-list') && button.value === 'ordered') {
          button.setAttribute('title', 'Liste ordonnée');
        } else if (button.classList.contains('ql-list') && button.value === 'bullet') {
          button.setAttribute('title', 'Liste à puces');
        } else if (button.classList.contains('ql-link')) {
          button.setAttribute('title', 'Insérer un lien');
        } else if (button.classList.contains('ql-clean')) {
          button.setAttribute('title', 'Effacer le formatage');
        }
      });


      this.quill.root.style.minHeight = '150px'; // Hauteur initiale définie
      this.quill.root.style.overflowY = 'hidden'; // Empêche les scrollbars

      // Ajouter un écouteur sur "text-change" pour ajuster la hauteur dynamiquement
      this.quill.on('text-change', () => {
        this.resizeEditor();
      });

      editor.dataset.quillInitialized = true;

    },

    resizeEditor() {
      const editor = this.quill.root;
      editor.style.height = 'auto'; // Réinitialise temporairement la hauteur
      const scrollHeight = editor.scrollHeight; // Récupère la hauteur réelle du contenu
      editor.style.height = `${Math.max(scrollHeight, 150)}px`; // Limite entre 150px et 500px de hauteur
    },

    /**
     * Déclenche l'ouverture de la boîte de dialogue pour les fichiers
     */
    triggerFileInput() {
      if (this.fileInput) {
        this.fileInput.click();
      } else {
        console.error("Référence fileInput introuvable !");
      }
    },

    /**
     * Mise à jour de la liste des fichiers sélectionnés
     */
    updateFileList(event) {
      const files = Array.from(event.target.files);
      this.fileList = files;
      console.log('Fichiers sélectionnés :', this.fileList);
    },

    /**
     * Gestion de la soumission du formulaire
     */
    handleSubmit() {
      let htmlContent = this.quill.root.innerHTML.trim();
      htmlContent = DOMPurify.sanitize(htmlContent, {
        ALLOWED_TAGS: [
          'p', 'br', 'b', 'i', 'u', 's', 'strong', 'em',
          'a', 'ul', 'ol', 'li', 'h1', 'h2', 'h3',
          'blockquote', 'code', 'pre', 'span'
        ],
        ALLOWED_ATTR: ['href', 'target', 'rel', 'class', 'style'],
        ALLOWED_STYLES: {
          '*': {
            'color': true,
          }
        }
      });

      // Nettoyage du contenu HTML avec DOMPurify
      htmlContent = DOMPurify.sanitize(htmlContent);

      // Validation de la longueur après nettoyage
      if (htmlContent.length < 5 || htmlContent.length > 5000) {
        alert('Le contenu doit contenir entre 5 et 5000 caractères.');
        return;
      }

      // FormData pour la soumission
      const formData = new FormData();
      formData.append('content', htmlContent);
      console.log(htmlContent)

      // Ajout des fichiers sélectionnés
      this.fileList.forEach((file) => formData.append('document[]', file));

      // Débogage : Affichage des données du FormData
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }

      // Soumission via fetch
      fetch(this.formAction, {
        method: 'POST',
        body: formData,
      })
          .then((response) => {
            if (response.ok) {
              this.resetForm();
              console.log('Soumission réussie');
              this.submissionSuccess = true;
              window.location.reload();
            } else {
              response.text().then((text) => {
                console.error('Erreur :', text);
                this.submissionError = 'Une erreur s\'est produite lors de la soumission.';
              });
            }
          })
          .catch((error) => {
            console.error('Erreur réseau/fetch :', error);
            this.submissionError = 'Une erreur réseau s\'est produite.';
          });
    },

    /**
     * Réinitialisation du formulaire après soumission ou annulation
     */
    resetForm() {
      this.fileList = [];
      this.content = '';
      this.submissionError = null;
      this.submissionSuccess = false;

      const fileInput = document.getElementById('document-input');
      if (fileInput) {
        fileInput.value = ''; // Réinitialiser le champ fichier
      }
      if (this.$refs.postForm) {
        this.$refs.postForm.reset(); // Réinitialiser le formulaire
      }
    },
  },
  computed: {
    sanitizedContent() {
      return DOMPurify.sanitize(this.content);
    },
  },
};
</script>

<style scoped>
</style>