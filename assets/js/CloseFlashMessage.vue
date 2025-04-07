<template>
  <button class="close-bttn" @click="closeParent" aria-label="Fermer ce message">
    &times;
  </button>
</template>

<script>
export default {
  name: "CloseFlashMessage",
  methods: {
    closeParent() {
      const parent = this.$el.closest('.flash-message');
      if (parent) {
        // Ajoute une classe d’animation
        parent.classList.add('fade-out');

        // Attends la fin de l’animation avant de le retirer
        setTimeout(() => {
          // Vérifie que l’élément est encore dans le DOM
          if (document.body.contains(parent)) {
            parent.remove();
          }
        }, 500); // doit correspondre à la durée du CSS
      }
    }
  }
}
</script>

<style scoped>

.fade-out {
  opacity: 0;
  transition: opacity 0.5s ease;
  display: none;
}
</style>
