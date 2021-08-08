<template>
    <button @click.prevent="$emit('clicked')" :class="mode">
        <slot></slot>
    </button>
</template>

<script>

export default {
    props: ['mode'],
    emits:['clicked'],
}
</script>


<style scoped>
button {
    padding: 0.55rem 1.5rem;
    font-family: inherit;
    background-color: #387780;
    border: 1px solid #387780;
    color: white;
    cursor: pointer;
    border-radius: 6px;
}

button:hover,
button:active {
    background-color: #FBD51b;
    border-color: #FBD51b;
}

.flat {
    background-color: transparent;
    color: #FBD51b;
    border: none;
}

.flat:hover,
.flat:active {
    background-color: #FBD51b;
}
@media (max-width: 800px)  {
    button {
        padding: 0.2rem 0.5rem;
        font-family: inherit;
        background-color: #387780;
        border: 1px solid #387780;
        color: white;
        cursor: pointer;
        border-radius: 6px;
        font-size: smaller;
    }


}
</style>
