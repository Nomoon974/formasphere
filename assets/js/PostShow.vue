<template>
  <div class="post_box">
    <!-- Conteneur principal du post -->
    <div id="post_container">
      <div class="post">
        <!-- En-tête -->
        <div class="post-header" v-if="post.user">
          <img
              class="profil-img img-profil-post"
              :src="post.user.avatar.startsWith('/') ? post.user.avatar : '/' + post.user.avatar"
              :alt="`Avatar de ${post.user.fullName}`"
          />
          <h4 class="post-author">{{ post.user.fullName }}</h4>

          <!-- Actions (modifier/supprimer) -->
          <div v-if="isEditable" class="post-actions">
            <delete-post
                :post-id="post.id"
                :token="csrfToken"
                :delete-action-url="deletePostUrl"
                :image-url="deleteIcon"
                @post-deleted="handlePostDeleted"
            ></delete-post>
            <EditPostButton
                @edit-toggled="onEditClick"
                :editIcon="editIcon"
            ></EditPostButton>
          </div>
        </div>

        <!-- Affichage pour utilisateurs non connectés -->
        <div v-else class="post-header">
          <p>Utilisateur non connecté</p>
        </div>

        <!-- Contenu éditable ou affichable -->
        <div v-if="isEditing" class="post-edit-form">
          <div ref="editor" class="quill-editor"></div>
          <textarea v-model="editedContent" class="hidden-label"></textarea>
          <div class="form-errors" v-if="error">{{ error }}</div>
          <div class="post-actions">
            <button class="save-btn" @click="saveEdit">Sauvegarder</button>
            <button class="cancel-btn" @click="cancelEdit">Annuler</button>
          </div>
        </div>
        <div v-else class="post-text-show">
          <p v-html="post.text"></p>
        </div>
      </div>

      <!-- Liste des fichiers -->
      <div class="post-file-list">
        <add-file-button
            @files-added="handleFilesAdded"
            :acceptedFileTypes="acceptedFileTypes"
            :allowMultiple="true"
        />
        <file-item
            v-for="doc in localDocuments"
            :key="doc.id"
            :file="doc"
            :csrfToken="doc.csrfToken"
            :isEditable="isEditable"
            @file-deleted="handleFileDeleted"
        ></file-item>
      </div>

      <!-- Date -->
      <small>{{ "Créé le : " +formatDate(post.createdAt) }}</small>
      <small>{{ post.updatedAt ? " et Modifié le : " + formatDate(post.updatedAt) : '' }}</small>

      <!-- Commentaires -->
<!--      <h3 class="comments-title">Commentaires</h3>-->
<!--      <div v-if="comments.length" v-for="comment in comments" :key="comment.id" class="comment">-->
<!--        <div class="comment-header">-->
<!--          <img-->
<!--              class="profil-img img-profil-comment"-->
<!--              :src="comment.user.avatar.startsWith('/') ? comment.user.avatar : '/' + comment.user.avatar"-->
<!--              :alt="`Avatar de ${comment.user.fullName}`"-->
<!--          />-->
<!--          <div class="comment-meta">-->
<!--            <h5 class="comment-author">{{ comment.user.fullName }}</h5>-->
<!--            <small>{{ formatDate(comment.createdAt) }}</small>-->
<!--          </div>-->
<!--        </div>-->
<!--        <p v-html="comment.text"></p>-->
<!--      </div>-->
<!--      <small v-else>Aucun commentaire pour le moment.</small>-->

<!--      &lt;!&ndash; Ajouter un commentaire &ndash;&gt;-->
<!--      <h3 class="comments-title">Ajouter un commentaire</h3>-->
<!--      <div class="form-comment">-->
<!--        <textarea-->
<!--            v-model="newComment"-->
<!--            placeholder="Entrez votre commentaire"-->
<!--            class="comment-input"-->
<!--        ></textarea>-->
<!--        <button class="icon-send-btn" @click="addComment">-->
<!--          <img class="icon-send" :src="sendIcon" alt="Envoyer">-->
<!--        </button>-->
<!--      </div>-->
      <comment-section
          :user="user"
          :comments="comments"
          :post-id="post.id"
          :csrf-token="csrfToken"
        @comment-added="handleNewComment">
      </comment-section>
    </div>
  </div>
</template>

<script>
import Quill from "quill";
import "quill/dist/quill.snow.css";
import FileItem from "./FileItem.vue";
import DeletePost from "./DeletePost.vue";
import AddFileButton from "./AddFileApi.vue";
import EditPostButton from "./EditPostButton.vue";
import CommentSection from "./CommentSection.vue";
import { ref } from "vue";

