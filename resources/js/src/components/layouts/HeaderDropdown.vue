<template>
    <div class="nk-header-tools">
        <ul class="nk-quick-nav">
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                    <div class="user-toggle">
                        <div class="user-avatar sm">
                            <em class="icon ni ni-user-alt"></em>
                        </div>
                        <div class="user-info d-none d-xl-block">
                            <div class="user-name dropdown-indicator">{{user.ho + ' ' + user.ten}}</div>
                            <div class="user-status user-status-active">{{user.role_name}}</div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                    <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                        <div class="user-card">
                            <div class="user-avatar">
                                <span>Đ</span>
                            </div>
                            <div class="user-info">
                                <span class="lead-text">{{user.ho + ' ' + user.ten}}</span>
                                <span class="sub-text">{{user.email}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-inner">
                        <ul class="link-list">
                            <li><a href="#" @click="logout()"><em class="icon ni ni-signout"></em><span>Đăng xuất</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    methods:{
        ...mapActions({
            logout: 'auth/logout',
        })
    },
    computed:{
        user(){
            return this.$store.getters['auth/user'];
        }
    }
}
</script>

<style scoped>

</style>
