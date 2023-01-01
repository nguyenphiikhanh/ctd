<template>
   <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Nhiệm vụ</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="btn icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="default-04" placeholder="Tìm kiếm">
                                                </div>
                                            </li>
                                            <li class="nk-block-tools-opt">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#taskCreate" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Tạo nhiệm vụ</span>
                                                </button>

                                                <div class="modal fade" id="taskCreate" data-bs-keyboard="false" data-bs-backdrop="static">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tạo nhiệm vụ</h5>
                                                                <a @click="onCloseModal()" href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="#" class="form-validate is-alter">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="full-name">Loại nhiệm vụ</label>
                                                                        <div class="form-control-wrap">
                                                                            <select v-model="activity.activity" class="form-control form-control-outlined">
                                                                                <option :value="null">--Chọn loại nhiệm vụ---</option>
                                                                                <option v-for="(option, index) in activitiy_list" :key="index" :value="option.id">{{option.activity_name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" v-if="activity.activity">
                                                                        <label class="form-label" for="email-address">Hoạt động</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="custom-control custom-radio">
                                                                                <input v-model="activity.action" type="radio" :value="actionType.NOTIFICATION_JOIN" id="customRadio2" name="customRadio" class="custom-control-input">
                                                                                <label class="custom-control-label" for="customRadio2">Tạo phần thi</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio">
                                                                                <input v-model="activity.action" type="radio" :value="actionType.NOTIFICATION_VIEW" id="customRadio2" name="customRadio" class="custom-control-input">
                                                                                <label class="custom-control-label" for="customRadio2">Thông báo(có phản hồi)</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio">
                                                                                <input v-model="activity.action" type="radio" :value="actionType.NOTIFICATION_NOT_RESPONSE" id="customRadio2" name="customRadio" class="custom-control-input">
                                                                                <label class="custom-control-label" for="customRadio2">Thông báo(không phản hồi)</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" v-if="activity.action">
                                                                        <label class="form-label" for="full-name">Tên nhiệm vụ</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" v-model="activity.taskName" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" v-if="activity.action">
                                                                        <label class="form-label" for="full-name">Mô tả</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea  v-model="activity.details" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group d-flex justify-content-center">
                                                                        <button type="button" @click="onSaveActivity()" class="btn btn-lg btn-primary">Lưu</button>
                                                                        <button type="button" @click="onCloseModal()" data-bs-dismiss="modal" class="btn btn-lg btn-outline-secondary custom-ml-3">Huỷ</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách nhiệm vụ</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <table class="table table-orders">
                                <thead class="tb-odr-head">
                                    <tr class="tb-odr-item">
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-id">Order ID</span>
                                            <span class="tb-odr-date d-none d-md-inline-block">Date</span>
                                        </th>
                                        <th class="tb-odr-amount">
                                            <span class="tb-odr-total">Amount</span>
                                            <span class="tb-odr-status d-none d-md-inline-block">Status</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id"><a href="#">#746F5K2</a></span>
                                            <span class="tb-odr-date">23 Jan 2019, 10:45pm</span>
                                        </td>
                                        <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$2300.00</span>
                                            </span>
                                            <span class="tb-odr-status">
                                                <span class="badge badge-dot bg-success">Complete</span>
                                            </span>
                                        </td>
                                        <td class="tb-odr-action">
                                            <div class="tb-odr-btns d-none d-md-inline">
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                            </div>
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="text-primary">Edit</a>
                                                        </li>
                                                        <li><a href="#" class="text-primary">View</a>
                                                        </li>
                                                        <li><a href="#" class="text-danger">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id"><a href="#">#546H74W</a></span>
                                            <span class="tb-odr-date">12 Jan 2020, 10:45pm</span>
                                        </td>
                                        <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$120.00</span>
                                            </span>
                                            <span class="tb-odr-status">
                                                <span class="badge badge-dot bg-warning">Pending</span>
                                            </span>
                                        </td>
                                        <td class="tb-odr-action">
                                            <div class="tb-odr-btns d-none d-md-inline">
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                            </div>
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="text-primary">Edit</a>
                                                        </li>
                                                        <li><a href="#" class="text-primary">View</a>
                                                        </li>
                                                        <li><a href="#" class="text-danger">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id"><a href="#">#87X6A44</a></span>
                                            <span class="tb-odr-date">26 Dec 2019, 12:15 pm</span>
                                        </td>
                                        <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$560.00</span>
                                            </span>
                                            <span class="tb-odr-status">
                                                <span class="badge badge-dot bg-success">Complete</span>
                                            </span>
                                        </td>
                                        <td class="tb-odr-action">
                                            <div class="tb-odr-btns d-none d-md-inline">
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                            </div>
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="text-primary">Edit</a>
                                                        </li>
                                                        <li><a href="#" class="text-primary">View</a>
                                                        </li>
                                                        <li><a href="#" class="text-danger">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id"><a href="#">#986G531</a></span>
                                            <span class="tb-odr-date">21 Jan 2019, 6 :12 am</span>
                                        </td>
                                        <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$3654.00</span>
                                            </span>
                                            <span class="tb-odr-status">
                                                <span class="badge badge-dot bg-danger">Cancelled</span>
                                            </span>
                                        </td>
                                        <td class="tb-odr-action">
                                            <div class="tb-odr-btns d-none d-md-inline">
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                            </div>
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="text-primary">Edit</a>
                                                        </li>
                                                        <li><a href="#" class="text-primary">View</a>
                                                        </li>
                                                        <li><a href="#" class="text-danger">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id"><a href="#">#326T4M9</a></span>
                                            <span class="tb-odr-date">21 Jan 2019, 6 :12 am</span>
                                        </td>
                                        <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">$200.00</span>
                                            </span>
                                            <span class="tb-odr-status">
                                                <span class="badge badge-dot bg-success">Complete</span>
                                            </span>
                                        </td>
                                        <td class="tb-odr-action">
                                            <div class="tb-odr-btns d-none d-md-inline">
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                            </div>
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="text-primary">Edit</a>
                                                        </li>
                                                        <li><a href="#" class="text-primary">View</a>
                                                        </li>
                                                        <li><a href="#" class="text-danger">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
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
import constants from "../constants";
import {mapActions} from 'vuex'
import activitiyServices from "../services/activitiy.services";

export default {
    data(){
        return{
            activity:{
                taskName: '',
                activity: null,
                action: null,
                details: ''
            },
            activitiy_list: [],
        }
    },
    computed:{
      actionType(){
          return constants.ACTIVITY;
      }
    },
    methods:{
        ...mapActions({
            getActivityList: 'activity/getActivityList'
        }),

        async getActivities(){
            await activitiyServices.getActivityList()
                .then(response => this.activitiy_list = response.data.data);
        },
        async onSaveActivity(){

        },
        onCloseModal(){
            this.activity.activity = null;
            this.activity.action = null;
        }
    },
    async mounted() {
        await this.getActivities();
    }
}
</script>

<style scoped>
.custom-ml-3{
    margin-left: 0.75rem;
}
</style>
