<template>
  <v-app dark>
    <v-app-bar app></v-app-bar>

    <v-main>
      <v-container class="px-10">
        <v-row class="justify-space-between">
          <h2 class="px-3">Комментариии</h2>
          <v-btn-toggle
            mandatory
            v-model="sort"
            color="grey darken-5"
            group
            dark
          >
            <v-btn class="ma-2 btn--capitalize">Популярные</v-btn>
            <v-btn class="ma-2 btn--capitalize">Новые</v-btn>
            <v-btn class="ma-2 btn--capitalize">Старые</v-btn>
          </v-btn-toggle>
          <v-spacer></v-spacer>
          <v-btn class="ma-2 btn--capitalize" text>
            <v-icon left> mdi-information-outline </v-icon>Правила</v-btn
          >
        </v-row>
        <v-row>
          <v-container fluid>
            <v-form>
              <v-row>
                <v-col cols="12" md="12">
                  <v-textarea
                    label="Написать комментарий"
                    auto-grow
                    outlined
                    rows="1"
                    row-height="15"
                    v-model="commentText"
                  ></v-textarea>
                </v-col>
              </v-row>
              <v-btn
                text
                class="btn--capitalize"
                :disabled="!isValidMessage(commentText)"
                @click="submit({ text: commentText, postId: 1 })"
              >
                Отправить
              </v-btn>
              <v-btn text class="btn--capitalize" @click="clearComment">
                Очистить
              </v-btn>
            </v-form>
          </v-container>
        </v-row>
        <CommentsTree :comments="allComments" />
      </v-container>
    </v-main>
    <v-footer>
    </v-footer>
  </v-app>
</template>

<script>
import CommentsTree from "./views/CommentsTree.vue";
import axios from "axios";
import { mapActions, mapState, mapMutations, mapGetters } from "vuex";
export default {
  components: {
    CommentsTree,
  },
  data: () => ({
    sort: "1",
    commentText: "",
  }),
  computed: {
    ...mapState(["comments"]),
    ...mapGetters(["allComments", "getPostId", "getSortBy", "getSortDir"]),
  },
  watch: {
    sort(newValue, oldValue) {
      switch (newValue) {
        case 0:
          this.setSortBy("rating");
          this.setSortDir("desc");
          break;
        case 1:
          this.setSortBy("created_at");
          this.setSortDir("desc");
          break;
        case 2:
          this.setSortBy("created_at");
          this.setSortDir("asc");
          break;
      }
      this.getAllComments({ postId: 1 });
    },
  },
  mounted() {
    this.getAllComments({ postId: 1 });
    this.setPost({ postId: 1 });
  },
  methods: {
    ...mapMutations(["setPost", "setSortBy", "setSortDir"]),
    ...mapActions(["getAllComments", "sendComment"]),
    clearComment() {
      this.commentText = "";
    },
    submit(data) {
      this.sendComment({ data });
      this.commentText = "";
    },
    isValidMessage(text){
      return Boolean(text.trim());
    }
  },
};
</script>

