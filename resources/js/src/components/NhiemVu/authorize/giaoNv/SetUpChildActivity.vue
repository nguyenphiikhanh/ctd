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
                    <ul class="custom-control-group d-flex">
                        <li v-for="(option, index) in classResources" :key="index" class="col-4">
                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                <input v-model="class_select" type="checkbox" :value="option.id" class="custom-control-input" :id="`class-${index}`">
                                <label class="custom-control-label col-12" :for="`class-${index}`">{{option.class_name}}</label>
                            </div>
                        </li>
                    </ul>
                    <div v-if="classResources.length == 0" class="row text-center d-flex justify-content-center"><small>Không có dữ liệu.</small></div>
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
        }
    },
    methods:{
        ...mapActions({
           getClassList: 'classes/getClassList',
        }),
        async getClasses(){
            await this.getClassList().then(res => this.classes = res.data);
        },
    },
    computed:{
        classResources(){
            if(this.searchText){
                return this.classes.filter((item)=>{
                    return this.searchText.toLowerCase().split(' ').every(v => item.class_name.toLowerCase().includes(v))
                })
            }
            else return this.classes;
        }
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
