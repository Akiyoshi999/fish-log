<template>
    <div>
        <button type="button" class="btn m-0 p-1 shadow-none">
            <i
                class="fas fa-heart mr-1 fa-lg"
                :class="{
                    'red-text': this.isLikedBy,
                    'animated heartBeat fast': this.goToLike
                }"
                @click="clickLike"
            />
        </button>
        {{ countLikes }} いいね!
        <button type="button" class="btn m-0 p-1 shadow-none">
            <i
                class="fas fa-star mr-1 fa-lg"
                :class="{
                    'orange-text': this.isFavoritedBy,
                    'animated rotateIn fast': this.goToFavorite
                }"
                @click="clickFavorite"
            />
        </button>
        <a v-if="isFavoritedBy">お気に入り済み</a>
        <a v-else>お気に入り登録</a>
    </div>
</template>

<script>
export default {
    props: {
        initialIsLikedBy: {
            type: Boolean,
            default: false
        },
        initialIsFavoritedBy: {
            type: Boolean,
            default: false
        },
        initialCountLikes: {
            type: Number,
            default: 0
        },
        authorized: {
            type: Boolean
        },
        likeEndpoint: {
            type: String
        },
        favoriteEndpoint: {
            type: String
        }
    },
    data() {
        return {
            isLikedBy: this.initialIsLikedBy,
            isFavoritedBy: this.initialIsFavoritedBy,
            countLikes: this.initialCountLikes,
            goToLike: false,
            goToFavorite: false
        };
    },
    methods: {
        clickLike() {
            if (!this.authorized) {
                alert("いいね機能はログイン中のみ有効です");
                return;
            }
            return this.isLikedBy ? this.unlike() : this.like();
        },
        clickFavorite() {
            if (!this.authorized) {
                alert("お気に入り機能はログイン中のみ有効です");
                return;
            }
            return this.isFavoritedBy ? this.unfavorite() : this.favorite();
        },
        async like() {
            const response = await axios.put(this.likeEndpoint);
            this.isLikedBy = true;
            this.countLikes = response.data.countLikes;
            this.goToLike = true;
        },
        async unlike() {
            const response = await axios.delete(this.likeEndpoint);
            this.isLikedBy = false;
            this.countLikes = response.data.countLikes;
            this.goToLike = false;
        },
        async favorite() {
            const response = await axios.put(this.favoriteEndpoint);
            this.isFavoritedBy = true;
            this.goToFavorite = true;
        },
        async unfavorite() {
            const response = await axios.delete(this.favoriteEndpoint);
            this.isFavoritedBy = false;
            this.goToFavorite = false;
        }
    }
};
</script>
