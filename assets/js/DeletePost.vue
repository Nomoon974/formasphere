<script>
  export default {
    props: {
      postId: {
        type: [String, Number],
      },
      deleteActionUrl: {
        type: String,
      },
      token: {
        type: [String, Number],
      },
      imageUrl: {
        type: String,
      },
    },
    data() {
      return {
        // Define your component data here
      };
    },
    methods: {
      confirmAndDelete(postId) {
        if (window.confirm('Voulez-vous vraiment supprimer ce post ?')) {
          const form = document.getElementById(`delete-form-${postId}`);
          if (form) form.submit();
        }
      },
    },
    mounted() {

    },
  };
</script>


<template>

  <form :id="'delete-form-' + postId"
        :action="deleteActionUrl"
        method="POST"
        style="display:none;">
    <input type="hidden" name="_token" :value="token">
  </form>
  <button class="delete-btn" style="background: none; border: none;" type="button" @click="confirmAndDelete(postId)"><img :src="imageUrl" alt="Bouton supprimer"></button>
</template>

<style scoped>

</style>