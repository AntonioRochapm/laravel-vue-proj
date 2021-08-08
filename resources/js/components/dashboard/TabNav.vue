<template>
    <div class="tab-content" >
        <ul class="nav nav-tabs md-tabs-navigation">
            <li v-for="(tab,key) in tabs" :key="key" class="nav-item">
                <a class="nav-link" :class="{ active: tab.name === selected }" @click="setTab(tab.name)"
                >
                    <i class="md-icon md-icon-font md-tab-icon md-theme-default">
                        {{ tab.image }}
                    </i>
                    <span class="md-tab-label">
                        {{ tab.name }}
                    </span>
                </a>
            </li>
        </ul>
        <slot></slot>
    </div>
</template>
<script>
export default {
    props: {
        /* Holds all of the tabs data */
        tabs: {
            type: Array,
            required: true,
        },
        selected: {
            type: String,
            required: true,
        }
    },
    methods: {
        setTab(tab) {
            this.$emit('selected', tab);
        },
    },
};
</script>

<style scoped>
    .md-tabs-navigation{
        background: linear-gradient(60deg, #66bb6a, #387780);
        box-shadow: 0 12px 20px -10px rgba(76, 175, 80, 0.28),
                    0 4px 20px 0px rgba(0, 0, 0, 0.12),
                    0 7px 8px -5px rgba(76, 175, 80, 0.2);
        margin: -35px 0 0;
        border-radius: 3px;
        padding: 15px 15px 15px 75px;
    }
    .tab-content{
        width: 95%;
    }
    .nav-item{
        background-color: transparent !important;
    }
    .active{
        background-color: rgba(255, 255, 255, 0.2) !important;
        padding: 12px 30px;
    }
    .nav-link{
        color: white;
        padding: 12px 30px;
        display: flex;
        align-items: center;
        border: none;
    }
    .nav-link:hover{
        background-color: rgba(255, 255, 255, 0.2) !important;
    }
    li{
        display: flex;
        flex-direction: row;
        font-size: 16px;
    }
    .md-tab-label{
        color: white;
    }
    .md-icon{
        color: white;
        font-family: Material Icons;
        font-style: normal;
        justify-content: center;
        align-items: center;
        font-size: 26px;
        padding-right: 6px;
    }
</style>
