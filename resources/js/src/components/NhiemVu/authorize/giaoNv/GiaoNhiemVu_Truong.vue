<template>
    <div class="card-inner" v-if="isShowing">
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
                    <ul v-if="!isSearching" class="custom-control-group">
                        <li v-for="(act, index) in classes" :key="index">
                            <div class="custom-control custom-radio custom-control-pro no-control">
                                <input v-model="class_selected" type="checkbox" :value="act.id" class="custom-control-input" :id="`class-${index}`">
                                <label class="custom-control-label" :for="`class-${index}`">{{act.class_name}}</label>
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
    props:{
        isShowing: {type: Boolean, default: false, required: true},
        class_choose: {type: Array, default: []}
    },
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
        class_selected:{
            get(){
                this.class_select = this.class_choose;
                return this.class_select;
            },
            set(val){
                this.class_select = val;
                this.$emit('class.selected',this.class_select);
            }
        }
    },
    async mounted() {
        asyncLoading(this.getClasses());
    }
}
</script>

<style scoped>

</style>
