<template>
  <div class="file-uploader">
    <input
        ref="fileInput"
        type="file"
        :accept="acceptedFileTypes"
        :multiple="allowMultiple"
        style="display: none;"
        @change="handleFileChange"
    />
    <button type="button" class="add-doc-btn" v-if="isEditing" @click="triggerFileInput" aria-label="Ajouter un document">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M30 24h-4v-4h-2v4h-4v2h4v4h2v-4h4z"/><path fill="currentColor" d="M16 28H8V4h8v6a2.006 2.006 0 0 0 2 2h6v4h2v-6a.91.91 0 0 0-.3-.7l-7-7A.9.9 0 0 0 18 2H8a2.006 2.006 0 0 0-2 2v24a2.006 2.006 0 0 0 2 2h8Zm2-23.6l5.6 5.6H18Z"/></svg>
    </button>
  </div>
</template>

<script>
export default {
  name: "FileUploader",
  props: {
    acceptedFileTypes: {
      type: String,
      default: ".pdf, .docx, .pptx, .xlsx, .zip, .txt, .py, .java, .cpp, .jpg, .jpeg, .png, .gif, .svg",
    },
    allowMultiple: {
      type: Boolean,
      default: true,
    },
    addIcon: {
      type: String,
      default: `<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
        <path fill="currentColor" d="M14 2H6c-1.11 0-2 .89-2 2v16c0 1.11.89 2 2 2h7.81c-.53-.91-.81-1.95-.81-3c0-.33.03-.67.08-1H6v-2h7.81c.46-.8 1.1-1.5 1.87-2H6v-2h12v1.08c.33-.05.67-.08 1-.08s.67.03 1 .08V8zm-1 7V3.5L18.5 9zm5 6v3h-3v2h3v3h2v-3h3v-2h-3v-3z"/>
      </svg>`,
    },
    isEditing: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      selectedFiles: [],
    };
  },
  methods: {
    /**
     * Ouvre la boîte de dialogue de sélection de fichiers
     */
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    /**
     * Gère la sélection de fichiers et les ajoute à la liste locale
     */
    handleFileChange(event) {
      const files = Array.from(event.target.files);
      this.selectedFiles = [...this.selectedFiles, ...files];
      this.$emit("files-added", this.selectedFiles);
      this.$refs.fileInput.value = ""; // Réinitialise l'input pour permettre une nouvelle sélection
    },
    /**
     * Supprime un fichier sélectionné de la liste
     */
    removeFile(index) {
      this.selectedFiles.splice(index, 1);
      this.$emit("files-added", this.selectedFiles); // Met à jour les fichiers au parent
    },
  },
};
</script>

<style scoped>
.file-uploader {
  display: flex;
  flex-direction: column;
}

.add-doc-btn {
  background: none;
  border: none;
  cursor: pointer;
}

.file-item button {
  background: none;
  border: none;
  cursor: pointer;
  color: red;
}
</style>
