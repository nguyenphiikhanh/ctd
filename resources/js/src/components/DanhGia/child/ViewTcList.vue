<template>
    <div class="modal fade modal-lg" tabindex="-1" id="viewTcList">
        <div class="modal-dialog modal-dialog-top mw-100" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Tiêu chí đánh giá</h5></div>
                <div class="modal-body">
                    <div class="col-12 overflow-table">
                        <table class="table table-bordered table-responsive table-responsive-sm">
                            <thead class="table-header">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên tiêu chí</th>
                                <th scope="col">Điểm tối đa</th>
                                <th scope="col">Ghi chú</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tc,index) in tcList" :key="index">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ tc.name }}</td>
                                <td>{{ tc.max_score }}</td>
                                <td>{{ tc.note }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        tcList: {type: Array},
    },
    methods:{
    closeModal(){
        this.$nextTick(() => {
            $('#viewTcList').modal('hide');
        });
    }
    }
};
</script>

<style scoped>
.mw-100{
    min-width: 100%;
}
.overflow-table{
    overflow: auto;
    max-width: 100%;
    max-height: 600px;
}
</style>
