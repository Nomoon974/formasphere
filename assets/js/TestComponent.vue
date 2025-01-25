<template>
  <div>
    <p v-if="post.user">
      Post créé par : {{ post.user.fullName }}
    </p>
    <p v-else>
      Auteur inconnu
    </p>
  </div>
</template>

<script>
export default {
  name: "TestComponent",
};
</script>