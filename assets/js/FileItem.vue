<template>
  <div class="post-file">
    <a :href="file.link" target="_blank">
      <span v-html="downloadIcon"></span>
      <span class="file-label">{{ extractFileName(file.link) }}</span>
    </a>
    <button v-if="isEditable" class="delete-doc-btn" @click="deleteFile">
      <span v-html="deleteIcon"></span>
    </button>
  </div>
</template>

<script>
export default {
  name: "FileItem",
  props: {
    file: {
      type: Object,
      required: true,
    },
    csrfToken: {
      type: String,
      required: true,
      default: "",
    },
    isEditable: {
      type: Boolean,
      required: true,
    },
    downloadIcon: {
      type: String,
      default: '<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#005B8F" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>',
    },
    deleteIcon: {
      type: String,
      default: '<svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 15 15"><path fill="indianred" fill-rule="evenodd" d="M.877 7.5a6.623 6.623 0 1 1 13.246 0a6.623 6.623 0 0 1-13.246 0M7.5 1.827a5.673 5.673 0 1 0 0 11.346a5.673 5.673 0 0 0 0-11.346m2.354 3.32a.5.5 0 0 1 0 .707L8.207 7.5l1.647 1.646a.5.5 0 0 1-.708.708L7.5 8.207L5.854 9.854a.5.5 0 0 1-.708-.708L6.793 7.5L5.146 5.854a.5.5 0 0 1 .708-.708L7.5 6.793l1.646-1.647a.5.5 0 0 1 .708 0" clip-rule="evenodd"/></svg>',
    },
  },
  methods: {
    extractFileName(filePath) {
      const fullName = filePath.split("/").pop();
      const [name, ...extParts] = fullName.split(".");
      const ext = extParts.join(".");

      const truncatedName = name.length > 10 ? name.slice(0, 10) + "... " : ext;


      return `${truncatedName}.${ext}`;
    },
    async deleteFile() {
      const confirmation = confirm("Voulez-vous vraiment supprimer ce fichier ?");
      if (!confirmation) {
        return; // Ne pas continuer si l'utilisateur annule
      }

      try {
        // Effectue la requête DELETE
        const response = await fetch(`/documents/${this.file.id}/delete`, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            _token: this.csrfToken,
          }),
        });

        // Essaie de parser les données JSON de la réponse
        const data = await response.json();

        // Vérifie si la réponse est réussie
        if (!response.ok) {
          throw new Error(data.error || "Erreur lors de la suppression du fichier.");
        }

        // Émet un événement pour mettre à jour la liste des fichiers
        this.$emit("file-deleted", this.file.id);

      } catch (error) {
        console.error("Erreur capturée :", error.message);
        alert("Impossible de supprimer le fichier. Veuillez réessayer.");
      }
    }

  },
  mounted() {
    console.log('Jeton CSRF reçu dans FileItem :', this.csrfToken);
  },
};
</script>

<style scoped>
/* Ajoutez vos styles ici */
</style>
