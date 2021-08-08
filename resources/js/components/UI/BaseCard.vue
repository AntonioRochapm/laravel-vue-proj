<template>
    <div id="card-div">
        <slot></slot>
    </div>
</template>

<style scoped>
#card-div{
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.26);
    padding: 1rem;
    max-width: 40rem;
}
</style>
