<template>
    <div>
        <Navbar/>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from "./layouts/Navbar";
export default {
    components:{
        Navbar
    },
    mounted() {
        console.log('Main Component mounted.')
    }
}
</script>

<style scoped>

</style>
