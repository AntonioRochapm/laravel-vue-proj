<template>
    <base-dialog v-if="invalidInput" title="Incorrect Answer" @close="confirmError">
        <template #default>
            <p>Please check your answers.</p>
            <p>Something is in the wrong box.</p>
        </template>
        <template #actions>
            <button @click="confirmError">Okay</button>
        </template>
    </base-dialog>
    <base-dialog v-else-if="correctInput" title="Congratulations!!">
        <template #default>
            <p>You did it!</p>
            <p>Choose what to do next.</p>
        </template>
        <template #actions>
            <base-button @clicked="newExercise" style="margin-right: 10px;">Next Challenge</base-button>
            <base-button @clicked="redirectMenu">Menu</base-button>
        </template>
    </base-dialog>
</template>

<script>
    import BaseButton from "../../UI/BaseButton";
    export default {
        components: {BaseButton},
        props:{
            invalidInput:{
                type: Boolean,
                required: true
            },
            correctInput:{
                type: Boolean,
                required: true
            }
        },
        methods:{
            //Alert Dialog funcs
            confirmError: function(){
                let invalid = false;
                let correct = false;
                this.$emit('reset-alert',invalid,correct);
            },
            redirectMenu: function(){
                this.$emit('redirect-menu');
            },
            newExercise: function (){
                this.$emit('new-exercise');
            }
        }
    }
</script>
