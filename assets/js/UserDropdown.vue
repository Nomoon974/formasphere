<template>
  <div class="navigation">
    <!-- Avatar cliquable -->
    <div class="user-menu" @click="toggleDropdown">
      <img class="profil-img"
           :src="userData.avatar.startsWith('/') ? userData.avatar : '/' + userData.avatar"
           alt="Profil Utilisateur"/>
    </div>

    <!-- Menu déroulant -->
    <ul v-if="isOpen"
        class="dropdown-menu"
        :style="{ display: isOpen ? 'block' : 'none' }"
        >
      <li>
        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
          <path fill="currentColor"
                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/>
        </svg>
        <a v-if="userData.profileLink"
           :href="userData.profileLink"
           aria-label="Voir votre profil">
          <span>
            Profil
          </span>
        </a>
      </li>
      <li>
        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z"/></svg>        <a v-if="userData.logoutLink"
           :href="userData.logoutLink"
           aria-label="Se déconnecter">
          <span class="logout-text">Se Déconnecter</span>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "UserDropdown",
  props: {
    userData: {type: Object, required: true},
  },
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {},
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
      // On attend que le DOM soit mis à jour par Vue
      this.$nextTick(() => {
        const dropdownMenu = this.$refs.dropdownMenu;
        if (this.isOpen && dropdownMenu) {
          dropdownMenu.classList.add('dropdownMenuVisible');

        }
      });
    },
    closeDropdown(event) {
      if (!this.$el.contains(event.target)) {
        this.isOpen = false;
      }
    }
  },
  mounted() {
    document.addEventListener("click", this.closeDropdown);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.closeDropdown);
  },
};
</script>

<style scoped>
/* Style de base du conteneur */
.navigation {
  position: relative;
  display: flex;
  align-items: center;
}

/* Avatar utilisateur */
.user-menu img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  transition: transform 0.2s ease-in-out;
  margin: 0;
}

/* Effet de zoom au survol */
.user-menu img:hover {
  transform: scale(1.1);
}

.dropdown-menu::before {
  content: "";
  position: absolute;
  top: -10px; /* place l'encoche au-dessus */
  right: 20px; /* ou left: 20px selon la position de ton bouton */
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 8px solid white; /* couleur identique au fond du menu */
  z-index: 1;
}

/* Menu déroulant caché par défaut */
.dropdown-menu {
  position: absolute;
  top: 60px;
  right: 0;
  width: max-content;
  background: white;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
  transform: translateY(-10px);
  transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
  list-style: none;
  padding: 0;
  z-index: 9999;
}

/* Style des liens du menu */
.dropdown-menu li {
  padding: 10px 15px;
  display: flex;
  align-items: start;
  justify-content: start;
  margin: 0 !important;
}

.dropdown-menu li:hover {
  background-color: var(--light-grey);
}

.dropdown-menu li a {
  text-decoration: none;
  color: #333;
  font-size: 14px;
  display: flex;
  align-items: center;
  width: 100%;
  margin: 0 !important;
}

/* Style spécifique pour la déconnexion */
.logout-text {
  color: indianred;
  font-weight: bold;
}

/* Couleur de l'icône de déconnexion */
.logout-icon svg {
  fill: indianred;
}
</style>
