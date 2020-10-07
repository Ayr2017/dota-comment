import axios from "axios";
export default {
    state: {
        comments: {},
        post: {},
        sortBy:'rating',
        sortDir:'desc',
    },
    getters: {
        allComments(state) {
            return state.comments;
        },
        getPostId(state){
            return state.post.postId;
        },
        getSortBy(state){
            return state.sortBy
        },
        getSortDir(state){
            return state.sortDir
        },
    },
    actions: {
        getAllComments({ commit, state, getters }, ctx) {
            axios
                .get(`/comments?post_id=${ctx.postId}&sort_by=${getters.getSortBy}&sort_dir=${getters.getSortDir}`)
                .then((response) => {
                    commit('fillAllComments', response.data);
                })
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    console.log('Finally')
                });
        },
        likeComment({ commit, state, actions }, ctx) {
            axios
                .put(`/comments/like?table_id=${ctx.tableId}&comment_id=${ctx.commentId}&type=like`)
                .then((response) => {
                    if (response.data.updated == true) {                        
                        this.dispatch('getAllComments',{postId:1})
                    }
                })
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    console.log('Finally')
                });
        },
        dislikeComment({ commit, state }, ctx) {
            axios
                .put(`/comments/like?table_id=${ctx.tableId}&comment_id=${ctx.commentId}&type=dislike`)
                .then((response) => {
                    if (response.data.updated == true) {                        
                        this.dispatch('getAllComments',{postId:1})
                    }
                })
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    console.log('Finally')
                });
        },
        sendComment({ commit, state },ctx){
            axios
                .post(`/comments`,ctx.data)
                .then((response) => {                  
                    if (response.data.stored == true) {
                        this.dispatch('getAllComments',{postId:1});
                    }
                })
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    console.log('Finally post comment')
                });
        }

    },
    mutations: {
        fillAllComments(state, data) {
            state.comments = data;
        },
        setPost(state,data){
            state.post = data;
        },
        setSortBy(state, fieldName){
            state.sortBy = fieldName;
        },
        setSortDir(state, dirName){
            state.sortDir = dirName;
        },
    }
}