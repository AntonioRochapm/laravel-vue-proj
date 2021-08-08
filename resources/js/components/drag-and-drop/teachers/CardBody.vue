<template>
    <div>
        <div class="">
            <div class="form-group">
                <slot name="header"></slot>
            </div>
            <slot name="body"></slot>
        </div>
        <div class="form-group">
            <slot name="add-option"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'card'
}
</script>

<style scoped>

</style>
