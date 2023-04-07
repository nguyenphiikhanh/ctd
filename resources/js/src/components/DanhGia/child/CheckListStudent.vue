<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="checkListStudent">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    props:{
        studentList: {type: Array},
        classView: {type:Object},
    },
    components:{
    },
    data(){
        return{
            studentListClone: [],
        }
    },
    methods:{
        ...mapActions({

        }),
        closeModal(){
            this.$emit('closeModal');
        },
    },
    mounted(){
        this.studentListClone = JSON.parse(JSON.stringify(this.studentList));
    }
};
</script>

<style scoped>
.mw-98{
    min-width: 98%;
}
.overflow-table{
    overflow: auto;
    max-width: 100%;
    max-height: 500px;
}
.table-header th{
    position: sticky;
    top: 0;
    background-color: #97dfe8;
}
</style>
