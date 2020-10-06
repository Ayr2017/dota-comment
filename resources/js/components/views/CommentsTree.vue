<template>
  <v-app>
    <Comment
      v-for="(comment, index) in comments"
      :key="index"
      :commentTree="comment"
    />
  </v-app>
</template>

<script>
import Comment from "./Comment.vue";
export default {
  components: {
    Comment,
  },
  props: ["comments"],
};
</script>