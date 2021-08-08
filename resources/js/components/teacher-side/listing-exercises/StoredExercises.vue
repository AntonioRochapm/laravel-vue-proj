<template>
    <li>
        <base-card>
            <header>
                <h3> Name: {{ title }}</h3>
            </header>
            <p>Description: {{ description }}</p>
            <p>Subject: {{ subject }}</p>
            <p>Type: {{ type.name }}</p>
            <base-button @clicked="$emit('delete',id,type.slug)">Delete</base-button>
<!--            <base-button mode="active" @click="deleteResource(id)">Update</base-button>-->
        </base-card>
    </li>
</template>

<script>
import BaseCard from "../../UI/BaseCard.vue";

export default {
    name:"stored-exercises",
    props:[
        'id',
        'title',
        'description',
        'subject',
        'type',
    ],
    components:{
        BaseCard,
    },
    emits:['delete'],
}
</script>

<style scoped>

li {
    margin: auto;
    max-width: 40rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
    cursor: pointer;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

h3 {
    font-size: 0.9rem;
    margin: 0.5rem 0;
}

p {
    margin: 0.5rem 0;
}

</style>
