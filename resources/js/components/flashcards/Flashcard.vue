<template>
    <div class="main-div-flash-card-create">
        <base-table-box class="base-table-box-flashcard"><
            <div slot="header">
                <h2>Flash Card with Images</h2>
            </div>
            <div slot="body">
                <div class="create-flashcard-form">


                    <form :action="formRoute" method="POST" enctype="multipart/form-data" ref="createFlashcard" @submit.prevent="formSubmit">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="container w-full" >
                            <base-card>

                                <div class="form-group">
                                    <input type="hidden" name="subject" :value="subject">
                                    <label for="exercise">Exercise Name</label>
                                    <input  id="exercise" type="text" name="exercise" placeholder="Write here" class="form-control" ref="exerciseInput" v-model="exercise" @input="$emit('update:exercise', $event.target.value)" required/>
                                    <label for="description">Description</label>
                                    <input id="description" placeholder="A brief description" type="text" name="description" ref="descriptionInput" class="form-control" v-model="description" @input="$emit('update:description', $event.target.value)" required>
                                </div >
                                <card
                                    :image="card.image"
                                    :answer="card.answer"
                                    :is-last="card.isLast"
                                    :key-index="key"
                                    v-for="(card, key) in cards" :key="key"
                                    @delete-card="deleteCard"
                                >


                                    <div class="card-create-container" slot="card">
                                        <label >Card {{key+1}}</label>
                                        <input type="text"  placeholder="Correct Answer" :name="'answer[' + key +']'" class="form-control answerInput" v-model="card.answer" @input="$emit('update:card.answer', $event.target.value) " required>
                                        <label >Choose Image</label>
                                        <input class="btn btn-outline-primary " accept="image/*"  type="file" :name="'image[' + key +']'" @input="$emit('update:card.image', $event.target.value)" required>
                                        <br/>
                                        <button type="button" v-if="!(cards.length===12)" class="btn btn-success buttonGreen"  @click.prevent="addCard()">Add another Option </button>
                                        <button id="cfRemoveCard" v-if="!(cards.length===1)" type="button" class="btn btn-success buttonOrange" @click.prevent="deleteCard(key)">Remove Option </button>
                                    </div>

                                </card>


                            </base-card>
                        </div>
                        <div class="create-flashcard-form-button">
                            <button type="submit" class="btn btn-success buttonGreen buttonGreenLight flashcardSubmit">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </base-table-box>
    </div>
</template>

<script>

let cardCount=1;

import BaseCard from "../UI/BaseCard.vue";
import Card from "./Card";
export default {
    name: 'Flashcard.vue',
    components: {
        'card': Card,
        BaseCard
    },
    props:{
        formRoute : {
            type : String,
            required : true
        },
        iniSubject : {
            type : String,
            required : true
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            exercise : '',
            description : '',
            cards: [{
                answer: '',
                image: '',
                isLast:true,
                keyIndex:0,
            }],
            subject : this.iniSubject
        }
    },
    created(){

    },
    methods: {
        formSubmit: function () {
            let self = this;
            let subject = parseInt(this.subject);
            let payload = [this.cards,this.exercise,this.description,subject];
            this.$refs.createFlashcard.submit();
        },
        addCard: function () {

            this.cards.push({
                answer: '',
                image: '',
                isLast: this.cards.length===1,
                keyIndex:this.keyIndex
            });
            cardCount++;
        },
        deleteCard(cardId) {
            this.cards.splice(cardId, 1)

        },

    }
}
</script>

<style scoped>

*{
    padding-left: 10px;
    text-align:center !important;
}
.main-div-flash-card-create{
    display: flex;
    justify-content: center;
}

h2{
    color: #FBD51B;
}

h3{
    font-weight: bold !important;
    margin-bottom: 5px;
}
input{
    margin-bottom:10px !important;
    max-width:100%;
}
label{
    background-color: var(--ouryellow) ;
    text-align: justify;
    border: hidden;
    border-radius: 15px;
    padding:5px 10px 5px 10px;
}
form{
    justify-items: center;
    max-width:100%;
    align-content: center;
}
.card-create-container button{
    margin: 7px;

}

.base-table-box-flashcard{
    width: 80%;
}

.answerInput{
    max-width: 100%;

}
.card-create-container{
    max-width:100%;
    border: 1px hidden rgba(0, 0, 0, 0.3) ;
    border-radius: 15px;
    box-shadow: -1px -1px 10px 1px #D3D3D3;
    padding: 10px;
    max-height: 100%;
    text-align: center;
    margin:10px;
}
.flashcardSubmit{
    padding-left: 20px !important;
    padding-right: 20px !important;
    margin-bottom: 40px !important;
    margin-top: 10px !important;
}

.create-flashcard-form-button{
    width: 100%;
    display: flex;
    justify-content: center;

}
.create-flashcard-form{
    display: flex;
    justify-content: center;
    padding-top: 30px;
}
</style>



