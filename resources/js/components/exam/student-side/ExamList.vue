<template>
<div>
    <base-dialog v-if="isLoading === true" title="Loading">
        <template #default>
            <p>Exams Are Loading</p>
            <p>Wait a few seconds.</p>
        </template>
    </base-dialog>
    <base-card class="exam-list">
        <b-col sm="7" md="6" class="my-1">
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                align="fill"
                size="sm"
                class="my-0"
            ></b-pagination>
        </b-col>
        <b-table :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage">
            <template #cell(teacher)="row">
                {{ findTeacherNameById(row.item.teacher_id) }}
            </template>
            <template #cell(actions)="row">
                <base-button type="button" @clicked="" mode="btn-success">Solve!</base-button>
            </template>
        </b-table>
    </base-card>
</div>

</template>

<script>
import ApiComms from "../../../comms";
import BaseButton from "../../UI/BaseButton.vue";
import BaseDialog from "../../UI/BaseDialog.vue";
import BaseCard from "../../UI/BaseCard.vue";

export default {
    components:{
        BaseDialog,
        BaseButton,
        BaseCard
    },
    data() {
        return {
            comms: new ApiComms(),
            currentPage: 1,
            totalRows: 1,
            perPage: 5,
            teachers: [],
            items: [],
            fields: [
                'name',
                'teacher',
                'actions'
            ],
            isLoading: false,
        }
    },
    computed: {
        rows(){
            return this.items.length;
        }
    },
    async created() {
        this.isLoading = true;
        let self = this;
        try{
            //get all teacher names
            self.teachers = await self.comms.getAllByUrl('axios/getTeacher');
            //get all subjects
            self.items = await self.comms.getAllByUrl('/axios/exams');
            self.isLoading = false;
        }catch (e){
            return;
        }

    },
    methods: {
        findTeacherNameById: function(id){
            id = id - 1;
            let t = this.teachers[id].name;
            return t;
        }
    },
    redirectToIndex(){
        window.location="/";
    },
}
</script>

<style scoped>
    @media (max-width: 576px) {
        .exam-list{
            font-size: 10px;
        }
    }
</style>
