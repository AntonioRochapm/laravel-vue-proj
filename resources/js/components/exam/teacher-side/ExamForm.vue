<template>
    <div class="form-top">
        <base-table-box>
            <div slot="header">
                <h2>Exam creation</h2>
            </div>
            <div slot="body">
                <div class="form-input-area">
                    <div class="mb-3">
                        <label class="sr-only" for="inline-form-input-name">Exam Description</label>
                        <b-form-input
                            id="inline-form-input-name"
                            v-model="description"
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="Description"
                        ></b-form-input>
                    </div>
                </div>
            </div>
        </base-table-box>
        <div class="body-top">
            <base-card class="card-top-body">
                <div >
                    <div class="mb-3">
                        <select class="form-select" v-model="selectedSub" @change="changeExercises()">
                            <option value="" selected>All Subjects</option>
                            <option v-for="(subjectItem, kSubject) in subjectList" :value="subjectItem.id" :key="kSubject">{{ subjectItem.name }}</option>
                        </select>
                        <select class="form-select" v-model="selectedTyp" @change="changeExercises()">
                            <option value="" selected>All Types</option>
                            <option v-for="(subjectItem, kType) in typeList" :value="subjectItem.id" :key="kType">{{ subjectItem.name }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" v-model="selectedExe">
                            <option value="" selected>Select an Exercise</option>
                            <option v-for="(subjectItem, kType) in sortedExercises" :value="subjectItem.id" :key="kType">
                                {{ findNameById(subjectList, subjectItem.subject_id) }} - {{ findNameById(typeList,subjectItem.type_id) }}
                            </option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <base-button type="button" @clicked="addExercise">Add Exercise to Exam</base-button>
                        </div>
                        <div class="mb-3">
                            <base-button type="button" @clicked="submitExam" mode="success">Submit Exam</base-button>
                        </div>
                    </div>
                </div>
            </base-card>
        </div>
    </div>
</template>

<script>
import BaseButton from "../../UI/BaseButton";
import ApiComms from '../../../comms.js';

export default {
    components: {BaseButton},
    data() {
        return {
            description: '',
            selectedSub: '',
            selectedTyp: '',
            selectedExe: '',
            sortedExercises: [],
            exerciseList: [],
            subjectList: [],
            typeList: [],
            examItems: [],
        }
    },
    created(){
        window.Event.$on('remove-exercise', (id) => {
            console.log(this.examItems)
            id = id - 1;
            this.sortedExercises.push(this.examItems[id]);
            this.examItems = this.examItems.filter((item, index) => index !== id);
        });
    },
    async mounted() {
        const c = new ApiComms();
        //get all subjects
        this.subjectList     = await c.getAllByUrl('/exercises/subject');
        //get all types
        this.typeList        = await c.getAllByUrl('/exercises/type');
        //get all exercises
        this.exerciseList    = await c.getAllByUrl('/exercises/exercise');
        this.sortedExercises = await c.getAllByUrl('/exercises/exercise');
    },
    methods:{
        findNameById(array,id)
        {
            return array.find(element => element.id === id).name;
        },
        changeExercises: function()
        {
            let sub = this.selectedSub;
            let typ = this.selectedTyp;

            if (sub === '' && typ === '')
            {
                this.sortedExercises = this.exerciseList;
            }
            else if (sub === '')
            {
                this.sortedExercises = this.exerciseList.filter(exercise => exercise.type_id === typ);
            }
            else if (typ === '')
            {
                this.sortedExercises = this.exerciseList.filter(exercise => exercise.subject_id === sub);
            }
            else
            {
                this.sortedExercises = this.exerciseList.filter(exercise    => exercise.subject_id === sub);
                this.sortedExercises = this.sortedExercises.filter(exercise => exercise.type_id === typ);
            }
        },
        addExercise: function ()
        {
            let ex = this.exerciseList.find(element => element.id === this.selectedExe);
            this.sortedExercises = this.sortedExercises.filter(exercise => exercise !== ex);
            this.examItems.push(ex);
            window.Event.$emit('add-exercise', ex);
        },
        submitExam: async function ()
        {
            try{
                const c = new ApiComms();
                let arrayIds = [];
                this.examItems.forEach(element => {
                    arrayIds.push(element.id);
                })
                let payload = [arrayIds, this.description];
                let url = '/exam';
                await c.saveAllByUrl(url,payload);
                window.location = '/';
            }catch(error){
                return error;
            }
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
.form-top{
    display: flex;
    flex-direction: column;
    justify-content: center;

}
.body-top{
    display: flex;
    justify-content: center;
}
.card-top-body{
    margin: 10px 0;
    width: 600px;
}
</style>
