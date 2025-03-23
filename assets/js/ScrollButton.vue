<template>
  <button class="scroll-button" @click="handleClick">
    <!-- Si on est proche du haut, on affiche l’icône "descendre" -->
    <svg
        v-if="isNearTop"
        xmlns="http://www.w3.org/2000/svg"
        width="1em"
        height="1em"
        viewBox="0 0 48 48"
    >
      <path
          fill="black"
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="4"
          d="M36 18L24 30L12 18"
      />
    </svg>

    <!-- Sinon, on est plutôt proche du bas, on affiche l’icône "monter" -->
    <svg
        v-else
        xmlns="http://www.w3.org/2000/svg"
        width="1em"
        height="1em"
        viewBox="0 0 48 48"
    >
      <path
          fill="black"
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="4"
          d="m13 30l12-12l12 12"
      />
    </svg>
  </button>
</template>

<script>
export default {
  name: 'ScrollButton',
  data() {
    return {
      isNearTop: true
    };
  },
  mounted() {
    window.addEventListener('scroll', this.onScroll);
    this.onScroll(); // Position initiale
    console.log("le bouton apparait")
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.onScroll);
  },
  methods: {
    onScroll() {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const windowHeight = window.innerHeight;
      const pageHeight = document.documentElement.scrollHeight;

      // Seuils ajustables
      const topThreshold = 200;     // "Proche du haut" si en dessous de 200px
      const bottomThreshold = 200;  // "Proche du bas" si à 200px de la fin de page

      // Vérifie si on est proche du haut
      if (scrollTop < topThreshold) {
        this.isNearTop = true;
        return;
      }

      // Vérifie si on est proche du bas
      if (windowHeight + scrollTop >= pageHeight - bottomThreshold) {
        this.isNearTop = false;
        return;
      }

      // Si ni haut ni bas, on ne change pas l'état (ou vous pouvez gérer d'autres cas)
    },
    handleClick() {
      if (this.isNearTop) {
        // Descendre en bas de la page
        window.scrollTo({
          top: document.documentElement.scrollHeight,
          behavior: 'smooth'
        });
      } else {
        // Remonter en haut de la page
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }
    }
  }
};
</script>

<style scoped>
.scroll-button {
  position: fixed;
  bottom: 50px;
  right: 50px;
  /* Style minimal, personnalisez à volonté */
  padding: 10px;
  background-color: #3498db;
  color: #fff;
  font-size: 20px; /* pour mieux voir l'icône svg */
  border: none;
  border-radius: 50%;
  cursor: pointer;
}


</style>
