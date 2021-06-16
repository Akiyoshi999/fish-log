<template>
    <div>
        <input
            type="file"
            name="image"
            accept="image/png, image/jpeg"
            ref="preview"
            @change="uploadFile"
        />
        <div v-if="url">
            <img :src="url" />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: ""
        };
    },
    methods: {
        uploadFile() {
            const file = this.$refs.preview.files[0];
            this.url = URL.createObjectURL(file);
        }
    }
};
</script>
