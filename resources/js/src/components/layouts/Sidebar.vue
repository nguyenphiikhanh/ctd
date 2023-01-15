<template>
    <div class="nk-sidebar-menu" data-simplebar>
        <ul class="nk-menu">
            <router-link :to="{name: 'Home'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span>
                        <span class="nk-menu-text">Trang chủ</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
            <router-link v-if="user.role != roles.ADMIN" :to="{name: 'NhiemVu_List'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                        <span class="nk-menu-text">Nhiệm vụ</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
            <router-link v-if="user.role != roles.ADMIN" :to="{name: 'Notifications'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-bell-fill"></em></span>
                        <span class="nk-menu-text">Thông báo nhiệm vụ</span><span class="nk-menu-badge">{{$store.getters['activity/activityReceiveCount']}}</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
        </ul><!-- .nk-menu -->
    </div><!-- .nk-sidebar-menu -->
</template>

<script>
import constants from "../../constants";
export default {
    computed:{
        roles(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        }
    }
}
</script>

<style scoped>

</style>
