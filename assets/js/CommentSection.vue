<template>
  <div class="comment">
    <h3 class="comments-title">Commentaires</h3>

    <!-- Liste des commentaires -->
    <div v-if="reversedComments.length">
      <div v-for="comment in reversedComments" :key="comment.id" class="comment">
        <div class="comment-header">
          <img
              class="profil-img img-profil-comment"
              :src="comment.user.avatar.startsWith('/') ? comment.user.avatar : '/' + comment.user.avatar"
              :alt="`Avatar de ${comment.user.fullName}`"
          />
          <div class="comment-meta">
            <h5 class="comment-author">{{ comment.user.fullName }}</h5>
            <small>{{ formatDate(comment.createdAt) }}</small>
          </div>
        </div>
        <p v-html="comment.text"></p>
      </div>
    </div>
    <small v-else>Aucun commentaire pour le moment.</small>

    <!-- Formulaire pour ajouter un commentaire -->
    <h3 class="comments-title">Ajouter un commentaire</h3>
    <div class="form-comment">
      <textarea
          v-model="newComment"
          placeholder="Entrez votre commentaire"
          class="comment-input"
      ></textarea>
      <button class="icon-send-btn" @click="addComment">
        <img class="icon-send" :src="sendIcon" alt="Envoyer" />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "CommentSection",
  props: {
    comments: {
      type: Array,
      required: true,
    },
    user: {
      type: Object,
      required: true,
    },
    postId: {
      type: Number,
      required: true,
    },
    csrfToken: {
      type: String,
      required: true,
    },
    sendIcon: {
      type: String,
      default: "/build/images/send-message.acb93f2a.png",
    },
  },
  data() {
    return {
      newComment: "",
    };
  },
  computed: {
    reversedComments() {
      return [...this.comments].reverse();
    },
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleString("fr-FR", {
        dateStyle: "medium",
        timeStyle: "short",
      });
    },
    async addComment() {
      if (!this.newComment.trim()) {
        alert("Le commentaire ne peut pas être vide.");
        return;
      }

      const newComment = {
        text: this.newComment.trim(),
        user: this.user,
        createdAt: new Date(),
      };

      const url = `/post/${this.postId}/comment`;

      try {
        // Envoi au backend
        const response = await fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": this.csrfToken,
          },
          body: JSON.stringify(newComment),
        });

        if (!response.ok) {
          const error = await response.json();
          throw new Error(error.error || "Erreur lors de l'enregistrement du commentaire.");
        }

        const savedComment = await response.json();

        // Émet l'événement avec le commentaire retourné par le backend
        this.$emit("comment-added", savedComment);

        // Réinitialise le champ texte
        this.newComment = "";

        window.location.reload();
      } catch (error) {
        console.error("Erreur lors de l'ajout du commentaire :", error);
        alert("Une erreur est survenue. Veuillez réessayer.");
      }
    },
  },
  watch: {
    comments: {
      immediate: true,
      handler(newValue) {
        this.localComments = [...newValue]; // Synchronise les commentaires avec les props
      },
    },
  },
};
</script>

<style scoped>

</style>
