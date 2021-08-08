<template>
        <div>
            <slot name="card"></slot>
        </div>



</template>

<script>

    import BaseCard from "../UI/BaseCard.vue";
    export default {
        components: {BaseCard},
        props:{
        keyIndex:{
        type:Number,
        required:true
      },
      answer:{
          type: String,
          required: true
      },
      image:{
          type:String,
          required: true
      },
      isLast:{
          type:Boolean,
          required: true
      }
    },
    created(){

    },
    methods: {



    }
    }
</script>

<style scoped>

input{
    margin-bottom:10px;
}
.form-group{
    margin-top: 10px;
}
</style>