export default {
  components: {
    CommentSection,
    EditPostButton,
    AddFileButton,
    DeletePost,
    FileItem,
  },
  name: "PostShow",
  props: {
    post: { type: Object, required: true },
    documents: { type: Array, required: true },
    comments: { type: Array, required: true, default: () => [] },
    user: { type: Object, required: true },
    csrfToken: { type: String, required: true },
    editIcon: { type: String, default: '<svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" viewBox="0 0 24 24"><g fill="#005B8F" fill-rule="evenodd" class="Vector" clip-rule="evenodd"><path d="M2 6.857A4.857 4.857 0 0 1 6.857 2H12a1 1 0 1 1 0 2H6.857A2.857 2.857 0 0 0 4 6.857v10.286A2.857 2.857 0 0 0 6.857 20h10.286A2.857 2.857 0 0 0 20 17.143V12a1 1 0 1 1 2 0v5.143A4.857 4.857 0 0 1 17.143 22H6.857A4.857 4.857 0 0 1 2 17.143z"/><path d="m15.137 13.219l-2.205 1.33l-1.033-1.713l2.205-1.33l.003-.002a1.2 1.2 0 0 0 .232-.182l5.01-5.036a3 3 0 0 0 .145-.157c.331-.386.821-1.15.228-1.746c-.501-.504-1.219-.028-1.684.381a6 6 0 0 0-.36.345l-.034.034l-4.94 4.965a1.2 1.2 0 0 0-.27.41l-.824 2.073a.2.2 0 0 0 .29.245l1.032 1.713c-1.805 1.088-3.96-.74-3.18-2.698l.825-2.072a3.2 3.2 0 0 1 .71-1.081l4.939-4.966l.029-.029c.147-.15.641-.656 1.24-1.02c.327-.197.849-.458 1.494-.508c.74-.059 1.53.174 2.15.797a2.9 2.9 0 0 1 .845 1.75a3.15 3.15 0 0 1-.23 1.517c-.29.717-.774 1.244-.987 1.457l-5.01 5.036q-.28.281-.62.487m4.453-7.126s-.004.003-.013.006z"/></g></g></svg>' },
    sendIcon: { type: String, default: "/build/images/send-message.acb93f2a.png" },
    deleteIcon: { type: String, default: "/build/images/close.53e53dde.png" },
  },
  setup(props) {
    const comments = ref(props.comments);

    function handleNewComment(newComment) {
      comments.value.push(newComment);
    }

    return {
      comments,
      handleNewComment,
    };
  },
  data() {
    return {
      isEditing: false,
      quillEditor: null,
      originalContent: "",
      editedContent: "",
      localDocuments: [...this.documents],
      localComments: [...this.comments],
      error: null,
      newComment: "",
    };
  },
  computed: {
    isEditable() {
      return this.user.id === this.post.user.id;
    },
    deletePostUrl() {
      return `/posts/${this.post.id}/delete`;
    },
  },
  methods: {
    onEditClick() {
      this.isEditing = true;

      this.$nextTick(() => {
        this.destroyQuill(); // Détruire l'éditeur existant, s'il y en a un
        this.initializeQuill(); // Réinitialiser l'éditeur Quill
      });
    },

    initializeQuill() {
      const editor = this.$refs.editor; // Récupère l'élément DOM de l'éditeur

      if (!editor || editor.dataset.quillInitialized) return; // Évite une double initialisation

      // Initialisation de Quill
      this.quillEditor = new Quill(editor, {
        theme: "snow",
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike"],
            [{ color: [] }],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            ["link"],
            ["clean"],
          ],
        },
      });

      // Charger le contenu du post existant dans l'éditeur
      this.quillEditor.root.innerHTML = this.post.text || "";

      // Appliquer des styles à l'éditeur
      this.quillEditor.root.style.minHeight = "150px";
      this.quillEditor.root.style.overflowY = "hidden"; // Empêche les scrollbars inutiles

      // Réajuster la hauteur automatiquement lors des modifications
      this.quillEditor.on("text-change", this.resizeEditor);

      // Empêche la réinitialisation multiple
      editor.dataset.quillInitialized = true;
    },

    resizeEditor() {
      const editor = this.quillEditor.root;
      editor.style.height = "auto"; // Réinitialise temporairement la hauteur
      editor.style.height = `${Math.max(editor.scrollHeight, 150)}px`; // Fixe la nouvelle hauteur minimale
    },


    destroyQuill() {
      if (this.quillEditor) {
        this.quillEditor.off(); // Supprimer tous les écouteurs
        this.quillEditor = null; // Réinitialiser l'instance
      }
    },

    async saveEdit() {
      const content = this.quillEditor.root.innerHTML.trim();
      if (!content || content === "<p><br></p>") {
        alert("Le contenu ne peut pas être vide.");
        return;
      }

      try {
        const response = await fetch(`/posts/post/${this.post.id}/edit`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": this.csrfToken,
          },
          body: JSON.stringify({ content }),
        });

        if (!response.ok) throw new Error("Erreur lors de la sauvegarde.");

        const data = await response.json();
        this.post.text = data.updatedText;
        this.isEditing = false;
        this.destroyQuill(); // Détruire Quill après sauvegarde
      } catch (error) {
        console.error(error);
        alert("Une erreur est survenue. Veuillez réessayer.");
      }
    },

    cancelEdit() {
      this.isEditing = false;

      // Restaurer le contenu original
      if (this.quillEditor) {
        this.quillEditor.root.innerHTML = this.post.text;
      }

      this.destroyQuill(); // Détruire Quill après annulation
    },

    handleFilesAdded(files) {
      console.log("Fichiers ajoutés :", files);
    },

    handleFileDeleted(deletedFileId) {
      this.localDocuments = this.localDocuments.filter((doc) => doc.id !== deletedFileId);
    },

    formatDate(date) {
      return new Date(date).toLocaleString("fr-FR", {dateStyle: "medium", timeStyle: "short"});
    },
  },
};
</script>

<style scoped>
.quill-editor {
  min-height: 200px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
}

.hidden-label {
  display: none;
}

.post-actions {
  margin-top: 10px;
}
</style>
