<template>
    <section class="md-layout-table md-card">
        <div class="tab-content">
            <div class="nav nav-tabs md-tabs-navigation">
                <slot name="header">

                </slot>
            </div>
            <div>
                <slot name="body">

                </slot>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        title:{
            type: String,
            require: false
        }
    }
}
</script>

<style scoped>
    .md-layout-table{
        width: 100%;
        display: flex;
        justify-content: center;
    }
    .md-card{
        margin-top: 60px;
        box-shadow: 0 12px 20px -10px rgba(76, 175, 80, 0.28),
        0 4px 20px 0px rgba(0, 0, 0, 0.12),
        0 7px 8px -5px rgba(76, 175, 80, 0.2);
    }
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
</style>
