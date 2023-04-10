<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Trang intro</h1>
                        <hr/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    data(){
        return{

        }
    },
    methods:{
    },
    mounted() {
        document.title = `Giới thiệu - ${process.env.MIX_APP_NAME}`;
    },
}
</script>

<style scoped>

</style>
