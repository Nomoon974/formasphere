<script>
export default {
  props: {
    postId: {
      type: [String, Number],
      required: true,
    },
    deleteActionUrl: {
      type: String,
      required: true,
    },
    token: {
      type: String,
      required: true,
    },
    deleteIcon: {
      type: String,
      default: `
      <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 15 15" font-weight="bold">
        <path fill="#CD5C5C" fill-rule="evenodd" d="M.877 7.5a6.623 6.623 0 1 1 13.246 0a6.623 6.623 0 0 1-13.246 0M7.5 1.827a5.673 5.673 0 1 0 0 11.346a5.673 5.673 0 0 0 0-11.346m2.354 3.32a.5.5 0 0 1 0 .707L8.207 7.5l1.647 1.646a.5.5 0 0 1-.708.708L7.5 8.207L5.854 9.854a.5.5 0 0 1-.708-.708L6.793 7.5L5.146 5.854a.5.5 0 0 1 .708-.708L7.5 6.793l1.646-1.647a.5.5 0 0 1 .708 0" clip-rule="evenodd"/>
      </svg>
    `,
    },
  },
  methods: {
    confirmAndDelete(postId) {

      if (window.confirm("Voulez-vous vraiment supprimer ce post ?")) {
        const form = document.getElementById(`delete-form-${postId}`);
        if (form) {
          console.log(this.token);
          form.submit();
          console.log(this.token);
        }
      }
    },

  },
};
</script>

<template>
  <div>
    <form
        :id="'delete-form-' + postId"
        :action="deleteActionUrl"
        method="POST"
        style="display: none;"
    >
      <input type="hidden" name="_token" :value="token" />
    </form>
    <button
        class="delete-btn"
        style="background: none; border: none;"
        type="button"
        @click="confirmAndDelete(postId)"
    >
      <span v-html="deleteIcon"></span>
    </button>
  </div>
</template>

<style scoped>
/* Ajoutez des styles spécifiques ici */
</style>
