<template>
    <div class="content">
        <base-dialog v-if="isLoading" title="Loading...">
            <template #default>
                <p>Loading...</p>
            </template>
        </base-dialog>
        <section >
            <h1 style="color: #387780">DASHBOARD</h1>
        </section>
        <section class="md-layout">
            <div
                v-for="statsCard in statsCards"
                class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25"
            >
                <stats-card :data-background-color="statsCard.colour">
                    <template slot="header">
                        <i class="md-icon md-icon-font md-theme-default">
                            {{ statsCard.iconHeader }}
                        </i>
                    </template>

                    <template slot="content">
                        <p class="category">{{ statsCard.category }}</p>
                        <h3 class="title">{{ statsCard.count }}</h3>
                    </template>

                    <template slot="footer">
                        <div class="stats">
                            <i class="md-icon md-icon-font md-theme-default">
                                {{ statsCard.iconFooter }}
                            </i>
                            {{ statsCard.text }}
                        </div>
                    </template>
                </stats-card>
            </div>
        </section>
        <section class="md-layout-table md-card">
            <tab-nav :tabs="tabs" :selected="selected" @selected="setSelected"
            >
                <div v-for="tabContent in tabsContent">
                    <tab :isSelected="selected === tabContent.name" class="tab-content-btn">
                        <button @click="getView( tabContent.url1 )" class="btn btn-primary btn-lg">
                            {{ tabContent.option1 }}
                        </button>
                        <button @click="getView( tabContent.url2 )" class="btn btn-primary btn-lg">
                            {{ tabContent.option2 }}
                        </button>
                    </tab>
                </div>
            </tab-nav>
        </section>
    </div>
</template>

<script>
import ApiComms from '../../comms.js';

    export default {
        data(){
            return{
                selected: 'Students',
                isLoading: true,
                statsCards: [
                    {
                        colour: 'eps-green',
                        iconHeader: 'person',
                        category: 'Number of Students',
                        count: '0',
                        iconFooter: 'date_range',
                        text: 'Active Accounts',
                    },
                    {
                        colour: 'eps-yellow',
                        iconHeader: 'groups',
                        category: 'Number of Classes',
                        count: '0',
                        iconFooter: 'date_range',
                        text: 'Active Classes',
                    },
                    {
                        colour: 'eps-green',
                        iconHeader: 'ballot',
                        category: 'Number of Exams',
                        count: '0',
                        iconFooter: 'update',
                        text: 'Just Updated',
                    },
                    {
                        colour: 'eps-yellow',
                        iconHeader: 'catching_pokemon',
                        category: 'Number of Exercises',
                        count: '0',
                        iconFooter: 'warning',
                        text: 'Keep up the good work',
                    }
                ],
                tabs: [
                    {
                        name: 'Students',
                        image: 'person',
                    },
                    {
                        name: 'Classes',
                        image: 'groups',
                    },
                    {
                        name: 'Exams',
                        image: 'ballot',
                    },
                    {
                        name: 'Exercises',
                        image: 'catching_pokemon',
                    },
                    {
                        name: 'Teachers',
                        image: 'school',
                    }
                ],
                tabsContent:[
                    {
                        name: 'Students',
                        option1: 'Switch to Student View',
                        url1: 'student-side',
                        option2: 'Create a new Student (individually)',
                        url2: 'students/create'
                    },
                    {
                        name: 'Classes',
                        option1: 'Check Classes List',
                        url1: 'classes',
                        option2: 'Create New Class (Excel Sheet)',
                        url2: 'classes/import-excel'
                    },
                    {
                        name: 'Exams',
                        option1: 'Check Exams\' List',
                        url1: 'exam/list',
                        option2: 'Create New Exam',
                        url2: 'exam/create'
                    },
                    {
                        name: 'Exercises',
                        option1: 'Check Exercises\' List',
                        url1: 'exercises',
                        option2: 'Create New Exercise',
                        url2: 'exercises/create'
                    },
                    {
                        name: 'Teachers',
                        option1: 'Check Teachers List',
                        url1: 'teacher-side/teachers-list',
                        option2: 'Create New Teacher',
                        url2: 'teacher-side/create'
                    }
                ]
            }
        },
        async mounted() {
            let ac = new ApiComms();
            this.statsCards[0].count = await ac.getCount('axios/studentCount');
            this.statsCards[1].count = await ac.getCount('axios/classCount');
            this.statsCards[2].count = await ac.getCount('axios/examCount');
            this.statsCards[3].count = await ac.getCount('axios/exerciseCount')
            this.isLoading = false;
        },
        methods:{
            setSelected: function(tab){
                this.selected = tab;
            },
            getView: function(url){
                window.location = url;
            }
        }
    }
</script>

<style scoped>
    .md-card-stats .md-card-header i{
        font-size: 36px !important;
        line-height: 56px;
        width: 56px;
        height: 56px;
        color: white;
    }
    .md-icon{
        display: inline-flex;
        align-items:center;
        font-family: Material Icons;
        font-style: normal;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .md-card .category{
        color: #999999;
    }
    .md-card .md-card-actions .stats{
        line-height: 22px;
        color: #999999;
        font-size: 16px;
    }
    .md-layout-item{
        display: flex;
        justify-content: center;
        padding-right: 15px;
        padding-left: 15px;
    }
    .content{
        padding: 30px 15px;
    }
    .md-layout{
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-top: 30px;
    }
    .md-layout-table{
        width: 100%;
    }
    @media screen and (max-width: 700px) {
        .md-layout{
            grid-template-columns: 1fr;
        }
    }
    @media screen and (min-width: 920px) {
        .md-layout{
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }
    }
    @media screen and (min-width: 1325px) {
        .md-layout-table{
            width: 70%;
        }
    }
    .md-layout-table{
        display: flex;
        justify-content: center;
    }
    .md-card{
        margin-top:80px;
        box-shadow: 0 12px 20px -10px rgba(76, 175, 80, 0.28),
                    0 4px 20px 0px rgba(0, 0, 0, 0.12),
                    0 7px 8px -5px rgba(76, 175, 80, 0.2);
    }
    .tab-content-btn{
        padding: 15px 30px;
        display: flex;
        flex-direction: column;

    }
    .tab-content-btn button{
        background: linear-gradient(60deg, #cba800, #FBD51b);
        border: none;
        margin: 5px;
    }
    .tab-content-btn button:hover{
        color: #387780;
    }
    .content{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
