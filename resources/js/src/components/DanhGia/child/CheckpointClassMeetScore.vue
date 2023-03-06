<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex justify-content-start col-10">
                        <button @click="viewTcList()" class="btn btn-outline-success end_item">Xem tiêu chí đánh giá</button>
                    </div>
                    <div class="col-12 overflow-table">
                        <table style="width: auto;" class="table table-bordered" cellspacing="0">
                        <tbody>
                            <template>
                            <tr style="height: 35px;">
                                <td style="height: 140px; width: 243px;" rowspan="4">
                                    <p><strong>Nguyễn Trọng Kh&aacute;nh(695105064)</strong></p>
                                </td>
                                <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Ti&ecirc;u ch&iacute; 1</strong></p>
                                </td>
                                <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Ti&ecirc;u ch&iacute; 1</strong></p>
                                </td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Điểm đ&aacute;nh gi&aacute; của</strong></p>
                                </td>
                                <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Điểm đ&aacute;nh gi&aacute; của</strong></p>
                                </td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>SV</p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>Lớp</p>
                                </td>
                                <td style="height: 35px; width: 239px; text-align: center;">
                                    <p>CVHT</p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>SV</p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>Lớp</p>
                                </td>
                                <td style="height: 35px; width: 239px; text-align: center;">
                                    <p>CVHT</p>
                                </td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                                <td style="height: 35px; width: 239px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                                <td style="height: 35px; width: 239px; text-align: center;">
                                    <p><strong><em>&nbsp;</em></strong></p>
                                </td>
                            </tr>
                            </template>
                        </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="awating" class="text-center">
                    Đang lấy dữ liệu điểm...
                </p>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
            <ViewTcList :tcList="tcList"/>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import ViewTcList from './ViewTcList.vue';
export default {
    props:{
        scoreList: {type: Array },
        classView: {type:Object},
        tcList: {type: Array},
    },
    components:{
        ViewTcList,
    },
    data(){
        return{
            awating: false,
            scoreListShow: this.scoreList,
        }
    },
    methods:{
        ...mapActions({

        }),
        viewTcList(){
            this.$nextTick(() => {
                $('#viewTcList').modal('show');
            });
        },
        closeModal(){
            this.$emit('closeModal');
        },
    },
    computed: {
    },
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
