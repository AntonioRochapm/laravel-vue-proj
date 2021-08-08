<template>
    <base-card class="md-card md-card-stats">
        <div class="md-card-header" :data-background-color="dataBackgroundColor">
            <slot name="header"></slot>
        </div>

        <div class="md-card-content">
            <slot name="content"></slot>
        </div>

        <div class="md-card-actions md-alignment-left">
            <slot name="footer"></slot>
        </div>
    </base-card>
</template>
<script>

import BaseCard from "../UI/BaseCard";
export default {
    name: "stats-card",
    components: {BaseCard},
    props: {
        dataBackgroundColor: {
            type: String,
            default: ""
        }
    }
};
</script>

<style scoped>
    .md-card{
        display: inline-block;
        position: relative;
        width: 100%;
        margin: 25px 0;
        z-index: 1;
    }
    .md-card [data-background-color="eps-green"]{
        background: #387780;
    }
    .md-card [data-background-color="eps-yellow"]{
         background: #FBD51b;
    }
    .md-card-header{
        box-shadow: 0 12px 20px -10px rgba(255, 152, 0, 0.28),
                    0 4px 20px 0px rgba(0, 0, 0, 0.12),
                    0 7px 8px -5px rgba(255, 152, 0, 0.2);
    }
    .md-card .md-card-header{
        margin: -30px 15px 0;
        border-radius: 3px;
        padding: 15px;
    }
    .md-card-stats .md-card-header{
        float: left;
        text-align: center;
    }
    .md-card-stats .md-card-content{
        text-align: right;
        padding-top: 10px;
    }
    .md-card .md-card-content{
        padding: 15px 20px;
    }
    .md-card .md-card-actions{
        margin: 0 20px 10px;
        padding: 10px 0 0 0;
        border-top: 1px solid #eeeeee;
    }
</style>
