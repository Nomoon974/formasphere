<template>
  <div class="add-doc-btn-container">
    <!-- Bouton pour ajouter des documents -->
    <div>
      <button class="add-doc-btn" type="button" @click="$emit('trigger-file')" title="Ajouter un fichier">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M30 24h-4v-4h-2v4h-4v2h4v4h2v-4h4z"/><path fill="currentColor" d="M16 28H8V4h8v6a2.006 2.006 0 0 0 2 2h6v4h2v-6a.91.91 0 0 0-.3-.7l-7-7A.9.9 0 0 0 18 2H8a2.006 2.006 0 0 0-2 2v24a2.006 2.006 0 0 0 2 2h8Zm2-23.6l5.6 5.6H18Z"/></svg>
      </button>
    </div>


    <!-- Input de type fichier (agissant en arrière-plan via ref) -->
    <input
        ref="fileInput"
        type="file"
        id="document-input"
        style="display: none;"
        multiple
        accept=".pdf, .docx, .pptx, .xlsx, .zip, .txt, .py, .java, .cpp, .jpg, .jpeg, .png, .gif, .svg"
        @change="handleFileChange"
    />

    <!-- Liste des fichiers sélectionnés -->

      <ul id="file-list" class="file-list">
        <li v-for="(file, index) in selectedFiles" :key="file.name">
          <div class="file-name">
            <!-- Icône du fichier -->
            <span v-html="getFileIcon(file.type)" class="file-icon"></span>
            {{ file.name }}

            <!-- Bouton pour retirer un fichier -->
            <span class="remove-file-btn" @click="removeFile(index)">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 24 24"
                fill="red"
            >
              <path
                  fill="currentColor"
                  d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18m11-9c0 6.075-4.925 11-11 11S1 18.075 1 12S5.925 1 12 1s11 4.925 11 11M7.403 15.182L10.586 12L7.403 8.818l1.415-1.415L12 10.586l3.182-3.182l1.414 1.414L13.414 12l3.182 3.182l-1.414 1.414L12 13.414l-3.182 3.182z"
              />
            </svg>
          </span>
          </div>
        </li>
      </ul>
    </div>


</template>

<script>
export default {
  name: "AddDocBtn",
  props: {
    fileInput: {
      type: Object,
      required: true, // Assurez-vous que la prop est fournie
    },
  },
  data() {
    return {
      selectedFiles: [], // Liste des fichiers sélectionnés
    };
  },
  methods: {
    // Gestion des fichiers nouvellement sélectionnés
    handleFileChange(event) {
      const newFiles = Array.from(event.target.files);
      console.log("Fichiers sélectionnés :", newFiles);
      // Ajoute uniquement les fichiers non déjà sélectionnés
      newFiles.forEach((newFile) => {
        if (
            !this.selectedFiles.some(
                (file) =>
                    file.name === newFile.name && file.size === newFile.size
            )
        ) {
          this.selectedFiles.push(newFile);
        }
      });

      this.updateFileList(newFiles);
    },

    // Supprime un fichier de la liste selon son index
    removeFile(index) {
      this.selectedFiles.splice(index, 1);
      this.updateFileList();
    },

    // Mise à jour de l'affichage de la liste des fichiers
    updateFileList(newFiles) {
      console.log("Liste des fichiers mise à jour :", newFiles);
      console.log("Liste des fichiers mise à jour :", this.selectedFiles);
    },

    // Déterminer l'icône en fonction du type de fichier
    getFileIcon(fileType) {
      if (fileType.includes("image")) {
        return `<svg class="icon icon-image" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2 2h20v20H2zm2 18h13.586L9 11.414l-5 5zm16-.414V4H4v9.586l5-5zM15.547 7a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-3 1a3 3 0 1 1 6 0a3 3 0 0 1-6 0"/></svg>`;
      } else if (fileType.includes("pdf")) {
        return `<svg class="icon icon-pdf" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 15 15"><path fill="currentColor" d="M2.5 6.5V6H2v.5zm4 0V6H6v.5zm0 4H6v.5h.5zm7-7h.5v-.207l-.146-.147zm-3-3l.354-.354L10.707 0H10.5zM2.5 7h1V6h-1zm.5 4V8.5H2V11zm0-2.5v-2H2v2zm.5-.5h-1v1h1zm.5-.5a.5.5 0 0 1-.5.5v1A1.5 1.5 0 0 0 5 7.5zM3.5 7a.5.5 0 0 1 .5.5h1A1.5 1.5 0 0 0 3.5 6zM6 6.5v4h1v-4zm.5 4.5h1v-1h-1zM9 9.5v-2H8v2zM7.5 6h-1v1h1zM9 7.5A1.5 1.5 0 0 0 7.5 6v1a.5.5 0 0 1 .5.5zM7.5 11A1.5 1.5 0 0 0 9 9.5H8a.5.5 0 0 1-.5.5zM10 6v5h1V6zm.5 1H13V6h-2.5zm0 2H12V8h-1.5zM2 5V1.5H1V5zm11-1.5V5h1V3.5zM2.5 1h8V0h-8zm7.646-.146l3 3l.708-.708l-3-3zM2 1.5a.5.5 0 0 1 .5-.5V0A1.5 1.5 0 0 0 1 1.5zM1 12v1.5h1V12zm1.5 3h10v-1h-10zM14 13.5V12h-1v1.5zM12.5 15a1.5 1.5 0 0 0 1.5-1.5h-1a.5.5 0 0 1-.5.5zM1 13.5A1.5 1.5 0 0 0 2.5 15v-1a.5.5 0 0 1-.5-.5z"/></svg>`;
      }
      return `<svg class="icon icon-document" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="currentColor" d="M15 4H6v16h12V7h-3zM6 2h10l4 4v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2m2 9h8v2H8zm0 4h8v2H8z"/></svg>`;
    },
  },
};
</script>
<style scoped>
.add-doc-btn-container {
    width: 100%;
}
</style>