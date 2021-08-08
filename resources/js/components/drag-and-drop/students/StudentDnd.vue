<template>
    <section>
        <alert-message
            :invalidInput="invalidInput"
            :correctInput="correctInput"
            @reset-alert="resetAlert"
            @redirect-menu="redirectMenu"
            @new-exercise="newExercise"
        >
        </alert-message>
        <div class="container header-text">
            <h3>Drag and drop the backlog options to the correct rectangle</h3>
        </div>
        <div class="d-flex container mt-5 options-container">
            <div class="col-3">
                <div class="p-2 alert alert-secondary">
                    <h3>Backlog</h3>
                    <draggable
                        class="list-group kanban-column"
                        :list="arrBacklog"
                        group="options"
                    >
                        <div
                            class="list-group-item"
                            v-for="element in arrBacklog"
                            :key="element"
                        >
                            {{ element }}
                        </div>
                    </draggable>
                </div>
            </div>
            <div class="col-3" v-for="(element,key) in games" :key="key">
                <div class="p-2 alert alert-primary">
                    <h3>{{ element[0] }}</h3>
                    <draggable
                        class="list-group kanban-column"
                        :list="arrProgress(key)"
                        group="options"
                    >
                        <div
                            class="list-group-item"
                            v-for="(e, c) in arrProgress(key)"
                            :key="c"
                        >
                            {{ e }}
                        </div>
                    </draggable>
                </div>
            </div>
        </div>
        <div class="container">
            <base-button mode="success" @clicked="valAnswer">Submit</base-button>
        </div>
    </section>
</template>

<script>
import BaseCard from '../../UI/BaseCard.vue'
import draggable from 'vuedraggable'

export default {
    name: "student-dnd",
    components:{
        BaseCard,
        draggable,
    },
    props:{
        exercise:{
            type: Number,
            required: true
        }
    },
    data(){
        return {
            games: [],
            arrBacklog:[],
            arrProgress1: [],
            arrProgress2: [],
            arrProgress3: [],
            arrProgress4: [],
            invalidInput: false,
            correctInput: false,
        }
    },
    mounted() {
        let self = this;
        axios({
            method: 'get',
            url: '/exercises/getDndById/'+ self.exercise
        })
            .then((response) => {
                self.games = response.data;
                self.games.forEach(e => {
                    e[1].forEach(el => {
                        self.arrBacklog.push(el)
                    })
                })
            })
            .catch(error =>{
                console.log(error)
            })
    },
    methods: {
        newExercise: function (){
            location.reload();
        },
        resetAlert: function(invalid,correct){
            this.invalidInput = invalid;
            this.correctInput = correct;
        },
        redirectMenu: function(){
            location.href = 'http://127.0.0.1:8000/student-side'},
        //TODO redirect to random exercise
        arrProgress: function (id)
        {
            switch(id+1){
                case 1:
                    return this.arrProgress1;
                case 2:
                    return this.arrProgress2;
                case 3:
                    return this.arrProgress3;
                case 4:
                    return this.arrProgress4;
                default:
                    break;
            }
        },
        arrayComp: function(array1,array2)
        {
            if(
                array2.length !== array1.length
            )
            {
                return false;
            }
            let a = array2.sort().toString();
            console.log('a',a)
            let b = array1.sort().toString();
            console.log('b', b)
            if(a !== b){
                return false;
            }
            return true;
        },
        valAnswer: function ()
        {
            this.games.forEach(game => {
                //one column verification
                if(this.games.length === 1)
                {
                    if(this.arrayComp(this.arrProgress1,this.games[0][1]))
                    {
                        this.correctInput = true;
                        return true;
                    }
                    this.invalidInput = true;
                    return false;
                }
                //second column verification
                else if(this.games.length === 2)
                {
                    if(
                        this.arrayComp(this.arrProgress1,this.games[0][1]) &&
                        this.arrayComp(this.arrProgress2,this.games[1][1])
                    )
                    {
                        this.correctInput = true;
                        return true;
                    }
                    this.invalidInput = true;
                    return false;
                }
                //three columns verification
                else if(this.games.length === 3)
                {
                    if(
                        this.arrayComp(this.arrProgress1,this.games[0][1]) &&
                        this.arrayComp(this.arrProgress2,this.games[1][1]) &&
                        this.arrayComp(this.arrProgress3,this.games[2][1])
                    )
                    {
                        this.correctInput = true;
                        return true;
                    }
                    this.invalidInput = true;
                    return false;
                }
                //four columns verification
                else if(this.games.length === 4)
                {
                    if(
                        this.arrayComp(this.arrProgress1,this.games[0][1]) &&
                        this.arrayComp(this.arrProgress2,this.games[1][1]) &&
                        this.arrayComp(this.arrProgress3,this.games[2][1]) &&
                        this.arrayComp(this.arrProgress3,this.games[3][1])
                    )
                    {
                        this.correctInput = true;
                        return true;
                    }
                    this.invalidInput = true;
                    return false;
                }
            });
        }
    }
}
</script>

<style scoped>
.kanban-column {
    min-height: 300px;
}
section{
    font-family: Gloria Hallelujah;
}
.alert-secondary{
    background-color: #FBD51b;
}
.alert-secondary h3{
    color: #387780;
}
.alert-primary{
    background-color: #387780;
}
.alert-primary h3{
    color: #FBD51b;
}
.list-group-item{
    background-color: #cba800;
}
.col-3{
    padding-left: 0;
}
.header-text{
    color: #387780;
    margin-top: 40px;
}
.options-container{
    max-height: 350px;
    overflow: hidden;
    margin-bottom: 10px;
}
</style>
