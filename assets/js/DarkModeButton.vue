<script>
export default {
  name: "DarkModeButton",
  data() {
    return {
      isDarkMode: false
    };
  },
  mounted() {
    this.isDarkMode = localStorage.getItem("darkMode") === "true";
  },
  methods: {
    toggleDarkMode() {
      console.log("Toggle Dark Mode");
      this.isDarkMode = !this.isDarkMode;
      localStorage.setItem("darkMode", this.isDarkMode);
      document.body.classList.toggle("dark");
    }
  }
};
</script>

<template>

  <div>
    <input type="checkbox" @change="toggleDarkMode" class="checkbox" id="checkbox">
    <label for="checkbox" class="checkbox-label">
      <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 36 36">
        <circle cx="18" cy="18" r="18" fill="#c2c2c2"/>
        <g fill="#5B6876">
          <circle cx="10.5" cy="8.5" r="3.5"/>
          <circle cx="20" cy="16" r="3"/>
          <circle cx="21.5" cy="27.5" r="3.5"/>
          <circle cx="21" cy="6" r="2"/>
          <circle cx="3" cy="18" r="1"/>
          <circle cx="6" cy="21" r="1"/>
          <circle cx="9" cy="24" r="1"/>
          <circle cx="12" cy="27" r="1"/>
          <circle cx="15" cy="30" r="1"/>
          <circle cx="18" cy="33" r="1"/>
          <circle cx="21" cy="36" r="1"/>
          <circle cx="24" cy="39" r="1"/>
          <circle cx="27" cy="42" r="1"/>
          <circle cx="30" cy="45" r="1"/>
        </g>
      </svg>

      <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 64 64">
        <path fill="#f39c12" d="M62.713 30.827L50.77 27.352a21.2 21.2 0 0 0-2.311-5.603q2.981-5.462 5.967-10.922c.544-.996-.541-2.086-1.539-1.538l-10.878 5.974a20.9 20.9 0 0 0-5.673-2.362c-1.183-4.03-2.365-8.06-3.548-12.1c-.313-1.071-1.853-1.075-2.168 0c-1.173 4.04-2.349 8.07-3.524 12.11a21.1 21.1 0 0 0-5.576 2.316c-3.666-2-7.333-4.01-10.999-6.01c-.994-.543-2.085.543-1.537 1.541l6.03 10.978a21 21 0 0 0-2.324 5.634L.805 30.854c-1.07.314-1.076 1.856 0 2.168l11.889 3.459a21.3 21.3 0 0 0 2.389 5.729q-2.967 5.426-5.932 10.854c-.546.996.539 2.087 1.537 1.54q5.42-2.978 10.841-5.953a21 21 0 0 0 5.636 2.332q1.74 5.945 3.483 11.883c.315 1.074 1.856 1.076 2.168 0q1.729-5.933 3.454-11.867a21.1 21.1 0 0 0 5.697-2.353l10.774 5.888a.95.95 0 0 0 .739.211c.272-.016.514-.141.702-.325c.208-.192.35-.451.367-.745a.96.96 0 0 0-.218-.743c-1.966-3.583-3.937-7.169-5.904-10.754a21.3 21.3 0 0 0 2.338-5.679c3.98-1.168 7.966-2.336 11.947-3.502c1.073-.314 1.077-1.857.002-2.17"/>
        <circle cx="31.553" cy="31.836" r="17.901" fill="#f9ec21"/>
      </svg>
      <span class="ball"></span>
    </label>
  </div>

</template>

<style scoped>

body {
  transition: background 0.2s linear;
}

body.dark {
  background-color: #292c35 !important;
}

/* #9b59b6 */

body.dark h1, body.dark .support a {
  color: #fff;
}

.checkbox {
  opacity: 1;
  position: absolute;
}

.checkbox-label {
  background-color: var(--cadetblue);
  width: 50px;
  height: 26px;
  border-radius: 50px;
  position: relative;
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 0;
}

.checkbox-label svg {
  margin: 0;
}

.checkbox-label .ball {
  background-color: #fff;
  width: 22px;
  height: 22px;
  position: absolute;
  left: 2px;
  top: 2px;
  border-radius: 50%;
  transition: transform 0.2s linear;
  margin: 0;
  outline: #777777;
}

.checkbox:checked + .checkbox-label .ball {
  transform: translateX(24px);
}

</style>