<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Thông báo</h3>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách thông báo</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <table class="table table-orders">
                                <thead class="tb-odr-head">
                                <tr class="tb-odr-item">
                                    <th class="tb-odr-info">
                                        <span class="tb-odr-id">Thời gian</span>
                                        <span class="tb-odr-date d-none d-md-inline-block">Tên nhiệm vụ</span>
                                    </th>
                                    <th class="tb-odr-amount">
                                        <span class="tb-odr-total">Amount</span>
                                        <span class="tb-odr-status d-none d-md-inline-block">Trạng thái</span>
                                    </th>
                                    <th class="tb-odr-action">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="tb-odr-body">
                                <tr class="tb-odr-item" v-for="(item, index) in notiList" :key="index">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-date">{{item.created_at}}</span>
                                        <span class="tb-odr-id"><a href="#">{{item.name}}</a></span>

                                    </td>
                                    <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$2300.00</span>
                                            </span>
                                        <span class="tb-odr-status">
<!--                                                <span class="badge badge-dot bg-success">Đã hoàn thành</span>-->
                                                <span class="badge badge-dot bg-warning">Chưa hoàn thành</span>
                                            </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" @click="forwardChildAct(item.id)" class="btn btn-sm btn-primary">Chuyển tiếp</a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- .card -->
                    </div><!-- nk-block -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";
import { asyncLoading } from 'vuejs-loading-plugin';


export default {
    data(){
        return{
            notiList: [],
        }
    },
    computed:{
    },
    methods:{
        ...mapActions({
            getActReceive: 'activity/getActivitiesReceive',
            forwardActivities: 'activity/forwardActivities'
        }),
        async getActivitiesReceive(){
            await this.getActReceive().then(res => this.notiList = res.data);
        },
        async forwardChildAct(id){
            this.$loading(true)
            await this.forwardActivities(id);
            this.$loading(false);
        }
    },
    mounted() {
        asyncLoading(this.getActivitiesReceive());
    }
}
</script>

<style scoped>

</style>
