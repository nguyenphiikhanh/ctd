<template>
    <div v-show="hidden" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <button class="btn btn-secondary">Loading more</button>
    </div>
</template>

<script>
export default {
    props: {
        loading: {type: Boolean, default: false},
        hidden: {type: Boolean, default: false}
    }
}
</script>

<style scoped>

</style>
