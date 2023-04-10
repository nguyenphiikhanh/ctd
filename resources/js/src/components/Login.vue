<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Đăng Nhập</h1>
                        <hr/>
                        <form @submit.prevent="login()" class="row" method="post">
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold">Tên đăng nhập</label>
                                <input type="text" v-model="authInfo.username" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="font-weight-bold">Mật khẩu</label>
                                <input type="password" v-model="authInfo.password" class="form-control">
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Đăng nhập
                                </button>
                            </div>
                        </form>
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
            authInfo: {
                username: '',
                password: '',
            },
        }
    },
    methods:{
      ...mapActions({
          loginAction: 'auth/login',
      }),
        async login(){
          this.$loading(true);
          await this.loginAction(this.authInfo);
          this.$loading(false)
        },
    },
    mounted() {
        document.title = `Đăng nhập - ${process.env.MIX_APP_NAME}`;
    },
    beforeCreate() {
        if(this.$store.getters['auth/isAuthenticated']){
            location.href = '/trang-chu'
        };
    },
}
</script>

<style scoped>

</style>
