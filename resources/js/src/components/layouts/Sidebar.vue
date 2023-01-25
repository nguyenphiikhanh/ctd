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
            <router-link v-if="user.role == roles.ADMIN" :to="{name: 'KhoaDaoTao'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                        <span class="nk-menu-text">Quản lý Khóa đào tạo</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
            <router-link v-if="user.role == roles.ADMIN" :to="{name: 'Khoa'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                        <span class="nk-menu-text">Quản lý Liên chi Đoàn</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
            <router-link v-if="user.role == roles.ADMIN" :to="{name: 'NhiemVu_List'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                        <span class="nk-menu-text">Quản lý Cán bộ Liên chi Đoàn</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
            <router-link v-if="user.role == roles.ADMIN" :to="{name: 'Lop'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                        <span class="nk-menu-text">Quản lý chi Đoàn</span>
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
            <router-link v-if="user.role != roles.ADMIN" :to="{name: 'CheckList'}">
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-list-check"></em></span>
                        <span class="nk-menu-text">Điểm danh hoạt động</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </router-link>
        </ul><!-- .nk-menu -->
    </div><!-- .nk-sidebar-menu -->
</template>

<script>
import constants from "../../constants";
import {mapActions} from "vuex";
import {asyncLoading} from "vuejs-loading-plugin";
export default {
    methods:{
      ...mapActions({
          getNotifyList: 'activity/getActivitiesReceive',
      }),
    },
    computed:{
        roles(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        }
    },
    async mounted() {
        await asyncLoading(this.getNotifyList());
    }
}
</script>

<style scoped>

</style>
