<template>
    <div class="bg-light p-2">
        <div class="d-flex flex-row align-items-start">
            <i :class="userIcon"></i>
            <h5 class="pl-1">{{ isCommentUser }}</h5>
            <div class="ml-auto card-text">
                <!-- Drop Down -->
                <div v-if="authorized" class="dropdown">
                    <a
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button
                            type="button"
                            class="dropdown-item"
                            @click="clickEditflag"
                        >
                            <i class="fas fa-pen mr-1"></i>コメントを更新する
                        </button>
                        <div class="dropdown-divider"></div>
                        <form method="DELETE" action="this.deleteEndpoint">
                            <button
                                type="button"
                                class="dropdown-item text-danger"
                                @click="clickDelete"
                            >
                                <i
                                    class="fas fa-trash-alt mr-1"
                                    type="submit"
                                    @click="clickDelete"
                                ></i
                                >コメントを削除する
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Drop Down -->
            </div>
        </div>
        <form>
            <div class="pl-2 pt-2">
                <!-- <div class="form-control ml-1 shadow-none textarea"> -->
                <input
                    name="comment"
                    class="form-control ml-1 shadow-none textarea"
                    :class="{
                        'bg-white': !this.isEditFlag
                    }"
                    v-model="isComment"
                    :readonly="!isEditFlag"
                />
                <div v-if="isEditFlag" class="mt-2 text-right">
                    <button
                        class="btn btn-primary btn-sm shadow-none"
                        type="submit"
                        @click="clickUpdate"
                    >
                        Post comment
                    </button>
                    <button
                        class="btn btn-outline-primary btn-sm ml-1 shadow-none"
                        type="button"
                        @click="clickEditCancel"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

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
        },
        userIcon: {
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
