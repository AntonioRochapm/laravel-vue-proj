<template>
    <section class="container" style="width: 700px">
        <exam-form></exam-form>
        <div class="container-card">
            <base-card class="card-table">
                <b-table :items="items" :fields="fields">
                    <template #cell(subject)="row">
                        {{ findNameById(subjectList, row.item.subject_id) }}
                    </template>
                    <template #cell(type)="row">
                        {{ findNameById(typeList, row.item.type_id) }}
                    </template>
                    <template #cell(actions)="row">
                        <base-button type="button" @clicked="removeExercise(row.item.id)" mode="btn-danger">Remove Exercise</base-button>
                    </template>
                </b-table>
            </base-card>
        </div>
    </section>
</template>

<script>
import ApiComms from "../../../comms";

export default {
    data() {
        return {
            items: [],
            subjectList: [],
            typeList: [],
            fields: [
                'subject',
                'type',
                'actions'
            ],
        }
    },
    created(){
        window.Event.$on('add-exercise', (ex) => {
            this.items.push(ex);
        })
    },
    async mounted() {
        const c = new ApiComms();
        //get all subjects
        this.subjectList = await c.getAllByUrl('/exercises/subject');
        //get all types
        this.typeList = await c.getAllByUrl('/exercises/type');

    },
    methods: {
        removeExercise: function (id) {
            this.items = this.items.filter((item) => item.id !== id);
            window.Event.$emit('remove-exercise', id);
        },
        findNameById(array, id) {
            return array.find(element => element.id === id).name;
        },
    }
}
</script>

<style scoped>
.card-table{
    display: flex;
    justify-content: center;
    width: 600px;
}
.container-card{
    display: flex;
    justify-content: center;
}
</style>
