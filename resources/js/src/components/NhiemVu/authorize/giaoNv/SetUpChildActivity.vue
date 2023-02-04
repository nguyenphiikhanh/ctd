<template>
    <div class="card-inner">
        <h5 class="title mb-4">Chọn đối tượng nhận</h5>
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" v-model="searchText" @input="searchClass()" placeholder="Tìm kiếm">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <small v-if="isSearching">Đang tìm kiếm...</small>
                    <ul v-if="!isSearching" class="custom-control-group d-flex">
                        <li v-for="(option, index) in classes" :key="index" class="col-4">
                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                <input v-model="class_select" type="checkbox" :value="option.id" class="custom-control-input" :id="`class-${index}`">
                                <label class="custom-control-label col-12" :for="`class-${index}`">{{option.class_name}}</label>
                            </div>
                        </li>
                    </ul>
                    <div v-if="classes.length == 0" class="row text-center d-flex justify-content-center"><small>Không có dữ liệu.</small></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
import { asyncLoading } from 'vuejs-loading-plugin';
export default {
    data(){
        return{
            classes: [],
            class_select: [],
            searchText: '',
            isSearching: false,
        }
    },
    methods:{
        ...mapActions({
           getClassList: 'classes/getClassList',
        }),
        async getClasses(){
            await this.getClassList().then(res => this.classes = res.data);
        },
        async searchClass(){
            this.isSearching = true;
            let data = {className: this.searchText};
            await this.getClassList(data).then(res => this.classes = res.data);
            this.isSearching = false;
        }
    },
    computed:{

    },
    async mounted() {
        asyncLoading(this.getClasses());
    },
    watch:{
        class_select(val){
            this.$emit('emitChange', val);
        }
    }
}
</script>

<style scoped>

</style>
