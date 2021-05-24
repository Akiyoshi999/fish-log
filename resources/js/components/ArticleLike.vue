<template>
    <div>
        <button type="button" class="btn m-0 p-1 shadow-none">
            <i
                class="fas fa-heart mr-1"
                :class="{ 'red-text': this.isLikedBy }"
            />
        </button>
        10 いいね!
        <button type="button" class="btn m-0 p-1 shadow-none">
            <i
                class="fas fa-star mr-1"
                :class="{ 'yellow-text': this.isFavoritedBy }"
            />
        </button>
        お気に入りに登録
    </div>
</template>

<script>
export default {
    props: {
        initiallsLikedBy: {
            type: Boolean,
            default: false
        },
        initiallsFavoritedBy: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isLikedBy: this.initiallsLikedBy,
            isFavoritedBy: this.initiallsFavoritedBy
        };
    }
};
</script>
