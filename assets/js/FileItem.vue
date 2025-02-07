<template>
  <div :class="['post-file', { editable: isEditing }]">
    <a :href="file.link" target="_blank">
      <span v-html="downloadIcon"></span>
      <span class="file-label">{{ extractFileName(file.link) }}</span>
    </a>
    <button v-if="isEditing" class="delete-doc-btn" @click="deleteFile" aria-label="Supprimer ce document">
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
    isEditing: {
      type: Boolean,
      required: true,
    },
    downloadIcon: {
      type: String,
      default: '<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#005B8F" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>',
    },
    deleteIcon: {
      type: String,
      default: '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"><path fill="#CD5C5C" d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94z"/></svg>',
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
  },
};
</script>

<style scoped>
/* Ajoutez vos styles ici */
</style>
