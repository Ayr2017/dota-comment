<template>
  <v-list three-line>
    <template>
      <!-- <v-subheader v-text="commentTree.header"></v-subheader> -->

      <!-- <v-divider :inset="true"></v-divider> -->

      <v-list-item class="pr-5">
        <v-list-item-avatar>
          <v-img
            :src="commentTree.avatar ? commentTree.avatar : avatarAnonymous"
          ></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title
            class="text-opacity--half row justify-space-between px-2"
          >
            <div class="left">
              <span class="comment-header__element font-weight-medium">{{
                commentTree.user.name ? commentTree.user.name : "Anon"
              }}</span>
              <span class="">
                <v-icon small class="text-opacity--half mb-1"
                  >mdi-clock-outline
                </v-icon>
                {{ transformDate(commentTree.created_at) }}</span
              >
              <span
                class="comment-header__element font-weight-thin"
                @click="openCommentField"
                v-if="commentTree.depth<5"
              >
                <v-btn text class="btn--lower" style="font-size: 16px"
                  ><v-icon small class="mb-n1">mdi-keyboard-return </v-icon>

                  ответить</v-btn
                ></span
              >
              <span class="comment-header__element font-weight-regular">
                <v-btn icon>
                  <v-icon small>mdi-share-variant</v-icon>
                </v-btn></span
              >
              <span class="comment-header__element font-weight-regular">
                <v-btn icon>
                  <v-icon small>mdi-block-helper</v-icon>
                </v-btn></span
              >
            </div>
            <div class="rating">
              <span class="comment-header__element font-weight-regular">
                <v-btn icon @click="likeComment({tableId:commentTree.table_id, commentId:commentTree.id})">
                  <v-icon color="light-green accent-3"
                    >mdi-thumb-up-outline</v-icon
                  ></v-btn
                ></span
              >
              <span class="comment-header__element font-weight-regular">
                <v-btn icon @click="dislikeComment({tableId:commentTree.table_id, commentId:commentTree.id})">
                  <v-icon color="red darken-1">mdi-thumb-down-outline</v-icon>
                </v-btn></span
              >
              <span
                class="comment-header__element font-weight-regular rating__text-wrapper"
                ><span :style="getColor(commentTree.rating)">{{
                  commentTree.rating
                }}</span></span
              >
            </div>
          </v-list-item-title>
          <v-list-item-subtitle
            v-html="commentTree.text"
          ></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </template>
    <template>
      <div class="ml-10 subcomment">
        <v-form  v-if="commentField">
          <v-container>
            <v-row>
              <v-col cols="12" md="12">
                <v-textarea
                  label="Напишите комментарий"
                  auto-grow
                  outlined
                  rows="1"
                  row-height="15"
                  v-model="commentText"
                ></v-textarea>
              </v-col>
            </v-row>
            <v-btn text class="mr-4" :disabled="!isValidMessage(commentText)" @click="submit({text:commentText,parentTableId:commentTree.table_id, parentCommentId:commentTree.id } )"> Отправить </v-btn>
            <v-btn text @click="closeCommentField"> Отменить </v-btn>
          </v-container>
        </v-form>
        <div class="prop pl-7">
          <Comment
            v-for="(comment, index) in commentTree.comments"
            :key="index"
            :commentTree="comment"
          />
        </div>
      </div>
    </template>
  </v-list>
</template>

<script>
import getTimeDiff from '../../utilites/timedifferent';
import {mapState, mapMutations,mapActions,mapGetters} from 'vuex';
export default {
  name: "Comment",
  props: ["commentTree", "comments"],
  data: () => ({
    avatarAnonymous: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
    commentField: false,
    ratingText: 0,
    commentText: "",
  }),
  mounted() {
  },
  methods: {
    ...mapActions(["likeComment","dislikeComment","sendComment"]),
    openCommentField() {
      this.commentField = true;
    },
    closeCommentField() {
      this.commentField = false;
    },
    submit(data) {
      this.sendComment({data})
      this.commentField = false;
      this.commentText ='';
    },
    transformDate(date) {
      return getTimeDiff(date,new Date());
    },
    getColor(value){
        if (value == 0) return null;
        else if (value > 0) return 'color:green'
        else return 'color:red'
    },
    isValidMessage(text){
      return Boolean(text.trim());
    },
  },
};
</script>

