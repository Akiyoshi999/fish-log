<template> </template>

<script>
export default {
    props: {
        commentUser: {
            type: String,
            default: ""
        },
        comment: {
            type: String,
            default: ""
        },
        authorized: {
            type: Boolean
        },
        updateEndpoint: {
            type: String
        },
        deleteEndpoint: {
            type: String
        },
        url: {
            type: String
        }
    },
    data() {
        return {
            isCommentUser: this.commentUser,
            isComment: this.comment,
            isEditFlag: false,
            isUrl: this.url
        };
    },
    methods: {
        clickUpdate() {
            return this.update();
        },
        clickDelete() {
            return this.delete();
        },
        async update() {
            const response = await axios.put(this.updateEndpoint, {
                content: this.isComment
            });
            this.isComment = response.data.comment;
        },
        async delete() {
            const response = await axios.delete(this.deleteEndpoint);
            this.goToArticle();
        },
        clickEditflag() {
            this.isEditFlag = true;
        },
        clickEditCancel() {
            this.isEditFlag = false;
        },
        goToArticle() {
            window.location.href = this.isUrl;
        }
    }
};
</script>
