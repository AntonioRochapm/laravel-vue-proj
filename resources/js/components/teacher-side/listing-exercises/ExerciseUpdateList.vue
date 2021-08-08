<template>
<div class="main-container">
    <h1>Exercise List</h1>
    <div class="subjects-types-cards">
        <base-card>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Subjects: {{subjectName}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                    <a @click="updateSubjectsOnExerciseList(subject.id, subject.name)" class="dropdown-item" v-for="subject in subjects" :key="subject.id">{{subject.name}}</a>
                </div>
            </div>
        </base-card>
        <base-card>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Types: {{typeName}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                    <a @click="updateTypesOnExerciseList(type.id, type.name)" class="dropdown-item"  v-for="type in types" :key="type.id">{{type.name}}</a>
                </div>
            </div>
        </base-card>
    </div>
<!--    //validations-->
    <base-dialog v-if=" isRelatedWithExam === true" title="Error Message" @close="confirmError">
        <template #default>
            <p>Unfortunately this exercise exists in a Exam.</p>
            <p>Make sure you delete the exam first before deleting the exercise.</p>
        </template>
        <template #actions>
            <base-button class="second-button-in-card"@clicked="redirectToIndex">Back</base-button>
            <base-button @clicked="confirmError(true)">Reload?</base-button>
        </template>
    </base-dialog>
    <base-dialog v-if="isLoading === true" title="Loading" @close="confirmError">
        <template #default>
            <p>Exercises Are Loading</p>
            <p>Wait a few seconds or try to reload.</p>
        </template>
        <template #actions>
            <base-button class="second-button-in-card"@clicked="redirectToIndex">Back</base-button>
            <base-button @clicked="confirmError(true)">Reload?</base-button>
        </template>
    </base-dialog>
    <base-dialog v-if="errorLoading" title="Error Loading Data" @close="confirmError">
        <template #default>
            <p>Unfortunately there was an error while loading the data!</p>
            <p>Please try again.</p>
        </template>
        <template #actions>
            <base-button class="second-button-in-card"@clicked="redirectToIndex">Back</base-button>
            <base-button @clicked="confirmError(false)">Retry</base-button>
        </template>
    </base-dialog>
    <base-dialog v-if="exercises.length < 1 && isLoading === false" title="No Exercises were found" @close="confirmError">
        <template #default>
            <p>Unfortunately there are no exercises with that subject and that type.</p>
            <p>Either create one or pick another subject or type.</p>
        </template>
        <template #actions>
                <base-button class="second-button-in-card"@clicked="redirectToIndex">Back</base-button>
                <base-button @clicked="confirmError(true)">Reload</base-button>
        </template>
    </base-dialog>

    <div class="lists-container">
        <base-card>
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
            <b-table
                id="my-table"
                :items="exercises"
                :per-page="perPage"
                :current-page="currentPage"
                :fields="fields"
                small
            >
                <template #cell(subject)="row">
                    {{getExerciseSubjectName(row.item.subject_id)}}
                </template>
                <template #cell(type)="row">
                    {{getExerciseTypeName(row.item.type_id)}}
                </template>
                <template #cell(action)="row">
                    <base-button type="button" @clicked="deleteExercise(row.item.id, row.item.type_id)" mode="btn-danger">Delete</base-button>
                </template>
            </b-table>
        </base-card>

    </div>

</div>
</template>

<script>
import HelperClass from '../../../HelperClass';
import ApiComms from '../../../comms.js';


import BaseCard from "../../UI/BaseCard.vue";
import BaseDialog from "../../UI/BaseDialog.vue";
import BaseButton from "../../UI/BaseButton.vue";
import StoredExercises from "./StoredExercises.vue";

export default {
    name: "exercise-update-list",
    components:{
        BaseCard,
        BaseDialog,
        BaseButton,
        StoredExercises
    },
    computed: {
        rows() {
            return this.exercises.length
        }
    },

    data(){
        return {
            fields:[
                "title",
                "description",
                "subject",
                "type",
                "action"
            ],
            isRelatedWithExam: false,
            perPage: 3, // bootstrap pagination
            currentPage: 1, // bootstrap pagination
            exercises: [],
            subjects: [],
            types: [],
            errorLoading: false,
            isLoading: false,
            epsHelper: new HelperClass(),
            comms: new ApiComms(),
            subjectIdSelected : 0,
            typeIdSelected : 0,
            subjectName : 'All',
            typeName : 'All',
            aboutToDelete: false,
        }
    },
    methods: {
        redirectToIndex(){
            window.location="/";
        },
        async loadLists(){
            try{

                this.isLoading = true;
                let self = this;

                //get all subjects

                self.subjects = await self.comms.getAllByUrl('/exercises/subject');
                //get all types
                self.types = await self.comms.getAllByUrl('/exercises/type');
                //get all exercises
                self.exercises = await self.comms.getAllByUrl('/exercises/exercise');

                // Push a new object into subjects and types arrays so we can have an All option which will show all
                // all types or all subjects
                let defaultSubject = {
                    id: 0,
                    name: 'All'
                };
                self.subjects.push(defaultSubject);
                let defaultType = {
                    id: 0,
                    name: 'All'
                };
                self.types.push(defaultType);

                self.errorLoading = false;
                self.isLoading = false;
            }catch(e){
                this.errorLoading = true;
            }
        },
        confirmError(resetValues){
            this.errorLoading = false;
            this.loadLists();
            this.isRelatedWithExam = false;
            if(resetValues){
                this.subjectName = 'All';
                this.typeName = 'All';
                this.subjectIdSelected = 0;
                this.typeIdSelected = 0;
            }
        },
        getExerciseSubjectName(subjectID){
            let resultID = this.epsHelper.findElementInObjectsArray(this.subjects, 'id',subjectID)
            return resultID.name;
        },
        getExerciseTypeName(typeID){
            let resultID = this.epsHelper.findElementInObjectsArray(this.types,'id' ,typeID)
            return resultID.name;
        },
        updateSubjectsOnExerciseList(subjectID, subjectName){
            this.subjectName = subjectName;
            this.subjectIdSelected = subjectID;
            let self = this;
            self.loadLists()
                .then(function (){
                    if(self.subjectIdSelected !== 0){
                        self.exercises = self.epsHelper.filterElementsInObjectsArray(self.exercises, 'subject_id', self.subjectIdSelected)
                    }
                    if(self.typeIdSelected !== 0){
                        self.exercises = self.epsHelper.filterElementsInObjectsArray(self.exercises, 'type_id', self.typeIdSelected)
                    }

                })
        },
        updateTypesOnExerciseList(typeID, typeName){
            this.typeIdSelected = typeID;
            this.typeName = typeName;
            let self = this;
            self.loadLists()
                .then(function (){
                    if(self.typeIdSelected !== 0){
                        self.exercises = self.epsHelper.filterElementsInObjectsArray(self.exercises, 'type_id', self.typeIdSelected)
                    }
                    if(self.subjectIdSelected !== 0){
                        self.exercises = self.epsHelper.filterElementsInObjectsArray(self.exercises, 'subject_id', self.subjectIdSelected)
                    }
                })
        },
        async deleteExercise(id, type_id){

            try{
                // Here we check if an exercise exists in a exam
                this.isRelatedWithExam = await this.comms.booleanResponse('/axios/exams/exercises/' + id);

                //If its not we allow the exercise to be deleted
                if(!this.isRelatedWithExam){
                    let typeSlug = this.epsHelper.findElementInObjectsArray(this.types, 'id',type_id);
                    this.isLoading = true
                    await this.comms.deleteByUrl('/exercises/' + typeSlug.slug + '/' + id);
                    this.errorLoading = false;
                    this.isLoading = false;
                    await this.loadLists();
                    this.subjectIdSelected = 0;
                    this.typeIdSelected = 0;
                    this.subjectName = 'All';
                    this.typeName = 'All';
                }
            }catch (e) {
                this.isLoading = false;
                this.errorLoading = true;
            }
        },
    },
    mounted(){
        this.loadLists()
    },
}
</script>

<style scoped>
    .second-button-in-card{
        margin-right: 5%;
    }
    a{
        cursor: pointer;
    }
    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .lists-container{
        display: flex;
        justify-content: space-around;
        width: 100%;
        padding-top: 30px;
    }
    .subjects-types-cards {
        display: flex;
        width: 100%;
        justify-content: space-around;
    }
    ul {
        list-style: none;
        margin: 0;
        padding: 0;
        margin: auto;
        max-width: 40rem;
    }
    .btn-secondary {
        color: #fff;
        background-color: #387780;
        border-color: #387780;
        font-size: 1.2rem;
        font-family: "Nunito", sans-serif;
    }
    .show > .btn-secondary.dropdown-toggle {
        color: #fff;
        background-color: #FBD51b;
        border-color: #FBD51b;
    }
    h1{
        color: #387780;
        padding-top: 20px;
    }
    @media (max-width: 600px)  {
        .btn-secondary {
            font-size: 0.8rem;
        }
    }
</style>



