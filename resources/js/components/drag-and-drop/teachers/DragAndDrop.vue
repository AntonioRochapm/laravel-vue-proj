<template>
    <div class="container w-full">
        <base-table-box>
            <div slot="header">
                <h2>Drag and Drop</h2>
            </div>
            <div slot="body">
                <div class="form-input-area">
                    <label class="sr-only" for="inline-form-input-name">Title</label>
                    <b-form-input
                        id="inline-form-input-name"
                        v-model="title"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Title"
                    ></b-form-input>
                    <div v-if="errorTitle.length">
                        <p style="color:red;">{{ errorTitle }}</p>
                    </div>
                    <label class="sr-only" for="inline-form-input-description">Description</label>
                    <b-form-input
                        id="inline-form-input-description"
                        v-model="description"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Description"
                    ></b-form-input>
                    <div v-if="errorDescription.length">
                        <p style="color:red;">{{ errorDescription }}</p>
                    </div>
                </div>
            </div>
        </base-table-box>
        <section class="card-grid">
            <div v-for="(card, key) in cards" :key="key" >
                <base-card>
                    <card-body
                        :subject="card.subject"
                        :key-index="key"
                        :is-last-card="card.isLastCard"
                    >
                        <div slot="header">
                            <label>Subject</label>
                            <select class="form-control" v-model="card.subject">
                                <option value="" selected>Choose an option</option>
                                <option v-for="(subjectItem, kSubject) in subjectList" :value="subjectItem.id" :key="kSubject">{{ subjectItem.name }}</option>
                            </select>
                            <div v-if="errorSubject.length">
                                <p style="color:red;">{{ errorSubject }}</p>
                            </div>
                            <base-button type="button" @clicked="addCard()">Add card</base-button>
                            <base-button v-if="!(cards.length === 2)" type="button" @clicked="removeCard(key)" mode="danger">Remove card</base-button>
                        </div>
                        <div slot="body" v-for="(option,k) in card.options" :key="k">
                            <card-option
                                :option-field="option.optionField"
                                :is-last="card.options.length === 1"
                            >
                                <label>Option</label>
                                <input type="text" v-model="option.optionField" @input="$emit('update:optionField', $event.target.value)"/>
                                <base-button v-if="!(card.options.length === 1)" type="button" mode="danger" @clicked="deleteOption(key,k)">Delete Option</base-button>
                            </card-option>
                            <div v-if="errorOption.length">
                                <p style="color:red;">{{ errorOption }}</p>
                            </div>
                        </div>
                        <div slot="add-option">
                            <base-button type="button" @clicked="addOption(card)">Add another Option</base-button>
                        </div>
                    </card-body>
                </base-card>
            </div>
        </section>
        <div class="mt">
            <base-button @clicked="formSubmit" class="btn btn-success">Create</base-button>
        </div>
    </div>

</template>

<script>
import BaseCard from "../../UI/BaseCard";
import ApiComms from "../../../comms";

export default {
    components: {BaseCard},
    props:{
        iniSubject: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            description: null,
            title: null,
            cards: [{
                subject: '',
                options: [{
                    optionField: ''
                }
                ],
                keyIndex: this.keyIndex,
                isLastCard: true
            },
            {
                subject: '',
                options: [{
                    optionField: ''
                }
                ],
                keyIndex: this.keyIndex,
                isLastCard: true
            },
            ],
            subjectList: [],
            errorTitle: '',
            errorDescription: '',
            errorSubject: '',
            errorOption: ''
        }
    },
    async created() {
        let c = new ApiComms();
        let url = '/exercises/subject';
        this.subjectList = await c.getAllByUrl(url);
    },
    methods: {
        checkForm: function() {
            // if the field is empty
            let cards = this.cards;
            let card;
            let option;
            let flagSubject = true;
            let flagOption = true;

            for(card of cards)
            {
                for(option of card.options){
                    option.optionField === '' ? flagOption = false : flagOption;
                }
                if(card.subject === ''){
                    flagSubject = false;
                    break;
                }
            }

            if (this.description && this.title && flagSubject && flagOption) {
                return true;
            }
            this.errorTitle = [];
            this.erroDescription = [];
            this.errorSubject = [];
            // All is good
            if(!this.title){
                this.errorTitle = 'Title is required';
            }
            if(!this.description){
                this.errorDescription = 'Description is required';
            }
            if(!flagSubject){
                this.errorSubject = 'One Subject per Card is required';
            }
            if(!flagOption)
                this.errorOption = 'At least one Option per Card is required';
            return false;
        },
        formSubmit: async function () {
            try{
                if(this.checkForm()){
                    let a = new ApiComms();
                    let payload = [this.title,this.description,this.cards];
                    let url = '/exercises/drag-and-drop';
                    // Send a POST request
                    await a.saveAllByUrl(url,payload);
                    window.location = '/';
                }else
                {
                    throw 'Form validation error'
                }
            }catch (error){
                console.log(error);
            }

        },
        //Cards
        addCard: function () {
            this.cards.push({
                subject: '',
                options: ['',],
                keyIndex: this.keyIndex,
                isLastCard: this.cards.length === 1
            });
        },
        removeCard: function (data) {
            this.cards.splice(data, 1);
        },
        //Options
        addOption: function (card) {
            card.options.push({
                optionField: '',
                isLast: card.options.length === 1,
            });
        },
        deleteOption: function(key,k){
            this.cards[key].options.splice(k,1);
        },
    }
}
</script>

<style scoped>
h2{
    color: #FBD51b;
}
.form-input-area{
    margin: 20px;
}
section{
    margin-top: 1rem;
}
.card-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 1rem;
}
.mt{
    margin-top: 1rem;
}
</style>
