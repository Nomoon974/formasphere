<template>
  <div class="edit-post-button">
    <button type="button" @click="toggleEdit" class="edit-btn">
      <span v-html="editIcon"></span>
    </button>
  </div>
</template>

<script>
export default {
  name: "EditPostButton",
  props: {
    editIcon: {
      type: String,
      default: '',
    },
  },
  methods: {
    toggleEdit() {
      this.$emit("edit-toggled"); // Émet un événement pour informer le parent
    },
  },
};
</script>

<style scoped>
.edit-btn {
  background: none;
  border: none;
  cursor: pointer;
}

.edit-btn * {
  width: 24px;
  height: 24px;
  color: #0056b3;
}
</style>
